<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
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
        $complianceOfficer = $_POST['complianceOfficer'] ?? '';
        $adviserEmail = $adviserInfo->email;
        $production = false; //if in production, set to true
        $includeAdviser = $_POST['includeAdviser'] ?? false;

        $mail = new PHPMailer(true);

        try {
            $this->load->library('mailsetter');

            $mail = $this->mailsetter->set($mail);

            //Recipients
            $mail->setFrom('filereview@onlineinsure.co.nz', 'Compliance');

            if ($production) {
                $mail->addAddress('compliance@eliteinsure.co.nz', 'Recipient');
                $mail->addCC('admin@eliteinsure.co.nz', 'admin');
            } else {
                //for production purposes only
                $mail->addAddress('kevin@eliteinsure.co.nz', 'Recipient');
                $mail->addAddress('omar@eliteinsure.co.nz', 'Recipient');
            }

            if ('true' == $includeAdviser) {
                $mail->addCC($adviserEmail, 'adviser');
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

        ob_start();
        set_time_limit(300);
        $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $html = $this->load->view('docs/pdf-template', [
            'data' => $_POST,
            'adviserInfo' => $adviserInfo,
            'added_by' => $_SESSION['name'],
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

            if ($insert_id = $this->ComplianceCollection->savecompliance($post_data)) {
                $result['message'] = 'Successfully saved.';
                $result['results_id'] = $insert_id;
                $result['filename'] = $filename;
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
}
