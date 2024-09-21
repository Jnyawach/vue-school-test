<?php

use Illuminate\Support\Facades\Artisan;

test('update all users', function () {
    $exitCode=Artisan::call('user:update');
    $output = Artisan::output();
    expect($exitCode)->toBe(0);
    expect($output)->toContain('All users updated successfully!');
});
