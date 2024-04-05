<?php
declare(strict_types=1);
namespace App\Common\Domain\Port;

/**
 * Interface representing port for interacting with filesystem.
 */
interface FilesystemPort
{
    /**
     * Uploads file from local storage to remote filesystem.
     *
     * @param string $localFilePath The local path of the file to upload.
     * @param string $remoteFilePath The remote path where the file should be uploaded.
     * @return bool True if the file was successfully uploaded, false otherwise.
     */
    public function uploadFile(string $localFilePath, string $remoteFilePath): bool;

    /**
     * Downloads file from remote filesystem to local storage.
     *
     * @param string $remoteFilePath The remote path of file to download.
     * @param string $localFilePath The local path where file should be saved.
     * @return bool True if the file was successfully downloaded, false otherwise.
     */
    public function downloadFile(string $remoteFilePath, string $localFilePath): bool;

    /**
     * Checks if file exists in remote filesystem.
     *
     * @param string $remoteFilePath The remote path of file to check.
     * @return bool True if the file exists, false otherwise.
     */
    public function fileExists(string $remoteFilePath): bool;

    /**
     * Deletes file from remote filesystem.
     *
     * @param string $remoteFilePath The remote path of file to delete.
     * @return bool True if the file was successfully deleted, false otherwise.
     */
    public function deleteFile(string $remoteFilePath): bool;

    /**
     * Retrieves URL of file in remote filesystem.
     *
     * @param string $remoteFilePath The remote path of file.
     * @return string|null The URL of file, or null if it doesn't exist.
     */
    public function getFileUrl(string $remoteFilePath): ?string;
}
