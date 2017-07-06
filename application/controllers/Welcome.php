<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->library('Oauth2');
    }

    public function index() {

        $this->load->view('home_page');
    }

    public function facebook() {
        $this->oauth2->facebook();
    }

    public function instagram() {
        $this->oauth2->instagram();
    }
    
    public function googleplus() {
        $this->oauth2->googleplus();
    }
}
