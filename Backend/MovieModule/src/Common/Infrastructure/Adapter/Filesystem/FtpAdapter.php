<?php
declare(strict_types=1);
namespace App\Common\Infrastructure\Adapter\Filesystem;

use FTP\Connection;

class FtpAdapter
{
    private string $host;
    private string $username;
    private string $password;
    private string $port;
    private int $timeout;
    private bool $passiveMode;
    /** @var resource */
    private $connection;

    public function __construct()
    {
        $this->host = $_ENV['FTP_HOST'];
        $this->username = $_ENV['FTP_USERNAME'];
        $this->password = $_ENV['FTP_PASSWORD'];
        $this->port = $_ENV['FTP_PORT'];
        $this->timeout = (int) ($_ENV['FTP_TIMEOUT'] ?? 10);
        $this->passiveMode = ($_ENV['FTP_PASSIVE_MODE'] ?? 'true') === 'true';

        $this->connection = $this->connect();
    }

    /**
     * Establishes a connection to the FTP server.
     *
     * @return false|Connection Zwraca zasób połączenia FTP lub false w przypadku niepowodzenia.
     */
    private function connect(): false|Connection
    {
        $connection = ftp_connect($this->host, (int)$this->port, $this->timeout);
        if (!$connection) {
            return false;
        }

        if ($this->passiveMode) {
            ftp_pasv($connection, true);
        }

        $login = ftp_login($connection, $this->username, $this->password);
        if (!$login) {
            ftp_close($connection);
            return false;
        }

        return $connection;
    }

    /**
     * Uploads a file to the FTP server.
     *
     * @param string $localFilePath The local path to the file to upload.
     * @param string $remoteFilePath The remote path where the file should be uploaded.
     * @return bool True if the file was successfully uploaded, false otherwise.
     */
    public function uploadFile(string $localFilePath, string $remoteFilePath): bool
    {
        if (!$this->connection) {
            return false;
        }

        $upload = ftp_put($this->connection, $remoteFilePath, $localFilePath);
        return $upload !== false;
    }

    /**
     * Downloads a file from the FTP server.
     *
     * @param string $remoteFilePath The remote path of the file to download.
     * @param string $localFilePath The local path where the file should be downloaded.
     * @return bool True if the file was successfully downloaded, false otherwise.
     */
    public function downloadFile(string $remoteFilePath, string $localFilePath): bool
    {
        if (!$this->connection) {
            return false;
        }

        $download = ftp_get($this->connection, $localFilePath, $remoteFilePath);
        return $download !== false;
    }

    /**
     * Lists files and directories in the given directory on the FTP server.
     *
     * @param string $directory The directory to list.
     * @return array|false An array of filenames in the given directory, or false on failure.
     */
    public function listDirectory(string $directory): array|false
    {
        if (!$this->connection) {
            return false;
        }

        return ftp_nlist($this->connection, $directory);
    }

    /**
     * Deletes file on the FTP server.
     *
     * @param string $remoteFilePath The remote path of the file to delete.
     * @return bool True if the file was successfully deleted, false otherwise.
     */
    public function deleteFile(string $remoteFilePath): bool
    {
        if (!$this->connection) {
            return false;
        }

        return ftp_delete($this->connection, $remoteFilePath);
    }

    /**
     * Creates directory on the FTP server.
     *
     * @param string $directory The remote path of the directory to create.
     * @return bool True if the directory was successfully created, false otherwise.
     */
    public function createDirectory(string $directory): bool
    {
        if (!$this->connection) {
            return false;
        }

        return ftp_mkdir($this->connection, $directory);
    }

    /**
     * Deletes directory on the FTP server.
     *
     * @param string $directory The remote path of the directory to delete.
     * @return bool True if the directory was successfully deleted, false otherwise.
     */
    public function deleteDirectory(string $directory): bool
    {
        if (!$this->connection) {
            return false;
        }

        return ftp_rmdir($this->connection, $directory);
    }

    /**
     * Gets information about file on the FTP server.
     *
     * @param string $remoteFilePath The path of the file on the FTP server.
     * @return array|false An array with information about the file, or false on failure.
     */
    public function getFileInfo(string $remoteFilePath): array|false
    {
        if (!$this->connection) {
            return false;
        }

        $fileList = ftp_rawlist($this->connection, '-a ' . $remoteFilePath);
        if (empty($fileList)) {
            return false;
        }

        $fileInfo = [];
        foreach ($fileList as $line) {
            $fileInfo[] = preg_split("/\s+/", $line, 9);
        }

        return $fileInfo[0] ?? false;
    }

    /**
     * Closes connection to the FTP server.
     */
    public function closeConnection(): void
    {
        if ($this->connection) {
            ftp_close($this->connection);
        }
    }
}
