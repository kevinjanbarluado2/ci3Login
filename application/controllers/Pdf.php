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

        $this->Cell(0, 10, 'www.eliteinsure.co.nz | Page'.$this->getAliasNumPage(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
        //$this->Cell(0, 10, 'www.eliteinsure.co.nz | Page'.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
    }

    
}

class Pdf extends CI_Controller {

	function __construct()
    {
      parent::__construct();
  
      date_default_timezone_set('Pacific/Auckland');
      error_reporting(0);
    }

	//view pdf
	public function viewPdfForm()
    {
        $results_id = $this->input->post('results_id');
        $this->load->model('ComplianceCollection');
        
        $res = $this->ComplianceCollection->getComplianceResultsById($results_id);
        $data['data'] = json_decode($res->answers, true);

        $this->load->model('AdvisersCollection');
        $adviserInfo = $this->AdvisersCollection->getActiveAdvisersById($res->adviser_id);
        
        ob_start();
        set_time_limit(300);
        $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $html = $this->load->view('docs/pdf-template', array(
            'data' => $data,
            'adviserInfo' => $adviserInfo,
            'added_by'=>$_SESSION['name']
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

	//function responsible for deleting records
	public function deletePdf(){
		$result = array();
		$page = 'deletePdf';
		$result['message'] = "There was an error in the connection. Please contact the administrator for updates.";

		if($this->input->post() && $this->input->post() != null) {
			$post_data = array();
			foreach ($this->input->post() as $k => $v) {
				$post_data[$k] = $this->input->post($k,true);
			}

			$this->load->model('PdfCollection');
			if($this->PdfCollection->deleteRows($post_data)) {
				$result['message'] = "Successfully deleted pdf.";
			} else {
				$result['message'] = "Failed to delete pdf.";
			}
		} 

		$result['key'] = $page;

		echo json_encode($result);
	}

	function fetchRows(){ 
		$this->load->model('PdfCollection');
        $fetch_data = $this->PdfCollection->make_datatables();  
        $data = array();  
        foreach($fetch_data as $k => $row){ 
        	$buttons = "";
        	$buttons_data = "";

            $sub_array = array();    
            $sub_array[] = $row->clients;  
            $sub_array[] = $row->first_name." ".$row->last_name;
            $sub_array[] = $row->filename;
            $sub_array[] = $row->date_added;
            
            $buttons_data .= ' data-results_id="'.$row->results_id.'" ';
            $buttons .= ' <a id="viewPdfForm" ' 
            		  . ' class="viewPdfForm" style="text-decoration: none;" '
            		  . ' href="'. base_url().'Pdf/viewPdfForm" '
            		  . $buttons_data
            		  . ' > '
            		  . ' <button class="btn btn-primary btn-round btn-fab btn-fab-mini" data-toggle="tooltip" data-placement="top" title="View PDF">'
            		  . ' <i class="material-icons">remove_red_eye</i> '
            		  . ' </button> '
            		  . ' </a> ';
            $buttons .= ' <a id="updatePdfForm" ' 
            		  . ' class="updatePdfForm" style="text-decoration: none;" '
            		  . ' href="'. base_url().'Pdf/updatePdfForm" '
            		  . $buttons_data
            		  . ' > '
            		  . ' <button class="btn btn-info btn-round btn-fab btn-fab-mini" data-toggle="tooltip" data-placement="top" title="Update PDF">'
            		  . ' <i class="material-icons">mode_edit</i> '
            		  . ' </button> '
            		  . ' </a> ';
            $buttons .= ' <a id="deletePdf" ' 
            		  . ' class="deletePdf" style="text-decoration: none;" '
            		  . ' href="'. base_url().'Pdf/deletePdf" '
            		  . $buttons_data
            		  . ' > '
            		  . ' <button class="btn btn-danger btn-round btn-fab btn-fab-mini" data-toggle="tooltip" data-placement="top" title="Delete PDF">'
            		  . ' <i class="material-icons">delete</i> '
            		  . ' </button> '
            		  . ' </a> ';
            $sub_array[] = $buttons;
            $data[] = $sub_array;  
        }  
        $output = array(  
            "draw"                  =>     intval($_POST["draw"]),  
            "recordsTotal"          =>      $this->PdfCollection->get_all_data(),  
            "recordsFiltered"     	=>     $this->PdfCollection->get_filtered_data(),  
            "data"                  =>     $data  
        );  
        echo json_encode($output);  
    }
}
