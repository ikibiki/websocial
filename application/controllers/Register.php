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
            $redir = site_url('app');
        }
        $this->setMessage('Register','Account successfully registered!');
        redirect($redir);
    }

    protected function setMessage($title, $text, $type) {
        $this->session->set_flashdata('msg', array('title' => $title, 'text' => $text, 'type' => $type));
    }

}
