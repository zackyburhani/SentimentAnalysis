<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Crawling extends CI_Controller
{
	public function __construct()
	{
        parent::__construct();
        $this->load->model('Model');
	} 
	
	public function index()
	{	
		$data = [
            'title' => 'Twitter',
            'data' => $this->Model->getSentimen(),
		];
		$this->load->view('template/v_header',$data);
		$this->load->view('template/v_sidebar');
		$this->load->view('v_crawling');
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

    public function hapus()
	{
		$data = $this->Model->hapusAll('data_crawling');
		return redirect('Crawling');
    }

    // public function export()
    // {
    //     // Load plugin PHPExcel nya
    //     include APPPATH.'third_party/PHPExcel/PHPExcel.php';
        
    //     // Panggil class PHPExcel nya
    //     $excel = new PHPExcel();
    //     // Settingan awal fil excel
    //     $excel->getProperties()->setCreator('My Notes Code')
    //                  ->setLastModifiedBy('My Notes Code')
    //                  ->setTitle("Data Siswa")
    //                  ->setSubject("Siswa")
    //                  ->setDescription("Laporan Semua Data Siswa")
    //                  ->setKeywords("Data Siswa");
    //     // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
    //     $style_col = array(
    //       'font' => array('bold' => true), // Set font nya jadi bold
    //       'alignment' => array(
    //         'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
    //         'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
    //       ),
    //       'borders' => array(
    //         'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
    //         'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
    //         'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
    //         'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
    //       )
    //     );
    //     // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
    //     $style_row = array(
    //       'alignment' => array(
    //         'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
    //       ),
    //       'borders' => array(
    //         'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
    //         'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
    //         'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
    //         'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
    //       )
    //     );
    //     $excel->setActiveSheetIndex(0)->setCellValue('A1', "DATA SISWA"); // Set kolom A1 dengan tulisan "DATA SISWA"
    //     $excel->getActiveSheet()->mergeCells('A1:E1'); // Set Merge Cell pada kolom A1 sampai E1
    //     $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
    //     $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
    //     $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
    //     // Buat header tabel nya pada baris ke 3
    //     $excel->setActiveSheetIndex(0)->setCellValue('A3', "NO"); // Set kolom A3 dengan tulisan "NO"
    //     $excel->setActiveSheetIndex(0)->setCellValue('B3', "NIS"); // Set kolom B3 dengan tulisan "NIS"
    //     $excel->setActiveSheetIndex(0)->setCellValue('C3', "NAMA"); // Set kolom C3 dengan tulisan "NAMA"
    //     $excel->setActiveSheetIndex(0)->setCellValue('D3', "JENIS KELAMIN"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
    //     $excel->setActiveSheetIndex(0)->setCellValue('E3', "ALAMAT"); // Set kolom E3 dengan tulisan "ALAMAT"
    //     // Apply style header yang telah kita buat tadi ke masing-masing kolom header
    //     $excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
    //     $excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
    //     $excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
    //     $excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
    //     $excel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);
    //     // Panggil function view yang ada di SiswaModel untuk menampilkan semua data siswanya
    //     $siswa = $this->Model->getAll('data_crawling','id_crawling','asc');
    //     $no = 1; // Untuk penomoran tabel, di awal set dengan 1
    //     $numrow = 4; // Set baris pertama untuk isi tabel adalah baris ke 4
    //     foreach($siswa as $data){ // Lakukan looping pada variabel siswa
    //       $excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
    //       $excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $data->tgl_tweet);
    //       $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $data->username);
    //       $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $data->tweet);
    //       $excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $data->id_sentimen);
          
    //       // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
    //       $excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
    //       $excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
    //       $excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
    //       $excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
    //       $excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
          
    //       $no++; // Tambah 1 setiap kali looping
    //       $numrow++; // Tambah 1 setiap kali looping
    //     }
    //     // Set width kolom
    //     $excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); // Set width kolom A
    //     $excel->getActiveSheet()->getColumnDimension('B')->setWidth(15); // Set width kolom B
    //     $excel->getActiveSheet()->getColumnDimension('C')->setWidth(25); // Set width kolom C
    //     $excel->getActiveSheet()->getColumnDimension('D')->setWidth(20); // Set width kolom D
    //     $excel->getActiveSheet()->getColumnDimension('E')->setWidth(30); // Set width kolom E
        
    //     // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
    //     $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
    //     // Set orientasi kertas jadi LANDSCAPE
    //     $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
    //     // Set judul file excel nya
    //     $excel->getActiveSheet(0)->setTitle("Laporan Data Siswa");
    //     $excel->setActiveSheetIndex(0);
    //     // Proses file excel
    //     header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    //     header('Content-Disposition: attachment; filename="Data Siswa.xlsx"'); // Set nama file excel nya
    //     header('Cache-Control: max-age=0');
    //     // $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2010');
    //     $write->save('php://output');
    // }

    public function upload()
    {
        if(isset($_FILES["data_crawling"]["name"]))
        {
            include APPPATH.'third_party/PHPExcel/PHPExcel.php';
            $path = $_FILES["data_crawling"]["tmp_name"];
            $object = PHPExcel_IOFactory::load($path);
            foreach($object->getWorksheetIterator() as $worksheet)
            {
                $highestRow = $worksheet->getHighestRow();
                $highestColumn = $worksheet->getHighestColumn();
                for($row=2; $row<=$highestRow; $row++)
                {   
                    // $namadaerah = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                    $tgl_tweet = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                    $tweet_id = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                    $username = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                    $tweet = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                    $sentimen = $worksheet->getCellByColumnAndRow(5, $row)->getValue();

                    $id_sentimen = $this->Model->getByID('sentimen','kategori',$sentimen);
                    $data[] = array(
                        'tgl_tweet' => $tgl_tweet,
                        'tweet_id' => $tweet_id,
                        'username' => $username,
                        'tweet' => $tweet,
                        'status' => null,
                        'proses' => '0',
                        'id_sentimen' => $id_sentimen->id_sentimen,
                    );
                }
            }
            $this->Model->insertimport($data);                
        }                
    }
}