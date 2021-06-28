<?php
defined('BASEPATH') or exit('No direct script access allowed');

//load Guzzle Library
require_once APPPATH.'third_party/guzzle/autoload.php';

class Ticket extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
   
    }

    public function new()
    {
        date_default_timezone_set('asia/jakarta');
        $this->load->helper('string');
        $data = [
            'id' => random_string('alnum',8),
            'date' => date('Y-m-d H:i:s'),
            'npk' => $this->session->userdata('npk'),
            'nama' => $this->session->userdata('nama'),
            'menu' => $this->input->post('menu'),
            'case' => $this->input->post('case'),
            'status' => 'OPEN'
        ];
        $this->db->insert('ticket', $data);

            $client = new \GuzzleHttp\Client();
            $response = $client->post(
                'https://region01.krmpesan.com/api/v2/message/send-text',
                [
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'Accept' => 'application/json',
                        'Authorization' => 'Bearer zrIchFm6ewt2f18SbXRcNzSVXJrQBEsD1zrbjtxuZCyi6JfOAcRIQkrL6wEmChqVWwl0De3yxAhJAuKS',
                    ],
                    'json' => [
                        'phone' => '081311196988',
                        'message' => "*NEW TICKET ".$data['menu']."*". 
                        "\r\n \r\n No. Ticket : *" . $data['id'] . "*" .
                        "\r\n Nama : *" . $data['nama'] . "*" .
                        "\r\n Kasus : *" . $data['case'] . "*"
                    ],
                ]
            );
            $body = $response->getBody();

        $this->session->set_flashdata('message', 'openticket');
        redirect('/dashboard');
    }

}
