<?php

namespace Domain\Support\Media;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Collection;

trait IsMediaable
{
    public function media(): MorphMany
    {
        return $this->morphMany(Media::class, 'mediaable');
    }

    public function getMedia(): Collection
    {
        return $this->media()->get();
    }

    public function getId(): string
    {
        return $this->getKey();
    }

    public function getType(): string
    {
        return $this->getMorphClass();
    }
}
