<?php

namespace App\Providers;

use App\Models\Comment;
use App\Models\CV;
use App\Models\User;
use App\Policies\CommentPolicy;
use App\Policies\CVPolicy;
use App\Policies\PermissionPolicy;
use App\Policies\RolePolicy;
use App\Policies\UserPolicy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

//use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
        Gate::policy(User::class, UserPolicy::class);
        Gate::policy(Comment::class, CommentPolicy::class);
        Gate::policy(Role::class, RolePolicy::class);
        Gate::policy(Permission::class, PermissionPolicy::class);
        Gate::policy(CV::class, CVPolicy::class);
        Model::preventLazyLoading(!$this->app->isProduction());

        //HTTPS configuration
//        if ($this->app->environment('production')) {
//            URL::forceScheme('https');
//        }

        //Password strong
        Password::defaults(
            function () {
                $rule = Password::min(8);

                return $this->app->isProduction()
                ? $rule->numbers()
                    ->letters()
//                    ->mixedCase()
                    ->symbols()
                : $rule;
            }
        );
    }
}
