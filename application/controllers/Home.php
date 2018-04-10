<?php
/**
 * Created by PhpStorm.
 * User: Ivan
 * Date: 08/03/2017
 * Time: 06.45
 */

class Home extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('url', 'html'));
        $this->load->library(array('session'));
    }

    function index()
    {
        $this->load->view('home_view');
    }

    function logout()
    {
        // destroy session
        $data = array('login' => '', 'uname' => '', 'uid' => '');
        $this->session->unset_userdata($data);
        $this->session->sess_destroy();
        redirect('home/index');
    }
}