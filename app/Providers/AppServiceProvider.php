<?php

namespace App\Providers;

use App\Contracts\Repositories\ConversationRepositoryInterface;
use App\Contracts\Repositories\MentorRepositoryInterface;
use App\Contracts\Repositories\OverviewRepositoryInterface;
use App\Contracts\Repositories\SettingsRepositoryInterface;
use App\Contracts\Repositories\TaskRepositoryInterface;
use App\Contracts\Repositories\UserRepositoryInterface;
use App\Contracts\Services\AvatarServiceInterface;
use App\Repositories\EloquentConversationRepository;
use App\Repositories\EloquentMentorRepository;
use App\Repositories\EloquentOverviewRepository;
use App\Repositories\EloquentSettingsRepository;
use App\Repositories\EloquentTaskRepository;
use App\Repositories\EloquentUserRepository;
use App\Services\DiceBearAvatarService;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ConversationRepositoryInterface::class, EloquentConversationRepository::class);
        $this->app->bind(MentorRepositoryInterface::class, EloquentMentorRepository::class);
        $this->app->bind(OverviewRepositoryInterface::class, EloquentOverviewRepository::class);
        $this->app->bind(SettingsRepositoryInterface::class, EloquentSettingsRepository::class);
        $this->app->bind(TaskRepositoryInterface::class, EloquentTaskRepository::class);
        $this->app->bind(UserRepositoryInterface::class, EloquentUserRepository::class);

        $this->app->singleton(AvatarServiceInterface::class, DiceBearAvatarService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('login', function (Request $request): Limit {
            $identifier = strtolower((string) $request->input('email')).'|'.$request->ip();

            return Limit::perMinute(5)
                ->by($identifier)
                ->response(function (Request $request, array $headers) {
                    return response()->json([
                        'message' => 'Too many login attempts. Please try again later.',
                    ], 429, $headers);
                });
        });
    }
}
