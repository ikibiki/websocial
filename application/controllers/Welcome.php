<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        $data["msg"] = $this->session->flashdata('msg');
        $this->load->view('comingsoon_view', $data);
    }

    protected function setMessage($title, $text, $type) {
        $this->session->set_flashdata('msg', array('title' => $title, 'text' => $text, 'type' => $type));
    }

}
