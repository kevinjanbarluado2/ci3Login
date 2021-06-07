<?php
defined('BASEPATH') or exit('No direct script access allowed');

use TCPDF as tcpdf;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

class MYPDF extends TCPDF
{
    function __construct($company)
    {
        parent::__construct();

        $this->SetCreator(PDF_CREATOR);
        $this->SetAuthor('EliteInsure Ltd');

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
    public function Footer()
    {

        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $image = base_url() . "img/logo.png";
        $this->Image($image,  8, 280, 0, 10, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

        $this->Cell(0, 10, 'www.eliteinsure.co.nz | Page' . $this->getAliasNumPage(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
        //$this->Cell(0, 10, 'www.eliteinsure.co.nz | Page'.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
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

    public function sendEmail()
    {
        $fileName = isset($_POST['fileName'])?$_POST['fileName']:"Sample Filename";
        $adviser_id = isset($_POST['adviser'])?$_POST['adviser']:"";
        $this->load->model('AdvisersCollection');
        $adviserInfo = $this->AdvisersCollection->getActiveAdvisersById($adviser_id);

        $adviserEmail =  $adviserInfo->email;
        $production = false;

        $mail = new PHPMailer(true);
        $iflocal = strpos(base_url(), "localhost");
        if ($iflocal != false) {
            $ports = 587;
        } else {
            $ports = 25;
        }
        try {
            //Server settings
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'eliteinsure.co.nz';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'filereview@eliteinsure.co.nz';                     //SMTP username
            $mail->Password   = 'compliance2021';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = $ports;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

            //Recipients
            $mail->setFrom('filereview@eliteinsure.co.nz', 'Compliance');
            if ($production) {
                $mail->addAddress('compliance@eliteinsure.co.nz', 'Recipient');
                $mail->addCC('admin@eliteinsure.co.nz', 'admin');
            }else{
                $mail->addAddress('kevin@eliteinsure.co.nz', 'Recipient');
            }
     
            if ($adviserEmail !== "") {
                $mail->addCC($adviserEmail, 'adviser');
            }
            //Attachments
        
            $mail->addAttachment('assets/resources/preview.pdf', "$fileName.pdf");         //Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Compliance Test Result';
            $mail->Body    = 'Hi, {compliance offer}, please find attached the file review report.';

            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
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
        $html = $this->load->view('docs/pdf-template', array(
            'data' => $_POST,
            'adviserInfo' => $adviserInfo,
            'added_by' => $_SESSION['name']
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

    public function savecompliance()
    {
        $result['message'] = "There was an error in the connection. Please contact the administrator for updates.";
        $result['result_id'] = '';
        $result['filename'] = '';

        if ($this->input->post() && $this->input->post() != null) {
            $post_data = array();
            foreach ($this->input->post() as $k => $v) {
                $post_data[$k] = $this->input->post($k, true);
            }

            $this->load->model('ComplianceCollection');
            if ($insert_id = $this->ComplianceCollection->savecompliance($post_data)) {
                $result['message'] = "Successfully saved.";
                $result['results_id'] = $insert_id;
                $result['filename'] = date("d M Y");
            } else {
                $result['message'] = "Failed to save details.";
            }
        }
        
        echo json_encode($result);
    }

    public function updatecompliance(){
      $result['message'] = "There was an error in the connection. Please contact the administrator for updates.";
      $result['result_id'] = $this->input->post('results_id');
      $result['filename'] = $this->input->post('filename');

      if ($this->input->post() && $this->input->post() != null) {
          $post_data = array();
          foreach ($this->input->post() as $k => $v) {
              $post_data[$k] = $this->input->post($k, true);
          }

          $this->load->model('ComplianceCollection');
          if ($insert_id = $this->ComplianceCollection->updatecompliance($post_data)) {
              $result['message'] = "Successfully updated.";
          } else {
              $result['message'] = "Failed to update details.";
          }
      }
      
      echo json_encode($result);
    }
}
