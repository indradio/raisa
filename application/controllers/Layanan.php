<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Layanan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $data['sidemenu'] = 'Dashboard';
        $data['sidesubmenu'] = '';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('dashboard/index', $data);
        $this->load->view('templates/footer');
    }

    public function informasi()
    {
        $data['sidemenu'] = 'Layanan';
        $data['sidesubmenu'] = 'Informasi';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['informasi'] = $this->db->get('informasi')->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('layanan/informasi', $data);
        $this->load->view('templates/footer');
    }

    public function buatInformasi()
    {
        date_default_timezone_set('asia/jakarta');

        $data = [
            'id' => time(),
            'judul' => $this->input->post('judul'),
            'deskripsi' => $this->input->post('deskripsi'),
            'gambar_banner' => 'default.jpg',
            'gambar_konten' => 'default.jpg',
            'berlaku' => date('Y-m-d', strtotime($this->input->post('berlaku')))
        ];
        $this->db->insert('informasi', $data);

        $config['upload_path']          = './assets/img/info/';
        $config['allowed_types']        = 'jpg|jpeg|png';
        $config['max_size']             = 1024;
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('gambar_banner')) {
            $this->db->set('gambar_banner', $this->upload->data('file_name'));
            $this->db->set('gambar_konten', $this->upload->data('file_name'));
            $this->db->where('judul', $this->input->post('judul'));
            $this->db->update('informasi');
        }

        redirect('layanan/informasi');
    }

    public function updateInformasi()
    {
        date_default_timezone_set('asia/jakarta');

        $this->db->set('judul', $this->input->post('judul'));
        $this->db->set('deskripsi', $this->input->post('deskripsi'));
        $this->db->set('berlaku', date('Y-m-d', strtotime($this->input->post('berlaku'))));
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('informasi');

        $config['upload_path']          = './assets/img/info/';
        $config['allowed_types']        = 'jpg|jpeg|png';
        $config['max_size']             = 1024;
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('gambar_banner')) {
            $this->db->set('gambar_banner', $this->upload->data('file_name'));
            $this->db->set('gambar_konten', $this->upload->data('file_name'));
        }

        redirect('layanan/informasi');
    }

    public function hapusInformasi($id)
    {
        $this->db->set('informasi');
        $this->db->where('id', $id);
        $this->db->delete('informasi');

        redirect('layanan/informasi');
    }

    public function messages()
    {
        $data['sidemenu'] = 'Layanan';
        $data['sidesubmenu'] = 'Kirim Pesan';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['pesan'] = $this->db->get('layanan_pesan')->result_array();
        $data['notifikasi'] = $this->db->get('layanan_notifikasi')->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('layanan/messages', $data);
        $this->load->view('templates/footer');
    }

    public function messages_send()
    {
        foreach ($this->input->post('penerima') as $to) :
            date_default_timezone_set('asia/jakarta');
            // $my_apikey = "NQXJ3HED5LW2XV440HCG";
            // $destination = $to;
            // $message = $this->input->post('pesan');
            // $api_url = "http://panel.apiwha.com/send_message.php";
            // $api_url .= "?apikey=" . urlencode($my_apikey);
            // $api_url .= "&number=" . urlencode($destination);
            // $api_url .= "&text=" . urlencode($message);
            // json_decode(file_get_contents($api_url, false));

            $postData = array(
                'deviceid' => 'ed59bffb-7ffd-4ac2-b039-b4725fdd4010',
                'number' => $to,
                'message' => $this->input->post('pesan')
            );

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, 'https://ws.premiumfast.net/api/v1/message/send');
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            $headers = array();
            $headers[] = 'Accept: application/json';
            $headers[] = 'Authorization: Bearer 4495c8929e574477a9167352d529969cded0eb310cd936ecafa011dc48f2921b';
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $result = curl_exec($ch);

            // Record History
            $penerima = $this->db->get_where('karyawan', ['phone' => $to])->row_array();

            $data = [
                'create_at' => date('Y-m-d H:i:s'),
                'pengirim' => $this->session->userdata('nama'),
                'penerima' => $penerima['nama'],
                'pesan' => $this->input->post('pesan')
            ];
            $this->db->insert('layanan_pesan', $data);

        endforeach;

        redirect('layanan/messages');
    }

    public function notifikasi()
    {
        $this->db->set('pesan', $this->input->post('notifikasi'));
        $this->db->where('id', '1');
        $this->db->update('layanan_notifikasi');

        redirect('layanan/messages');
    }

    public function broadcast()
    {
        $data['sidemenu'] = 'Kehadiran';
        $data['sidesubmenu'] = 'Data';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $this->load->helper('url');
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('layanan/broadcast', $data);
        $this->load->view('templates/footer');
    }
    public function broadcast_send($parameter)
    {
        date_default_timezone_set('asia/jakarta');
        if ($parameter == 'A') {
            $this->db->where('is_active', '1');
            $this->db->where('status', '1');
            $this->db->where('group', 'A');
            // $this->db->where('npk', '0282');
            $karyawan = $this->db->get('karyawan')->result_array();
            foreach ($karyawan as $k) :
                //Notifikasi ke USER
                $postData = array(
                    'deviceid' => 'ed59bffb-7ffd-4ac2-b039-b4725fdd4010',
                    'number' => $k['phone'],
                    'message' => "*PENTING! : PENGISIAN FORM PEDULI KESEHATAN KARYAWAN*" .
                        "\r\n \r\nSemangat Pagi, Hai *" . $k['nama'] . "*" .
                        "\r\n \r\nDalam rangka pencegahan penyebaran COVID 19 dan demi menjaga kesehatan serta keselamatan para karyawan serta keluarga karyawan setelah libur lebaran, maka setiap karyawan *DIHARUSKAN* mengisi FORM PEDULI KESEHATAN KARYAWAN sebelum kembali berkerja." .
                        "\r\n \r\nAdapun poin penting yang perlu diingat sebagai berikut:" .
                        "\r\n \r\n*1. Form ini diisi dengan penuh kesadaran dan kejujuran, kejujuran karyawan menentukan keselamatan karyawan lainnya.*" .
                        "\r\n*2. Setiap Karyawan menyadari bahwa keselamatan karyawan lain serta keluarga juga menjadi bagian dari tanggung jawab sosial guna mencegah persebaran virus / penyakit infeksi COVID-19.*" .
                        "\r\n*3. Setiap karyawan telah mentaati peraturan pemerintah danperusahaan dalam mencegah persebaran virus / penyakit infeksi COVID-19.*" .
                        "\r\n*4. Tanpa form ini Karyawan tidak diperkenankan masuk di hari kerja setelah Libur Lebaran.*" .
                        "\r\n \r\nUntuk pengisian FORM PEDULI KESEHATAN KARYAWAN dapat melalui link berikut : https://raisa.winteq-astra.com/dirumahaja" .
                        "\r\n \r\nDemikian informasi yang kami sampaikan. Atas perhatian dan pengertiannya kami ucapkan terima kasih." .
                        "\r\n \r\n \r\nHormat kami," .
                        "\r\n \r\n \r\nPT Astra Otoparts Tbk Divisi Winteq"
                );

                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, 'https://ws.premiumfast.net/api/v1/message/send');
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

                $headers = array();
                $headers[] = 'Accept: application/json';
                $headers[] = 'Authorization: Bearer 4495c8929e574477a9167352d529969cded0eb310cd936ecafa011dc48f2921b';
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                $result = curl_exec($ch);
            endforeach;
            redirect('layanan/broadcast');
        } elseif ($parameter == 'B') {
            $this->db->where('is_active', '1');
            $this->db->where('status', '1');
            $this->db->where('group', 'B');
            $karyawan = $this->db->get('karyawan')->result_array();
            foreach ($karyawan as $k) :
                //Notifikasi ke USER
                $postData = array(
                    'deviceid' => 'ed59bffb-7ffd-4ac2-b039-b4725fdd4010',
                    'number' => $k['phone'],
                    'message' => "*PENTING! : PENGISIAN FORM PEDULI KESEHATAN KARYAWAN*" .
                        "\r\n \r\nSemangat Pagi, Hai *" . $k['nama'] . "*" .
                        "\r\n \r\nDalam rangka pencegahan penyebaran COVID 19 dan demi menjaga kesehatan serta keselamatan para karyawan serta keluarga karyawan setelah libur lebaran, maka setiap karyawan *DIHARUSKAN* mengisi FORM PEDULI KESEHATAN KARYAWAN sebelum kembali berkerja." .
                        "\r\n \r\nAdapun poin penting yang perlu diingat sebagai berikut:" .
                        "\r\n \r\n*1. Form ini diisi dengan penuh kesadaran dan kejujuran, kejujuran karyawan menentukan keselamatan karyawan lainnya.*" .
                        "\r\n*2. Setiap Karyawan menyadari bahwa keselamatan karyawan lain serta keluarga juga menjadi bagian dari tanggung jawab sosial guna mencegah persebaran virus / penyakit infeksi COVID-19.*" .
                        "\r\n*3. Setiap karyawan telah mentaati peraturan pemerintah danperusahaan dalam mencegah persebaran virus / penyakit infeksi COVID-19.*" .
                        "\r\n*4. Tanpa form ini Karyawan tidak diperkenankan masuk di hari kerja setelah Libur Lebaran.*" .
                        "\r\n \r\nUntuk pengisian FORM PEDULI KESEHATAN KARYAWAN dapat melalui link berikut : https://raisa.winteq-astra.com/dirumahaja" .
                        "\r\n \r\nDemikian informasi yang kami sampaikan. Atas perhatian dan pengertiannya kami ucapkan terima kasih." .
                        "\r\n \r\n \r\nHormat kami," .
                        "\r\n \r\n \r\nPT Astra Otoparts Tbk Divisi Winteq"
                );

                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, 'https://ws.premiumfast.net/api/v1/message/send');
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

                $headers = array();
                $headers[] = 'Accept: application/json';
                $headers[] = 'Authorization: Bearer 4495c8929e574477a9167352d529969cded0eb310cd936ecafa011dc48f2921b';
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                $result = curl_exec($ch);
            endforeach;
            redirect('layanan/broadcast');
        } elseif ($parameter == 'C') {
            $this->db->where('is_active', '1');
            $this->db->where('status', '1');
            $this->db->where('group', 'C');
            $karyawan = $this->db->get('karyawan')->result_array();
            foreach ($karyawan as $k) :
                //Notifikasi ke USER
                $postData = array(
                    'deviceid' => 'ed59bffb-7ffd-4ac2-b039-b4725fdd4010',
                    'number' => $k['phone'],
                    'message' => "*PENTING! : PENGISIAN FORM PEDULI KESEHATAN KARYAWAN*" .
                        "\r\n \r\nSemangat Pagi, Hai *" . $k['nama'] . "*" .
                        "\r\n \r\nDalam rangka pencegahan penyebaran COVID 19 dan demi menjaga kesehatan serta keselamatan para karyawan serta keluarga karyawan setelah libur lebaran, maka setiap karyawan *DIHARUSKAN* mengisi FORM PEDULI KESEHATAN KARYAWAN sebelum kembali berkerja." .
                        "\r\n \r\nAdapun poin penting yang perlu diingat sebagai berikut:" .
                        "\r\n \r\n*1. Form ini diisi dengan penuh kesadaran dan kejujuran, kejujuran karyawan menentukan keselamatan karyawan lainnya.*" .
                        "\r\n*2. Setiap Karyawan menyadari bahwa keselamatan karyawan lain serta keluarga juga menjadi bagian dari tanggung jawab sosial guna mencegah persebaran virus / penyakit infeksi COVID-19.*" .
                        "\r\n*3. Setiap karyawan telah mentaati peraturan pemerintah danperusahaan dalam mencegah persebaran virus / penyakit infeksi COVID-19.*" .
                        "\r\n*4. Tanpa form ini Karyawan tidak diperkenankan masuk di hari kerja setelah Libur Lebaran.*" .
                        "\r\n \r\nUntuk pengisian FORM PEDULI KESEHATAN KARYAWAN dapat melalui link berikut : https://raisa.winteq-astra.com/dirumahaja" .
                        "\r\n \r\nDemikian informasi yang kami sampaikan. Atas perhatian dan pengertiannya kami ucapkan terima kasih." .
                        "\r\n \r\n \r\nHormat kami," .
                        "\r\n \r\n \r\nPT Astra Otoparts Tbk Divisi Winteq"
                );

                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, 'https://ws.premiumfast.net/api/v1/message/send');
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

                $headers = array();
                $headers[] = 'Accept: application/json';
                $headers[] = 'Authorization: Bearer 4495c8929e574477a9167352d529969cded0eb310cd936ecafa011dc48f2921b';
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                $result = curl_exec($ch);
            endforeach;
            redirect('layanan/broadcast');
        }
    }
}
