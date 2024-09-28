<?php

namespace Domain\RolesAndPermissions\Models;

use App\Observers\ModelObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy(ModelObserver::class)]
class Role extends \Spatie\Permission\Models\Role
{
    public $incrementing = false;

    protected $keyType = 'string';
}
