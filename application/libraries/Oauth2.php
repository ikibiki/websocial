<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'third_party/oauth2-client/vendor/autoload.php';

class Oauth2 {

    protected $CI;

    public function __construct() {
        $this->CI = & get_instance();
    }

    public function facebook() {

        $provider = new \League\OAuth2\Client\Provider\Facebook([
            'clientId' => '147803949109037',
            'clientSecret' => '7991382e239b602628a44899b08f0f1b',
            'redirectUri' => 'http://localhost/websocial/welcome/facebook',
            'graphApiVersion' => 'v2.9',
        ]);

        if (!isset($_GET['code'])) {

            // If we don't have an authorization code then get one
            $authUrl = $provider->getAuthorizationUrl([
                'scope' => ['email', 'first_name', 'last_name', 'gender', 'name', 'cover', 'picture'],
            ]);
            $_SESSION['oauth2state'] = $provider->getState();

            $atts = array(
                'width' => 800,
                'height' => 600,
                'scrollbars' => 'yes',
                'status' => 'yes',
                'resizable' => 'no',
                'window_name' => 'Facebook'
            );

            echo anchor_popup($authUrl, 'Login to Facebook', $atts);
            echo "<br/><a href='$authUrl'>Login to Facebook</a>";
            exit;

// Check given state against previously stored one to mitigate CSRF attack
        } elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {

            unset($_SESSION['oauth2state']);
            echo 'Invalid state.';
            exit;
        }

// Try to get an access token (using the authorization code grant)
        $token = $provider->getAccessToken('authorization_code', [
            'code' => $_GET['code']
        ]);

// Optional: Now you have a token you can look up a users profile data
        try {

            // We got an access token, let's now get the user's details
            $user = $provider->getResourceOwner($token);

            // Use these details to create a new profile
            printf('Hello %s!', $user->getFirstName());

            echo '<pre>';
            var_dump($user);
            # object(League\OAuth2\Client\Provider\FacebookUser)#10 (1) { ...
            echo '</pre>';
        } catch (\Exception $e) {

            // Failed to get user details
            exit('Oh dear...');
        }

        echo '<pre>';
// Use this to interact with an API on the users behalf
        var_dump($token->getToken());
# string(217) "CAADAppfn3msBAI7tZBLWg...
// The time (in epoch time) when an access token will expire
        var_dump($token->getExpires());
# int(1436825866)
        echo '</pre>';
    }

    public function instagram() {
        $provider = new League\OAuth2\Client\Provider\Instagram([
            'clientId' => '043b90f26aa04a0ab204a2ddb5700078',
            'clientSecret' => '1a39ff5dcd7b4fcfb45dce7e02c29241',
            'redirectUri' => 'http://localhost/websocial/welcome/instagram',
            'host' => 'https://api.instagram.com' // Optional, defaults to https://api.instagram.com
        ]);

        if (!isset($_GET['code'])) {
            $options = [
                'state' => 'OPTIONAL_CUSTOM_CONFIGURED_STATE',
                'scope' => ['basic', 'likes', 'comments'] // array or string
            ];
            // If we don't have an authorization code then get one
            $authUrl = $provider->getAuthorizationUrl($options);
            $_SESSION['oauth2state'] = $provider->getState();
            header('Location: ' . $authUrl);
            exit;

// Check given state against previously stored one to mitigate CSRF attack
        } elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {

            unset($_SESSION['oauth2state']);
            exit('Invalid state');
        } else {

            // Try to get an access token (using the authorization code grant)
            $token = $provider->getAccessToken('authorization_code', [
                'code' => $_GET['code']
            ]);

            // Optional: Now you have a token you can look up a users profile data
            try {

                // We got an access token, let's now get the user's details
                $user = $provider->getResourceOwner($token);

                // Use these details to create a new profile

                var_dump($provider);
                var_dump($user);
            } catch (Exception $e) {

                // Failed to get user details
                var_dump($e);
                exit('Oh dear...');
            }

            // Use this to interact with an API on the users behalf
            echo $token->getToken();
            var_dump($token);
        }
    }

    public function googleplus() {
        $provider = new League\OAuth2\Client\Provider\Google([
            'clientId' => '278969783450-40bg0o40ug2sak77jn8qkj1co22s9t2v.apps.googleusercontent.com',
            'clientSecret' => '	uGlgprbKCf-2gNr79aBUeES1',
            'redirectUri' => 'http://localhost/websocial/welcome/googleplus',
            'hostedDomain' => 'http://localhost',
        ]);

        if (!empty($_GET['error'])) {

            // Got an error, probably user denied access
            exit('Got error: ' . htmlspecialchars($_GET['error'], ENT_QUOTES, 'UTF-8'));
        } elseif (empty($_GET['code'])) {
            $options = [
                'scope' => [
                    'https://www.googleapis.com/auth/plus.login',
                    'https://www.googleapis.com/auth/plus.me',
                    'https://www.googleapis.com/auth/plus.stream.write',
                    'https://www.googleapis.com/auth/plus.stream.read',
                    'https://www.googleapis.com/auth/plus.media.upload',
                ] // array or string
            ];
            // If we don't have an authorization code then get one
            $authUrl = $provider->getAuthorizationUrl($options);
            $_SESSION['oauth2state'] = $provider->getState();
            header('Location: ' . $authUrl);
            exit;
        } elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {

            // State is invalid, possible CSRF attack in progress
            unset($_SESSION['oauth2state']);
            exit('Invalid state');
        } else {

            // Try to get an access token (using the authorization code grant)
            $token = $provider->getAccessToken('authorization_code', [
                'code' => $_GET['code']
            ]);

            // Optional: Now you have a token you can look up a users profile data
            try {

                var_dump($provider);
                die;
                
                $ownerDetails = $provider->getResourceOwner($token);

                // Use these details to create a new profile
                printf('Hello %s!', $ownerDetails->getFirstName());
            } catch (Exception $e) {

                // Failed to get user details
                exit('Something went wrong: ' . $e->getMessage());
            }

            // Use this to interact with an API on the users behalf
            echo $token->getToken();

            // Use this to get a new access token if the old one expires
            echo $token->getRefreshToken();

            // Number of seconds until the access token will expire, and need refreshing
            echo $token->getExpires();
        }
    }

}
