<?php

namespace App\Http\Controllers\Api;

use App\Actions\Mentor\FollowMentorAction;
use App\Actions\Mentor\GetMentorDetailsAction;
use App\Actions\Mentor\GetRecentMentorsAction;
use App\Actions\Mentor\ListMentorsAction;
use App\Actions\Mentor\UnfollowMentorAction;
use App\Actions\User\ResolveCurrentUserAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ListMentorsRequest;
use App\Http\Resources\MentorResource;
use App\Models\Mentor;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class MentorController extends Controller
{
    public function __construct(
        private readonly ResolveCurrentUserAction $resolveCurrentUser,
        private readonly ListMentorsAction $listMentors,
        private readonly GetRecentMentorsAction $getRecentMentors,
        private readonly GetMentorDetailsAction $getMentorDetails,
        private readonly FollowMentorAction $followMentor,
        private readonly UnfollowMentorAction $unfollowMentor,
    ) {
    }

    public function index(ListMentorsRequest $request): AnonymousResourceCollection
    {
        $user = ($this->resolveCurrentUser)($request->user());
        $mentors = ($this->listMentors)($request->validated(), $user);

        return MentorResource::collection($mentors);
    }

    public function recent(Request $request): AnonymousResourceCollection
    {
        $user = ($this->resolveCurrentUser)($request->user());

        return MentorResource::collection(($this->getRecentMentors)($user));
    }

    public function show(Request $request, int $mentor): MentorResource
    {
        $user = ($this->resolveCurrentUser)($request->user());
        $mentorModel = ($this->getMentorDetails)($mentor, $user);

        return new MentorResource($mentorModel);
    }

    public function follow(Request $request, Mentor $mentor): MentorResource
    {
        $user = ($this->resolveCurrentUser)($request->user());

        ($this->followMentor)($user, $mentor);

        return new MentorResource(($this->getMentorDetails)($mentor->id, $user));
    }

    public function unfollow(Request $request, Mentor $mentor): MentorResource
    {
        $user = ($this->resolveCurrentUser)($request->user());

        ($this->unfollowMentor)($user, $mentor);

        return new MentorResource(($this->getMentorDetails)($mentor->id, $user));
    }
}
