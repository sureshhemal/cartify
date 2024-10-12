<?php

namespace Domain\ServiceProviders;

use Domain\Products\Models\Product;
use Domain\Products\Policies\ProductPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class ProductServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Gate::policy(Product::class, ProductPolicy::class);
    }
}
