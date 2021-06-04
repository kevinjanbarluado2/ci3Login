<?php
defined('BASEPATH') or exit('No direct script access allowed');

use TCPDF as tcpdf;

class Compliance extends CI_Controller
{
    public function index()
    {
        var_export("TEST");
        die();
    }

    public function generate()
    {
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);



        $html = $this->load->view('docs/pdf-template', array(
            'data' => $_POST
        ), true);
        $pdf->AddPage(); // add a page
        $pdf->writeHTMLCell(187, 275, 12, 5, $html, 0, 0, false, true, '', true);
        $link=FCPATH . "assets/resources/preview.pdf";
        $pdf->Output($link, 'F');
        echo json_encode(array("link"=>base_url('assets/resources/preview.pdf')));
    }
}
