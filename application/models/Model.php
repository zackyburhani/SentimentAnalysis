<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model extends CI_Model {

    public function __construct()
    {
		parent::__construct();
    }

    //ambil semua data
	public function getAll($table,$col,$order)
	{
		$this->db->order_by($col, $order);
        $query = $this->db->get($table);
        return $query->result();
	}

    //simpan
	public function simpan($table,$data)
	{
		$checkinsert = false;
		try{
			$this->db->insert($table,$data);
			$checkinsert = true;
		}catch (Exception $ex) {
			$checkinsert = false;
		}
		return $checkinsert;
    }
    
    //update
	public function update($pk,$id,$data,$table)
	{
		$checkupdate = false;
		try{
			$this->db->where($pk,$id);
			$this->db->update($table,$data);
			$checkupdate = true;
		}catch (Exception $ex) {
			$checkupdate = false;
		}
		return $checkupdate;
    }
    
    //hapus
	public function hapus($pk,$id,$table)
	{
		$checkdelete = false;
		try{
			$this->db->where($pk,$id);
			$this->db->delete($table);
			$checkdelete = true;
		}catch (Exception $ex) {
			$checkdelete = false;
		}
		return $checkdelete;
    }
    
    //ambil semua data perID
	public function getByID($table,$kolom,$id)
	{
		$this->db->from($table);
		$this->db->where($kolom, $id);
		$query = $this->db->get();
		return $query->row();
    }
    
    public function getSentimen()
   	{
        $this->db->order_by('id_crawling', 'desc');
        $this->db->join('sentimen', 'data_crawling.id_sentimen = sentimen.id_sentimen');
        return $this->db->get('data_crawling')->result();
    }

    public function getSentimenExcel()
   	{
        $result = $this->db->query("SELECT * FROM data_crawling JOIN sentimen ON sentimen.id_sentimen = data_crawling.id_sentimen");
        return $result;
    }

    public function hapusAll($table)
	{
		$checkdelete = false;
		try{
			$this->db->query("DELETE FROM $table");
			$checkdelete = true;
		}catch (Exception $ex) {
			$checkdelete = false;
		}
		return $checkdelete;
	}
	
	public function hapusSentimen($sentimen)
	{
		$checkdelete = false;
		try{
			$this->db->query("DELETE FROM data_crawling WHERE id_sentimen = '$sentimen'");
			$checkdelete = true;
		}catch (Exception $ex) {
			$checkdelete = false;
		}
		return $checkdelete;
    }

      
    public function insertimport($data)
    {
        $this->db->insert_batch('data_crawling', $data);
    }

    public function getDataTwitter()
    {
        $this->db->from('data_crawling');
		$this->db->where('proses', '0');
		$query = $this->db->get();
		return $query->result();
	}

	public function getTotalFrequencyLatih($kata,$id_sentimen)
    {
		$query = $this->db->query("SELECT COUNT(*) as total FROM term_frequency WHERE kata = '$kata' AND id_sentimen = '$id_sentimen' AND id_testing is null")->row();
		return $query->total;
	}

	public function getTotalFrequencyUji($kata,$id_sentimen)
    {
		$query = $this->db->query("SELECT COUNT(*) as total FROM term_frequency WHERE kata = '$kata' AND id_sentimen = '$id_sentimen' AND id_training is null")->row();
		return $query->total;
	}

	public function updateFrequencyLatih($kata,$id_sentimen)
    {
		$checkupdate = false;
		try{
			$this->db->query("UPDATE term_frequency set jumlah = jumlah + 1 where kata = '$kata' and id_sentimen = '$id_sentimen' and id_testing is null");
			$checkupdate = true;
		}catch (Exception $ex) {
			$checkupdate = false;
		}
		return $checkupdate;
	}

	public function updateFrequencyUji($kata,$id_sentimen)
    {
		$checkupdate = false;
		try{
			$this->db->query("UPDATE term_frequency set jumlah = jumlah + 1 where kata = '$kata' and id_sentimen = '$id_sentimen' and id_training is null");
			$checkupdate = true;
		}catch (Exception $ex) {
			$checkupdate = false;
		}
		return $checkupdate;
	}

	public function getWordSum($cls)
	{
		$query = $this->db->query("SELECT SUM(jumlah) as jumlah_term FROM term_frequency WHERE id_sentimen = '$cls' and id_training is not null");
		return $query->row();
	}

	public function updateHitungFreq($kata,$id_sentimen,$update)
    {
		$checkupdate = false;
		try{
			$this->db->query("UPDATE term_frequency set nilai_hitung = '$update' where kata = '$kata' and id_sentimen = '$id_sentimen' and id_training is not null");
			$checkupdate = true;
		}catch (Exception $ex) {
			$checkupdate = false;
		}
		return $checkupdate;
	}

	public function getTermFreq($id_sentimen)
	{
		$this->db->where('id_sentimen', $id_sentimen);
		$this->db->where('id_testing', null);
        $query = $this->db->get('term_frequency');
        return $query->result();
	}

	public function jumlah($table)
  	{
    	$query = $this->db->get($table);
    	return $query->num_rows();
  	}
	
	public function getSumFreq($cls)
	{
		$query = $this->db->query("SELECT SUM(jumlah) as jumlah_term FROM term_frequency JOIN sentimen ON sentimen.id_sentimen = term_frequency.id_sentimen WHERE sentimen.kategori = '$cls' and id_training is not null");
		return $query->row(); 
	}

	public function getPrior($cls)
	{
		$this->db->join('data_crawling', 'data_crawling.id_crawling = data_training.id_crawling');
		$this->db->join('sentimen', 'sentimen.id_sentimen = data_crawling.id_sentimen');
		$this->db->select('sentimen.kategori as kategori');
		$this->db->where('sentimen.kategori', $cls);
		$query = $this->db->get('data_training');
		return $query->num_rows();
	}

	public function getDataTesting($id_crawling)
	{
		$this->db->join('data_testing', 'data_testing.id_crawling = data_crawling.id_crawling');
		$this->db->where('data_crawling.id_crawling', $id_crawling);
		$query = $this->db->get('data_crawling');
		return $query->row();
	}

	public function getFreqProses($id_sentimen, $kata)
	{
		$this->db->where('kata', $kata);
		$this->db->where('id_testing', null);
		$this->db->where('id_sentimen', $id_sentimen);
		$query = $this->db->get('term_frequency');
		return $query->row();
	}

	public function getSumUji($cls)
	{
		$query = $this->db->query("SELECT SUM(jumlah) as jumlah_term FROM term_frequency WHERE id_sentimen = '$cls' AND id_training is not null");
		return $query->row(); 
	}
	
	public function getCountUji($cls)
	{
		$this->db->join('data_crawling', 'data_crawling.id_crawling = data_training.id_crawling');
		$this->db->select('id_sentimen');
		$this->db->where('id_sentimen', $cls);
		$query = $this->db->get('data_training');
		return $query->num_rows();
	}

	public function getKlasifikasi()
	{			
		$this->db->join('sentimen', 'sentimen.id_sentimen = klasifikasi.id_sentimen');
		$this->db->select('sentimen.kategori as name, COUNT(*) as y');
		$this->db->group_by('sentimen.kategori');
		$query = $this->db->get('klasifikasi');
		return $query->result();
	}

	public function getCollectionKlasifikasi()
	{
		$this->db->join('data_crawling', 'data_crawling.id_crawling = data_testing.id_crawling');
		$this->db->join('sentimen', 'sentimen.id_sentimen = data_crawling.id_sentimen');
		$this->db->order_by('id_testing','asc');
		$query = $this->db->get('data_testing');
		return $query->result();
	}

	public function getPrediksi($id_testing)
	{
		$this->db->join('sentimen', 'sentimen.id_sentimen = klasifikasi.id_sentimen');
		$this->db->where('id_testing', $id_testing);
		$query = $this->db->get('klasifikasi');
		return $query->row();
	}

	public function getHasil($id_testing)
	{
		$this->db->where('id_testing', $id_testing);
		$query = $this->db->get('hasil');
		return $query->result();
	}

	public function getSentimenHasil($id_sentimen)
	{
		$this->db->where('id_sentimen', $id_sentimen);
		$query = $this->db->get('sentimen');
		return $query->row();
	}

	public function getHasilView($id_testing)
	{
		$this->db->where('id_testing', $id_testing);
		$this->db->join('sentimen', 'sentimen.id_sentimen = hasil.id_sentimen');
		$query = $this->db->get('hasil');
		return $query->result();	
	}
	
	public function getFreqTest($id_testing,$kelas_peluang) 
    {
        $this->db->join('data_testing', 'data_testing.id_testing = proses.id_testing');
		$this->db->where('data_testing.id_testing', $id_testing);
		$this->db->where('kelas_peluang', $kelas_peluang);
		$query = $this->db->get('proses');
		return $query->result();	
	}
	
	public function getDetailHitung($id_testing) 
    {
		$this->db->where('proses.id_testing', $id_testing);
		$query = $this->db->get('proses');
		return $query->result();
	} 
	
	public function getKlasifikasiSentimen()
	{
		$this->db->join('sentimen', 'sentimen.id_sentimen = klasifikasi.id_sentimen');
		$query = $this->db->get('klasifikasi');
		return $query->result();
	}

	public function getTwitterCM($id_crawling)
	{
		$this->db->join('sentimen', 'sentimen.id_sentimen = data_crawling.id_sentimen');
		$this->db->where('id_crawling',$id_crawling);
		$query = $this->db->get('data_crawling');
		return $query->row();
	}

	public function getDataWC()
	{
		$query = $this->db->query("SELECT sentimen.id_sentimen,kategori FROM klasifikasi JOIN sentimen on sentimen.id_sentimen = klasifikasi.id_sentimen GROUP BY sentimen.id_sentimen");
		return $query->result();
	}

	public function getCollectWC($kategori)
	{
		$query = $this->db->query("SELECT REPEAT(CONCAT(kata, ' '), jumlah) as string FROM term_frequency where term_frequency.id_training is null AND term_frequency.id_testing is not null AND id_sentimen = '$kategori'");
		return $query->result();
	}
	
}