<?php

namespace Domain\Users\Traits;

trait HasPermissions
{
    public function onlySeesOwnProducts(): bool
    {
        return $this->hasPermissionTo('view-own-product')
            && ! $this->hasPermissionTo('view-any-product');
    }

    public function onlySeeHimself(): bool
    {
        return $this->hasPermissionTo('view-own-user')
            && ! $this->hasPermissionTo('view-any-user');
    }
}
