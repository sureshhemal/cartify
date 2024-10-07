<?php

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

use function Pest\Laravel\postJson;
use function PHPUnit\Framework\assertEquals;

test('can upload file', function () {
    Storage::fake();

    $initialFileCount = count(Storage::allFiles());

    actingAsAdmin();

    $response = postJson('api/file-upload', [
        'image' => UploadedFile::fake()->create(
            'image.jpg',
            2048,
            'image/jpeg'
        ),
    ]);

    $response->assertOk();
    assertEquals($initialFileCount + 1, count(Storage::allFiles()));
    $response->assertJsonFragment(Storage::allFiles());
});
