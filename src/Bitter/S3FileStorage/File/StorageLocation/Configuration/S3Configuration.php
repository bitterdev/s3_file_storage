<?php

namespace Bitter\S3FileStorage\File\StorageLocation\File\StorageLocation\Configuration;

use Aws\S3\S3Client;
use Concrete\Core\Error\ErrorList\Error\Error;
use Concrete\Core\Error\ErrorList\ErrorList;
use Concrete\Core\File\StorageLocation\Configuration\DeferredConfigurationInterface;
use Concrete\Core\Form\Service\Validation;
use Concrete\Core\Http\Request;
use Concrete\Core\File\StorageLocation\Configuration\ConfigurationInterface;
use Concrete\Core\File\StorageLocation\Configuration\Configuration;
use League\Url\Url;
use League\Flysystem\AwsS3v3\AwsS3Adapter;

class S3Configuration extends Configuration implements ConfigurationInterface, DeferredConfigurationInterface
{
    public ?string $bucket = null;
    public ?string $key = null;
    public ?string $secret = null;
    public ?string $region = null;
    public ?string $publicUrl = null;
    public ?string $customEndpoint = null;

    protected Validation $formValidation;

    public function __construct(
        Validation $formValidation
    )
    {
        $this->formValidation = $formValidation;
    }

    public function hasPublicURL(): bool
    {
        return true;
    }

    public function hasRelativePath(): bool
    {
        return false;
    }

    public function loadFromRequest(Request $req)
    {
        $data = $req->request->get('fslType');

        $this->customEndpoint = $data['customEndpoint'] ?? "";
        $this->bucket = $data['bucket'] ?? "";
        $this->key = $data['key'] ?? "";
        $this->secret = $data['secret'] ?? "";
        $this->region = $data['region'] ?? "";
        $this->publicUrl = $data['publicUrl'] ?? "";
    }

    public function validateRequest(Request $req): ErrorList
    {
        $e = new ErrorList();

        $data = $req->request->get('fslType', []);

        if (is_array($data)) {
            $this->formValidation->setData($data);

            $this->formValidation->addRequired("bucket", t("You must enter a valid S3 Bucket."));
            $this->formValidation->addRequired("region", t("You must enter a valid region."));
            $this->formValidation->addRequired("key", t("You must enter a valid S3 Key."));
            $this->formValidation->addRequired("secret", t("You must enter a valid S3 Secret."));

            $this->formValidation->test();

            $e = $this->formValidation->getError();
        } else {
            $e->addError(new Error(t("Invalid form data.")));
        }

        return $e;
    }

    public function getAdapter(): AwsS3Adapter
    {
        return new AwsS3Adapter($this->getClient(), $this->bucket);
    }

    protected function getClient(): S3Client
    {
        $config = [
            'credentials' => [
                'key' => $this->getKey(),
                'secret' => $this->getSecret()
            ],
            'region' => $this->getRegion(),
            'version' => 'latest'
        ];

        if (strlen($this->getCustomEndpoint()) > 0) {
            $config['endpoint'] = $this->getCustomEndpoint();
        }

        return new S3Client($config);
    }

    public function getPublicURLToFile($file): string
    {
        $file = trim($file, '/');

        if (!empty($this->publicUrl)) {
            $url = Url::createFromUrl($this->publicUrl);
            $url->setPath($file);
            return (string) $url;
        }

        return $this->getClient()->getObjectUrl($this->bucket, $file);
    }

    public function getCustomEndpoint(): ?string
    {
        return $this->customEndpoint;
    }

    public function getRelativePathToFile($file): string
    {
        return $file;
    }

    public function getBucket(): ?string
    {
        return $this->bucket;
    }

    public function getKey(): ?string
    {
        return $this->key;
    }

    public function getSecret(): ?string
    {
        return $this->secret;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function getPublicUrl(): ?string
    {
        return $this->publicUrl;
    }
}