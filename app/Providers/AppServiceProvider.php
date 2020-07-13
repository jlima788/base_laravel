<?php

namespace App\Providers;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->isLocal() && class_exists('\Laravel\Telescope\TelescopeServiceProvider')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Dispatcher $events)
    {
        Schema::defaultStringLength(config('default.string'));

        $this->app->bind('path.public', function () {
            return base_path() . '/public_html';
        });

        $this->app->singleton(\Faker\Generator::class, function () {
            return \Faker\Factory::create('pt_BR');
        });

        $events->listen(BuildingMenu::class, function (BuildingMenu $event) {
            if (auth()->user()->staf) {
                $event->menu->add([
                    'header' => "Lojas",
                    'can' => ['loja']
                ]);

                $event->menu->add([
                    'text' => 'Store',
                    'url' => route('admin.store.index'),
                    'can' => ['loja'],
                    'active' => [
                        'admin/store*'
                    ],
                ]);
            }

            $event->menu->add([
                'header' => "Usuários",
                'can' => ['usuario', 'grupo']
            ]);

            $event->menu->add([
                'text' => 'Usuário',
                'url' => route('admin.user.user.index'),
                'icon' => 'fas fa-fw fa-user',
                'can' => ['usuario'],
                'active' => [
                    'admin/user/user*'
                ],
            ]);

            $event->menu->add([
                'text' => 'Grupo',
                'url' => route('admin.user.role.index'),
                'icon' => 'fas fa-fw fa-users',
                'can' => ['grupo'],
                'active' => [
                    'admin/user/role*'
                ],
            ]);

            $event->menu->add(['header' => 'account_settings']);
            
            $event->menu->add([
                'text' => 'profile',
                'url' => route('admin.user.profile.index'),
                'icon' => 'fas fa-fw fa-user',
            ]);

            $event->menu->add([
                'text' => 'change_password',
                'url' => route('admin.user.profile.index'),
                'icon' => 'fas fa-fw fa-lock',
            ]);
        });

        $this->app->register(\Modules\MenuProvider::class);
    }
}
