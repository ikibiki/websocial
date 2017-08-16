<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class App extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        var_dump($this->session);
        $data['fbloginurl'] = $this->facebookci->getLoginLink();
        if ($this->isSessionActive()) {
            $data["user"] = $this->isSessionActive();
            $data["msg"] = $this->session->flashdata('msg');
            $this->load->view('default_view', $data);
        } else {
            redirect('login');
        }
    }

    public function logout(){
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
