<?php
/**
 * Created by PhpStorm.
 * User: Ivan
 * Date: 08/03/2017
 * Time: 06.50
 */

class Signup extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library(array('session', 'form_validation'));
        $this->load->database();
        $this->load->model('user_model');
    }

    function index()
    {
        // set form validation rules
        $this->form_validation->set_rules('fname', 'First Name', 'trim|required|alpha|min_length[3]|max_length[30]');
        $this->form_validation->set_rules('lname', 'Last Name', 'trim|required|alpha|min_length[3]|max_length[30]');
        $this->form_validation->set_rules('email', 'Email ID', 'trim|required|valid_email|is_unique[user.email]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|matches[cpassword]');
        $this->form_validation->set_rules('cpassword', 'Confirm Password', 'trim|required');

        // submit
        if ($this->form_validation->run() == FALSE) {
            // form validation fails
            $this->load->view('signup_view');
        }
        else {
            // insert user details into db
            $data = array(
                'fname' => $this->input->post('fname'),
                'lname' => $this->input->post('lname'),
                'email' => $this->input->post('email'),
                'password' => md5($this->input->post('password'))
            );

            if ($this->user_model->insert_user($data)) {
                $this->session->set_flashdata('msg','<div class="alert alert-success text-center">Anda berhasil mendaftar, Silahkan login</div>');
                redirect('signup/index');
            }
            else {
                // error
                $this->session->set_flashdata('msg','<div class="alert alert-danger text-center">Oops! Error.  Coba lagi nanti!!!</div>');
                redirect('signup/index');
            }
        }
    }
}