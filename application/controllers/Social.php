<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Social extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index($social) {
        switch ($social) {
            case 'facebook': {
                    $this->facebookci->getFBCallback('social/facebook');
                }break;
        }
    }

    public function facebook(){
         $this->facebookci->getFBCallback('social/facebook');
         var_dump($_SESSION);
//        var_dump($this->session->userdata("fb_access_token"));
        $this->facebookci->getAccessToken($this->input->get("code"));
    }
    
    protected function setMessage($title, $text, $type) {
        $this->session->set_flashdata('msg', array('title' => $title, 'text' => $text, 'type' => $type));
    }

}
