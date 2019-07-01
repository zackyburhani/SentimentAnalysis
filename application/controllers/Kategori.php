<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori extends CI_Controller
{
	public function __construct()
	{
        parent::__construct();
        $this->load->model('Model');
	} 
	
	public function index()
	{	
		$data = [
            'title' => 'Kategori',
		];
		$this->load->view('template/v_header',$data);
		$this->load->view('template/v_sidebar');
		$this->load->view('v_kategori');
		$this->load->view('template/v_footer');
    }

    public function simpan()
	{	
		$data = [
			'kategori' => $this->input->post('kategori'),
		];

		$result = $this->Model->simpan('sentimen',$data);

        if($result){
            echo json_encode("sukses");
        } else {
            echo json_encode("gagal");
        }
	}
    
    public function getKategori()
    {
        $data = $this->Model->getAll('sentimen','id_sentimen','DESC');
        if($data){
            echo json_encode($data);
        } else {
            echo json_encode("gagal");
        }
    }

    public function getKategoriID($id)
    {
        $data = $this->Model->getByID('sentimen','id_sentimen',$id);
        if($data){
            echo json_encode($data);
        } else {
            echo json_encode("gagal");
        }
    }

    public function ubah($id)
    {
		$data = [
			'kategori' => $this->input->post('kategori'),
		];

		$result = $this->Model->update('id_sentimen',$id,$data,'sentimen');

		if($result){
            echo json_encode("sukses");
        } else {
            echo json_encode("gagal");
        }
    }

    public function hapus($id)
	{
		$data = $this->Model->hapus('id_sentimen',$id,'sentimen');
		if($data){
            echo json_encode("sukses");
        } else {
            echo json_encode("gagal");
        }
	}
}