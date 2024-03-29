<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    |
    | This option controls the default authentication "guard" and password
    | reset options for your application. You may change these defaults
    | as required, but they're a perfect start for most applications.
    |
    */

    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    |
    | Next, you may define every authentication guard for your application.
    | Of course, a great default configuration has been defined for you
    | here which uses session storage and the Eloquent user provider.
    |
    | All authentication drivers have a user provider. This defines how the
    | users are actually retrieved out of your database or other storage
    | mechanisms used by this application to persist your user's data.
    |
    | Supported: "session"
    |
    */

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
        'superadmin'=>[
            'driver' => 'session',
            'provider' => 'superadmins',
        ],
        'employe'=>[
            'driver' => 'session',
            'provider' => 'employes',
        ],
        'director'=>[
            'driver' => 'session',
            'provider' => 'directors',
        ],
        'president'=>[
            'driver' => 'session',
            'provider' => 'presidents',
        ],
        'administrative'=>[
            'driver' => 'session',
            'provider' => 'administratives',
        ],
        'finenciere'=>[
            'driver' => 'session',
            'provider' => 'finencieres',
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    |
    | All authentication drivers have a user provider. This defines how the
    | users are actually retrieved out of your database or other storage
    | mechanisms used by this application to persist your user's data.
    |
    | If you have multiple user tables or models you may configure multiple
    | sources which represent each model / table. These sources may then
    | be assigned to any extra authentication guards you have defined.
    |
    | Supported: "database", "eloquent"
    |
    */

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],
        'superadmins' => [
            'driver' => 'eloquent',
            'model' => App\Models\Auth\admins\SuperAdmin::class,
        ],
        'employes' => [
            'driver' => 'eloquent',
            'model' => \App\Models\Auth\employe\Employe::class,
        ],
        'directors' => [
            'driver' => 'eloquent',
            'model' => \App\Models\Directory\Director::class,
        ],
        'presidents' => [
            'driver' => 'eloquent',
            'model' => \App\Models\Directory\President::class,
        ],
        'administratives' => [
            'driver' => 'eloquent',
            'model' => \App\Models\Auth\admins\AdminAdministrative::class,
        ],
        'finencieres' => [
            'driver' => 'eloquent',
            'model' => \App\Models\Auth\admins\AdminFinancieres::class,
        ],

        // 'users' => [
        //     'driver' => 'database',
        //     'table' => 'users',
        // ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Resetting Passwords
    |--------------------------------------------------------------------------
    |
    | You may specify multiple password reset configurations if you have more
    | than one user table or model in the application and you want to have
    | separate password reset settings based on the specific user types.
    |
    | The expire time is the number of minutes that each reset token will be
    | considered valid. This security feature keeps tokens short-lived so
    | they have less time to be guessed. You may change this as needed.
    |
    | The throttle setting is the number of seconds a user must wait before
    | generating more password reset tokens. This prevents the user from
    | quickly generating a very large amount of password reset tokens.
    |
    */

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
        'superadmins' => [
            'provider' => 'superadmins',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
        'employes' => [
            'provider' => 'employes',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
        'directors' => [
            'provider' => 'directors',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
        'presidents' => [
            'provider' => 'presidents',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
        'administratives' => [
            'provider' => 'administratives',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
        'finencieres' => [
            'provider' => 'finencieres',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Password Confirmation Timeout
    |--------------------------------------------------------------------------
    |
    | Here you may define the amount of seconds before a password confirmation
    | times out and the user is prompted to re-enter their password via the
    | confirmation screen. By default, the timeout lasts for three hours.
    |
    */

    'password_timeout' => 10800,

];
