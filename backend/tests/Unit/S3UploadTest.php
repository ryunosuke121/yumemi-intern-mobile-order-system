<?php

namespace Tests\Unit;

use Aws\Credentials\Credentials;
use Aws\S3\S3Client;
use Illuminate\Support\Facades\Config;
use PHPUnit\Framework\TestCase;

class S3UploadTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_upload_file(): void
    {
        $dummyFilePath = 'tests/dummy.txt';
        $s3Client = new S3Client([
            'credentials' => new Credentials(
                env('AWS_ACCESS_KEY_ID'),
                env('AWS_SECRET_ACCESS'),
            ),
            'region' => env('AWS_DEFAULT_REGION'),
            'version' => 'latest',
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT'),
        ]);

        $result = $s3Client->putObject([
            'Bucket' => env('AWS_BUCKET'),
            'Key' => 'dummy.txt',
            'SourceFile' => $dummyFilePath,
        ]);

        $this->assertArrayHasKey('ObjectURL', $result);
    }
}
