<?php

namespace Domain\Categories\Models;

use App\Models\BaseModel;
use App\Observers\ModelObserver;
use Database\Factories\CategoryFactory;
use Domain\Categories\QueryBuilders\CategoryQueryBuilder;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy(ModelObserver::class)]
class Category extends BaseModel
{
    public const SEARCHABLE_FIELDS = ['code', 'name'];

    protected static function newFactory(): CategoryFactory
    {
        return CategoryFactory::new();
    }

    public function newEloquentBuilder($query): CategoryQueryBuilder
    {
        return new CategoryQueryBuilder($query);
    }
}
