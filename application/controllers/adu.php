<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Adu extends CI_Controller
{


    public function index()
    {
        $data['adus'] = $this->wbdcmds->all_adus($this->session->user_id);
        $this->load->view('header/header', $data);
        $this->load->view('navbar/navbar');
        $this->load->view('pages/adu');
    }

    public function add_cdu()
    {
        $this->form_validation->set_rules('adu_name', 'Name of ADU', 'trim|required');
        $this->form_validation->set_rules('adu_password', 'Password', 'required');


        if ($this->form_validation->run() == FALSE) {
            $response = array('status' => 'error', 'message' => validation_errors('<p class="w3-red">', '</p>'));
        } else {
            $data = $this->input->post();
            if ($this->wbdcmds->add_adu($data)) {
                $response = array('status' => 'success', 'message' => '<p class=" w3-panel w3-green">Succsessfully Added ADU. </p>');
            } else {
                $response = array('status' => 'error', 'message' => '<p class="w3-red">Failed to Register ADU. Try Again Later</p>');
            }
        }
        echo json_encode($response);
    }

    //Check status of the ADU
    public function check_status()
    {
        $adu_id = $this->input->post();
        if($this->wbdcmds->check_status($adu_id))
        {
            $response = array('status'=>'online');
        }
        else
        {
            $response = array('status'=>'offline');
        }

        echo json_encode($response);
    }

    public function schedule_mass_push()
    {
        //validate all other input types appart from file
        $this->form_validation->set_rules('adus[]', 'ADU ', 'required');
        $this->form_validation->set_rules('mass_push_name', 'Push Name', 'required');
        $this->form_validation->set_rules('mass_start_date', 'Start Date', 'required');
        $this->form_validation->set_rules('mass_end_date', 'End Date', 'required');


        if ($this->form_validation->run($this) == FALSE) {
            $response = array('status' => 'error', 'message' => validation_errors('<p class="w3-panel w3-red w3-round-small">', '</p>'));
        } else {
            
            $config['upload_path']          = './uploads/';
            $config['allowed_types']        = 'gif|jpg|png|mkv';

            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('mass_content')) {
                $response = array('status' => 'error', 'message' => $this->upload->display_errors());
            } else {
                $file_data = $this->upload->data();
                $full_path = $file_data['full_path'];
                $content_type = $file_data['file_type'];
                date_default_timezone_set('Africa/Nairobi');
                $time_scheduled = date("H:i:s");
                $day_scheduled = date("Y-m-d");
                $data = $this->input->post();
                $data['content'] = $full_path;
                $data['content_type'] = $content_type;
                $data['time_scheduled'] = $time_scheduled;
                $data['day_scheduled'] = $day_scheduled;
                if ($this->wbdcmds->schedule_mass_push($data)) {
                    $response = array('status' => 'success', 'message' => '<p class= "w3-panel w3-round-small w3-green"> Push Scheduled Succsessfully</p>');
                } else {
                    $response = array('status' => 'error', 'message' => "There was an Error Scheduling your mass push, please try again later");
                }
            }
        }
        echo json_encode($response);
    }
    

    public function return_schedule()
    {
        $adu_id = $this->input->post('adu_id');

        if ($this->wbdcmds->return_schedule($adu_id)) {
            $result = $this->wbdcmds->return_schedule($adu_id);
            if ($result) {
                $response = array('status' => 'success', 'message' => $result);
            } else {
                $response = array('status' => 'error', 'message' => 'No Pushes Have Been Scheduled for your ADU');
            }
        } else {
            $response = array('status' => 'error', 'message' => 'No Pushes Have Been Scheduled for your ADU');
        }
        echo json_encode($response);
    }

    public function download_report()
    {
        $adu_id = $this->uri->segment(3);
        //load pdf library
        $this->load->library('pdf');
        $data['schedule_list'] = $this->wbdcmds->download_report($adu_id); 
        $html = $this->load->view('schedule_list',$data, true);
        $this->pdf->createPDF($html, 'ADU Schedule List', false);
        $response = array("status"=>'success');
        echo json_encode($response);
    }
  

    public function logout()
    {
        session_destroy();

        redirect('home/index', 'refresh');
    }
}

/* End of file Adu.php */