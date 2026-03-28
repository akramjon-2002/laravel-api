<?php

namespace App\Providers;

use App\Contracts\Repositories\ConversationRepositoryInterface;
use App\Contracts\Repositories\MentorRepositoryInterface;
use App\Contracts\Repositories\OverviewRepositoryInterface;
use App\Contracts\Repositories\SettingsRepositoryInterface;
use App\Contracts\Repositories\TaskRepositoryInterface;
use App\Contracts\Services\AvatarServiceInterface;
use App\Repositories\EloquentConversationRepository;
use App\Repositories\EloquentMentorRepository;
use App\Repositories\EloquentOverviewRepository;
use App\Repositories\EloquentSettingsRepository;
use App\Repositories\EloquentTaskRepository;
use App\Services\DiceBearAvatarService;
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

        $this->app->singleton(AvatarServiceInterface::class, DiceBearAvatarService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
