<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Laravel\Socialite\Facades\Socialite;
use File;
use App\User;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }
    protected $providers = [
        'github',
        'facebook',
        'google',
        'twitter'
    ];
     /**
     * Redirect the user to the OAuth Provider.
     *
     * @return Response
     */
    public function redirectToProvider($provider){
        if( ! $this->isProviderAllowed($provider) ) {
            return $this->sendFailedResponse("{$provider} không được hỗ trợ");
        }
        try {
            return Socialite::driver($provider)->redirect();
        } catch (Exception $e) {
            // You should show something simple fail message
            return $this->sendFailedResponse($e->getMessage());
        }
    }
     
    public function handleProviderCallback($provider){
        try {
            $user = Socialite::driver($provider)->user();
        } catch (Exception $e) {
            return $this->sendFailedResponse($e->getMessage());
        }
        // check for email in returned user
        return empty( $user->email )
            ? $this->sendFailedResponse("Email không hợp lệ.")
            : $this->loginOrCreateAccount($user, $provider);
    }
    /**
     * Send a successful response
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendSuccessResponse()
    {
        return redirect()->intended('/');
    }
    //Send a failed response with a msg
    protected function sendFailedResponse($msg = null)
    {
        return redirect()->route('login')
            ->withErrors(['msg' => $msg ?: 'Không thể đăng nhập, hãy thử lại với tài khoản khác.']);
    }
     /**
     * If a user has registered before using social auth, return the user
     * else, create a new user object.
     * @param  $user Socialite user object
     * @param $provider Social auth provider
     * @return  User
     */
    public function loginOrCreateAccount($providerUser, $provider){
        // check for already has account
        $user = User::where('email', $providerUser->getEmail())->first();
        // if user not found
        if( !$user ) {
             // create a new user
             $user = User::create([
                'name' => $providerUser->getName(),
                'email' => $providerUser->getEmail(),
                'avatar' => $providerUser->getAvatar(),
                'provider' => $provider,
                'provider_id' => $providerUser->getId(),
                'access_token' => $providerUser->token,
                // user can use reset password to create a password
                'password' => ''
            ]);
        }
        // login the user
        Auth::login($user, true);
        return $this->sendSuccessResponse();
    }
     /**
     * Check for provider allowed and services configured
     *
     * @param $driver
     * @return bool
     */
    private function isProviderAllowed($provider)
    {
        return in_array($provider, $this->providers) && config()->has("services.{$provider}");
    }
}
