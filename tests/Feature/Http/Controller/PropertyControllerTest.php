<?php

namespace Tests\Feature\Http\Controller;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class PropertyControllerTest extends TestCase
{

    /** @test */
    public function can_upload_image()
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->image('avatar.jpg')->size(100);

        $response = $this->json('POST', '/admin/upload', [
            'file' => $file,
        ]);

        $fileName = json_decode($response->getContent(), true)['payload'][0];

        // Assert the file was stored...
        Storage::disk('public')->assertExists('images/'.$fileName);

        // Assert a file does not exist...
        Storage::disk('public')->assertMissing('images/missing.jpg');
    }
}
