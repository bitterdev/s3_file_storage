<?php

namespace Bitter\S3FileStorage\AwsS3v3;

use League\Flysystem\AwsS3v3\AwsS3Adapter;
use League\Flysystem\Config;

class SecureS3Adapter extends AwsS3Adapter
{
    public function write($path, $contents, Config $config): array
    {
        $config = $this->sanitizeConfig($config);
        return parent::write($path, $contents, $config);
    }

    public function writeStream($path, $contents, Config $config): array
    {
        $config = $this->sanitizeConfig($config);
        return parent::writeStream($path, $contents, $config);
    }

    public function createDirectory($path, Config $config): array
    {
        $config = $this->sanitizeConfig($config);
        return parent::createDirectory($path, $config);
    }

    public function setVisibility($path, $visibility): void
    {
        // Do Nothing
    }

    private function sanitizeConfig(Config $config): Config
    {
        $config->set('ACL', null);
        $config->set('visibility', null);
        return $config;
    }
}