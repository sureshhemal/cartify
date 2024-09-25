<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

final readonly class ModelObserver
{
    public function creating(Model $model): void
    {
        $model->{$model->getKeyName()} = Str::orderedUuid()->toString();
    }
}
