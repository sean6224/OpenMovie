<?php
declare(strict_types=1);
namespace App\Common\Infrastructure\Adapter;

use App\Common\Infrastructure\Adapter\Filesystem\FtpAdapter;
use App\Common\Infrastructure\Adapter\Filesystem\S3Adapter;

class FilesystemAdapter
{
    private string $adapterType;
    private string $basePath;
    private ?S3Adapter $s3Adapter;
    private ?FtpAdapter $ftpAdapter;

    public function __construct()
    {
        $this->basePath = rtrim($_ENV['BASE_PATH'] ?? '', '/');
        $this->adapterType = $_ENV['FILESYSTEM_ADAPTER'] ?? 'local';

        if ($this->adapterType === 's3') {
            $this->s3Adapter = new S3Adapter();
        }

        if ($this->adapterType === 'ftp') {
            $this->ftpAdapter = new FtpAdapter();
        }
    }

    /**
     * Get the base path.
     *
     * @return string The base path.
     */
    public function getBasePath(): string
    {
        return $this->basePath;
    }

    /**
     * Get the adapter type.
     *
     * @return string The adapter type.
     */
    public function getAdapterType(): string
    {
        return $this->adapterType;
    }

    /**
     * Get the S3 adapter instance.
     *
     * @return S3Adapter|null The S3 adapter instance, or null if not set.
     */
    public function getS3Adapter(): ?S3Adapter
    {
        return $this->s3Adapter;
    }

    public function getFtpAdapter(): ?FtpAdapter
    {
        return $this->ftpAdapter;
    }
}
