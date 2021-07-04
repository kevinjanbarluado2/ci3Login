<?php
defined('BASEPATH') or exit('No direct script access allowed');

use TCPDF as tcpdf;

class MYPDF extends TCPDF
{
    public function __construct($company)
    {
        parent::__construct();

        $this->SetCreator(PDF_CREATOR);
        $this->SetAuthor('EliteInsure Ltd');

        // set margins
        $this->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP / 2, PDF_MARGIN_RIGHT);
        $this->setPageOrientation('P', true, 10);
        $this->SetFont('CALIBRI_0', '', 11); // set the font

        $this->setHeaderMargin(PDF_MARGIN_HEADER);
        // $this->setHeaderMargin(0);
        $this->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM - 10);

        $this->SetPrintHeader(true);
        $this->SetPrintFooter(true);

        $this->setFontSubsetting(false);

        $this->setListIndentWidth(3);

        $this->company = $company['company'];
        $this->fspr_number = $company['fspr'];
        $this->trans = null;
        $this->docref = null;
        $this->hasPartner = null;
    }

    // Page header
    public function Header()
    {
        // Page Width: 209
        // $this->SetFillColor(68, 84, 106);
        // $this->Cell(18, 18, '', 0, 0, 'L');
        // $this->writeHtmlCell(21, 18, 19, 6, '<img src="/img/logo-only.png" width="55">');
        // $this->SetFont('CALIBRIB_0', 'B', 18);
        // $this->SetTextColor(68, 84, 106);
        // $this->Cell(152, 18, ($this->PageNo() > 1 ? '' : 'COMPLIANCE SUMMARY  '), 0, 0, 'R');
        $this->writeHTML('<div align="right"><img src="' . base_url() . 'img/img.png" width="70"></div>', true, false, true, false);
        // $this->SetFillColor(46, 116, 185);
        $this->setTopMargin(30);
    }

    // Page footer
    public function Footer()
    {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('CALIBRI_0', 'I', 10);
        // Page number
        $this->writeHTMLCell(0, 10, 8, 280, '<img src="' . base_url() . 'img/logo.png" height="30">');

        $this->Cell(0, 10, 'www.eliteinsure.co.nz | Page ' . $this->getAliasNumPage(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
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

    public function updatePdfForm(){
		$data = array();
		$results_id=$this->input->post('results_id');
        $this->load->model('PdfCollection');
        $result = $this->PdfCollection->get_one_data($results_id,'results_id');
        
        echo json_encode(array('message'=>'working','results_id'=>$this->input->post('results_id'),'token'=>$result->token));
        
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
            
            // $buttons_data .= ' data-results_id="'.$row->results_id.'" ';
            foreach($row as $k1=>$v1){
                if(($k1 != "answers") && ($k1 != "token"))
                    $buttons_data .= ' data-'.$k1.'="'.$v1.'" ';
            }

            $buttons .= ' <a id="viewPdfForm" ' 
            		  . ' class="viewPdfForm" data-key="view" style="text-decoration: none;" '
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
             $buttons .= ' <a id="sendEmailForm" ' 
                      . ' class="sendEmailForm" style="text-decoration: none;" '
                      . ' href="'. base_url().'Pdf/sendEmailForm" '
                      . $buttons_data
                      . ' > '
                      . ' <button class="btn btn-warning btn-round btn-fab btn-fab-mini" data-toggle="tooltip" data-placement="top" title="Email PDF">'
                      . ' <i class="material-icons">mail</i> '
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

    //accessing email form
    public function sendEmailForm() {
        $formData = array();
        $result = array();
        $result['key'] = 'sendEmail';
        $formData['key'] = $result['key'];

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

        $result['form'] = $this->load->view('forms/sendmail.php', $formData, TRUE);
        echo json_encode($result);
    }

    //accessing email form
    public function sendSummaryEmailForm() {
        $formData = array();
        $result = array();
        $result['key'] = 'sendSummaryEmail';
        $formData['key'] = $result['key'];

        $summary_id = $this->input->post('summary_id');
        $this->load->model('SummaryCollection');
        
        $res = $this->SummaryCollection->getSummaryById($summary_id);
        $result_ids = explode(',',$res->result_id);
        $date_from = $res->date_from;
        $date_until = $res->date_until;
        $replacement = '';

        $result_arr = array();

        $result_arr = $this->SummaryCollection->getResultsByIds($result_ids, $date_from, $date_until);
        
        $result_arr = json_decode(json_encode($result_arr), true);

        $providers_arr_name = array();
        foreach ($result_arr as $k => $v) {
            $providers_arr = isset($result_arr[$k]['providers']) ? explode(',', $result_arr[$k]['providers']) : [];
            $providers_arr = array_unique($providers_arr);

            foreach ($providers_arr as $k1 => $v1) {
                $providers_arr_name[$result_arr[$k]['result_id']][$k1] = $this->SummaryCollection->getProvidersNameById($providers_arr[$k1]);
            }
        }

        $policy_arr_name = [];

        foreach ($result_arr as $k => $v) {
            $policy_arr = isset($result_arr[$k]['policy_type']) ? explode(',',$result_arr[$k]['policy_type']) : array();
            $policy_arr = array_unique($policy_arr);

            foreach ($policy_arr as $k1 => $v1) {
                $policy_arr_name[$result_arr[$k]['result_id']][$k1] = $this->SummaryCollection->getPolicyNameById($policy_arr[$k1]);
            }
        }

        $adviser_str = "";
        $result_str = "";
        foreach ($result_arr as $k => $v) {
            if($adviser_str == "") {
                $adviser_str = $result_arr[$k]['adviser_id'];
                $result_str = $result_arr[$k]['result_id'];
            } else {
                $adviser_str .= ",".$result_arr[$k]['adviser_id'];
                $result_str .= ",".$result_arr[$k]['result_id'];
            }
        }
        
        ob_start();
        set_time_limit(300);
        $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $html = $this->load->view('docs/summary-template', [
            'data' => $_POST,
            'result_arr' => $result_arr,
            'added_by' => $_SESSION['name'],
            'providers_arr' => $providers_arr_name,
            'policy_arr' => $policy_arr_name,
        ], true);
        // remove default header/footer
        $pdf->setPrintHeader(true);
        $pdf->setPrintFooter(true);
        $pdf->AddPage('', '', true); // add a page
        // $pdf->writeHTMLCell(187, 300, 12, 0, $html, 0, 0, false, true, '', true);
        $pdf->writeHTML($html, true, false, true, false);
        $link = FCPATH . 'assets/resources/preview.pdf';
        $pdf->Output($link, 'F');
        ob_end_clean();

        $result['form'] = $this->load->view('forms/sendmail.php', $formData, TRUE);
        echo json_encode($result);
    }
}
