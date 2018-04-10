<?php
/**
 * Created by PhpStorm.
 * User: Ivan
 * Date: 17/03/2017
 * Time: 14.39
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Antrian_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    function get_antrian_sekarang()
    {
        $this->db->select("*");
        $this->db->from("antrian");
        $this->db->order_by("nomor_sekarang", "desc")->limit(1);

        return $this->db->get();
    }

    function update_nomor_antrian($data)
    {
        $id = $data['nomor_antrian'] - 1;
        $this->db->where('nomor_antrian', $id);
        $this->db->update('antrian', $data);
    }

    function update_nomor_sekarang($data)
    {
        $this->db->where('nomor_sekarang');
        $this->db->update('antrian', $data);
    }

    function insert_kode_booking($data)
    {
        $this->db->set('kode_booking', $data['kode_booking']);
        $this->db->where('id', $data['id']);
        $this->db->update('user');
    }

    function ambil_nomor_antrian($data)
    {
        $this->db->set('antrian', $data['nomor']);
        $this->db->where('id', $data['id']);
        $this->db->update('user');
    }

    function reset_data($data)
    {
        $this->db->set('antrian', 0);
        $this->db->set('kode_booking', '');
        $this->db->update('user');
    }

    function reset_antrian()
    {
        $this->db->set('nomor_antrian', 0);
        $this->db->set('nomor_sekarang', 0);
        $this->db->update('antrian');
    }

}