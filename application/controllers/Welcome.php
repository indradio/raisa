<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$tanggal = '03';
		// $tanggal = date('d');
		$bulan = date('m');
		$tahun = date('Y');
		
		// $this->db->where('day(tglmulai)', $tanggal);
		$this->db->where('month(tglmulai)', $bulan);
		$this->db->where('year(tglmulai)', $tahun);
		$this->db->where('status', '9');
		$lembur = $this->db->get('lembur')->result_array();
		foreach ($lembur as $l) :
			$this->db->select('SUM(durasi) as total');
			$this->db->where('link_aktivitas', $l['id']);
			$this->db->from('aktivitas');
			$durasi = $this->db->get()->row()->total;

			$this->db->set('durasi', $durasi);
			$this->db->where('id', $l['id']);
			$this->db->update('lembur');
		endforeach;
	}
}
