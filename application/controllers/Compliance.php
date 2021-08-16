<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
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
        $this->setPageOrientation('P', true, 10);
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

class Compliance extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        date_default_timezone_set('Pacific/Auckland');
        error_reporting(0);
        $dotenv = Dotenv::createImmutable(FCPATH);
        $dotenv->load();
    }

    public function index()
    {
        var_export('TEST');

        die();
    }

    public function sendEmail()
    {
        $fileName = $_POST['filename'] ?? 'Sample Filename';
        $adviser = $_POST['adviser'] ?? '';
        $this->load->model('AdvisersCollection');
        $adviserInfo = $this->AdvisersCollection->getActiveAdvisersById($adviser);
        $adviserName = $adviserInfo->first_name." ".$adviserInfo->last_name;

        $complianceOfficer = $_POST['complianceOfficer'] ?? '';
        $adviserEmail = $adviserInfo->email;
        $production = false; //if in production, set to true
        $includeAdviser = $_POST['includeAdviser'] ?? false;

        $results_token = $_POST['results_token'] ?? '';

        $mail = new PHPMailer(true);

        try {
            $this->load->library('mailsetter');

            $mail = $this->mailsetter->set($mail);
            $advisermail = $this->mailsetter->set($mail);

            //Recipients
            $mail->setFrom('filereview@onlineinsure.co.nz', 'Compliance');

            if ($production) {
                $mail->addAddress('compliance@eliteinsure.co.nz', 'Recipient');
                $mail->addCC('admin@eliteinsure.co.nz', 'admin');
                
                if ('true' == $includeAdviser) {
                    $advisermail->addAddress($adviserEmail, 'adviser');
                     //Content
                    $advisermail->isHTML(true);                                  
                    //Set email format to HTML
                    $advisermail->Subject = 'Compliance Test Result';
                    $advisermail->Body = "Hello Adviser $adviserName,<br><br>   
                    After you review the attached compliance result and you have your questions / feedback, kindly click the link below to communicate with the Compliance Officer.
                    <br><br>
                    <a href=\"".base_url()."Compliance/replyEmail?v=".$results_token."&adviser=".$adviser."\" onclick=\"window.open(this.href,'newwindow','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=400,height=600'); return false;\">Click here to reply</a>
                    ";

                    $advisermail->send();
                }
            } else {
                //for production purposes only
                $mail->addAddress('kevin@eliteinsure.co.nz', 'Recipient');
                $mail->addAddress('omar@eliteinsure.co.nz', 'Recipient');

                //will add this to previous "if" condition when done.
                if ('true' == $includeAdviser) {
                    $advisermail->addAddress($adviserEmail, 'adviser');
                     //Content
                    $advisermail->isHTML(true);                                  
                    //Set email format to HTML
                    $advisermail->Subject = 'Compliance Test Result';
                    $advisermail->Body = "Hello Adviser $adviserName,<br><br>   
                    After you review the attached compliance result and you have your questions / feedback, kindly click the link below to communicate with the Compliance Officer.
                    <br><br>
                    <a href=\"".base_url()."Compliance/replyEmail?v=".$results_token."&adviser=".$adviser."\" onclick=\"window.open(this.href,'newwindow','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=400,height=600'); return false;\">Click here to reply</a>
                    ";

                    $advisermail->send();
                }
            }
            //Attachments

            $mail->addAttachment('assets/resources/preview.pdf', "$fileName.pdf");         //Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Compliance Test Result';
            $mail->Body = "Hi, {$complianceOfficer}, please find attached the file review report.";

            $mail->send();
            echo json_encode(['status' => 'Message has been sent successfully', 'message' => 'Successfully Sent', 'includeAdviser' => $includeAdviser]);
        } catch (Exception $e) {
            echo json_encode(['status' => $mail->ErrorInfo]);
        }
    }

    public function generate()
    {
        $adviser_id = $_POST['data']['info']['adviser'];

        $this->load->model('AdvisersCollection');
        $adviserInfo = $this->AdvisersCollection->getActiveAdvisersById($adviser_id);

        $this->load->model('ComplianceCollection');
        $chat = $this->ComplianceCollection->get_chat($_POST['results_token']);

        ob_start();
        set_time_limit(300);
        $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $html = $this->load->view('docs/pdf-template', [
            'data' => $_POST,
            'adviserInfo' => $adviserInfo,
            'added_by' => $_SESSION['name'],
            'chat' => $chat
        ], true);
        // remove default header/footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(true);
        $pdf->AddPage(); // add a page
        $pdf->writeHTMLCell(187, 300, 12, 5, $html, 0, 0, false, true, '', true);
        $link = FCPATH . 'assets/resources/preview.pdf';
        $pdf->Output($link, 'F');
        ob_end_clean();
        echo json_encode(['link' => base_url('assets/resources/preview.pdf')]);
    }

    public function savecompliance()
    {
        $result['message'] = 'There was an error in the connection. Please contact the administrator for updates.';
        $result['result_id'] = '';
        $result['filename'] = '';
        $result['token'] = '';

        if ($this->input->post() && null != $this->input->post()) {
            $post_data = [];

            foreach ($this->input->post() as $k => $v) {
                $post_data[$k] = $this->input->post($k, true);
            }

            $client = $post_data['data']['info']['client'];
            $adviser_id = $post_data['data']['info']['adviser'];

            $this->load->model('AdvisersCollection');
            $adviserInfo = $this->AdvisersCollection->getActiveAdvisersById($adviser_id);
            $adviserName = $adviserInfo->first_name . ' ' . $adviserInfo->last_name;
            $filename = 'File review - ' . $client . ' by ' . $adviserName;
            $token = md5(uniqid(rand(), true));

            $post_data['data']['info']['filename'] = $filename;
            $post_data['data']['info']['token'] = $token;

            $this->load->model('ComplianceCollection');

            if ($insert_id = $this->ComplianceCollection->savecompliance($post_data)) {
                $result['message'] = 'Successfully saved.';
                $result['results_id'] = $insert_id;
                $result['filename'] = $filename;
                $result['token'] = $token;
            } else {
                $result['message'] = 'Failed to save details.';
            }
        }

        echo json_encode($result);
    }

    public function updatecompliance()
    {
        $result['message'] = 'There was an error in the connection. Please contact the administrator for updates.';
        $result['results_id'] = $this->input->post('results_id');
        $result['filename'] = $this->input->post('filename');
        $result['token'] = $this->input->post('token');

        if ($this->input->post() && null != $this->input->post()) {
            $post_data = [];

            foreach ($this->input->post() as $k => $v) {
                $post_data[$k] = $this->input->post($k, true);
            }

            $client = $post_data['data']['info']['client'];
            $adviser_id = $post_data['data']['info']['adviser'];

            $this->load->model('AdvisersCollection');
            $adviserInfo = $this->AdvisersCollection->getActiveAdvisersById($adviser_id);
            $adviserName = $adviserInfo->first_name . ' ' . $adviserInfo->last_name;
            $filename = 'File review - ' . $client . ' by ' . $adviserName;

            $post_data['data']['info']['filename'] = $filename;
            $this->load->model('ComplianceCollection');

            if ($insert_id = $this->ComplianceCollection->updatecompliance($post_data)) {
                $result['message'] = 'Successfully updated.';
            } else {
                $result['message'] = 'Failed to update details.';
            }
        }

        echo json_encode($result);
    }

    function fetchRows()
    {
        $this->load->model('ComplianceCollection');
        $adviserId = isset($_POST['adviserId']) ? $_POST['adviserId'] : null;
        $fetch_data = $this->ComplianceCollection->make_datatables($adviserId);
        $data = array();

        foreach ($fetch_data as $k => $row) {
            $buttons = "";
            $buttons_data = "";
            
            $myJSON = json_decode($row->soa_data);
            $clientName = $myJSON->clientFirstname.' '.$myJSON->clientSurname;
            $sub_array = array();
            $sub_array[] = $clientName;
            $sub_array[] = $row->title;
            $replacementOfCover = ucfirst($myJSON->first->disclosure->replacementOfCover);
            $provider = $row->provider;
            $policyType = implode(",",$myJSON->first->lookid);
            $sub_array[] = date("d M Y", $row->timestamp);


            //  foreach($row as $k1=>$v1){
            //  	$buttons_data .= ' data-'.$k1.'="'.$v1.'" ';
            //  }

            $buttons .= ' <a id="viewAdvisersForm" target="_blank"'
                . ' class="viewAdvisersForm" style="text-decoration: none;" '
                . ' href="' . urldecode($row->actual_link)
                . ' "> '
                . ' <button class="btn btn-primary btn-round btn-fab btn-fab-mini" data-toggle="tooltip" data-placement="top" title="View Plan">'
                . ' <i class="material-icons">remove_red_eye</i> '
                . ' </button> '
                . ' </a> ';
            $buttons .= '<button id="fetchPlan" data-policyType="'.$policyType.'" data-provider="'.$provider.'" data-clientName="'.$clientName.'" data-replacementOfCover="'.$replacementOfCover.'" class="btn btn-warning btn-round btn-fab btn-fab-mini" data-toggle="tooltip" data-placement="top" title="Import Plan">'
                . ' <i class="material-icons">done_all</i> '
                . ' </button> ';
    
            $sub_array[] = $buttons;
            $data[] = $sub_array;
        }
        $output = array(
            "draw"                  =>     intval($_POST["draw"]),
            "recordsTotal"          =>      $this->ComplianceCollection->get_all_data($adviserId),
            "recordsFiltered"         =>     $this->ComplianceCollection->get_filtered_data($adviserId),
            "data"                  =>     $data
        );
        echo json_encode($output);
    }

    public function savechat()
    {
        $result['token'] = '';
        $result['message'] = 'There was an error in the connection. Please contact the administrator for updates.';
        if ($this->input->post() && null != $this->input->post()) {
            $post_data = [];

            foreach ($this->input->post() as $k => $v) {
                $post_data[$k] = $this->input->post($k, true);
            }

            $this->load->model('ComplianceCollection');

            if ($insert_id = $this->ComplianceCollection->savechat($post_data)) {
                $result['message'] = 'Successfully saved.';
                $result['token'] = $post_data['results_token'];
            } else {
                $result['message'] = 'Failed to save details.';
            }
        }

        echo json_encode($result);
    }

    //accessing chat/notes
    public function get_chat() {
        $this->load->model('ComplianceCollection');
        $result['data'] = $this->ComplianceCollection->get_chat($_POST['results_token']);

        echo json_encode($result);
    }

    //load replyEmail gui
    public function replyEmail() {
        $data['adviser'] = isset($_GET['adviser']) && $_GET['adviser'] != '' ? $_GET['adviser'] : '';
        $data['token'] = isset($_GET['v']) && $_GET['v'] != '' ? $_GET['v'] : '';
        $data['page'] = "redirect-page";
        $view = $this->load->view('pages/replyEmail',$data,true);
        echo $view;
    }

    //load chatbox
    public function loadChatBox() {
        $token = isset($_GET['v']) && $_GET['v'] != '' ? $_GET['v'] : '';
        $adviser = isset($_GET['adviser']) && $_GET['adviser'] != '' ? $_GET['adviser'] : '';

        $this->load->model('ComplianceCollection');
        $data['chat'] = $this->ComplianceCollection->get_chat($token);

        $this->load->model('AdvisersCollection');
        $data['adviser'] = $this->AdvisersCollection->getActiveAdvisersById($adviser);
        
        $data['token'] = isset($_GET['v']) && $_GET['v'] != '' ? $_GET['v'] : '';
        $data['page'] = "actual-page";
        $view = $this->load->view('pages/replyEmail',$data,true);
        echo $view;
    }

    //accessing chat/notes
    public function fetchNotification() {
        $this->load->model('ComplianceCollection');
        $result['data'] = $this->ComplianceCollection->fetchNotification($_POST['session_id']);

        echo json_encode($result);
    }

    //accessing chat/notes
    public function updateNotification() {
        $this->load->model('ComplianceCollection');
        $result['data'] = $this->ComplianceCollection->updateNotification($_POST['token']);
    }
}
