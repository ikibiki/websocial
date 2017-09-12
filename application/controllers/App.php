<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class App extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('UserAccount');
        $this->load->model('SocialAccount');
    }

    public function test()
    {
//        echo '<a href="' . $this->facebookci->getReAuthLink() . '">TEST</a>';
    }


    public function index()
    {
        if ($this->isSessionActive()) {
            $data["user"] = $this->isSessionActive();


            $temp = $this->SocialAccount->getSocialAccountsByUser($data['user']->ID);

            foreach ($temp as $item) {
                $data['socaccs'][] = (object)array(
                    'ID' => $item->ID,
                    'info' => $this->getSimpleSAI($item->SocialCode, $item->AccessToken, $item->SocialID),
                );
            }

            $data["msg"] = $this->session->flashdata('msg');
            $data["default"] = true;
            $this->load->view('default_view', $data);
        } else {
            redirect('login');
        }
    }

    public function connect()
    {
        if ($this->isSessionActive()) {
            $data['fbloginurl'] = $this->facebookci->getLoginLink();
            $data['twitterloginurl'] = site_url('social/twitter/1');
            $data['linkedinloginurl'] = $this->linkedinci->getLoginLink();
            $data["user"] = $this->isSessionActive();

            $data['socaccs'] = $this->SocialAccount->getSocialAccountsByUser($data['user']->ID);

            $data["msg"] = $this->session->flashdata('msg');
            $data["connect"] = true;
            $this->load->view('default_view', $data);
        } else {
            redirect('login');
        }
    }

    public function process()
    {

        $redir = 'app';
        $user = $this->isSessionActive();
        $mode = $this->input->post('mode');

        $status = '';

        if ($user) {

            $msg = $this->input->post('msg');
            $socaccs = $this->input->post('socaccs');

            if ($mode == 'text') {

                foreach ($socaccs as $item) {
                    $soc = $this->SocialAccount->getSocialAccount(intval($item));

                    if ($soc->SocialCode === 'FB') {
                        $resp = $this->facebookci->createPost($msg, $soc->SocialID, $soc->AccessToken);
                        $status .= 'Facebook successfully posted <a href="https://www.facebook.com/' . $resp['id'] . '">here</a>! ';
                    }

                    if ($soc->SocialCode === 'TW') {
                        $ats = explode(',', $soc->AccessToken);
                        $resp = $this->twitterci->tweet($msg, $ats[0], $ats[1]);
                        $status .= 'See your  <a href="https://twitter.com/' . $soc->SocialID . '/status/' . $resp->id . '">tweet</a>! ';
                    }

                    if ($soc->SocialCode === 'LIN') {
                        $accesstoken = $soc->AccessToken;
                        $resp = $this->linkedinci->createPost($accesstoken, $msg);
                        $status .= 'Linked in status posted  <a href="' . $resp['updateUrl'] . '">here</a>! ';
                    }

                }
            }

            if ($mode == 'image') {

                $error = false;

                $config['upload_path'] = 'uploads';
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size'] = 2048;
                $config['encrypt_name'] = true;
                $config['file_ext_tolower'] = true;

                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('imagefile')) {
                    $status .= $this->upload->display_errors() . ' ';
                } else {

                    $imagefile = $this->upload->data();
                }

                if (!$error) {

                    foreach ($socaccs as $item) {
                        $soc = $this->SocialAccount->getSocialAccount(intval($item));
                        if ($soc->SocialCode === 'FB') {
                            $resp = $this->facebookci->createImagePost($msg, $imagefile['full_path'], $soc->SocialID, $soc->AccessToken);
                            $status .= 'Facebook image successfully uploaded <a href="https://www.facebook.com/' . $resp['id'] . '">here</a>! ';
                        }

                        if ($soc->SocialCode === 'TW') {
                            $ats = explode(',', $soc->AccessToken);
                            $resp = $this->twitterci->tweetPhoto($msg, $imagefile['full_path'], $ats[0], $ats[1]);
                            $status .= 'See your  <a href="https://twitter.com/' . $soc->SocialID . '/status/' . $resp->id . '">tweet</a>! ';
                        }
                    }
                }
            }
            $this->setMessage('Post', $status, 'info');
        }
        redirect($redir);
    }

    public function getSimpleSAI($socialcode, $accesstoken, $socialid = '')
    {
        switch ($socialcode) {
            case 'FB': {
                $temp = $this->facebookci->getFacebookProfile($accesstoken);
                return 'Facebook - ' . $temp['name'];
            }
            case 'TW': {
                $ats = explode(',', $accesstoken);
                $temp = $this->twitterci->getTwitterProfile($ats[0], $ats[1]);
                return 'Twitter - @' . $temp->screen_name;
            }
            case 'LIN': {
                $temp = $this->linkedinci->getLinkedinProfile($accesstoken);
                return 'LinkedIn - ' . $temp['firstName'] . ' ' . $temp['lastName'];
            }
            default:
                return null;
        }

    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect(base_url());
    }

    protected function isSessionActive()
    {
        return $this->session->user;
    }

    protected function setMessage($title, $text, $type)
    {
        $this->session->set_flashdata('msg', array('title' => $title, 'text' => $text, 'type' => $type));
    }

}
