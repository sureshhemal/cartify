<?php

namespace Domain\Support\Media;

use App\Models\BaseModel;
use App\Observers\ModelObserver;
use Database\Factories\MediaFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Storage;

/**
 * @property string $name
 */
#[ObservedBy(ModelObserver::class)]
class Media extends BaseModel
{
    protected $appends = [
        'url',
    ];

    public function mediaable(): MorphTo
    {
        return $this->morphTo();
    }

    public function url(): Attribute
    {
        return new Attribute(
            get: function () {
                return Storage::temporaryUrl($this->name, now()->addMinutes(30));
            }
        );
    }

    public static function newFactory(): MediaFactory
    {
        return MediaFactory::new();
    }
}
