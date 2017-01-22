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

        return response()->json([
            'url' => $url
        ]);
    }

    public function finalise(Request $request) {
        session_start();

        if(isset($_SESSION['access_token']) && $_SESSION['access_token']) {
            $access_token = $_SESSION['access_token'];
            $connection = new TwitterOAuth($this->consumer_key, $this->consumer_secret, $access_token['oauth_token'], $access_token['oauth_token_secret']);
            $user = $connection->get("account/verify_credentials");

            $handle = $user->screen_name;

            return view('tweet')->with('handle', $handle);
        } else {
            $oauth_token = $_SESSION['oauth_token'];
            $oauth_token_secret = $_SESSION['oauth_token_secret'];

            if ($request->input('oauth_token') !== false && $oauth_token !== $request->input('oauth_token')) {
                abort(422, 'Missing parameters.');
            }

            $connection = new TwitterOAuth($this->consumer_key, $this->consumer_secret, $oauth_token, $oauth_token_secret);

            $access_token = $connection->oauth('oauth/access_token', array(
                'oauth_verifier' => $request->input('oauth_verifier')
            ));

            $_SESSION['access_token'] = $access_token;

            $connection = new TwitterOAuth($this->consumer_key, $this->consumer_secret, $access_token['oauth_token'], $access_token['oauth_token_secret']);
            $user = $connection->get("account/verify_credentials");

            $handle = $user->screen_name;

            if($access_token) {
                return view('tweet')->with('handle', $handle);
            } else {
                redirect()->route('/');
            }
        }
    }

    public function sendTweets(Request $request) {
        session_start();

        if(isset($_SESSION['access_token'])) {

            $sections = $request->input('sections');

            //if this were full Laravel we'd make a custom Request and validate here
            if(empty($sections))
                abort(422, 'Missing parameters.');

            $access_token = $_SESSION['access_token'];
            $connection = new TwitterOAuth($this->consumer_key, $this->consumer_secret, $access_token['oauth_token'], $access_token['oauth_token_secret']);

            $sections = $request->input('sections');

            $user = $connection->get("account/verify_credentials");

            $responses = array();
            $previous = false;

            foreach ($sections as $key => $section) {
                if($previous) {
                    $status = $connection->post('statuses/update', array(
                        'status' => $section,
                        'in_reply_to_status_id' => $previous
                    ));
                    $previous = $status->id;
                    $responses[] = $status;
                } else {
                    $status = $connection->post('statuses/update', array(
                        'status' => $section
                    ));
                    $previous = $status->id;
                    $responses[] = $status;
                }
            }
            return response()->json([
                'status' => 200,
                'response' => $responses
            ]);
        } else {
            abort(400, 'Missing parameters.');
        }
    }
}
