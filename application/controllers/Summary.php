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

class Summary extends CI_Controller
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

    // public function sendEmail()
    // {
    //     $fileName = isset($_POST['filename'])?$_POST['filename']:"Sample Filename";
    //     $adviser = isset($_POST['adviser'])?$_POST['adviser']:"";
    //     $this->load->model('SummaryCollection');
    //     $adviserInfo = $this->SummaryCollection->getActiveAdvisersById($adviser);
    //     $complianceOfficer = isset($_POST['complianceOfficer'])?$_POST['complianceOfficer']:"";
    //     $adviserEmail =  $adviserInfo->email;
    //     $production = false; //if in production, set to true 
    //     $includeAdviser = isset($_POST['includeAdviser'])?$_POST['includeAdviser']:false;

    //     $mail = new PHPMailer(true);
    //     $iflocal = strpos(base_url(), "localhost");
    //     if ($iflocal != false) {
    //         $ports = 587;
    //     } else {
    //         $ports = 587;
    //     }
    //     try {
    //         //Server settings
    //         //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    //         $mail->isSMTP();                                            //Send using SMTP
    //         $mail->Host       = 'eliteinsure.co.nz';                     //Set the SMTP server to send through
    //         $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    //         $mail->Username   = 'filereview@eliteinsure.co.nz';                     //SMTP username
    //         $mail->Password   = 'compliance2021';                               //SMTP password
    //         $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    //         $mail->Port       = $ports;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

    //         //Recipients
    //         $mail->setFrom('filereview@eliteinsure.co.nz', 'Compliance');
    //         if ($production) {
    //             $mail->addAddress('compliance@eliteinsure.co.nz', 'Recipient');
    //             $mail->addCC('admin@eliteinsure.co.nz', 'admin');
    //         }else{
    //             //for production purposes only
    //             $mail->addAddress('kevin@eliteinsure.co.nz', 'Recipient');
    //             $mail->addAddress('omar@eliteinsure.co.nz', 'Recipient');
    //         }
     
    //         if ($includeAdviser == "true") {
    //             $mail->addCC($adviserEmail, 'adviser');
    //         }
    //         //Attachments
        
    //         $mail->addAttachment('assets/resources/preview.pdf', "$fileName.pdf");         //Add attachments
    //         // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //         //Content
    //         $mail->isHTML(true);                                  //Set email format to HTML
    //         $mail->Subject = 'Compliance Test Result';
    //         $mail->Body    = "Hi, {$complianceOfficer}, please find attached the file review report.";

    //         $mail->send();
    //         echo json_encode(array("status" => "Message has been sent successfully", "message" => "Successfully Sent","includeAdviser"=>$includeAdviser));
    //     } catch (Exception $e) {
    //         echo json_encode(array("status" => $mail->ErrorInfo));
    //     }
    // }


    public function generate()
    {
        $adviser_ids = isset($_POST['data']['info']['adviser']) ? $_POST['data']['info']['adviser'] : '';
        $replacement = isset($_POST['data']['info']['replacement']) ? $_POST['data']['info']['replacement'] : '';
        $providers = isset($_POST['data']['info']['providers']) ? $_POST['data']['info']['providers'] : '';
        $policy_type = isset($_POST['data']['info']['policyType']) ? $_POST['data']['info']['policyType'] : '';
        $date_from = isset($_POST['data']['info']['date_from']) ? $_POST['data']['info']['date_from'] : '';
        $date_until = isset($_POST['data']['info']['date_until']) ? $_POST['data']['info']['date_until'] : '';
        $this->load->model('SummaryCollection');

        $result_arr = array();
        $provider_flag = 0;
        $policy_type_flag = 0;

        if(isset($adviser_ids) && sizeof($adviser_ids) >= 1 && $adviser_ids != '') {
            foreach ($adviser_ids as $k => $v) {
                //first filter to get result by adviser id and replacement
                $result = $this->SummaryCollection->getResultsById($adviser_ids[$k], $replacement, $date_from, $date_until);

                if($result != null) {
                    if($providers != '') {
                        $providers_new = isset($result->providers) ? explode(',',$result->providers) : array();
                        $providers_new = array_unique($providers_new);
                        //second filter to get result with a selected provider
                        foreach ($providers as $k1 => $v1) {
                            if(in_array($providers[$k1], $providers_new)) {
                                $provider_flag = 1;
                                break;
                            }     
                        }
                    } else $provider_flag = 1;

                    if($policy_type != '') {
                        $policy_type_new = isset($result->policy_type) ? explode(',',$result->policy_type) : array();
                        $policy_type_new = array_unique($policy_type_new);
                        //third filter to get result with a selected policytype
                        foreach ($policy_type as $k1 => $v1) {
                            if(in_array($policy_type[$k1], $policy_type_new)) {
                                $policy_type_flag = 1;
                                break;
                            }     
                        }

                    } else $policy_type_flag = 1;

                    if($provider_flag == 1 && $policy_type_flag == 1) {
                        $provider_flag = 0;
                        $policy_type_flag = 0;
                        array_push($result_arr, $result);
                    }   
                }
            }
        } else {
            $result = $this->SummaryCollection->getResultsById($adviser_ids, $replacement, $date_from, $date_until);

            foreach ($result as $k => $v) {
                //first filter to get result by adviser id and replacement
                if($result != null) {
                    if($providers != '') {
                        $providers_new = isset($result[$k]['providers']) ? explode(',',$result[$k]['providers']) : array();
                        $providers_new = array_unique($providers_new);
                        //second filter to get result with a selected provider
                        foreach ($providers as $k1 => $v1) {
                            if(in_array($providers[$k1], $providers_new)) {
                                $provider_flag = 1;
                                break;
                            }     
                        }
                    } else $provider_flag = 1;

                    if($policy_type != '') {
                        $policy_type_new = isset($result[$k]['policy_type']) ? explode(',',$result[$k]['policy_type']) : array();
                        $policy_type_new = array_unique($policy_type_new);
                        //third filter to get result with a selected policytype
                        foreach ($policy_type as $k1 => $v1) {
                            if(in_array($policy_type[$k1], $policy_type_new)) {
                                $policy_type_flag = 1;
                                break;
                            }     
                        }

                    } else $policy_type_flag = 1;
                    
                    if($provider_flag == 1 && $policy_type_flag == 1) {
                        $provider_flag = 0;
                        $policy_type_flag = 0;
                        array_push($result_arr, $result[$k]);
                    }  
                }
            }
        }

        $result_arr = json_decode(json_encode($result_arr), true);
        $providers_arr_name = array();
        foreach ($result_arr as $k => $v) {
            $providers_arr = isset($result_arr[$k]['providers']) ? explode(',',$result_arr[$k]['providers']) : array();
            $providers_arr = array_unique($providers_arr);
            foreach ($providers_arr as $k1 => $v1) {
                $providers_arr_name[$result_arr[$k]['adviser_id']][$k1] = $this->SummaryCollection->getProvidersNameById($providers_arr[$k1]);
            }
        }

        $policy_arr_name = array();
        foreach ($result_arr as $k => $v) {
            $policy_arr = isset($result_arr[$k]['policy_type']) ? explode(',',$result_arr[$k]['policy_type']) : array();
            $policy_arr = array_unique($policy_arr);
            foreach ($policy_arr as $k1 => $v1) {
                $policy_arr_name[$result_arr[$k]['adviser_id']][$k1] = $this->SummaryCollection->getPolicyNameById($policy_arr[$k1]);
            }
        }

        $adviser_str = "";
        foreach ($result_arr as $k => $v) {
            if($adviser_str == "")
                $adviser_str = $result_arr[$k]['adviser_id'];
            else 
                $adviser_str .= ",".$result_arr[$k]['adviser_id'];
        }

        ob_start();
        set_time_limit(300);
        $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $html = $this->load->view('docs/summary-template', array(
            'data' => $_POST,
            'result_arr' => $result_arr,
            'added_by' => $_SESSION['name'],
            'providers_arr' => $providers_arr_name,
            'policy_arr' => $policy_arr_name
        ), true);
        // remove default header/footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(true);
        $pdf->AddPage(); // add a page
        $pdf->writeHTMLCell(187, 300, 12, 5, $html, 0, 0, false, true, '', true);
        $link = FCPATH . "assets/resources/preview.pdf";
        $pdf->Output($link, 'F');
        ob_end_clean();
        echo json_encode(array(
            "link" => base_url('assets/resources/preview.pdf'),
            "adviser_str" => $adviser_str
        ));
    }

    public function savesummary()
    {
        
        $result['message'] = "There was an error in the connection. Please contact the administrator for updates.";
        $result['summary_id'] = '';
        $result['filename'] = '';
        $result['adviser_str'] = $this->input->post('adviser_str');

        if ($this->input->post() && $this->input->post() != null) {
            $post_data = array();
            foreach ($this->input->post() as $k => $v) {
                $post_data[$k] = $this->input->post($k, true);
            }

            $adviser_ids = $this->input->post('adviser_str');
            $date_from = isset($_POST['data']['info']['date_from']) ? $_POST['data']['info']['date_from'] : '';
            $date_until = isset($_POST['data']['info']['date_until']) ? $_POST['data']['info']['date_until'] : '';

            $this->load->model('SummaryCollection');
            $this->load->model('AdvisersCollection');

            $filename = "Summary of Multiple Adviser ".date("d/m/Y");
            if($adviser_ids != '') {
                $adviser_arr = explode(',',$adviser_ids);

                if(sizeof($adviser_arr) == 1) {
                    $adviserInfo = $this->AdvisersCollection->getActiveAdvisersById($adviser_id);
                    $adviserName = $adviserInfo->first_name." ".$adviserInfo->last_name;
                    $filename = "Summary of ".$adviserName." ".date("d/m/Y");
                }
            }            

            $post_data['data']['info']['adviser'] = $adviser_ids;
            $post_data['data']['info']['filename'] = $filename;
            $this->load->model('SummaryCollection');
            if ($insert_id = $this->SummaryCollection->savesummary($post_data)) {
                $result['message'] = "Successfully saved.";
                $result['summary_id'] = $insert_id;
                $result['filename'] = $filename;
            } else {
                $result['message'] = "Failed to save details.";
            }
        }
        
        echo json_encode($result);
    }

    public function updatesummary(){
        $result['message'] = "There was an error in the connection. Please contact the administrator for updates.";
        $result['summary_id'] = $this->input->post('summary_id');
        $result['filename'] = $this->input->post('filename');
        $result['adviser_str'] = $this->input->post('adviser_str');

        if ($this->input->post() && $this->input->post() != null) {
            $post_data = array();
            foreach ($this->input->post() as $k => $v) {
                $post_data[$k] = $this->input->post($k, true);
            }
          
            $adviser_ids = $this->input->post('adviser_str');
            $date_from = isset($_POST['data']['info']['date_from']) ? $_POST['data']['info']['date_from'] : '';
            $date_until = isset($_POST['data']['info']['date_until']) ? $_POST['data']['info']['date_until'] : '';
            

            $this->load->model('SummaryCollection');
            $this->load->model('AdvisersCollection');
            $filename = "Summary of Multiple Adviser ".date("d/m/Y");
            if($adviser_ids != '') {
                $adviser_arr = explode(',',$adviser_ids);

                if(sizeof($adviser_arr) == 1) {
                    $adviserInfo = $this->AdvisersCollection->getActiveAdvisersById($adviser_id);
                    $adviserName = $adviserInfo->first_name." ".$adviserInfo->last_name;
                    $filename = "Summary of ".$adviserName." ".date("d/m/Y");
                }
            }        
            
            $post_data['data']['info']['adviser'] = $adviser_ids;
            $post_data['data']['info']['filename'] = $filename;
            $this->load->model('SummaryCollection');
            if ($insert_id = $this->SummaryCollection->updatesummary($post_data)) {
               $result['message'] = "Successfully updated.";
            } else {
                $result['message'] = "Failed to update details.";
            }
        }
      
      echo json_encode($result);
    }
}
