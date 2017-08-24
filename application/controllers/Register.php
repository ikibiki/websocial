<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('UserAccount');
        $this->load->model('SocialAccount');
    }

    public function index() {


        $mode = $this->input->get('social');

        switch ($mode) {
            case 'facebook': {
                    $accesstoken = $this->session->userdata('fb_access_token');
                    if ($accesstoken) {
                        $profile = $this->facebookci->getFacebookProfile($accesstoken);
                        $profile = (object) array(
                                    'ID' => $profile['id'],
                                    'Name' => $profile['name'],
                                    'Email' => $profile['email'],
                                    'SocialCode' => 'FB',
                        );
                        $data['profile'] = $profile;
                    }
                }break;
            case 'twitter': {


                    $accesstoken = $this->session->userdata('oauth_token');
                    $accesstokensecret = $this->session->userdata('oauth_token_secret');


                    if ($accesstoken) {
                        $profile = $this->twitterci->getTwitterProfile($accesstoken, $accesstokensecret);

                        var_dump($profile);
                        die;
                        $profile = (object) array(
                                    'ID' => $profile->screen_name,
                                    'Name' => $profile->name,
                                    'Email' => $profile->email,
                                    'SocialCode' => 'FB',
                        );
                        $data['profile'] = $profile;
                    }
                }break;
            case 'linkedin': {

                    $accesstoken = $this->session->userdata('linkedin_access_token');

                    if ($accesstoken) {

                        $profile = $this->linkedinci->getLinkedinProfile($accesstoken);
                        $profile = (object) array(
                                    'ID' => $profile['id'],
                                    'Name' => $profile['firstName'] . ' ' . $profile['lastName'],
                                    'Email' => null,
                                    'SocialCode' => 'LIN',
                        );
                        $data['profile'] = $profile;
                    }
                }break;
            default:break;
        }

        $data["msg"] = $this->session->flashdata('msg');
        $this->load->view('register_view', $data);
    }

    public function process() {
        if (!$this->verifyRecaptcha()) {
            $this->setMessage('Warning!', 'Invalid reCAPTCHA. Please try again.', 'danger');
        } else {
            $socialcode = $this->input->post('socialcode');
            $redir = $this->input->post('redir');
            $name = $this->input->post('name');
            $email = $this->input->post('email');
            $password = $this->input->post('password');

            $userid = $this->UserAccount->setUserInfo(array(
                'UserName' => $name,
                'Email' => $email,
                'Password' => $password,
            ));
            if (empty($redir)) {
                $redir = 'login';
            }
            if ($socialcode) {
                $this->bind($socialcode, $userid);
            }
            $this->setMessage('Register', 'Account successfully registered! Login to continue.');
            redirect($redir);
        }
    }

    private function bind($socialcode, $userid) {
        switch ($socialcode) {
            case 'FB': {
                    $accesstoken = $this->session->userdata('fb_access_token');
                    $fbprofile = $this->facebookci->getFacebookProfile($accesstoken);

                    $this->SocialAccount->setSocialAccount($id = 0, $userid, 'FB', $fbprofile['id'], $accesstoken);
                    $this->setMessage('Success', 'Facebook bound to account.', 'success');
                }break;
            case 'TW': {
                    $accesstoken = $this->session->userdata('oauth_token');
                    $accesstokensecret = $this->session->userdata('oauth_token_secret');
                    $profile = $this->twitterci->getTwitterProfile($accesstoken, $accesstokensecret);
                    $this->SocialAccount->setSocialAccount($id = 0, $userid, 'TW', $profile->screen_name, $accesstoken . ',' . $accesstokensecret);
                    $this->setMessage('Success', 'Twitter bound to account.', 'success');
                }break;
            case 'LIN': {
                    $accesstoken = $this->session->userdata('linkedin_access_token');
                    $linprofile = $this->linkedinci->getLinkedinProfile($accesstoken);
                    $this->SocialAccount->setSocialAccount($id = 0, $userid, 'LIN', $linprofile['id'], $accesstoken);
                    $this->setMessage('Success', 'LinkedIn bound to account.', 'success');
                }break;
            default: {
                    
                }
        }
    }

    protected function setMessage($title, $text, $type) {
        $this->session->set_flashdata('msg', array('title' => $title, 'text' => $text, 'type' => $type));
    }

    protected function verifyRecaptcha() {
        return true;
        if (ENVIRONMENT === 'development') {
            return true;
        }
        if ($this->input->post('g-recaptcha-response')) {
            $secret = GRECAPTCHA_SECRET;
            $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret . '&response=' . $this->input->post('g-recaptcha-response'));
            $responseData = json_decode($verifyResponse);
            if ($responseData->success) {
                return true;
            }
        }
        return false;
    }

}
