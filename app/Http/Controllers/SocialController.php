<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use Facebook\Facebook;

class SocialController extends Controller
{
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        $user = Socialite::driver('facebook')->user();

        $fb = new Facebook([
            'app_id' => env('FACEBOOK_CLIENT_ID'),
            'app_secret' => env('FACEBOOK_CLIENT_SECRET'),
            'default_graph_version' => 'v12.0',
        ]);

        $linkData = [
            'link' => 'https://your-site-link.com',
            'message' => 'Check out this amazing content!',
        ];

        try {
            $response = $fb->post('/me/feed', $linkData, $user->token);
        } catch (Facebook\Exceptions\FacebookResponseException $e) {
            // Handle error
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            // Handle error
        }

        return redirect()->route('home')->with('success', 'Posted to Facebook successfully!');
    }

    public function redirectToInstagram()
    {
        return Socialite::driver('instagram')->redirect();
    }

    public function handleInstagramCallback()
    {
        $user = Socialite::driver('instagram')->user();

        //API instagram perlu third party services.
    }
}
