# S3 File Storage Add-on - Setup Guide

With this add-on, you can easily integrate **Amazon S3** or compatible services like **MinIO** as a file storage system in Concrete CMS. Uploading, managing, and retrieving files works just like with the integrated file manager.

## Setup Steps

1. Go to the Dashboard:  
   `System & Settings > Files > File Storage Locations`

2. Click **"Choose S3 File Storage"** and then click **"Go"** under "Choose Type".

3. Fill out the form:

    - **Name**: A custom name for this storage location.
    - **Bucket**: The name of your S3 bucket.
    - **Region**: The region where your bucket is located (e.g., `eu-central-1`).
    - **Access Key & Secret**: Your AWS credentials or the credentials of a compatible IAM user.

4. Optionally, you can also specify:
    - **Custom Endpoint**: If you're using a non-Amazon S3 service like **MinIO**, enter the appropriate endpoint here (e.g., `https://localhost:9000`). Leave this field empty if using Amazon AWS S3.
    - **Public Base URL**: If you're using a CDN like **CloudFront**, you can enter the public URL where files will be served (e.g., `https://cdn.example.com`).

5. Save the settings.

## Done!

Now you can use your S3 bucket directly within the **Concrete CMS File Manager** for uploading, viewing, and managing your files.
