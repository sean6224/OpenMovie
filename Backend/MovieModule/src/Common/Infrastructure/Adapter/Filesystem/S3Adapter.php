<?php
declare(strict_types=1);
namespace App\Common\Infrastructure\Adapter\Filesystem;

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

class S3Adapter
{
    private S3Client $s3Client;
    private string $bucketName;

    public function __construct()
    {
        $this->s3Client = new S3Client([
            'version' => 'latest',
            'region'  => $_ENV['S3_REGION'],
            'credentials' => [
                'key'    => $_ENV['S3_KEY'],
                'secret' => $_ENV['S3_SECRET'],
            ],
        ]);
        $this->bucketName = $_ENV['S3_BUCKET'];
    }

    /**
     * Uploads file to S3 bucket.
     *
     * @param string $localFilePath The local path to file to upload.
     * @param string $remoteFilePath The remote path where file should be uploaded.
     * @return bool True if the file was successfully uploaded, false otherwise.
     */
    public function uploadFile(string $localFilePath, string $remoteFilePath): bool
    {
        try {
            $this->s3Client->putObject([
                'Bucket' => $this->bucketName,
                'Key'    => $remoteFilePath,
                'Body'   => fopen($localFilePath, 'rb'),
            ]);
            return true;
        } catch (S3Exception $e) {
            throw new S3Exception('Error when uploading file to S3: ' . $e->getMessage(), $e->getCode(), (array)$e);
        }
    }

    /**
     * Downloads file from S3 bucket.
     *
     * @param string $remoteFilePath The remote path of file to download.
     * @param string $localFilePath The local path where file should be downloaded.
     * @return bool True if the file was successfully downloaded, false otherwise.
     * @throws S3Exception If an error occurs during the download process.
     */
    public function downloadFile(string $remoteFilePath, string $localFilePath): bool
    {
        try {
            $this->s3Client->getObject([
                'Bucket' => $this->bucketName,
                'Key'    => $remoteFilePath,
                'SaveAs' => $localFilePath,
            ]);
            return true;
        } catch (S3Exception $e) {
            throw new S3Exception('Error when downloading file from S3: ' . $e->getMessage(), $e->getCode(), (array)$e);
        }
    }

    /**
     * Checks if file exists in S3 bucket.
     *
     * @param string $remoteFilePath The remote path of file to check.
     * @return bool True if the file exists, false otherwise.
     */
    public function fileExists(string $remoteFilePath): bool
    {
        return $this->s3Client->doesObjectExist($this->bucketName, $remoteFilePath);
    }

    /**
     * Deletes file from S3 bucket.
     *
     * @param string $remoteFilePath The remote path of file to delete.
     * @return bool True if the file was successfully deleted, false otherwise.
     * @throws S3Exception If an error occurs during the deletion process.
     */
    public function deleteFile(string $remoteFilePath): bool
    {
        try {
            $this->s3Client->deleteObject([
                'Bucket' => $this->bucketName,
                'Key'    => $remoteFilePath,
            ]);
            return true;
        } catch (S3Exception $e) {
            throw new S3Exception('Error when deleting file from S3: ' . $e->getMessage(), $e->getCode(), (array)$e);
        }
    }

    /**
     * Retrieves URL of file in S3 bucket.
     *
     * @param string $remoteFilePath The remote path of file.
     * @return string|null The URL of the file, or null if it doesn't exist.
     */
    public function getFileUrl(string $remoteFilePath): ?string
    {
        if ($this->fileExists($remoteFilePath)) {
            return $this->s3Client->getObjectUrl($this->bucketName, $remoteFilePath);
        }
        return null;
    }

    /**
     * Lists all objects in S3 bucket.
     *
     * @return array An array containing information about each object in bucket.
     * @throws S3Exception If an error occurs while listing objects.
     */
    public function listObjects(): array
    {
        try {
            $objects = $this->s3Client->listObjectsV2([
                'Bucket' => $this->bucketName,
            ]);
            return $objects['Contents'] ?? [];
        } catch (S3Exception $e) {
            throw new S3Exception('Error when listing objects in S3 bucket: ' . $e->getMessage(), $e->getCode(), (array)$e);
        }
    }

    /**
     * Retrieves metadata of file in S3 bucket.
     *
     * @param string $remoteFilePath The remote path of file.
     * @return array|null The metadata of file, or null if it doesn't exist.
     * @throws S3Exception If an error occurs while retrieving metadata.
     */
    public function getFileMetadata(string $remoteFilePath): ?array
    {
        try {
            $metadata = $this->s3Client->headObject([
                'Bucket' => $this->bucketName,
                'Key'    => $remoteFilePath,
            ]);
            return $metadata->toArray();
        } catch (S3Exception $e) {
            throw new S3Exception('Error when retrieving file metadata from S3: ' . $e->getMessage(), $e->getCode(), (array)$e);
        }
    }

    /**
     * Copies file within S3 bucket.
     *
     * @param string $sourcePath The source path of file.
     * @param string $destinationPath The destination path of file.
     * @return bool True if the file was successfully copied, false otherwise.
     * @throws S3Exception If an error occurs during the copy operation.
     */
    public function copyFile(string $sourcePath, string $destinationPath): bool
    {
        try {
            $this->s3Client->copyObject([
                'Bucket'     => $this->bucketName,
                'CopySource' => "$this->bucketName/$sourcePath",
                'Key'        => $destinationPath,
            ]);
            return true;
        } catch (S3Exception $e) {
            throw new S3Exception('Error when copying file within S3 bucket: ' . $e->getMessage(), $e->getCode(), (array)$e);
        }
    }
}
