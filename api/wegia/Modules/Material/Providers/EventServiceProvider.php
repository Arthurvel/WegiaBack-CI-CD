<?php

namespace Modules\Material\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Material\app\Models\TransacaoProduto;
use Modules\Material\app\Observers\TransacaoProdutoObserver;

class EventServiceProvider extends ServiceProvider
{
    public function boot()
    {
        TransacaoProduto::observe(TransacaoProdutoObserver::class);
    }
}
