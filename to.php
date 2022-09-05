<?php

return [
//'users'=>[//old table
    'users' => [//new table
        'id' => 'users.id' ?? null,// column=>data(new)
        'first_name' => 'users.name' ?? null,
        'last_name' => 'users.lastname' ?? null,
        'email' => 'users.email' ?? null,
        'password' => 'users_passwd.passwd' ?? null,
        'is_active' => 'users.activated' ?? 0,
        'language' => 'users.lang' ?? 'en',
    ],
    'mt4_web_registers' => [
        'user_id' => 'users.id',
        'leverage_id' => 'relation:'
    ],
//]
//    'users' => [//table
//        'id' => 'users.id' ?? null,// column=>data
//        'first_name' => 'users.name' ?? null,
//        'last_name' => 'users.lastname' ?? null,
//        'email' => 'users.email' ?? null,
//        'password' => 'users_passwd.passwd' ?? null,
//        'is_active' => 'users.activated' ?? 0,
//        'language' => 'users.lang' ?? 'en',
//    ],
//    'mt4_web_registers'=>[
//        'user_id' => 'users.id',
//        'leverage_id' => 'relation:'
//    ],
];

