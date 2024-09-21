<?php

namespace App\Actions;

use App\Models\User;


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
               'firstname'=>fake()->name(),
               'lastname'=>fake()->name(),
               'timezone'=>fake()->randomElement(['CET', 'CST', 'GMT+1']),
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
}
