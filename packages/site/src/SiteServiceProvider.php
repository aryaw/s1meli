<?php

namespace Site;

use Cms\User\Http\Models\UserModel;
use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;

use GuzzleHttp\Client;

class SiteServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {        
        $this->loadMigrationsFrom(realpath(__DIR__.'/Migrations'));
        $this->loadViewsFrom(realpath(__DIR__.'/Views/'), 'site');
        $this->mapping($this->app->router);       

        $this->app['validator']->extend('gmail_check', function ($attribute, $value, $parameters)
        {
            // check tanpa dot for gmail
            $arrEmail = explode('@',strtolower($value));
            if(isset($arrEmail[1])){
                if($arrEmail[1]=='gmail.com' || $arrEmail[1]=='googlemail.com'){
                    $validString = str_replace('.', '', $arrEmail[0]);
                    $validEmail = $validString.'@'.$arrEmail[1];

                    $user = UserModel::where('email_gmail', $validEmail)
                                ->select('users.id as user_id')
                                ->first();
                    if($user){
                        return false;
                    }
                }
            }
            
            $user2 = UserModel::where('email', $value)->first();
            if($user2){
                return false;
            }

            return true;
        });

        
        $this->app['validator']->extend('email_check_forgot', function ($attribute, $value, $parameters)
        {
            $user = UserModel::where('email', $value)->first();
            if($user){
                return true;
            }
            return false;
        });

        $this->app['validator']->extend('google_recaptcha', function($attribute, $value, $parameters){
            $client = new Client();
            $response = $client->post('https://www.google.com/recaptcha/api/siteverify',
                [
                    'form_params' => [
                        'secret' => config('max.google_recaptcha_secret'),
                        'remoteip' => request()->getClientIp(),
                        'response' => $value
                    ]
                ]
            );
            $body = json_decode((string)$response->getBody());
            if($body){
                if(isset($body->success) && $body->success===true){
                    return true;
                }
            }
            return false;
        });

    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {        
    }

    protected function mapping(Router $router)
    {
        $router->group(['namespace' => 'Site\Controllers'], function ($route) {
            require realpath(__DIR__.'/Routes/web.php');
        });
    }
}