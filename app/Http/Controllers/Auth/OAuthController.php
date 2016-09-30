<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\User\CreateUser;
use App\User;
use Exception;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Http\Request;
use Laravel\Socialite\AbstractUser;
use Laravel\Socialite\Facades\Socialite;

class OAuthController extends Controller
{
    use RedirectsUsers;

    protected $redirectTo = '/';

    /**
     * OAuthController constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->middleware('guest');
    }

    /**
     * A user is requesting to login through a given provider.
     *
     * @param $provider string Requested provider
     *
     * @throws Exception
     */
    public function handleProviderRequest($provider)
    {
        $method = $this->getRedirectionMethodName($provider);

        if (method_exists($this, $method)) {
            return $this->$method();
        }

        throw new Exception('Social provider not found.');
    }

    /**
     * Get the method's name for redirecting the user to the provider's
     * login/authorization page.
     *
     * @param $provider string Requested provider
     *
     * @return string
     */
    protected function getRedirectionMethodName($provider)
    {
        return 'handle' . ucfirst(camel_case($provider)) . 'ProviderRedirection';
    }

    /**
     * The user has left the authorization page of the provider, and has
     * been set back. We now need to re-route the request based on the
     * provider.
     *
     * @param         $provider string Requested provider
     * @param Request $request
     *
     * @return mixed
     * @throws Exception
     */
    public function handleProviderCallback($provider, Request $request)
    {
        $method = $this->getCallbackMethodName($provider);

        if (method_exists($this, $method)) {
            return $this->$method($request);
        }

        throw new Exception('Social provider not found.');
    }

    /**
     * Get the method's name for handling the user's token after
     * authorization.
     *
     * @param $provider string Requested provider
     *
     * @return string
     */
    protected function getCallbackMethodName($provider)
    {
        return 'handle' . ucfirst(camel_case($provider)) . 'ProviderCallback';
    }

    /**
     * Redirect the user to the Google provider.
     *
     * @return mixed
     */
    protected function handleGoogleProviderRedirection()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Redirect the user to the Facebook provider.
     *
     * @return mixed
     */
    protected function handleFacebookProviderRedirection()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Handle the response from Google's API after authorization.
     *
     * @param Request $request
     *
     * @return mixed
     */
    protected function handleGoogleProviderCallback(Request $request)
    {
        $abstractUser = Socialite::driver('google')->user();

        if (!$user = $this->findUser($abstractUser)) {
            $user = $this->createUser($abstractUser);
        }

        $this->login($user, $request);

        return redirect()->intended($this->redirectPath());
    }

    /**
     * Returns a User instance if it exists in our database, null otherwise.
     *
     * @param AbstractUser $user
     *
     * @return User|null
     */
    protected function findUser(AbstractUser $user)
    {
        return User::whereEmail($user->email)->first();
    }

    /**
     * Store a new user in our database, using the abstract user returned
     * from Socialite.
     *
     * @param AbstractUser $user
     *
     * @return User
     */
    protected function createUser(AbstractUser $user)
    {
        return $this->dispatch(new CreateUser([
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'avatar' => $user->getAvatar(),
        ]));
    }

    /**
     * Login the user.
     *
     * @param $user
     * @param $request
     */
    protected function login($user, $request)
    {
        auth()->login($user, true);
    }

    /**
     * Handle the response from Facebook's API after authorization.
     *
     * @param Request $request
     *
     * @return mixed
     */
    protected function handleFacebookProviderCallback(Request $request)
    {
        $abstractUser = Socialite::driver('facebook')->user();

        if (!$user = $this->findUser($abstractUser)) {
            $user = $this->createUser($abstractUser);
        }

        $this->login($user, $request);

        return redirect()->intended($this->redirectPath());
    }
}