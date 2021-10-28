<?php

use App\Repositories\ConfigRepository;

return [
    'endpoint' => env('LINODE_API_ENDPOINT','https://api.linode.com/v4/'),
    'token' => fn()=>resolve(ConfigRepository::class)->get('token')
];
