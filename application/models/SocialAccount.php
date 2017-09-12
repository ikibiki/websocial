<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class SocialAccount extends CI_Model {

    private $dbi;

    public function __construct() {
        parent::__construct();
        $this->dbi = $this->load->database('default', true);
    }

    public function verifyAccess($email, $password) {
        $this->dbi->reset_query();
        $this->dbi->from('tblusers');
        $this->dbi->where('Email', $email);
        $this->dbi->where('IsActive', 1);
        $res = $this->dbi->get()->result();

        if (password_verify($password, $res[0]->Password)) {
            $this->dbi->reset_query();
            $this->dbi->select('ID, UserName, Email, Birthday, ResetCode, IsLock, IsActive, Privilege, DTCreated');
            $this->dbi->from('tblusers');
            $this->dbi->where('Email', $email);
            $res = $this->dbi->get()->result();
            return $res[0];
        } else {
            return false;
        }
    }

    public function getSocialAccount($id) {
        $this->dbi->reset_query();

        $this->dbi->from('tblsocialaccount');
        if ($id > 0) {
            $this->dbi->where('ID', intval($id));
        }
        return $this->dbi->get()->result()[0];
    }

    public function getSocialAccountsByUser($userid){
        $this->dbi->reset_query();

        $this->dbi->from('tblsocialaccount');
        $this->dbi->where('User_Ref', $userid);
        return $this->dbi->get()->result();

    }

    public function getSocialAccountByUser($socialcode, $userid) {
        $this->dbi->reset_query();

        $this->dbi->from('tblsocialaccount');
        $this->dbi->where('SocialCode', $socialcode);
        $this->dbi->where('User_Ref', $userid);
        return $this->dbi->get()->result();
    }

    public function getSocialAccountBySAID($socialcode, $socialid) {
        $this->dbi->reset_query();

        $this->dbi->from('tblsocialaccount');
        $this->dbi->where('SocialCode', $socialcode);
        $this->dbi->where('SocialID', $socialid);
        return $this->dbi->get()->result()[0];
    }

    public function removeSocialAccount($socialcode, $userid) {
        $this->dbi->reset_query();
        $this->dbi->where('SocialCode', $socialcode);
        $this->dbi->where('User_Ref', $userid);
        $this->dbi->delete('tblsocialaccount');
    }

    public function setSocialAccount($id = 0, $userid, $socialcode, $socialid, $accesstoken) {
        $this->dbi->reset_query();
        $this->dbi->where('ID', $id);
        $exist = $this->dbi->get("tblsocialaccount")->result();

        $data = array(
            'User_Ref' => $userid,
            'SocialCode' => $socialcode,
            'SocialID' => $socialid,
            'AccessToken' => $accesstoken,
        );


        if ($exist) {
            $this->dbi->reset_query();
            $this->dbi->where('ID', $id);
            $this->dbi->update('tblsocialaccount', $data);
            return $id;
        } else {
            $this->dbi->reset_query();
            $this->dbi->insert('tblsocialaccount', $data);
            return $this->dbi->insert_id();
        }
    }

    public function updateAccessToken($userid, $socialcode, $socialid, $accesstoken) {
        $this->dbi->reset_query();

        $this->dbi->where(array(
            'User_Ref' => $userid,
            'SocialID' => $socialid,
            'SocialCode' => $socialcode,
        ));
        $exist = $this->dbi->get("tblsocialaccount")->result();
        $data = array(
            'AccessToken' => $accesstoken,
        );

        if ($exist) {
            $this->dbi->reset_query();
            $this->dbi->where(array(
                'User_Ref' => $userid,
                'SocialID' => $socialid,
                'SocialCode' => $socialcode,
            ));
            $this->dbi->update('tblsocialaccount', $data);
            return $exist[0]->ID;
        } else {

            $data['User_Ref'] = $userid;
            $data['SocialID'] = $socialid;
            $data['SocialCode'] = $socialcode;
            $this->dbi->reset_query();
            $this->dbi->insert('tblsocialaccount', $data);
            return $this->dbi->insert_id();
        }
        return $this->dbi->insert_id();
    }

}
