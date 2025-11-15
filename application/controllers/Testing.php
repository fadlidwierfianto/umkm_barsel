<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Testing extends CI_Controller
{

    public function index()
    {
        $response = [
            "status"  => true,
            "message" => "Testing API works!"
        ];

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }
    public function get_customer()
    {
        $this->load->model('Model_api_kustomer');
        $customers = $this->Model_api_kustomer->get_customer();

        $response = [
            "status" => true,
            "data" => $customers
        ];

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }
}
