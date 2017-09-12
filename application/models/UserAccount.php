<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class UserAccount extends CI_Model {

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

    public function getUserInfo($id = 0, $showinactive = false) {
        $this->dbi->reset_query();

        $this->dbi->from('tblusers');
        if ($id > 0) {
            $this->dbi->where('ID', intval($id));
        }
        if (!$showinactive) {
            $this->dbi->where('IsActive', 1);
        }
        return $this->dbi->get()->result()[0];
    }

    public function getUserInfoByEmail($email, $showinactive = false) {
        $this->dbi->reset_query();

        $this->dbi->from('tblusers');
        $this->dbi->where('Email', $email);

        if (!$showinactive) {
            $this->dbi->where('IsActive', 1);
        }
        return $this->dbi->get()->result()[0];
    }

    public function setUserInfo($data, $id = null) {
        $this->dbi->reset_query();
        $exist = $this->dbi->get("tblusers")->result();

        if ($data['Password']) {
            $data['Password'] = password_hash($data['Password'], PASSWORD_DEFAULT);
        }

        if ($exist) {
            $this->dbi->where('ID', $id);
            $this->dbi->update('tblusers', $data);
            return $id;
        } else {
            $this->dbi->reset_query();
            $this->dbi->insert('tblusers', $data);
            return $this->dbi->insert_id();
        }
    }

    public function getSocialAccount($id, $accountcode) {
        $this->dbi->reset_query();
        $this->dbi->from('tblsocialaccount');
        $this->dbi->where('User_Ref', $id);
        $this->dbi->where('AccountCode', $accountcode);
        $res = $this->dbi->get()->result();
        return $res ? $res[0] : '';
    }

    public function setSocialAccount($id, $data) {
        $this->dbi->reset_query();
        $this->dbi->where('ID', $id);
        $exist = $this->dbi->get("tblsocialaccount")->result();

        if ($exist) {
            $this->dbi->where('ID', $id);
            $this->dbi->update('tblsocialaccount', $data);
            return $id;
        } else {
            $this->dbi->reset_query();
            $this->dbi->insert('tblsocialaccount', $data);
            return $this->dbi->insert_id();
        }
    }

    public function isAllowSystemEntry($empid) {
        $this->dbi->reset_query();
        $this->dbi->select('tblprivileges.Description, tblprivileges.Level');
        $this->dbi->from('tbluseraccess');
        $this->dbi->join('tblprivileges', 'tbluseraccess.Priv_Ref=tblprivileges.ID');
        $this->dbi->where('tbluseraccess.User_Ref', $empid);
        $this->dbi->where('tblprivileges.Privilege', 'EMPLOYEE');
        return $this->dbi->get()->result()[0] ? true : false;
    }

    public function changePassword($id, $pwd) {
        $this->dbi->reset_query();

        $this->dbi->where('ID', $id);
        $this->dbi->update('tblusers', array(
            'Content' => password_hash($pwd, PASSWORD_BCRYPT)
        ));
        return $id;
    }

    ///
    public function isCredCodeExists($empid, $code) {
        $this->dbi->reset_query();
        $this->dbi->from('tblcredentials');
        $this->dbi->where('User_Ref', intval($empid));
        $this->dbi->like('Code', $code, 'after');
        return count($this->dbi->get()->result()) > 0 ? true : false;
    }

    public function isCredentialExists($empid, $code) {
        $this->dbi->reset_query();
        $this->dbi->from('tblcredentials');
        $this->dbi->where('Code', $code);
        $this->dbi->where('User_Ref', intval($empid));
        return $this->dbi->get()->result()[0] ? true : false;
    }

    public function isFacebook($empid) {
        $this->dbi->reset_query();
        $this->dbi->from('tblcredentials');
        $this->dbi->where('Code', 'FB');
        $this->dbi->where('User_Ref', intval($empid));
        $tuple = $this->dbi->get()->result();
        return array_key_exists(0, $tuple);
    }

    public function getFacebook($fbuserid) {
        $this->dbi->reset_query();
        $this->dbi->from('tblcredentials');
        $this->dbi->where('Code', 'FB');
        $this->dbi->where('Content', $fbuserid);
        $tuple = $this->dbi->get()->result()[0];
        return $tuple ? $tuple : '';
    }

    public function revokeFacebook($id) {
        $this->dbi->reset_query();
        $this->dbi->where('Code', 'FB');
        $this->dbi->where('User_Ref', $id);
        $this->dbi->delete('tblcredentials');
    }

    public function getCredentials($empid) {
        $this->dbi->reset_query();
        $this->dbi->from('tblcredentials');
        $this->dbi->where('User_Ref', $empid);
        return $this->dbi->get()->result();
    }

    public function createMeta($emp, $month, $year, $meta) {
        $this->dbi->reset_query();

        $this->dbi->where("User_Ref", $emp);
        $this->dbi->where("Month", $month);
        $this->dbi->where("Year", $year);
        $this->dbi->delete('tblmetadt');

        $this->dbi->reset_query();
        $meta['User_Ref'] = $emp;
        $meta['Month'] = $month;
        $meta['Year'] = $year;
        $this->dbi->insert('tblmetadt', $meta);
        return $this->dbi->insert_id();
    }

    public function getEmployeeIDs() {
        $this->dbi->reset_query();

        $this->dbi->select('DISTINCT(tblusers.ID)');
        $this->dbi->from('tblusers');
        $this->dbi->join('tbldepartment', 'tblusers.Dept=tbldepartment.ID');
        $this->dbi->where('tblusers.Active', 1);
        $this->dbi->order_by('tblusers.ID', 'asc');
        $result = $this->dbi->get()->result();

        return $result;
    }

    public function getUserMeta($empid = 0) {
        $this->dbi->reset_query();

        $this->dbi->select('tblusers.ID AS EmployeeID, tblusers.FirstName, tblusers.LastName, tbldepartment.Department, tblmetadt.Month, tblmetadt.Year, tblmetadt.Lates, tblmetadt.Absences, tblmetadt.Undertime, tblmetadt.LatesCount, tblmetadt.UndertimeCount');
        if ($empid > 0) {
            $this->dbi->where('User_Ref', $empid);
        }
        $this->dbi->join('tblusers', 'tblusers.ID=tblmetadt.User_Ref');
        $this->dbi->join('tbldepartment', 'tbldepartment.ID=tblusers.Dept');
        $this->dbi->from('tblmetadt');
        return $this->dbi->get()->result();
    }

    public function createCredential($data) {
        $this->dbi->reset_query();
        $this->dbi->insert('tblcredentials', $data);
        return $this->dbi->insert_id();
    }

}
