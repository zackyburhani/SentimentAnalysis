<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class KataDasar extends CI_Controller
{
	public function __construct()
	{
        parent::__construct();
        $this->load->model('Model');
	} 
	
	public function index()
	{	
		$data = [
            'title' => 'Kata Dasar',
		];
		$this->load->view('template/v_header',$data);
		$this->load->view('template/v_sidebar');
		$this->load->view('v_kataDasar');
		$this->load->view('template/v_footer');
    }

    public function getKataDasar()
	{	
		$data = $this->Model->getAll('tb_katadasar','id_katadasar','asc');
        if($data){
            echo json_encode($data);
        } else {
            echo json_encode("gagal");
        }
    }

    
}