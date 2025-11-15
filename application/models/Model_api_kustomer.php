<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Model_api_kustomer extends CI_Model
{
    public function get_customer()
    {
        $this->db->select('username, email, no_hp, jenis_kelamin, password');
        $this->db->from('rb_konsumen');
        $query = $this->db->get();
        return $query->result();
    }
    public function register_customer($data)
    {
        $registerCustomer = [
            'username' => $data['username'] ?? null,
            'email' => $data['email'] ?? null,
            'no_hp' => $data['no_hp'] ?? null,
        ];
    }
}
