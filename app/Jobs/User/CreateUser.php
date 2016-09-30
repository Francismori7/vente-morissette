<?php

namespace App\Jobs\User;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;

class CreateUser
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var array
     */
    private $data;

    /**
     * Create a new job instance.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return User
     */
    public function handle()
    {
        return User::create([
            'name' => $this->data['name'],
            'city' => $this->data['city'] ?? 'N/A',
            'avatar' => $this->data['avatar'] ?? null,
            'email' => $this->data['email'],
            'password' => $this->data['password'] ?? bcrypt(str_random(36)),
        ]);
    }
}
