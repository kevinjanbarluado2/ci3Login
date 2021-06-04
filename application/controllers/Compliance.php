<?php
defined('BASEPATH') or exit('No direct script access allowed');

use TCPDF as tcpdf;

class MYPDF extends TCPDF {

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
    public function index()
    {
        var_export("TEST");
        die();
    }
    
    
    public function generate()
    {
        $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);



        $html = $this->load->view('docs/pdf-template', array(
            'data' => $_POST
        ), true);
        // remove default header/footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(true);
        $pdf->AddPage(); // add a page
        $pdf->writeHTMLCell(187, 300, 12, 5, $html, 0, 0, false, true, '', true);
        $link = FCPATH . "assets/resources/preview.pdf";
        $pdf->Output($link, 'F');
        echo json_encode(array("link" => base_url('assets/resources/preview.pdf')));
    }
}
