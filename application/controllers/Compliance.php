<?php
defined('BASEPATH') or exit('No direct script access allowed');

use TCPDF as tcpdf;

class MYPDF extends TCPDF {
    function __construct($company)
    {
      parent::__construct();
  
      $this->SetCreator(PDF_CREATOR);
      $this->SetAuthor('Doc Generator');
  
      // set margins
      $this->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP / 2, PDF_MARGIN_RIGHT);
      $this->setPageOrientation('P', true, 10);
      $this->SetFont('dejavusans', '', 8); // set the font
  
      $this->setHeaderMargin(PDF_MARGIN_HEADER);
      $this->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM - 10);
  
      $this->SetPrintHeader(false);
      $this->SetPrintFooter(true);
  
      $this->setFontSubsetting(false);
  
      $this->company = $company['company'];
      $this->fspr_number = $company['fspr'];
      $this->trans = null;
      $this->docref = null;
      $this->hasPartner = null;
    }
    //Page header
    // public function Header() {
    //     // Logo
    //     $image_file = K_PATH_IMAGES.'logo_example.jpg';
    //     $this->Image($image_file, 10, 10, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
    //     // Set font
    //     $this->SetFont('helvetica', 'B', 20);
    //     // Title
    //     $this->Cell(0, 15, '<< TCPDF Example 003 >>', 0, false, 'C', 0, '', 0, false, 'M', 'M');
    // }

    // Page footer
    public function Footer() {
        
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $image = base_url() . "img/logo.png";
        $this->Image($image,  8, 280, 0, 10 , 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

        $this->Cell(0, 10, 'www.eliteinsure.co.nz | Page'.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
    }

    
}

class Compliance extends CI_Controller
{
    function __construct()
    {
      parent::__construct();
  
      date_default_timezone_set('Pacific/Auckland');
      error_reporting(0);
    }

    public function index()
    {
        var_export("TEST");
        die();
    }
    
    
    public function generate()
    {
        $adviser_id = $_POST['data']['info']['adviser'];
        
        $this->load->model('AdvisersCollection');
        $adviserInfo = $this->AdvisersCollection->getActiveAdvisersById($adviser_id);
        
        ob_start();
        set_time_limit(300);
        $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $html = $this->load->view('docs/pdf-template', array(
            'data' => $_POST,
            'adviserInfo' => $adviserInfo
        ), true);
        // remove default header/footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(true);
        $pdf->AddPage(); // add a page
        $pdf->writeHTMLCell(187, 300, 12, 5, $html, 0, 0, false, true, '', true);
        $link = FCPATH . "assets/resources/preview.pdf";
        $pdf->Output($link, 'F');
        ob_end_clean();
        echo json_encode(array("link" => base_url('assets/resources/preview.pdf')));
    }
}
