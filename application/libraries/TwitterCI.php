<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'third_party/codebird/codebird.php';

class TwitterCI {

    protected $CI;

    public function __construct() {
        $this->CI = & get_instance();
    }

    public function loginTwitter() {

        $callbackurl = '';
        if (ENVIRONMENT === 'development') {
            $callbackurl = 'http://localhost/websocial/social/twitter';
        } else {
            $callbackurl = 'http://websocial.theshiftleft.com/social/twitter';
        }

        \Codebird\Codebird::setConsumerKey(TWITTER_APP, TWITTER_SECRET); // static, see README
        $cb = \Codebird\Codebird::getInstance();
        $reply = $cb->oauth_requestToken([
            'oauth_callback' => $callbackurl
        ]);

        $cb->setToken($reply->oauth_token, $reply->oauth_token_secret);
        $_SESSION['oauth_token'] = $reply->oauth_token;
        $_SESSION['oauth_token_secret'] = $reply->oauth_token_secret;
        $_SESSION['oauth_callback_confirmed'] = true;

        $auth_url = $cb->oauth_authorize();
        header('Location: ' . $auth_url);
        exit;
    }

    public function getTwCallback() {
        \Codebird\Codebird::setConsumerKey(TWITTER_APP, TWITTER_SECRET);
        $cb = \Codebird\Codebird::getInstance();

        $cb->setToken($_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);
        unset($_SESSION['oauth_verify']);

        $reply = $cb->oauth_accessToken([
            'oauth_verifier' => $_GET['oauth_verifier']
        ]);

        $_SESSION['oauth_token'] = $reply->oauth_token;
        $_SESSION['oauth_token_secret'] = $reply->oauth_token_secret;
    }

    public function getTwitterProfile($accesstoken, $accesstokensecret) {
        \Codebird\Codebird::setConsumerKey(TWITTER_APP, TWITTER_SECRET);
        $cb = \Codebird\Codebird::getInstance();
        $cb->setToken($accesstoken, $accesstokensecret);
        $reply = $cb->account_verifyCredentials('include_email=true&include_entities=true&skip_status=true');
        return $reply;
    }

    public function tweet($msg, $accesstoken, $accesstokensecret) {
        \Codebird\Codebird::setConsumerKey(TWITTER_APP, TWITTER_SECRET);
        $cb = \Codebird\Codebird::getInstance();
        $cb->setToken($accesstoken, $accesstokensecret);
        $reply = $cb->statuses_update('status=' . urlencode($msg));
        return $reply;
    }

    public function twitterLogout($accesstoken, $accesstokensecret) {
        \Codebird\Codebird::setConsumerKey(TWITTER_APP, TWITTER_SECRET);
        $cb = \Codebird\Codebird::getInstance();

        $cb->logout();
    }

    protected function setMessage($title, $text, $type) {
        $this->CI->session->set_flashdata('msg', array('title' => $title, 'text' => $text, 'type' => $type));
    }

}
