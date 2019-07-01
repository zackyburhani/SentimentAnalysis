<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stopword extends CI_Controller
{
	public function __construct()
	{
        parent::__construct();
        $this->load->model('Model');
	} 
	
	public function index()
	{	
		$data = [
            'title' => 'Stopword',
		];
		$this->load->view('template/v_header',$data);
		$this->load->view('template/v_sidebar');
		$this->load->view('v_Stopword');
		$this->load->view('template/v_footer');
    }

    public function getStopword()
	{	
		$data = $this->Model->getAll('stopwords','id','asc');
        if($data){
            echo json_encode($data);
        } else {
            echo json_encode("gagal");
        }
    }

    
}