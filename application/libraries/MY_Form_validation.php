<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation {

    function add_to_error_array($field = '', $message='')
    {
        if(!isset($this->_error_array[$field]))
        {
            $this->_error_array[$field] = $message;
        }
        return;
    }

    function error_array()
    {
        if(count($this->_error_array) === 0)
        {
            return false;
        }
        else
        {
            return $this->_error_array;;
        }
    }
}

/* End of file MY_Form_validation.php */
