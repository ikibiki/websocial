<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'third_party/LinkedIn/LinkedIn.php';

class LinkedInCI {

    protected $CI;

    public function __construct() {
        $this->CI = & get_instance();
    }

    public function getLoginLink() {
        $li = new \LinkedIn\LinkedIn(
                array(
            'api_key' => LINKEDIN_APP,
            'api_secret' => LINKEDIN_SECRET,
            'callback_url' => 'http://localhost/websocial/social/linkedin'
                )
        );
        $url = $li->getLoginUrl(
                array(
                    \LinkedIn\LinkedIn::SCOPE_BASIC_PROFILE,
                    \LinkedIn\LinkedIn::SCOPE_EMAIL_ADDRESS,
                    \LinkedIn\LinkedIn::SCOPE_WRITE_SHARE
                )
        );
        return $url;
    }

    public function getLinkedinProfile($accesstoken) {
        $li = new \LinkedIn\LinkedIn(
                array(
            'api_key' => LINKEDIN_APP,
            'api_secret' => LINKEDIN_SECRET,
            'callback_url' => 'http://localhost/websocial/social/linkedin'
                )
        );
        $li->setAccessToken($accesstoken);
        $info = $li->get('/people/~?format=json)');
        return $info;
    }

    public function getLinkedinCallback() {
        $li = new \LinkedIn\LinkedIn(
                array(
            'api_key' => LINKEDIN_APP,
            'api_secret' => LINKEDIN_SECRET,
            'callback_url' => 'http://localhost/websocial/social/linkedin'
                )
        );
        $token = $li->getAccessToken($_GET['code']);
        $_SESSION['linkedin_access_token'] = $token;
        return $token;
    }

    public function createPost($accesstoken, $msg) {
        $li = new \LinkedIn\LinkedIn(
                array(
            'api_key' => LINKEDIN_APP,
            'api_secret' => LINKEDIN_SECRET,
            'callback_url' => 'http://localhost/websocial/social/linkedin'
                )
        );
        $li->setAccessToken($accesstoken);
        $info = $li->post('/people/~/shares?format=json)', array(
            'comment' => $msg,
            'visibility' => array(
                'code' => 'anyone',
            ),
        ));
        return $info;
    }

    public function revokeLinkedin() {
        
    }

    protected function setMessage($title, $text, $type) {
        $this->CI->session->set_flashdata('msg', array('title' => $title, 'text' => $text, 'type' => $type));
    }

}
