<?php

namespace Domain\Support\Media;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Collection;

interface Mediaable
{
    public function media(): MorphMany;

    public function getMedia(): Collection;

    public function getId(): string;

    public function getType(): string;
}
