<?php

defined('C5_EXECUTE') or die('Access Denied');

use Bitter\S3FileStorage\File\StorageLocation\Configuration\S3FileStorageConfiguration;
use Concrete\Core\Form\Service\Form;
use Concrete\Core\Support\Facade\Application;
use Concrete\Core\View\View;

/** @var S3Configuration $configuration */

$app = Application::getFacadeApplication();
/** @var Form $form */
/** @noinspection PhpUnhandledExceptionInspection */
$form = $app->make(Form::class);

?>

<?php if ($configuration instanceof S3FileStorageConfiguration) { ?>
    <div class="ccm-dashboard-header-buttons">
        <?php /** @noinspection PhpUnhandledExceptionInspection */
        View::element("dashboard/help", [], "s3_file_storage"); ?>
    </div>

    <fieldset>
        <legend>
            <?php echo t("General Settings"); ?>
        </legend>

        <div class="form-group">
            <?php echo $form->label("customEndpoint", t("Custom Endpoint")); ?>
            <?php echo $form->text("customEndpoint", $configuration->getCustomEndpoint(), ["name" => "fslType[endpoint]"]); ?>

            <p class="help-block">
                <?php echo t("Leave empty when using Amazon S3. For S3-compatible services like MinIO, specify the custom endpoint here (e.g., %s).", "<code>https://localhost:9000</code>"); ?>
            </p>
        </div>

        <div class="form-group">
            <?php echo $form->label("bucket", t("Bucket")); ?>

            <div class="float-end">
                <div class="text-muted small">
                    <?php echo t("Required"); ?>
                </div>
            </div>

            <?php echo $form->text("bucket", $configuration->getBucket(), ["name" => "fslType[bucket]", "required" => "required"]); ?>
        </div>

        <div class="form-group">
            <?php echo $form->label("region", t("Region")); ?>

            <div class="float-end">
                <div class="text-muted small">
                    <?php echo t("Required"); ?>
                </div>
            </div>

            <?php echo $form->text("region", $configuration->getRegion(), ["name" => "fslType[region]", "required" => "required"]); ?>
        </div>

        <div class="form-group">
            <?php echo $form->label("key", t("Key")); ?>

            <div class="float-end">
                <div class="text-muted small">
                    <?php echo t("Required"); ?>
                </div>
            </div>

            <?php echo $form->password('key', $configuration->getKey(), ["name" => "fslType[key]", "required" => "required"]); ?>
        </div>

        <div class="form-group">
            <?php echo $form->label("secret", t("Secret")); ?>

            <div class="float-end">
                <div class="text-muted small">
                    <?php echo t("Required"); ?>
                </div>
            </div>

            <?php echo $form->text('secret', $configuration->getSecret(), ["name" => "fslType[secret]", "required" => "required"]); ?>
        </div>

        <div class="form-group">
            <?php echo $form->label("publicUrl", t("Public Url")); ?>
            <?php echo $form->text("publicUrl", $configuration->getPublicUrl(), ["name" => "fslType[Public]"]); ?>

            <p class="help-block">
                <?php echo t("If you're using a CDN like CloudFront, enter the public URL that should be prepended to file paths (e.g., %s). Leave empty to use the default S3 URL.", "<code>https://xxxxxxx.cloudfront.net</code>"); ?>
            </p>
        </div>
    </fieldset>
<?php } ?>