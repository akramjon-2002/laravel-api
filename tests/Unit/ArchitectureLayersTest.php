<?php

arch('api controllers do not use repository implementations')
    ->expect('App\Http\Controllers\Api')
    ->not->toUse('App\Repositories');

arch('api controllers do not use the DB facade')
    ->expect('App\Http\Controllers\Api')
    ->not->toUse('Illuminate\Support\Facades\DB');

arch('actions do not use the DB facade directly')
    ->expect('App\Actions')
    ->not->toUse('Illuminate\Support\Facades\DB');

arch('repositories do not depend on HTTP concerns')
    ->expect('App\Repositories')
    ->not->toUse('Illuminate\Http');

arch('services do not depend on controllers or DB facades')
    ->expect('App\Services')
    ->not->toUse([
        'App\Http\Controllers',
        'Illuminate\Support\Facades\DB',
    ]);
