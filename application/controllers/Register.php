<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('UserAccount');
    }

    public function index() {
        $data["msg"] = $this->session->flashdata('msg');
        $this->load->view('register_view', $data);
    }

    public function process() {
        if (!$this->verifyRecaptcha()) {
            $this->setMessage('Warning!', 'Invalid reCAPTCHA. Please try again.', 'danger');
        } else {
            $redir = $this->input->post('redir');
            $name = $this->input->post('name');
            $email = $this->input->post('email');
            $password = $this->input->post('password');

            $this->UserAccount->setUserInfo(array(
                'UserName' => $name,
                'Email' => $email,
                'Password' => $password,
            ));
            if (empty($redir)) {
                $redir = site_url('app/connect');
            }
            $this->setMessage('Register', 'Account successfully registered!');
            redirect($redir);
        }
    }

    protected function setMessage($title, $text, $type) {
        $this->session->set_flashdata('msg', array('title' => $title, 'text' => $text, 'type' => $type));
    }

    protected function verifyRecaptcha() {
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
