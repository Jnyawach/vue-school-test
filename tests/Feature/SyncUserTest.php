<?php

use App\Jobs\UserSyncJob;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Queue;

test ('test is the job is published', function (){
    Queue::fake();
    Queue::assertNothingPushed();
    Queue::assertPushed(UserSyncJob::class,2);

});

test('test if job dispatch works', function () {
    $exitCode=Artisan::call('sync:users');
    $output = Artisan::output();
    expect($exitCode)->toBe(0);
    expect($output)->toContain('All users synced successfully!');

});
