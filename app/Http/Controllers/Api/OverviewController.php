<?php

namespace App\Http\Controllers\Api;

use App\Actions\Overview\GetOverviewAction;
use App\Actions\User\ResolveCurrentUserAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\OverviewResource;
use Illuminate\Http\Request;

class OverviewController extends Controller
{
    public function __construct(
        private readonly ResolveCurrentUserAction $resolveCurrentUser,
        private readonly GetOverviewAction $getOverview,
    ) {
    }

    public function __invoke(Request $request): OverviewResource
    {
        $user = ($this->resolveCurrentUser)($request->user());

        return new OverviewResource(($this->getOverview)($user));
    }
}
