<?php

namespace Concrete\Package\S3FileStorage;

use Bitter\S3FileStorage\Provider\ServiceProvider;
use Concrete\Core\Entity\Package as PackageEntity;
use Concrete\Core\Package\Package;
use Concrete\Core\File\StorageLocation\Type\Type;

class Controller extends Package
{
    protected string $pkgHandle = 's3_file_storage';
    protected string $pkgVersion = '0.0.3';
    protected $appVersionRequired = '9.0.0';
    protected $pkgAutoloaderRegistries = [
        'src/Bitter/S3FileStorage' => 'Bitter\S3FileStorage',
    ];

    public function getPackageDescription(): string
    {
        return t('Flexible file storage add-on for Concrete CMS that works with any S3-compatible service, including MinIO and other open-source or third-party providers—not just Amazon S3.');
    }

    public function getPackageName(): string
    {
        return t('File Storage for S3');
    }

    public function on_start()
    {
        require_once('vendor/autoload.php');

        /** @var ServiceProvider $serviceProvider */
        /** @noinspection PhpUnhandledExceptionInspection */
        $serviceProvider = $this->app->make(ServiceProvider::class);
        $serviceProvider->register();
    }

    public function install(): PackageEntity
    {
        $pkg = parent::install();

        $storageObject = Type::getByHandle("s3_file_storage");

        if (!$storageObject instanceof Type) {
            Type::add('s3_file_storage', t('S3 File Storage'), $pkg);
        }

        return $pkg;
    }
}