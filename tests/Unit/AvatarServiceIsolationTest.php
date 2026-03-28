<?php

use App\Contracts\Services\AvatarServiceInterface;
use App\Services\DiceBearAvatarService;
use Tests\TestCase;

uses(TestCase::class);

it('generates dicebear avatar urls without network calls', function (): void {
    $service = new DiceBearAvatarService();

    expect($service->makeAvatarUrl('Sarah Johnson'))
        ->toContain('api.dicebear.com/7.x/avataaars/svg')
        ->toContain('seed=Sarah+Johnson');
});

it('allows the avatar service to be replaced with a fake in tests', function (): void {
    $fake = new class implements AvatarServiceInterface
    {
        public function makeAvatarUrl(string $seed): string
        {
            return 'https://fake.test/avatar/'.strtolower(str_replace(' ', '-', $seed)).'.svg';
        }
    };

    $this->app->instance(AvatarServiceInterface::class, $fake);

    expect(app(AvatarServiceInterface::class)->makeAvatarUrl('Sarah Johnson'))
        ->toBe('https://fake.test/avatar/sarah-johnson.svg');
});
