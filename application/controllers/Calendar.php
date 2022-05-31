<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Calendar extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        date_default_timezone_set('asia/jakarta');
        $this->load->model("calendar_model");
    }

    public function index()
    {
        $data['sidemenu'] = 'Info HR';
        $data['sidesubmenu'] = 'Kalender';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('calendar/index', $data);
        $this->load->view('templates/footer');
    }

    public function events($params=null)
    {
        if($params=='add')
        {
            $this->load->helper('string');
            $this->load->helper('date');

            $id = date('ym').random_string('alnum',4);
            $data = [
                'id' => $id,
                'title' => $this->input->post('title'),
                'description' => $this->input->post('description'),
                'category' => $this->input->post('category'),
                'starts' => date('Y-m-d', strtotime($this->input->post('start'))),
                'ends' => date('Y-m-d', strtotime($this->input->post('end'))),
                'created_by' => $this->session->userdata('inisial'),
                'created_at' => date('Y-m-d H:i:s')
            ];
            $this->db->insert('calendar_event', $data);

            $start = new DateTime(date('Y-m-d', strtotime($this->input->post('start'))));
            $end = new DateTime(date('Y-m-d', strtotime("1 day", strtotime($this->input->post('end')))));
            $daterange  = new DatePeriod($start, new DateInterval('P1D'), $end);
            foreach($daterange as $date){
                $detail_id = $id.random_string('alnum',2);
                $data = [
                    'id' => $detail_id,
                    'calendar_id' => $id,
                    'title' => $this->input->post('title'),
                    'date' => $date->format("Y-m-d"),
                    'category' => $this->input->post('category')
                ];
                $this->db->insert('calendar_event_details', $data);
            }
        } elseif($params=='delete')
        {
            $this->db->where('id', $this->input->post('id'));
            $this->db->delete('calendar_event');

            $this->db->where('calendar_id', $this->input->post('id'));
            $this->db->delete('calendar_event_details');
        
        }else
        {
            $data['sidemenu'] = 'Info HR';
            $data['sidesubmenu'] = 'Kalender';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();

            if (empty($this->input->post('year')))
            {
                $data['year'] = date('Y');
            }else{
                $data['year'] = $this->input->post('year');
            }

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('calendar/events', $data);
            $this->load->view('templates/footer');
        }
    }

    public function GET_EVENTS()
    {
        // Our Start and End Dates
        $events = $this->calendar_model->GET_EVENTS();

        foreach ($events->result() as $row) {

            $output['data'][] = array(
                "title" => $row->title,
                "description" => $row->description,
                "start" => date('Y-m-d', strtotime($row->starts)),
                "end" => date('Y-m-d', strtotime('+1 days', strtotime($row->ends))),
                "category" => $row->category,
                "action" => ''
            );
        }
        echo json_encode($output);
        exit();
    }

    public function GET_EVENTS_BY_YEAR()
    {
        // Our Start and End Dates
        $events = $this->calendar_model->GET_EVENTS_BY_YEAR($this->input->post('year'));

        foreach ($events->result() as $row) {
            if ($row->starts==$row->ends){
                $date = date('d M Y', strtotime($row->starts));
            }else{
                $date = date('d M Y', strtotime($row->starts)).' - '.date('d M Y', strtotime($row->ends));
            }

            $output['data'][] = array(
                "title" => $row->title,
                "description" => $row->description,
                "date" => $date,
                "start" => date('d M Y', strtotime($row->starts)),
                "end" => date('d M Y', strtotime($row->ends)),
                "category" => $row->category,
                "action" => '<a href="#" class="btn btn-link btn-danger btn-just-icon" role="button" aria-disabled="false" data-toggle="modal" data-target="#deleteEvent" data-id="'. $row->id .'"><i class="material-icons">close</i></a>'
            );
        }
        echo json_encode($output);
        exit();
    }

    public function GET_NASIONAL()
    {
        // Our Start and End Dates
        $events = $this->calendar_model->GET_NASIONAL();
        $data_events = array();

        foreach ($events->result() as $row) {

            $data_events[] = array(
                "id" => $row->id,
                "title" => $row->title,
                "description" => $row->description,
                "start" => date('Y-m-d', strtotime($row->starts)),
                "end" => date('Y-m-d', strtotime('+1 days', strtotime($row->ends)))
            );
        }
        echo json_encode(array("events" => $data_events));
        exit();
    }
    public function GET_KEAGAMAAN()
    {
        // Our Start and End Dates
        $events = $this->calendar_model->GET_KEAGAMAAN();
        $data_events = array();

        foreach ($events->result() as $row) {

            $data_events[] = array(
                "id" => $row->id,
                "title" => $row->title,
                "description" => $row->description,
                "start" => date('Y-m-d', strtotime($row->starts)),
                "end" => date('Y-m-d', strtotime('+1 days', strtotime($row->ends)))
            );
        }
        echo json_encode(array("events" => $data_events));
        exit();
    }
    public function GET_MASSAL()
    {
        // Our Start and End Dates
        $events = $this->calendar_model->GET_MASSAL();
        $data_events = array();

        foreach ($events->result() as $row) {

            $data_events[] = array(
                "id" => $row->id,
                "title" => $row->title,
                "description" => $row->description,
                "start" => date('Y-m-d', strtotime($row->starts)),
                "end" => date('Y-m-d', strtotime('+1 days', strtotime($row->ends)))
            );
        }
        echo json_encode(array("events" => $data_events));
        exit();
    }

}
