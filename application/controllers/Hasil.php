<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hasil extends CI_Controller
{
    public function __construct()
	{
        parent::__construct();
        $this->load->model('Model');
    } 
    
    public function index()
    {
        $testing = $this->Model->jumlah('data_testing');
        $data = [
            'title' => 'Hasil',
            'testing' => $testing,
		];
		$this->load->view('template/v_header',$data);
		$this->load->view('template/v_sidebar');
		$this->load->view('v_hasil');
		$this->load->view('template/v_footer');
    }

    public function hasil_hitung()
    {
        $collection = array();
        $title = "Data Hasil Perhitungan";
        $sentimen = $this->Model->getAll('sentimen','id_sentimen','asc');
        $klasifikasi = $this->Model->getCollectionKlasifikasi();
        foreach($klasifikasi as $class){
            $prediksi = $this->Model->getPrediksi($class->id_testing);
            $collection[] = [
                'id_testing' => $class->id_testing,
                'username' => $class->username,
                'tweet' => $class->tweet,
                'kategori' => $class->kategori,
                'prediksi' => $prediksi->kategori,
                'testing_data' => $this->Model->jumlah('data_testing')
            ];
        }

        $data = [
            'collection' => $collection
        ];

		$this->load->view('template/v_header',$data);
		$this->load->view('template/v_sidebar');
		$this->load->view('v_prediksi');
		$this->load->view('template/v_footer');
    }

    public function getKlasifikasi()
    {
        $data = $this->Model->getKlasifikasi();
        
        $sum = $this->Model->jumlah('klasifikasi');
        
        $tampung = array();
        foreach($data as $val){
            $tampung[] = [
                'name' => $val->name,
                'persentase' => $val->y,
                'y' => round($val->y/$sum*100,2)
            ];
        }
        echo json_encode($tampung);
    }

    public function confusion_matrix()
    {
        $title = "Data Confusion Matrix";
        $testing_data = $this->Model->jumlah('data_testing');

        $klasifikasi = $this->Model->getKlasifikasiSentimen();

        foreach($klasifikasi as $kelas){
            $predictedLabels[] = $kelas->kategori;
            $testing = $this->Model->getByID('data_testing','id_testing',$kelas->id_testing);
            $twitter = $this->Model->getTwitterCM($testing->id_crawling);
            $actualLabels[] = $twitter->kategori;
        }

        require_once(APPPATH.'controllers/ControllerCM.php');

        $getPrecision = new ControllerCM($actualLabels, $predictedLabels);
        $accuracy = ControllerCM::score($actualLabels, $predictedLabels);
        $recall = $getPrecision->getRecall();
        $precision = $getPrecision->getPrecision();
            
        foreach($precision as $index_pc => $value_pc){
            $th[] = $index_pc;
        }
            
        sort($th);
        $confusionMatrix = ControllerCM::compute($actualLabels, $predictedLabels,$th);
            
        $matrix = array();

        foreach($th as $index_th => $value){
            $matrix[$value] = $confusionMatrix[$index_th];
            if(!array_key_exists($value,$recall)){
                $recall[$value] = 0;
            } 
            if(!array_key_exists($value,$precision)){
                $precision[$value] = 0;
            } 
        }

        ksort($precision);

        $data_cm = [
            'title' => $title,
            'testing_data' => $testing_data,
            'confusionMatrix' => $confusionMatrix,
            'th' => $th,
            'matrix' => $matrix,
            'recall' => $recall,
            'precision' => $precision,
            'accuracy'=> $accuracy
        ];
                
        $this->load->view('template/v_header',$data_cm);
        $this->load->view('template/v_sidebar');
        $this->load->view('v_cm');
        $this->load->view('template/v_footer');
    }

    public function column_drilldown()
    {
        $testing_data = $this->Model->jumlah('data_testing');
        $klasifikasi = $klasifikasi = $this->Model->getKlasifikasiSentimen();

        foreach($klasifikasi as $kelas){
            $predictedLabels[] = $kelas->kategori;
            $testing = $this->Model->getByID('data_testing','id_testing',$kelas->id_testing);
            $twitter = $this->Model->getTwitterCM($testing->id_crawling);
            $actualLabels[] = $twitter->kategori;
        }

        require_once(APPPATH.'controllers/ControllerCM.php');
        $getPrecision = new ControllerCM($actualLabels, $predictedLabels);
        $accuracy = ControllerCM::score($actualLabels, $predictedLabels);
        $error_rate = ControllerCM::error_rate($actualLabels, $predictedLabels);
        $recall = $getPrecision->getRecall();
        $precision = $getPrecision->getPrecision();
        $devide_recall = $getPrecision->getRecall();
        $devide_precision = $getPrecision->getPrecision();

        foreach ($devide_recall as $array_key1 => $array_item1) {
            if ($devide_recall[$array_key1] == 0) {
            unset($devide_recall[$array_key1]);
            }
        }

        foreach ($devide_precision as $array_key2 => $array_item2) {
            if ($devide_precision[$array_key2] == 0) {
                unset($devide_precision[$array_key2]);
            }
        }

        $sum_precision = array_sum($precision);
        $count_precision = count($devide_precision);
        $sum_recall = array_sum($recall);
        $count_recall = count($devide_recall);
            
        if($sum_precision == 0 && $count_precision == 0){
            $total_precision = 0;
        } else {
            $total_precision = $sum_precision/$count_precision;
        }

        if($sum_recall == 0 && $count_recall == 0){
            $total_recall = 0;
        } else {
            $total_recall = $sum_recall/$count_recall;
        }        

        $data[] = [
            'accuracy' => round($accuracy*100,2),
            'precision' => $precision,
            'recall' => $recall,
            'error_rate' => round($error_rate*100,2),
            'total_precision' => round($total_precision,2),
            'total_recall' => round($total_recall,2),
        ]; 

        echo json_encode($data);
    }

    public function word_cloud()
    {
        $title = "Word Cloud";
        $testing_data = $this->Model->jumlah('data_testing');
        $klasifikasi = $this->Model->getDataWC(); 

        $data_wc = [
            'title' => $title,
            'klasifikasi' => $klasifikasi,
            'testing_data' => $testing_data,
        ];

        $this->load->view('template/v_header',$data_wc);
        $this->load->view('template/v_sidebar');
        $this->load->view('v_wc');
        $this->load->view('template/v_footer');
    }

    public function data_cloud($kategori)
    {  
        $data = $this->Model->getCollectWC($kategori);
        if(count($data) == 0){
            return null;
        }

        foreach($data as $dt){
            $string[] = $dt->string;
        }

        $str = implode(" ", $string);
        $str = trim(preg_replace('/\s+/', ' ', $str));
        echo json_encode($str);
    }

    public function jumlah_kategori_cloud()
    {
        $klasifikasi = $this->Model->getDataWC();
        echo json_encode($klasifikasi);
    }

    public function data_prediksi($id)
    {   
        $hasil = Hasil::where('id_testing',$id)->get();
        return $hasil;
    }

    public function hapus_testing()
    {
        try{
            $data_training = TwitterStream::where('status','1')->delete();
            return redirect('/analisa');
        }    
        catch (\Exception $e) {
            return redirect('/analisa')->with('status', 'Data Tidak Berhasil Dihapus');
        }
    }
}
