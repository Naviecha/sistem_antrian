<?php
/**
 * Created by PhpStorm.
 * User: Ivan
 * Date: 08/03/2017
 * Time: 07.08
 */

class profile extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('url', 'html', 'form'));
        $this->load->library(array('session', 'form_validation', '../core/input'));
        $this->load->database();
        $this->load->model(array('user_model', 'antrian_model'));
    }

    function index()
    {
        $details = $this->user_model->get_user_by_id($this->session->userdata('uid'));
        $data['uname'] = $details[0]->fname . " " . $details[0]->lname;
        $data['uemail'] = $details[0]->email;
        $data['kode_booking'] = $details[0]->kode_booking;
        $data['antrian'] = $details[0]->antrian;

        $data['antrian_sekarang'] = $this->antrian_model->get_antrian_sekarang()->result();

        $this->load->view('profile_view', $data);
    }

    function ambil_nomor()
    {
        // ambil session user
        $details = $this->user_model->get_user_by_id($this->session->userdata('uid'));

        // update nomor antrian yang tersedia
        $antrian['nomor_antrian'] = $this->input->get('hitung');
        $this->antrian_model->update_nomor_antrian($antrian);
        echo $antrian['nomor_antrian'];

        // insert kode_booking user ke db
        $kode['id'] = $details[0]->id;
        $kode['kode_booking'] = $this->input->get('kode_booking');
        $this->antrian_model->insert_kode_booking($kode);

        // ambil nomor antrian u/ user & insert ke db
        $nomor['id'] = $details[0]->id;
        $nomor['nomor'] = $this->input->get('hitung');
        $this->antrian_model->ambil_nomor_antrian($nomor);
    }

    function reset_data()
    {
        $details = $this->user_model->get_user_by_id($this->session->userdata('uid'));
        $user['id'] = $details[0]->id;
        $this->antrian_model->reset_data($user);
    }

    function reset_antrian()
    {
        $this->antrian_model->reset_antrian();
    }

    function reset()
    {
        $this->reset_data();
        $this->reset_antrian();
    }
}