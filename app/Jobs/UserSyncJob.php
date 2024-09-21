<?php

namespace App\Jobs;



use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\Middleware\RateLimited;
use Illuminate\Support\Facades\Log;


class UserSyncJob implements ShouldQueue
{
    use Queueable;

    public $users;

    public function middleware(): array
    {
        return [(new RateLimited('sync_users'))->dontRelease()];
    }


    /**
     * Create a new job instance.
     */
    public function __construct($users)
    {
        //
        $this->users=$users;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //

        $post_url = 'https://api.sample-post-url.app'; //sample post url
        $data = [
            'batches'=>[
                'subscribers'=>[

                    ]
            ]
        ];
        foreach ($this->users as $user){
            $user_data=[
                'email'=>$user->email,
                'first_name'=>$user->first_name,
                'last_name'=>$user->last_name,
                'time_zone'=>$user->time_zone
            ];

            $data['batches']['subscribers'][]=$user_data;
        }

        // sync users
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $post_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_POST, 1);
        $headers = array();
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);

        $res=json_decode($result);
        if ($res->status=='success'){
            $this->users->each(function ($user) {
                $user->update([
                    'sync_status' => true,
                ]);
            });
        }

    }
}
