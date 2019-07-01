<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Preprocessing extends CI_Controller
{
	public function __construct()
	{
        parent::__construct();
        $this->load->model('Model');
        error_reporting(0);
    } 
	
	public function index()
	{	
		$data = [
            'title' => 'Preprocessing',
		];
		$this->load->view('template/v_header',$data);
		$this->load->view('template/v_sidebar');
		$this->load->view('v_preprocessing');
		$this->load->view('template/v_footer');
    }

    public function preprocessing()
	{	
        $twitter = $this->Model->getDataTwitter();
        $data_training = $this->Model->jumlah('data_training');
        if(count($twitter) == 0){
            echo json_encode(0);
            return;
        }
        foreach($twitter as $tweet){
            $preprocessing = $tweet->tweet;
            $case_folding = $this->case_folding($preprocessing);
            $cleansing = $this->cleansing($case_folding);
            $tokenizing = $this->tokenizing($cleansing);
            $stopword = $this->stopWord($tokenizing);
            $stemming = $this->stemming($stopword);
            $data[] = [
                'case_folding' => [
                    'screen_name' => $tweet->username,
                    'full_text' => $case_folding
                ],
                'cleansing' => [
                    'screen_name' => $tweet->username,
                    'full_text' => $cleansing
                ],
                'tokenizing' => [
                    'screen_name' => $tweet->username,
                    'full_text' => $tokenizing
                ],
                'stopword' => [
                    'screen_name' => $tweet->username,
                    'full_text' => $stopword
                ],
                'stemming' => [
                    'screen_name' => $tweet->username,
                    'full_text' => $stemming
                ],
                'training' => $data_training,
            ];
        }

        if($data){
            echo json_encode($data);
        } else {
            echo json_encode("gagal");
        }
    }

   private function case_folding($data)
    {
        $lower = strtolower($data);
        return $lower;
    }

    private function cleansing($data)
    {
        $data = preg_replace('/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/', '', $data); //remove url
        $data = preg_replace('/#([\w-]+)/i', '', $data); //  #remove tag
        $data = preg_replace('/@([\w-]+)/i', '', $data); // #remove @someone
        $data = str_replace('rt : ', '', $data); // #remove RT
        $data = str_replace(',', '  ', $data);
        $data = str_replace('.', '  ', $data);
        $data = preg_replace('/[^A-Za-z0-9\  ]/', '', $data);
        $data = trim(preg_replace('/\s+/', ' ', $data));
        $data = (string)$data;

        return $data;
    }

    public function tokenizing($string)
    {
        $array = explode(' ', $string);
        return $array;
    }

    public function stopWord($data) 
    {
        $searchString = implode(" ",$data);
        $stopwords = $this->Model->getAll('stopwords','id','asc');
        foreach($stopwords as $stop){
            $list[] = $stop->stopword;
        }
        $wordsFromSearchString = str_word_count($searchString, true);
        $finalWords = array_diff($wordsFromSearchString, $list);
        $implode = implode(" ", $finalWords);
        $array = $this->tokenizing($implode);
        return $array;
    }

    public function stemming($kata)
    {   
        require_once(APPPATH.'controllers/ControllerStemming.php');
        $stemming = new ControllerStemming();
        $term = array();
        foreach($kata as $value){
            /* 1. Cek Kata di Kamus jika Ada SELESAI */
            if($stemming->cekKamus($value)){ // Cek Kamus
                array_push($term,$value); // Jika Ada push kedalam array
                continue;
            }
            /* 2. Buang Infection suffixes (\-lah", \-kah", \-ku", \-mu", atau \-nya") */
            $value = $stemming->Del_Inflection_Suffixes($value);
            
            /* 3. Buang Derivation suffix (\-i" or \-an") */
            $value = $stemming->Del_Derivation_Suffixes($value);
            
            /* 4. Buang Derivation prefix */
            $value = $stemming->Del_Derivation_Prefix($value);
            
            array_push($term,$value);
        }
        return $term;
    }

    public function latih()
    {
        $twitter = $this->Model->getDataTwitter();
        foreach($twitter as $tweet => $value){
            $preprocessing = $value->tweet;
            $case_folding = $this->case_folding($preprocessing);
            $cleansing = $this->cleansing($case_folding);
            $tokenizing = $this->tokenizing($cleansing);
            $stopword = $this->stopWord($tokenizing);
            $stemming = $this->stemming($stopword);

            //simpan data training
            $data_training = [
                'id_crawling' => $value->id_crawling,
            ];

            $simpan_training = $this->Model->simpan('data_training',$data_training);

            //update status data crawling
            $this->Model->update('id_crawling',$value->id_crawling,['status' => '0','proses' => '1'],'data_crawling');

            //ambil id training
            $id_training = $this->Model->getByID('data_training','id_crawling',$value->id_crawling);

            //simpan frekuensi
            for($i=0; $i<count($stemming); $i++){
                $count = $this->Model->getTotalFrequencyLatih($stemming[$i],$value->id_sentimen);
                
                if ($count == 0) {

                    $wordFrequency = [
                        'kata' => $stemming[$i],
                        'id_sentimen' => $value->id_sentimen,
                        'jumlah' => 1,
                        'id_training' => $id_training->id_training,
                    ];

                    $simpanFrequency = $this->Model->simpan('term_frequency',$wordFrequency);

                } else {
                    // WordFrequency::where([['kata',$stemming[$i]],['id_testing',null],['id_sentimen',$value->id_sentimen]])->increment('jumlah', 1);
                    $wordFrequency = $this->Model->updateFrequencyLatih($stemming[$i],$value->id_sentimen);
                }
            }
            $update_nilai[] = $stemming;
        }

        //simpan nilai_perhitungan pada table term freq
        foreach($this->Model->getAll('sentimen','id_sentimen','asc') as $stm){
            $class['class'][] = $stm->id_sentimen;
        }

        foreach($update_nilai as $nilai_stemming){
            $hitung = 1;
            $distinct = $this->db->query("SELECT count(*) as total FROM (SELECT kata FROM term_frequency WHERE term_frequency.id_training is not null GROUP by kata) as x")->result();
            foreach($distinct as $dst){
                $distinctWords = $dst->total;
            }
            $uniqueWords = $distinctWords;

            foreach ($nilai_stemming as $word) {
                foreach($class['class'] as $cls ){
                    $wordC = $this->db->query("SELECT jumlah as total FROM term_frequency where kata = '$word' and id_sentimen = '$cls' AND term_frequency.id_training is not null")->result();
                    if($wordC == null){
                        $wordCount = null;
                    } else {
                        foreach($wordC as $wC){
                            $wordCount = $wC->total;
                        }
                    }

                    $total[$cls][$word] = $wordCount;
                    $wordSum = $this->Model->getWordSum($cls);
                    $sum[$cls] = $wordSum->jumlah_term;
                    
                    $prob = ($total[$cls][$word]+1)/($sum[$cls]+$uniqueWords);
                    // $value[$cls][$word][] = round($prob,11); 
                    $update = round($prob,11);
                    $this->Model->updateHitungFreq($word,$cls,$update);
                }
            }
        }
   }

    public function uji()
    {    
        $twitter = $this->Model->getDataTwitter();
        foreach($twitter as $tweet => $value){

            //simpan data testing
            $data_testing = [
                'id_crawling' => $value->id_crawling,
            ];

            $simpan_testing = $this->Model->simpan('data_testing',$data_testing);
        
            $this->Model->update('id_crawling',$value->id_crawling,['status' => '1','proses' => '1'],'data_crawling');

            $analisa = $this->Model->getDataTesting($value->id_crawling);
            
            $preprocessing = $analisa->tweet;

            $case_folding = $this->case_folding($preprocessing);
            $cleansing = $this->cleansing($case_folding);
            $tokenizing = $this->tokenizing($cleansing);
            $stopword = $this->stopWord($tokenizing);
            $stemming = $this->stemming($stopword);
            
            $kategori = $this->decide($stemming,$analisa->id_testing);
            
            //ambil data hasil
            $hasil = $this->Model->getByID('hasil','id_testing',$analisa->id_testing);

            $klasifikasi = [
                'id_sentimen' => $kategori['hasil'],
                'id_testing' => $analisa->id_testing,
                'id_hasil' => $hasil->id_hasil
            ];

            $this->Model->simpan('klasifikasi',$klasifikasi);
            
            //simpan frekuensi
            for($i=0; $i<count($stemming); $i++){
                $count = $this->Model->getTotalFrequencyUji($stemming[$i],$value->id_sentimen);
                if ($count == 0) {
                    $id_training = $this->Model->getByID('data_training','id_crawling',$value->id_crawling);

                    $wordFrequency = [
                        'kata' => $stemming[$i],
                        'id_sentimen' => $kategori['hasil'],
                        'jumlah' => 1,
                        'id_testing' => $analisa->id_testing,
                    ];

                    $simpanFrequency = $this->Model->simpan('term_frequency',$wordFrequency);

                } else {
                    $wordFrequency = $this->Model->updateFrequencyUji($stemming[$i],$kategori['hasil']);
                }
            }

            //simpan proses
            foreach($kategori['value'] as $index_kategori => $value_kategori){
                foreach($value_kategori as $index_kata => $data_kata){
                    foreach($data_kata as $index_nilai => $data_nilai){
                        $id_training = $this->Model->getFreqProses($index_kategori,$index_kata);
                        $kelas_peluang = $this->Model->getByID('sentimen','id_sentimen',$index_kategori);
                        
                        if(empty($id_training)){
                            $proses = null;
                        } else {
                            $proses = $id_training->id_training;
                        }

                        $data_proses = [
                            'id_testing' => $analisa->id_testing,
                            'id_training' => $proses,
                            'kemunculan_kata' => $index_kata,
                            'kelas_peluang' => $kelas_peluang->kategori,
                            'nilai' => $data_nilai
                        ];

                        $simpanProses = $this->Model->simpan('proses',$data_proses);
                    }
                }
            }
        }
    }

    private function decide($keywordsArray,$id_testing) 
    {
        foreach($this->Model->getAll('sentimen','id_sentimen','asc') as $stm){
            $class['class'][] = $stm->id_sentimen;
        }

        $hitung = 1;
        $distinct = $this->db->query("SELECT count(*) as total FROM (SELECT kata FROM term_frequency WHERE term_frequency.id_training is not null GROUP by kata) as x")->result();
        foreach($distinct as $dst){
            $distinctWords = $dst->total;
        }
        $uniqueWords = $distinctWords;
        
        foreach ($keywordsArray as $word) {

            foreach($class['class'] as $cls ){
                $wordC = $this->db->query("SELECT jumlah as total FROM term_frequency where kata = '$word' and id_sentimen = '$cls' AND term_frequency.id_training is not null")->result();
                if($wordC == null){
                    $wordCount = null;
                } else {
                    foreach($wordC as $wC){
                        $wordCount = $wC->total;
                    }
                }

                $total[$cls][$word] = $wordCount;
                $wordSum = $this->Model->getSumUji($cls); 
                $sum[$cls] = $wordSum->jumlah_term;
                
                $prob = ($total[$cls][$word]+1)/($sum[$cls]+$uniqueWords);
                $value[$cls][$word][] = round($prob,11); 
            }
        }	

        //cari prior
        $i = 0;
        foreach($class['class'] as $cls)
        {
            $Count = $this->Model->getCountUji($cls);
            $totalCount = $this->Model->jumlah('data_training');
            $prior[$cls] = $Count / $totalCount;
        }

        foreach($value as $key => $val){
            foreach($val as $keys => $vals){
                $hitung = array_product($val[$keys]);
                $tam[$key][] = $hitung;
            }
            $multiply = array_product($tam[$key]);
            $final[$key] = $multiply*$prior[$key];
        }

        foreach($class['class'] as $cls){
            //simpan hasil

            $hasil = [
                'nilai' => $final[$cls],
                'id_testing' => $id_testing,
                'id_sentimen' => $cls
            ];

            $this->Model->simpan('hasil',$hasil);
        }

        // echo json_encode($semua_data); die();
        arsort($final);
        $category = key($final);

        $semua_data = [
            'kata_unik' => $uniqueWords,
            'word_count' => $wordCount,
            'total' => $total,
            'sum' => $sum,
            'value' => $value,
            'class' => $Count,
            'total_semua_class' => $totalCount,
            'prior' => $prior,
            'final' => $final,
            'hasil' => $category
        ];

        return $semua_data;
    }

    
}