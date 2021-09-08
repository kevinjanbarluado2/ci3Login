<?php
defined('BASEPATH') or exit('No direct script access allowed');

use TCPDF as tcpdf;
use Dotenv\Dotenv;

class MYPDF extends TCPDF
{
    public function __construct($company)
    {
        parent::__construct();

        $this->SetCreator(PDF_CREATOR);
        $this->SetAuthor('EliteInsure Ltd');

        // set margins
        $this->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP / 2, PDF_MARGIN_RIGHT);
        $this->setPageOrientation('L', true, 10);
        $this->SetFont('dejavusans', '', 8); // set the font

        $this->setHeaderMargin(PDF_MARGIN_HEADER);
        $this->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM - 10);

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
    public function Footer()
    {

        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $image = base_url() . 'img/logo.png';
        $this->Image($image, 8, 280, 0, 10, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

        $this->Cell(0, 10, 'www.eliteinsure.co.nz | Page' . $this->getAliasNumPage(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
        //$this->Cell(0, 10, 'www.eliteinsure.co.nz | Page'.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
    }
}

class AdviserNotes extends CI_Controller {
	public function index() {
		var_export("TEST");die();
	}

	//view pdf
	public function viewPdfForm()
    {
        $results_id = $this->input->post('results_id');
        $results_token = $this->input->post('results_token');
        $this->load->model('ComplianceCollection');
        
        $res = $this->ComplianceCollection->getComplianceResultsById($results_id);
        $data['data'] = json_decode($res->answers, true);

        $this->load->model('AdvisersCollection');
        $adviserInfo = $this->AdvisersCollection->getActiveAdvisersById($res->adviser_id);

        $this->load->model('ComplianceCollection');
        $chat = $this->ComplianceCollection->get_chat($results_token);

        ob_start();
        set_time_limit(300);
        $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $html = $this->load->view('docs/pdf-template', [
            'data' => $data,
            'adviserInfo' => $adviserInfo,
            'added_by'=>$_SESSION['name'],
            'chat' => $chat
        ], true);
        // remove default header/footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(true);
        $pdf->AddPage(); // add a page
        // $pdf->writeHTMLCell(187, 300, 12, 5, $html, 0, 0, false, true, '', true);
        $pdf->writeHTML($html, true, false, true, false, '');
        $link = FCPATH . "assets/resources/preview.pdf";
        $pdf->Output($link, 'F');
        ob_end_clean();
        echo json_encode(["link" => base_url('assets/resources/preview.pdf')]);
    }

	function fetchRows(){ 
		$this->load->model('AdviserNotesCollection');
        $fetch_data = $this->AdviserNotesCollection->make_datatables();  
        $data = array();  
        foreach($fetch_data as $k => $row){ 
        	$buttons = "";
        	$buttons_data = "";

            $answers = json_decode($row->answers, true);
            $total_score = 0;
            $total_question = 0;
            $max_score = 0;

            for ($i = 1; $i <= 6; $i++) :
                foreach ($answers['step' . $i] as $ind => $x) :
                    $total_score += (($x['value']) == '') ? 0 : $x['value'];
                endforeach;
                $total_question += sizeof($answers['step' . $i]);
            endfor;

            $max_score = $total_question * 2;
            $score_percentage = ($total_score / $max_score) * 100;
            $score_disp = $row->score."/".$max_score." (".number_format($score_percentage, 2)."%)";

            $sub_array = array();    
            $sub_array[] = $row->clients;  
            $sub_array[] = $row->compliance_officer_name;
            $sub_array[] = $row->filename;
            $sub_array[] = $score_disp;
            $sub_array[] = $row->date_added;
            
            // $buttons_data .= ' data-results_id="'.$row->results_id.'" ';
            foreach($row as $k1=>$v1){
                if($k1 != "answers")
                    $buttons_data .= ' data-'.$k1.'="'.$v1.'" ';
            }

            $buttons .= ' <a id="viewPdfForm" ' 
            		  . ' class="viewPdfForm" data-key="view" style="text-decoration: none;" '
            		  . ' href="'. base_url().'AdviserNotes/viewPdfForm" '
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
            $sub_array[] = $buttons;
            $data[] = $sub_array;  
        }  
        $output = array(  
            "draw"                  =>     intval($_POST["draw"]),  
            "recordsTotal"          =>      $this->AdviserNotesCollection->get_all_data(),  
            "recordsFiltered"     	=>     $this->AdviserNotesCollection->get_filtered_data(),  
            "data"                  =>     $data  
        );  
        echo json_encode($output);  
    }
}
