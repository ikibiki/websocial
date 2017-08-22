<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Social extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('UserAccount');
        $this->load->model('SocialAccount');
    }

    public function index() {
        
    }

    public function facebook($revoke = true) {

        if (!boolval($revoke)) {
            $this->facebookci->revokeFB();
            redirect('app');
        } else {
            $this->facebookci->getFBCallback();
            $accesstoken = $this->session->userdata('fb_access_token');

            if ($this->validateFB($accesstoken)) {
                $profile = $this->facebookci->getFacebookProfile($accesstoken);
                $social = $this->SocialAccount->getSocialAccountBySAID('FB', $profile['id']);
                $user = $this->UserAccount->getUserInfo($social->User_Ref);
                $this->session->set_userdata('user', $user);
                redirect('app');
            } else {
                echo "Account not registered";
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


        if ($this->validateTW($accesstoken)) {
            $accesstokenseret = $this->session->userdata('oauth_token_secret');
//            $profile = $this->twitterci->getTwitterProfile($accesstoken, $accesstokenseret);
            $social = $this->SocialAccount->getSocialAccountBySAID('TW', $accesstoken);
            $user = $this->UserAccount->getUserInfo($social->User_Ref);
            $this->session->set_userdata('user', $user);
            redirect('app');
        } else {
            echo "Account not registered";
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

    private function validateTW($accesstoken) {
        $socialaccount = $this->SocialAccount->getSocialAccountBySAID('FB', $accesstoken);
        return $socialaccount ? true : false;
    }

    protected function setMessage($title, $text, $type) {
        $this->session->set_flashdata('msg', array('title' => $title, 'text' => $text, 'type' => $type));
    }

}
