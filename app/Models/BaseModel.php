<?php

namespace App\Models;

use App\Observers\ModelObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy(ModelObserver::class)]
abstract class BaseModel extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $keyType = 'string';
}
