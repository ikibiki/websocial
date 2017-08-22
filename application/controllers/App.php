<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class App extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('UserAccount');
        $this->load->model('SocialAccount');
    }

    public function test() {
        $this->twitterci->getTwitterProfile('22249359-QDVs54Z5QefknNnugTkdsg5WWUY3VICjKBwFrvdyP', '0X1o9VfEY9bUUcz6ioyVnri4aBkDHfZpBOr6e4ipBVIcR');
    }

    public function index() {
        if ($this->isSessionActive()) {
            $data["user"] = $this->isSessionActive();
            $data["msg"] = $this->session->flashdata('msg');
            $this->load->view('default_view', $data);
        } else {
            redirect('login');
        }
    }

    public function process() {

        $redir = 'app';
        $user = $this->isSessionActive();

        if ($user) {

            $msg = $this->input->post('msg');

            $fb = $this->input->post('FB');
            $tw = $this->input->post('TW');



            if ($fb) {
                $accesstoken = $this->SocialAccount->getSocialAccountByUser('FB', $user->ID)->AccessToken;

                $this->facebookci->createPost($msg, $accesstoken);
            }

            if ($tw) {
                $twat = $this->SocialAccount->getSocialAccountByUser('TW', $user->ID);
                $accesstoken = $twat->SocialID;
                $accesstokensecret = $twat->AccessToken;

                $this->twitterci->tweet($msg, $accesstoken, $accesstokensecret);
            }
        }
        redirect($redir);
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect(base_url());
    }

    protected function isSessionActive() {
        return $this->session->user;
    }

    protected function setMessage($title, $text, $type) {
        $this->session->set_flashdata('msg', array('title' => $title, 'text' => $text, 'type' => $type));
    }

}
