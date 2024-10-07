<?php

namespace Domain\Support\Media;

use Illuminate\Support\Facades\Storage;

class MediaHandler
{
    private Mediaable $model;

    private array $media;

    /**
     * @param  array  $media
     *
     * Example input:
     * ```
     * $media = [
     *     'added' => [
     *         ['name' => 'file_path', 'type' => 'mime_type']
     *      ],
     *     'removed' => [
     *          ['name' => 'file_path', 'type' => 'mime_type']
     *      ],
     * ];
     * ```
     */
    public static function syncModelWithMedia(Mediaable $model, array $media): void
    {
        $self = new self;
        $self->model = $model;
        $self->media = $media;

        $self->removeMediaFromStorage();
        $self->detachMediaFromModel();
        $self->attachMediaToModel();
    }

    private function removeMediaFromStorage(): void
    {
        foreach ($this->media['removed'] as $media) {
            Storage::delete($media['name']);
        }
    }

    private function detachMediaFromModel(): void
    {
        Media::query()
            ->whereIn('name', array_column($this->media['removed'], 'name'))
            ->delete();
    }

    private function attachMediaToModel(): void
    {
        foreach ($this->media['added'] as $media) {
            Media::create([
                'name' => $media['name'],
                'type' => $media['type'],
                'mediaable_id' => $this->model->getId(),
                'mediaable_type' => $this->model->getType(),
            ]);
        }
    }
}
