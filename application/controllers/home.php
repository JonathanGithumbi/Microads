<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function index()
    {
        $this->load->view('header/header');
        $this->load->view('pages/home');
                
    }


    public function user_sign_up()
    {
        $this->form_validation->set_rules('user_email_address', 'Email Address', 'trim|required|valid_email');
        $this->form_validation->set_rules('user_password', 'Password', 'required');
        $this->form_validation->set_rules('confirm_user_password', 'Confirm Password', 'trim|required|matches[user_password]');
        
        
        if ($this->form_validation->run() == FALSE) {
            $response = array('status'=>'error', 'message'=>validation_errors('<p class="w3-red w3-round-small">','</p>'));
        } else {
            $data = $this->input->post();
            if($this->wbdcmds->user_sign_up($data))
            {
                $response = array('status'=>'success', 'message'=>'<p class= "w3-green w3-round-small">Signed Up Successfully ! Login to Contiue.</p>');
            }
            else
            {
                $response = array('status'=> 'error', 'message'=> 'Failed Sign up Attempt! Please try again later');
            }
        }
        echo json_encode($response);        
    }
    
    public function user_log_in()
    {
        $this->form_validation->set_rules('user_log_in_email_address', 'Email Address', 'trim|required|valid_email');
        $this->form_validation->set_rules('user_log_in_password', 'Password', 'required');
        
        
        if ($this->form_validation->run() == FALSE) {
            $response = array('status'=>'error', 'message'=> validation_errors('<p class="w3-red w3-round-small">','</p>'));
        } else {
            $data = $this->input->post();
            if($this->wbdcmds->user_log_in($data))
            {
                $response = array('status' =>'success', 'messsage'=> 'Signed In Successfully');
            }
            else
            {
                $response = array('status' =>'error', 'message'=> '<p class="w3-red w3-round-small">Incorrect Username or Password.</p>');
            }
        }
        echo json_encode($response);
    }
}

/* End of file Home.php */
