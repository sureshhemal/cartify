<?php

namespace Domain\Products\Models;

use App\Models\BaseModel;
use App\Observers\ModelObserver;
use Brick\Money\Money;
use Database\Factories\ProductFactory;
use Domain\Categories\Models\Category;
use Domain\Products\QueryBuilders\ProductQueryBuilder;
use Domain\Support\Media\IsMediaable;
use Domain\Support\Media\Mediaable;
use Domain\Users\Models\User;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

/**
 * @property Money $price
 * @property string $currency
 * @property string $image
 * @property string $name
 * @property string $seller_id
 * @property string $category_id
 * @property User $seller
 */
#[ObservedBy(ModelObserver::class)]
class Product extends BaseModel implements Mediaable
{
    use IsMediaable;
    use SoftDeletes;

    public const SEARCHABLE_FIELDS = ['name', 'code', 'description'];

    protected $appends = [
        'avatar',
    ];

    public static function newFactory(): ProductFactory
    {
        return ProductFactory::new();
    }

    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'seller_id', 'id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function getPriceAttribute(): Money
    {
        return Money::ofMinor($this->attributes['price'], $this->currency);
    }

    public function setPriceAttribute(Money $price): void
    {
        $this->attributes['price'] = $price->getMinorAmount()->toInt();
        $this->attributes['currency'] = $price->getCurrency()->getCurrencyCode();
    }

    public function avatar(): Attribute
    {
        return Attribute::get(function (): string {
            return $this->image
                ? Storage::temporaryUrl($this->image, now()->addMinutes(5))
                : $this->defaultProductImageUrl();
        });
    }

    private function defaultProductImageUrl(): string
    {
        $name = trim(collect(explode(' ', $this->name))->map(function ($segment) {
            return mb_substr($segment, 0, 1);
        })->join(' '));

        return 'https://ui-avatars.com/api/?name='.urlencode($name).'&color=7F9CF5&background=EBF4FF';
    }

    public function newEloquentBuilder($query): ProductQueryBuilder
    {
        return new ProductQueryBuilder($query);
    }
}
