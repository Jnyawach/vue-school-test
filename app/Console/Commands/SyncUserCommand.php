<?php

namespace App\Console\Commands;

use App\Actions\UserAction;
use Illuminate\Console\Command;

class SyncUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync users to external api';

    /**
     * Execute the console command.
     */
    public function handle(UserAction $action)
    {
        //
        try {
            $action->syncUsers();
            $this->info('All users synced successfully!');
        }catch (\Exception $e){
            $this->error($e->getMessage());
        }
    }
}
