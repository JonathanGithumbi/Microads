<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Wbdcmds extends CI_Model
{

    public function user_sign_up($data)
    {
        $email_address = $data['user_email_address'];
        $password = password_hash($data['user_password'], PASSWORD_DEFAULT);

        $sql = "INSERT INTO `users`( user_email_address, user_password) VALUES (?,?)";
        $result = $this->db->query($sql, array($email_address, $password));

        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function user_log_in($data)
    {

        $email_address = $data['user_log_in_email_address'];
        $password = $data['user_log_in_password'];

        $sql = "SELECT * FROM users WHERE user_email_address = ?";
        $result = $this->db->query($sql, array($email_address));

        if ($result && $result->num_rows() > 0) {
            $result = $result->row_array();
            if (password_verify($password, $result['user_password'])) {

                $array = array(
                    'user_id' => $result['user_id']
                );

                $this->session->set_userdata($array);

                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function add_adu($data)
    {
        $adu_name = $data['adu_name'];
        $password = password_hash($data['adu_password'], PASSWORD_BCRYPT);
        $adu_owner = $data['adu_owner'];
        $sql = "INSERT INTO `adus` (adu_name, adu_password,adu_owner) VALUES (?,?,?)";
        $result = $this->db->query($sql, array($adu_name, $password, $adu_owner));

        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function all_adus($user_id)
    {
        $sql = 'SELECT * FROM `adus` WHERE adu_owner = ?';
        $result = $this->db->query($sql, array($user_id));
        $result = $result->result_array();

        return $result;
    }
     
    public function download_report($adu_id)
    {
        $this->db->select('push_id,push_name,push_type,content,content_type,time_scheduled,day_scheduled,start_time,end_time,start_date,end_date');
        $this->db->where('adu_id',$adu_id);
        $result=$this->db->get('queue');
       
        return $result->result();
    }

    public function schedule_mass_push($data)
    {
        $sql = "INSERT INTO `queue` (adu_id,push_name,push_type,content,content_type,time_scheduled,day_scheduled,start_time,end_time,start_date,end_date) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
        if (count($data['adus']) > 1) {
            foreach ($data['adus'] as $adu_id) {
                $result = $this->db->query($sql, array($adu_id, $data['mass_push_name'], 'mass', $data['content'], $data['content_type'], $data['time_scheduled'], $data['day_scheduled'], $data['mass_start_time'], $data['mass_end_time'], $data['mass_start_date'], $data['mass_end_date']));
            }
        } else if (count($data['adus']) < 2) {
            foreach ($data['adus'] as $adu_id) {
                $result = $this->db->query($sql, array($adu_id, $data['mass_push_name'], 'single', $data['content'], $data['content_type'], $data['time_scheduled'], $data['day_scheduled'], $data['mass_start_time'], $data['mass_end_time'], $data['mass_start_date'], $data['mass_end_date']));
            }
        }
        return true;
    }
    public function return_schedule($adu_id)
    {
        
        $this->db->select('push_id,push_name,push_type,content,content_type,time_scheduled,day_scheduled,start_time,end_time,start_date,end_date');
        $this->db->where('adu_id',$adu_id);
        $result=$this->db->get('queue');

        if ($result) {

            
             return $result->result_array();
        } else {
            return false;
        }
    }
    public function fetch_schedule($adu_id)
    {
        $sql = "SELECT push_id,push_name,push_type,content,content_type,time_scheduled,day_scheduled,start_time,end_time,start_date,end_date FROM `queue` WHERE adu_id = ?  ORDER BY day_scheduled,time_scheduled DESC";
        $result = $this->db->query($sql, array($adu_id));
        $result = $result->result_array();

        return $result;
    }
    private function put_online($adu_id, $time_online)
    {
        $exists_sql = "select * from online_adus where adu_id = ?";
        if ($this->db->query($exists_sql, $adu_id)) {
            $delete_sql = "delete from online_adus where adu_id = ?";
            if ($this->db->query($delete_sql, $adu_id)) {
                $sql = "INSERT INTO `online_adus` (adu_id, time_online) VALUES (?,?)";
                if ($this->db->query($sql, array($adu_id, $time_online))) {
                    return true;
                } else {
                    return print_r($this->db->error());
                }
            }
        } else {
            $sql = "INSERT INTO `online_adus` (adu_id, time_online) VALUES (?,?)";
            if ($this->db->query($sql, array($adu_id, $time_online))) {
                return true;
            } else {
                return print_r($this->db->error());
            }
        }
    }
    public function app_login($data)
    {
        $attempted_adu_name = $data['adu_name'];
        $attempted_password = $data['adu_password'];

        $sql = " SELECT adu_id, adu_name, adu_password FROM adus WHERE adu_name = ? ";
        $result = $this->db->query($sql, $attempted_adu_name);

        if ($result) {
            $result = $result->row_array();
            $adu_id = $result['adu_id'];

            $adu_name = $result['adu_name'];
            $password = $result['adu_password'];

            if (password_verify($attempted_password, $password)) {
                $time_online = date("H:i:s");
                $array = array(
                    'adu_logged_in' => $adu_id
                );
                
                $this->session->set_userdata( $array );
                
                $this->put_online($adu_id, $time_online);
                return true;
            } else {

                return false;
            }
        } else {

            return false;
        }
    }
    public function check_status($adu_id)
    {
        $adu_id = (int) $adu_id['adu_id'];
        $sql = "SELECT adu_id FROM `online_adus` WHERE adu_id = ? ";
        $result = $this->db->query($sql, $adu_id);
        if ($result->num_rows() != 0) {
            return true;
        } else {
            return false;
        }
    }
}

/* End of file Wbdcmds.php */
