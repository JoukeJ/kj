<?php namespace App\Providers;

use App\Services\PasswordBroker;

class PasswordResetServiceProvider extends \Illuminate\Auth\Passwords\PasswordResetServiceProvider
{
    /**
     * Register the password broker instance.
     *
     * @return void
     */
    protected function registerPasswordBroker()
    {
        $this->app->singleton('auth.password', function ($app) {
            // The password token repository is responsible for storing the email addresses
            // and password reset tokens. It will be used to verify the tokens are valid
            // for the given e-mail addresses. We will resolve an implementation here.
            $tokens = $app['auth.password.tokens'];

            $users = $app['auth']->driver()->getProvider();

            $view = 'emails.' . \Config::get('app.locale') . '.password';

            // The password broker uses a token repository to validate tokens and send user
            // password e-mails, as well as validating that password reset process as an
            // aggregate service of sorts providing a convenient interface for resets.
            return new PasswordBroker(
                $tokens, $users, $app['mailer'], $view
            );
        });
    }
}
