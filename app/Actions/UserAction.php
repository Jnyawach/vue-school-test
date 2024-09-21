<?php

namespace App\Actions;

use App\Jobs\UserSyncJob;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Batch;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;


class UserAction
{
    public function getUsers(){
        // get users
        try {
            return User::all();
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }

   public function updateUser(User $user){
       try {
           $user->update([
               'first_name'=>fake()->name(),
               'last_name'=>fake()->name(),
               'sync_status'=>false,
               'time_zone'=>fake()->randomElement(['CET', 'CST', 'GMT+1']),
           ]);
       }catch (\Exception $e){
           return $e->getMessage();
       }
   }

   public function updateAllUsers()
   {
       try {
           $users=$this->getUsers();
           foreach ($users as $user){
               $this->updateUser($user);
           }
       }catch (\Exception $e){
           return $e->getMessage();
       }
   }

   public function syncUsers(){
       try {
           User::where('updated_at', '>=', Carbon::now()->subHour())
               ->where('sync_status',false)
               ->limit(40000)
               ->chunk(1000, fn($users)=>UserSyncJob::dispatch($users));



       }catch (\Exception $e){
           return $e->getMessage();
       }


   }
}
