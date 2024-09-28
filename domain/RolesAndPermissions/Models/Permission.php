<?php

namespace Domain\RolesAndPermissions\Models;

use App\Observers\ModelObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy(ModelObserver::class)]
class Permission extends \Spatie\Permission\Models\Permission
{
    public $incrementing = false;

    protected $keyType = 'string';
}
