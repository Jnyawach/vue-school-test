<?php

namespace App\Console\Commands;

use App\Actions\UserAction;
use App\Models\User;
use Illuminate\Console\Command;

class UserUpdateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update user details including firstname, lastname and timezone.';

    /**
     * Execute the console command.
     */
    public function handle(UserAction $action)
    {
        //
        try {
            $action->updateAllUsers();
            $this->info('All users updated successfully!');
        }catch (\Exception $e){
            $this->error($e->getMessage());
        }


    }
}
