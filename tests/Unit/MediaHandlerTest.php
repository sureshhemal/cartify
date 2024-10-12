<?php

use Domain\Products\Models\Product;
use Domain\Support\Media\Media;
use Domain\Support\Media\MediaHandler;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;

beforeEach(function () {
    Storage::fake();

    $this->file = UploadedFile::fake()->create('image.jpg', 2048, 'image/jpg');

    $this->path = Storage::put('uploads', $this->file);
});

test('can create media database record', function () {
    $product = Product::factory()->create();

    MediaHandler::syncModelWithMedia($product, [
        'added' => [
            [
                'name' => $this->path,
                'type' => $this->file->getMimeType(),
            ],
        ],
        'removed' => [],
    ]);

    assertDatabaseHas('media', [
        'name' => $this->path,
        'type' => $this->file->getMimeType(),
        'mediaable_id' => $product->getKey(),
        'mediaable_type' => Product::class,
    ]);
});

test('delete storage file when removing', function () {
    $product = Product::factory()->create();

    MediaHandler::syncModelWithMedia($product, [
        'added' => [],
        'removed' => [
            [
                'name' => $this->path,
                'type' => $this->file->getMimeType(),
            ],
        ],
    ]);

    Storage::assertMissing($this->path);
});

test('delete media database records when removing', function () {
    $product = Product::factory()->create();

    $media = Media::factory()->create([
        'name' => $this->path,
        'type' => $this->file->getMimeType(),
        'mediaable_id' => $product->getKey(),
        'mediaable_type' => Product::class,
    ]);

    MediaHandler::syncModelWithMedia($product, [
        'added' => [],
        'removed' => [
            [
                'name' => $this->path,
                'type' => $this->file->getMimeType(),
            ],
        ],
    ]);

    assertDatabaseMissing('media', [
        'id' => $media->getKey(),
    ]);
});
