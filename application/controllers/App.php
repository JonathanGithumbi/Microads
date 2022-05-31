<?php

defined('BASEPATH') or exit('No direct script access allowed');

class APP extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        //Do your magic here
    }

    public function index()
    {
        $this->load->view('app/header/header');
        $this->load->view('app/pages/login');
        $this->load->view('app/footer/footer');
    }
    public function login()
    {
        $this->form_validation->set_rules('adu_name', 'Name of ADU', 'required');
        $this->form_validation->set_rules('adu_password', 'Password', 'required');

        
        if ($this->form_validation->run() == FALSE) {
            $response = array('status'=>'error', 'message'=>validation_errors());
        }
         else {
            $data = $this->input->post();
            if($this->wbdcmds->app_login($data))
            {
                $response = array('status'=>'success');
               
            }
            else
            {
                $response = array('status'=>'error', 'message'=>'Invalid Credentials');
            }
        }
        echo json_encode($response);
    }

    public function play_interface()
    {
        $data['schedule'] = $this->wbdcmds->fetch_schedule($this->session->adu_logged_in);
        $this->load->view('App/header/header');
        $this->load->view('App/pages/interface',$data);
        $this->load->view('App/footer/footer');
    }
}

/* End of file APP.php */
