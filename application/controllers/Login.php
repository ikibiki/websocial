<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('UserAccount');
    }

    public function index() {

        if ($this->isSessionActive()) {
            redirect('app');
            exit;
        }

        $data["msg"] = $this->session->flashdata('msg');
        $data['fbloginurl'] = $this->facebookci->getLoginLink();
        $data['twitterloginurl'] = site_url('social/twitter/1');
        $data['linkedinloginurl'] = $this->linkedinci->getLoginLink();
        $this->load->view('login_view', $data);
    }

    public function process() {

        if (!$this->verifyRecaptcha()) {
            $this->setMessage('Warning!', 'Invalid reCAPTCHA. Please try again.', 'danger');
        } else {

            $redir = $this->input->post('redir');

            $email = $this->input->post('email');
            $password = $this->input->post('password');
            $result = $this->UserAccount->verifyAccess($email, $password);
            if ($result) {

                $this->session->set_userdata('user', $result);

                if (empty($redir)) {
                    $redir = 'app';
                }
                $this->setMessage('Welcome', 'Welcome back!', 'info');
            } else {
                if (empty($redir)) {
                    $redir = 'login';
                }
                $this->setMessage('Login', 'Wrong credentials.', 'danger');
            }
            redirect($redir);
        }
    }

    public function facebook() {
        
    }

    public function instagram() {
        
    }

    public function googleplus() {
        
    }

    protected function setMessage($title, $text, $type) {
        $this->session->set_flashdata('msg', array('title' => $title, 'text' => $text, 'type' => $type));
    }

    protected function isSessionActive() {
        return $this->session->user;
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
