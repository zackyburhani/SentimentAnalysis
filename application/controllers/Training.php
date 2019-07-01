<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Training extends CI_Controller
{

    public function __construct()
	{
        parent::__construct();
        $this->load->model('Model');
    } 
    
    public function index()
    {
            foreach($this->Model->getAll('sentimen','id_sentimen','asc') as $stm){
                $class['class'][] = $stm->kategori;
                $data_training[$stm->kategori] = $this->Model->getTermFreq($stm->id_sentimen);
            }
            
            $total = $this->Model->jumlah('term_frequency');

            foreach($class['class'] as $cls){
                
                $sum = $this->Model->getSumFreq($cls);  
                $data_sum[] = [
                    'kelas' => $cls,
                    'jumlah' => $sum->jumlah_term,
                ];
            }

            $distinct = $this->db->query("SELECT count(*) as total FROM (SELECT kata FROM term_frequency WHERE term_frequency.id_training is not null GROUP by kata) as x")->result();
            foreach($distinct as $dst){
                $distinctWords = $dst->total;
            }
            $uniqueWords = $distinctWords;

            $totalCount = $this->Model->jumlah('data_training');

            if($totalCount == 0){
                $data = [
                    'validasi' => 0
                ];
            } else {
                //cari prior
                $i = 0;
                foreach($class['class'] as $cls)
                {
                    $Count = $this->Model->getPrior($cls); 
                    
                    $prior[] = [
                        'kelas' => $cls,
                        'nilai' => $Count / $totalCount,
                    ];
                }

                $data = [
                    'validasi' => 1,
                    'title' => 'Preprocessing',
                    'data_sum' => $data_sum,
                    'prior' => $prior,
                    'uniqueWords' => $uniqueWords,
                    'data_training' => $data_training,
                    'total' => $total
                ];

            }

            // echo json_encode($data); die();
            $this->load->view('template/v_header',$data);
            $this->load->view('template/v_sidebar');
            $this->load->view('v_training');
            $this->load->view('template/v_footer');
    }

    public function hapus_training($kategori)
    {
        $sentimen = $this->Model->getByID('sentimen','kategori',$kategori);
        $data_training = $this->Model->hapusSentimen($sentimen->id_sentimen);
        redirect('Training');
    }

    public function data_sentimen()
    {
        $data_training = $this->Model->getAll('sentimen','id_sentimen','asc');
        echo json_encode($data_training);
    }

}
