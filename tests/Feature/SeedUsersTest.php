<?php

use App\Models\User;

test('test user seeder', function () {
    $this->artisan('migrate:fresh --seed');
    $userCount = User::count();
    expect($userCount)->toBeGreaterThan(0);

});
