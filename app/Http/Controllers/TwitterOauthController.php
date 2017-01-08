<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use \Abraham\TwitterOAuth\TwitterOAuth;

class TwitterOauthController extends Controller
{
    private $consumer_key;
    private $consumer_secret;
    private $oauth_callback;

    private $access_token;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->consumer_key = env('CONSUMER_KEY');
        $this->consumer_secret = env('CONSUMER_SECRET');
        $this->oauth_callback = env('OAUTH_CALLBACK');
    }

    public function authorise(Request $request) {
        session_start();

        $connection = new TwitterOAuth($this->consumer_key, $this->consumer_secret);

        $request_token = $connection->oauth('oauth/request_token', array(
            'oauth_callback' => $this->oauth_callback
        ));

        $_SESSION['oauth_token'] = $request_token['oauth_token'];
        $_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];

        $url = $connection->url('oauth/authorize', array(
            'oauth_token' => $request_token['oauth_token']
        ));

        return array(
            'url' => $url
        );
    }

    public function finalise(Request $request) {
        session_start();

        if(isset($_SESSION['access_token']) && $_SESSION['access_token']) {
            return view('tweet');
        } else {
            $oauth_token = $_SESSION['oauth_token'];
            $oauth_token_secret = $_SESSION['oauth_token_secret'];

            if ($request->input('oauth_token') !== false && $oauth_token !== $request->input('oauth_token')) {
                abort(500, 'Missing parameters.');
            }

            $connection = new TwitterOAuth($this->consumer_key, $this->consumer_secret, $oauth_token, $oauth_token_secret);

            $this->access_token = $connection->oauth('oauth/access_token', array(
                'oauth_verifier' => $request->input('oauth_verifier')
            ));

            $_SESSION['access_token'] = $this->access_token;

            if($this->access_token) {
                return view('tweet');
            } else {
                redirect()->route('/');
            }
        }
    }

    public function sendTweets(Request $request) {
        if(isset($_SESSION['access_token']) && $_SESSION['access_token']) {

        } else {
            redirect()->route('/');
        }
    }
}
