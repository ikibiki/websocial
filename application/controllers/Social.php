<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Social extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('UserAccount');
        $this->load->model('SocialAccount');
    }

    public function index() {
        redirect('app');
    }

    public function facebook($revoke = 1) {

        if (!boolval($revoke)) {
            $this->facebookci->revokeFB();
            redirect('app');
        } else {
            $this->facebookci->getFBCallback();
            $accesstoken = $this->session->userdata('fb_access_token');

            if ($this->isSessionActive()) {
                $profile = $this->facebookci->getFacebookProfile($accesstoken);
                $this->SocialAccount->updateAccessToken($user->ID, 'FB', $profile['id'], $accesstoken);

                $this->setMessage("Connect", "Twitter connected!", "success");
                redirect('app/connect');
            } else {

                if ($this->validateFB($accesstoken)) {
                    $profile = $this->facebookci->getFacebookProfile($accesstoken);
                    $social = $this->SocialAccount->getSocialAccountBySAID('FB', $profile['id']);
                    $user = $this->UserAccount->getUserInfo($social->User_Ref);
                    $this->session->set_userdata('user', $user);
                    $this->SocialAccount->updateAccessToken($user->ID, 'FB', $accesstoken);
                    $this->setMessage("Welcome", "You logged in with facebook!", "success");
                    redirect('app');
                } else {
                    $this->setMessage("Social Combo", "Oops... Your facebook account is not registered.", "danger");
                    redirect('login');
                }
            }
        }
    }

    public function twitter($login = 0) {
        if ($login == 1) {
            $this->twitterci->loginTwitter();
            exit;
        }
        $this->twitterci->getTwCallback();
        $accesstoken = $this->session->userdata('oauth_token');
        $accesstokensecret = $this->session->userdata('oauth_token_secret');

        if ($this->isSessionActive()) {
            $profile = $this->twitterci->getTwitterProfile($accesstoken, $accesstokensecret);
            $this->SocialAccount->updateAccessToken($user->ID, 'TW', $profile->screen_name, $accesstoken . ',' . $accesstokensecret);

            $this->setMessage("Connect", "Twitter connected!", "success");
            redirect('app/connect');
        } else {

            $profile = $this->twitterci->getTwitterProfile($accesstoken, $accesstokensecret);

            if ($this->validateTW($profile->screen_name)) {
                $profile = $this->twitterci->getTwitterProfile($accesstoken, $accesstokensecret);
                $social = $this->SocialAccount->getSocialAccountBySAID('TW', $profile->screen_name);
                $user = $this->UserAccount->getUserInfo($social->User_Ref);
                $this->session->set_userdata('user', $user);
                $this->SocialAccount->updateAccessToken($user->ID, 'TW', $accesstoken . ',' . $accesstokensecret);

                $this->setMessage("Welcome", "You logged in with twitter", "success");
                redirect('app');
            } else {
                $this->setMessage("Social Combo", "Oh.. Your twitter account is not registered.", "danger");
                redirect('login');
            }
        }
    }

    public function linkedin() {
        $this->linkedinci->getLinkedinCallback();
        $accesstoken = $this->session->userdata('linkedin_access_token');

        if ($this->isSessionActive()) {
            $profile = $this->linkedinci->getLinkedinProfile($accesstoken);
            $this->SocialAccount->updateAccessToken($user->ID, 'LIN', $profile['id'], $accesstoken);
            $this->setMessage("Connect", "LinkedIn connected!", "success");
            redirect('app/connect');
        } else {
            if ($this->validateLIN($accesstoken)) {
                $profile = $this->linkedinci->getLinkedinProfile($accesstoken);
                $social = $this->SocialAccount->getSocialAccountBySAID('LIN', $profile['id']);
                $user = $this->UserAccount->getUserInfo($social->User_Ref);
                $this->session->set_userdata('user', $user);
                $this->SocialAccount->updateAccessToken($user->ID, 'LIN', $accesstoken);
                $this->setMessage("Welcome", "You logged in with linked in!", "success");
                redirect('app');
            } else {
                $this->setMessage("Social Combo", "Uh oh.. Your linked in account is not registered.", "danger");
                redirect('login');
            }
        }
    }

    public function bind($socialcode, $userid) {
        $redir = 'app';
        switch ($socialcode) {
            case 'FB': {
                    $accesstoken = $this->session->userdata('fb_access_token');
                    $fbprofile = $this->facebookci->getFacebookProfile($accesstoken);

                    $this->SocialAccount->setSocialAccount($id = 0, $userid, 'FB', $fbprofile['id'], $accesstoken);
                    $this->setMessage('Success', 'Facebook bound to account.', 'success');
                }break;
            case 'TW': {
                    $accesstoken = $this->session->userdata('oauth_token');
                    $accesstokenseret = $this->session->userdata('oauth_token_secret');
                    $this->SocialAccount->setSocialAccount($id = 0, $userid, 'TW', $accesstoken, $accesstokenseret);
                    $this->setMessage('Success', 'Twitter bound to account.', 'success');
                }break;
            case 'LIN': {
                    $accesstoken = $this->session->userdata('linkedin_access_token');
                    $linprofile = $this->linkedinci->getLinkedinProfile($accesstoken);
                    $this->SocialAccount->setSocialAccount($id = 0, $userid, 'LIN', $linprofile['id'], $accesstoken);
                    $this->setMessage('Success', 'LinkedIn bound to account.', 'success');
                }break;
            default: {
                    $redir = 'app';
                }
        }
        redirect($redir);
    }

    public function unbind($socialcode, $userid) {
        $redir = 'app/connect';
        switch ($socialcode) {
            case 'FB': {
                    $this->SocialAccount->removeSocialAccount($socialcode, $userid);
                    $this->setMessage('Success', 'Facebook removed from account.', 'success');
                }break;
            case 'TW': {
                    $this->SocialAccount->removeSocialAccount($socialcode, $userid);
                    $this->setMessage('Success', 'Twitter removed from account.', 'success');
                }break;
            case 'LIN': {
                    $this->SocialAccount->removeSocialAccount($socialcode, $userid);
                    $this->setMessage('Success', 'LinkedIn removed from account.', 'success');
                }break;
            default: {
                    $redir = 'app';
                }
        }
        redirect($redir);
    }

    private function validateFB($accesstoken) {
        $profile = $this->facebookci->getFacebookProfile($accesstoken);
        $socialaccount = $this->SocialAccount->getSocialAccountBySAID('FB', $profile['id']);
        return $socialaccount ? true : false;
    }

    private function validateTW($twhandle) {
        $socialaccount = $this->SocialAccount->getSocialAccountBySAID('TW', $twhandle);
        return !empty($socialaccount) ? true : false;
    }

    private function validateLIN($accesstoken) {
        $linprofile = $this->linkedinci->getLinkedinProfile($accesstoken);
        $socialaccount = $this->SocialAccount->getSocialAccountBySAID('LIN', $linprofile['id']);
        return $socialaccount ? true : false;
    }

    protected function setMessage($title, $text, $type) {
        $this->session->set_flashdata('msg', array('title' => $title, 'text' => $text, 'type' => $type));
    }

    protected function isSessionActive() {
        return $this->session->user;
    }

}
