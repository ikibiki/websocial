<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class App extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('UserAccount');
        $this->load->model('SocialAccount');
    }

    public function test() {
        
    }

    public function index() {
        if ($this->isSessionActive()) {
            $data["user"] = $this->isSessionActive();
            $data['safb'] = $this->SocialAccount->getSocialAccountByUser('FB', $data["user"]->ID);
            $data['satw'] = $this->SocialAccount->getSocialAccountByUser('TW', $data["user"]->ID);
            $data['salin'] = $this->SocialAccount->getSocialAccountByUser('LIN', $data["user"]->ID);
            $data["msg"] = $this->session->flashdata('msg');
            $data["default"] = true;
            $this->load->view('default_view', $data);
        } else {
            redirect('login');
        }
    }

    public function connect() {
        if ($this->isSessionActive()) {
            $data['fbloginurl'] = $this->facebookci->getLoginLink();
            $data['twitterloginurl'] = site_url('social/twitter/1');
            $data['linkedinloginurl'] = $this->linkedinci->getLoginLink();
            $data["user"] = $this->isSessionActive();
            $data['safb'] = $this->SocialAccount->getSocialAccountByUser('FB', $data["user"]->ID);
            $data['satw'] = $this->SocialAccount->getSocialAccountByUser('TW', $data["user"]->ID);
            $data['salin'] = $this->SocialAccount->getSocialAccountByUser('LIN', $data["user"]->ID);
            $data["msg"] = $this->session->flashdata('msg');
            $data["connect"] = true;
            $this->load->view('default_view', $data);
        } else {
            redirect('login');
        }
    }

    public function process() {

        $redir = 'app';
        $user = $this->isSessionActive();

        $status = '';

        if ($user) {

            $msg = $this->input->post('msg');

            $fb = $this->input->post('FB');
            $tw = $this->input->post('TW');
            $lin = $this->input->post('LIN');

            if ($fb) {
                $accesstoken = $this->SocialAccount->getSocialAccountByUser('FB', $user->ID)[0]->AccessToken;
                $resp = $this->facebookci->createPost($msg, $accesstoken);
                $status .= 'Facebook successfully posted <a href="https://www.facebook.com/' . $resp['id'] . '">here</a>! ';
            }

            if ($tw) {
                $twat = $this->SocialAccount->getSocialAccountByUser('TW', $user->ID)[0];
                $ats = explode(',', $twat->AccessToken);
                $resp = $this->twitterci->tweet($msg, $ats[0], $ats[1]);
                $status .= 'See your  <a href="https://twitter.com/' . $twat->SocialID . '/status/' . $resp->id . '">tweet</a>! ';
            }

            if ($lin) {
                $accesstoken = $this->SocialAccount->getSocialAccountByUser('LIN', $user->ID)[0]->AccessToken;
                $resp = $this->linkedinci->createPost($accesstoken, $msg);
                $status .= 'Linked in status posted  <a href="' . $resp['updateUrl'] . '">here</a>! ';
            }
            $this->setMessage('Post', $status, 'info');
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
