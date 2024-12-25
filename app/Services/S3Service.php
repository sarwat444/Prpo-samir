<?php

namespace App\Services;
use Illuminate\Support\Facades\Storage;
use Aws\S3\S3Client;
/**
 * Class S3Service.
 */
class S3Service
{
    protected $s3;

    public function __construct()
    {
        $this->s3 = new S3Client([
            'version' => 'latest',
            'region' => config('filesystems.disks.s3.region'),
            'credentials' => [
                'key' => config('filesystems.disks.s3.key'),
                'secret' => config('filesystems.disks.s3.secret'),
            ],
        ]);
    }

    public function uploadVideo($file, $filePath)
    {
       /* $result = $this->s3->putObject([
            'Bucket' => config('filesystems.disks.s3.bucket'),
            'Key' => $filePath,
            'Body' => file_get_contents($file),
            'ACL' => 'public-read',
        ]);

        return $result['ObjectURL'];*/
        
    }
}
