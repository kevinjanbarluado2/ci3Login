<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
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
        $this->setPageOrientation('L', true, 10);
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
        $this->writeHTML('<div align="right"><img src="' . str_replace('\\', '', base_url()) . 'img/img.png" width="70"></div>', true, false, true, false);
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
        $this->writeHTMLCell(0, 10, 8, 280, '<img src="' . str_replace('\\', '', base_url()) . 'img/logo.png" height="30">');

        $this->Cell(0, 10, 'www.eliteinsure.co.nz | Page ' . $this->getAliasNumPage(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
    }
}

class Summary extends CI_Controller
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
        $complianceOfficer = $_POST['complianceOfficer'] ?? '';
        $production = false; //if in production, set to true

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

            //Attachments
            $mail->addAttachment('assets/resources/preview.pdf', "$fileName.pdf");         //Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Summary Test Result';
            $mail->Body = "Hi, {$complianceOfficer}, please find attached the file review report.";

            $mail->send();
            echo json_encode(['status' => 'Message has been sent successfully', 'message' => 'Successfully Sent']);
        } catch (Exception $e) {
            echo json_encode(['status' => $mail->ErrorInfo]);
        }
    }

    //view pdf

    public function viewSummaryForm()
    {
        $summary_id = $this->input->post('summary_id');
        $this->load->model('SummaryCollection');

        $res = $this->SummaryCollection->getSummaryById($summary_id);
        $result_ids = explode(',', $res->result_id);
        $date_from = $res->date_from;
        $date_until = $res->date_until;
        $replacement = '';

        $result_arr = [];

        $result_arr = $this->SummaryCollection->getResultsByIds($result_ids, $date_from, $date_until);

        $result_arr = json_decode(json_encode($result_arr), true);

        $providers_arr_name = [];

        foreach ($result_arr as $k => $v) {
            $providers_arr = isset($result_arr[$k]['providers']) ? explode(',', $result_arr[$k]['providers']) : [];
            $providers_arr = array_unique($providers_arr);

            foreach ($providers_arr as $k1 => $v1) {
                $providers_arr_name[$result_arr[$k]['result_id']][$k1] = $this->SummaryCollection->getProvidersNameById($providers_arr[$k1]);
            }
        }

        $policy_arr_name = [];

        foreach ($result_arr as $k => $v) {
            $policy_arr = isset($result_arr[$k]['policy_type']) ? explode(',', $result_arr[$k]['policy_type']) : [];
            $policy_arr = array_unique($policy_arr);

            foreach ($policy_arr as $k1 => $v1) {
                $policy_arr_name[$result_arr[$k]['result_id']][$k1] = $this->SummaryCollection->getPolicyNameById($policy_arr[$k1]);
            }
        }

        $adviser_str = '';
        $result_str = '';

        foreach ($result_arr as $k => $v) {
            if ('' == $adviser_str) {
                $adviser_str = $result_arr[$k]['adviser_id'];
                $result_str = $result_arr[$k]['result_id'];
            } else {
                $adviser_str .= ',' . $result_arr[$k]['adviser_id'];
                $result_str .= ',' . $result_arr[$k]['result_id'];
            }
        }

        //////////////////////////////////////////////////////
        // $this->load->model('AdvisersCollection');
        // $adviserInfo = $this->AdvisersCollection->getActiveAdvisersById($res->adviser_id);

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
        echo json_encode(['link' => base_url('assets/resources/preview.pdf')]);
    }

    public function generate()
    {
        // $adviser_ids = $_POST['data']['info']['adviser'] ?? '';
        // $replacement = $_POST['data']['info']['replacement'] ?? '';
        // $providers = $_POST['data']['info']['providers'] ?? '';
        // $policy_type = $_POST['data']['info']['policyType'] ?? '';
        // $date_from = $_POST['data']['info']['date_from'] ?? '';
        // $date_until = $_POST['data']['info']['date_until'] ?? '';
        // $this->load->model('SummaryCollection');

        // $result_arr = [];
        // $provider_flag = 0;
        // $policy_type_flag = 0;

        // if (isset($adviser_ids) && sizeof($adviser_ids) >= 1 && '' != $adviser_ids) {
        //     foreach ($adviser_ids as $k => $v) {
        //         //first filter to get result by adviser id and replacement
        //         $result = $this->SummaryCollection->getResultsById($adviser_ids[$k], $replacement, $date_from, $date_until);

        //         foreach ($result as $k => $v) {
        //             //first filter to get result by adviser id and replacement
        //             if (null != $result) {
        //                 if ('' != $providers) {
        //                     $providers_new = isset($result[$k]['providers']) ? explode(',', $result[$k]['providers']) : [];
        //                     $providers_new = array_unique($providers_new);
        //                     //second filter to get result with a selected provider
        //                     foreach ($providers as $k1 => $v1) {
        //                         if (in_array($providers[$k1], $providers_new)) {
        //                             $provider_flag = 1;

        //                             break;
        //                         }
        //                     }
        //                 } else {
        //                     $provider_flag = 1;
        //                 }

        //                 if ('' != $policy_type) {
        //                     $policy_type_new = isset($result[$k]['policy_type']) ? explode(',', $result[$k]['policy_type']) : [];
        //                     $policy_type_new = array_unique($policy_type_new);
        //                     //third filter to get result with a selected policytype
        //                     foreach ($policy_type as $k1 => $v1) {
        //                         if (in_array($policy_type[$k1], $policy_type_new)) {
        //                             $policy_type_flag = 1;

        //                             break;
        //                         }
        //                     }
        //                 } else {
        //                     $policy_type_flag = 1;
        //                 }

        //                 if (1 == $provider_flag && 1 == $policy_type_flag) {
        //                     $provider_flag = 0;
        //                     $policy_type_flag = 0;
        //                     array_push($result_arr, $result[$k]);
        //                 }
        //             }
        //         }
        //     }
        // } else {
        //     $result = $this->SummaryCollection->getResultsById($adviser_ids, $replacement, $date_from, $date_until);

        //     foreach ($result as $k => $v) {
        //         //first filter to get result by adviser id and replacement
        //         if (null != $result) {
        //             if ('' != $providers) {
        //                 $providers_new = isset($result[$k]['providers']) ? explode(',', $result[$k]['providers']) : [];
        //                 $providers_new = array_unique($providers_new);
        //                 //second filter to get result with a selected provider
        //                 foreach ($providers as $k1 => $v1) {
        //                     if (in_array($providers[$k1], $providers_new)) {
        //                         $provider_flag = 1;

        //                         break;
        //                     }
        //                 }
        //             } else {
        //                 $provider_flag = 1;
        //             }

        //             if ('' != $policy_type) {
        //                 $policy_type_new = isset($result[$k]['policy_type']) ? explode(',', $result[$k]['policy_type']) : [];
        //                 $policy_type_new = array_unique($policy_type_new);
        //                 //third filter to get result with a selected policytype
        //                 foreach ($policy_type as $k1 => $v1) {
        //                     if (in_array($policy_type[$k1], $policy_type_new)) {
        //                         $policy_type_flag = 1;

        //                         break;
        //                     }
        //                 }
        //             } else {
        //                 $policy_type_flag = 1;
        //             }

        //             if (1 == $provider_flag && 1 == $policy_type_flag) {
        //                 $provider_flag = 0;
        //                 $policy_type_flag = 0;
        //                 array_push($result_arr, $result[$k]);
        //             }
        //         }
        //     }
        // }

        // $result_arr = json_decode(json_encode($result_arr), true);
        // $providers_arr_name = [];

        // foreach ($result_arr as $k => $v) {
        //     $providers_arr = isset($result_arr[$k]['providers']) ? explode(',', $result_arr[$k]['providers']) : [];
        //     $providers_arr = array_unique($providers_arr);

        //     foreach ($providers_arr as $k1 => $v1) {
        //         $providers_arr_name[$result_arr[$k]['result_id']][$k1] = $this->SummaryCollection->getProvidersNameById($providers_arr[$k1]);
        //     }
        // }

        // $policy_arr_name = [];

        // foreach ($result_arr as $k => $v) {
        //     $policy_arr = isset($result_arr[$k]['policy_type']) ? explode(',', $result_arr[$k]['policy_type']) : [];
        //     $policy_arr = array_unique($policy_arr);

        //     foreach ($policy_arr as $k1 => $v1) {
        //         $policy_arr_name[$result_arr[$k]['result_id']][$k1] = $this->SummaryCollection->getPolicyNameById($policy_arr[$k1]);
        //     }
        // }

        // $adviser_str = '';
        // $result_str = '';

        // foreach ($result_arr as $k => $v) {
        //     if ('' == $adviser_str) {
        //         $adviser_str = $result_arr[$k]['adviser_id'];
        //         $result_str = $result_arr[$k]['result_id'];
        //     } else {
        //         $adviser_str .= ',' . $result_arr[$k]['adviser_id'];
        //         $result_str .= ',' . $result_arr[$k]['result_id'];
        //     }
        // }

        $this->load->model('SummaryCollection');
        $fetch_data = $this->SummaryCollection->getFilteredSummary();
        $data = [];

        foreach ($fetch_data as $k => $row) {
            $buttons = '';
            $buttons_data = '';

            $sub_array = [];

            //policy type start
            $policy_type_arr = explode(',', $row->policy_type);
            $policy_type_list = '';

            if (sizeof($policy_type_arr) >= 1) {
                $policy_type_arr = array_unique($policy_type_arr);
                $policy_type_arr_new = array_values($policy_type_arr);

                foreach ($policy_type_arr_new as $k1 => $v1) {
                    $policy_type_name = $this->SummaryCollection->getPolicyNameById($policy_type_arr_new[$k1]);
                    if($policy_type_name != '') {
                        if ('' == $policy_type_list) {
                            $policy_type_list .= $policy_type_name;
                        } else {
                            $policy_type_list .= ',' . $policy_type_name;
                        }
                    }  
                }
            }
            //policy type end

            //provider start
            $providers_arr = explode(',', $row->providers);
            $providers_list = '';

            if (sizeof($providers_arr) >= 1) {
                $providers_arr = array_unique($providers_arr);
                $providers_arr_new = array_values($providers_arr);

                foreach ($providers_arr_new as $k1 => $v1) {
                    $providers_name = $this->SummaryCollection->getProvidersNameById($providers_arr_new[$k1]);
                    if($providers_name != '') {
                        if ('' == $providers_list) {
                            $providers_list .= $providers_name;
                        } else {
                            $providers_list .= ',' . $providers_name;
                        }
                    } 
                }
            }
            //provider end

            $answers = isset($row->answers) ? json_decode($row->answers, true) : [];

            //step 1 computation start
            $step1_score = 0;
            $step1_total_questions = sizeof($answers['step1']);
            foreach ($answers['step1'] as $key => $value) {
                $step1_score += $answers['step1'][$key]['value'];
            }
            $step1_max_score = $step1_total_questions * 2;
            $step1_score_percentage = ($step1_score / $step1_max_score) * 100;
            $step1_score_percentage = round((float)$step1_score_percentage, 2, PHP_ROUND_HALF_UP);
            $step1_score_disp = $step1_score."/".$step1_max_score." (".$step1_score_percentage."%)";
            //step 1 computation end

            //step 2 computation start
            $step2_score = 0;
            $step2_total_questions = sizeof($answers['step2']);
            foreach ($answers['step2'] as $key => $value) {
                $step2_score += $answers['step2'][$key]['value'];
            }
            $step2_max_score = $step2_total_questions * 2;
            $step2_score_percentage = ($step2_score / $step2_max_score) * 100;
            $step2_score_percentage = round((float)$step2_score_percentage, 2, PHP_ROUND_HALF_UP);
            $step2_score_disp = $step2_score."/".$step2_max_score." (".$step2_score_percentage."%)";
            //step 2 computation end

            //step 3 computation start
            $step3_score = 0;
            $step3_total_questions = sizeof($answers['step3']);
            foreach ($answers['step3'] as $key => $value) {
                $step3_score += $answers['step3'][$key]['value'];
            }
            $step3_max_score = $step3_total_questions * 2;
            $step3_score_percentage = ($step3_score / $step3_max_score) * 100;
            $step3_score_percentage = round((float)$step3_score_percentage, 2, PHP_ROUND_HALF_UP);
            $step3_score_disp = $step3_score."/".$step3_max_score." (".$step3_score_percentage."%)";
            //step 3 computation end

            //step 4 computation start
            $step4_score = 0;
            $step4_total_questions = sizeof($answers['step4']);
            foreach ($answers['step4'] as $key => $value) {
                $step4_score += $answers['step4'][$key]['value'];
            }
            $step4_max_score = $step4_total_questions * 2;
            $step4_score_percentage = ($step4_score / $step4_max_score) * 100;
            $step4_score_percentage = round((float)$step4_score_percentage, 2, PHP_ROUND_HALF_UP);
            $step4_score_disp = $step4_score."/".$step4_max_score." (".$step4_score_percentage."%)";
            //step 4 computation end

            //step 5 computation start
            $step5_score = 0;
            $step5_total_questions = sizeof($answers['step5']);
            foreach ($answers['step5'] as $key => $value) {
                $step5_score += $answers['step5'][$key]['value'];
            }
            $step5_max_score = $step5_total_questions * 2;
            $step5_score_percentage = ($step5_score / $step5_max_score) * 100;
            $step5_score_percentage = round((float)$step5_score_percentage, 2, PHP_ROUND_HALF_UP);
            $step5_score_disp = $step5_score."/".$step5_max_score." (".$step5_score_percentage."%)";
            //step 5 computation end

            //step 6 computation start
            $step6_score = 0;
            $step6_total_questions = sizeof($answers['step6']);
            foreach ($answers['step6'] as $key => $value) {
                $step6_score += $answers['step6'][$key]['value'];
            }
            $step6_max_score = $step6_total_questions * 6;
            $step6_score_percentage = ($step6_score / $step6_max_score) * 100;
            $step6_score_percentage = round((float)$step6_score_percentage, 2, PHP_ROUND_HALF_UP);
            $step6_score_disp = $step6_score."/".$step6_max_score." (".$step6_score_percentage."%)";
            //step 6 computation end

            //total score computation start
            for ($i = 1; $i <= 6; $i++) {
                $total_question += sizeof($answers['step' . $i]);
            }

            $max_score = $total_question * 2;
            $score_percentage = ($row->score / $max_score) * 100;
            $score_percentage = round((float)$score_percentage, 2, PHP_ROUND_HALF_UP);
            $total_question = 0;

            $total_score_disp = $row->score."/".$max_score." (".$score_percentage."%)";
            //total score computation end
            
            $sub_array['clients'] = $row->clients;
            $sub_array['step1'] = $step1_score_disp;
            $sub_array['step2'] = $step2_score_disp;
            $sub_array['step3'] = $step3_score_disp;
            $sub_array['step4'] = $step4_score_disp;
            $sub_array['step5'] = $step5_score_disp;
            $sub_array['step6'] = $step6_score_disp;
            $sub_array['total_score'] = $total_score_disp;
            $sub_array['replacement'] = ($row->replacement == '') ? 'N/A' : $row->replacement;
            $sub_array['policy_type'] = $policy_type_list;
            $sub_array['providers'] = $providers_list;

            $data[] = $sub_array;
        }

        ob_start();
        set_time_limit(300);
        $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $html = $this->load->view('docs/summary-template', [
            'data' => $data
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
        echo json_encode([
            'link' => base_url('assets/resources/preview.pdf'),
            'adviser_str' => $adviser_str,
            'result_str' => $result_str,
            'count' => sizeof($fetch_data)
        ]);
    }

    public function savesummary()
    {
        var_export($_POST);die();
        $result['message'] = 'There was an error in the connection. Please contact the administrator for updates.';
        $result['summary_id'] = '';
        $result['filename'] = '';
        $result['adviser_str'] = $this->input->post('adviser_str');
        $result['result_str'] = $this->input->post('result_str');

        if ($this->input->post() && null != $this->input->post()) {
            $post_data = [];

            foreach ($this->input->post() as $k => $v) {
                $post_data[$k] = $this->input->post($k, true);
            }

            $adviser_ids = $this->input->post('adviser_str');
            $result_ids = $this->input->post('result_str');
            $date_from = $_POST['data']['info']['date_from'] ?? '';
            $date_until = $_POST['data']['info']['date_until'] ?? '';

            $this->load->model('SummaryCollection');
            $this->load->model('AdvisersCollection');

            $filename = 'Summary of Multiple Adviser ' . date('d/m/Y');

            if ('' != $adviser_ids) {
                $adviser_arr = explode(',', $adviser_ids);
                $adviser_arr = array_unique($adviser_arr);
                $adviser_arr_new = array_values($adviser_arr);

                if (1 == sizeof($adviser_arr_new)) {
                    $adviserInfo = $this->AdvisersCollection->getActiveAdvisersById($adviser_arr_new[0]);
                    $adviserName = $adviserInfo->first_name . ' ' . $adviserInfo->last_name;
                    $filename = 'Summary of ' . $adviserName . ' ' . date('d/m/Y');
                }
            }

            $post_data['data']['info']['adviser'] = $adviser_ids;
            $post_data['data']['info']['result'] = $result_ids;
            $post_data['data']['info']['filename'] = $filename;
            $this->load->model('SummaryCollection');

            if ($insert_id = $this->SummaryCollection->savesummary($post_data)) {
                $result['message'] = 'Successfully saved.';
                $result['summary_id'] = $insert_id;
                $result['filename'] = $filename;
            } else {
                $result['message'] = 'Failed to save details.';
            }
        }

        echo json_encode($result);
    }

    public function updatesummary()
    {
        $result['message'] = 'There was an error in the connection. Please contact the administrator for updates.';
        $result['summary_id'] = $this->input->post('summary_id');
        $result['filename'] = $this->input->post('filename');
        $result['adviser_str'] = $this->input->post('adviser_str');
        $result['result_str'] = $this->input->post('result_str');

        if ($this->input->post() && null != $this->input->post()) {
            $post_data = [];

            foreach ($this->input->post() as $k => $v) {
                $post_data[$k] = $this->input->post($k, true);
            }

            $adviser_ids = $this->input->post('adviser_str');
            $result_ids = $this->input->post('result_str');
            $date_from = $_POST['data']['info']['date_from'] ?? '';
            $date_until = $_POST['data']['info']['date_until'] ?? '';

            $this->load->model('SummaryCollection');
            $this->load->model('AdvisersCollection');
            $filename = 'Summary of Multiple Adviser ' . date('d/m/Y');

            if ('' != $adviser_ids) {
                $adviser_arr = explode(',', $adviser_ids);
                $adviser_arr = array_unique($adviser_arr);
                $adviser_arr_new = array_values($adviser_arr);

                if (1 == sizeof($adviser_arr_new)) {
                    $adviserInfo = $this->AdvisersCollection->getActiveAdvisersById($adviser_arr_new[0]);
                    $adviserName = $adviserInfo->first_name . ' ' . $adviserInfo->last_name;
                    $filename = 'Summary of ' . $adviserName . ' ' . date('d/m/Y');
                }
            }

            $post_data['data']['info']['adviser'] = $adviser_ids;
            $post_data['data']['info']['result'] = $result_ids;
            $post_data['data']['info']['filename'] = $filename;
            $this->load->model('SummaryCollection');

            if ($insert_id = $this->SummaryCollection->updatesummary($post_data)) {
                $result['message'] = 'Successfully updated.';
                $result['filename'] = $filename;
                $result['message'] = 'Successfully updated.';
            } else {
                $result['message'] = 'Failed to update details.';
            }
        }

        echo json_encode($result);
    }

    //function responsible for deleting records
    public function deleteSummary()
    {
        $result = [];
        $page = 'deleteSummary';
        $result['message'] = 'There was an error in the connection. Please contact the administrator for updates.';

        if ($this->input->post() && null != $this->input->post()) {
            $post_data = [];

            foreach ($this->input->post() as $k => $v) {
                $post_data[$k] = $this->input->post($k, true);
            }

            $this->load->model('SummaryCollection');

            if ($this->SummaryCollection->deleteRows($post_data)) {
                $result['message'] = 'Successfully deleted summary.';
            } else {
                $result['message'] = 'Failed to delete summary.';
            }
        }

        $result['key'] = $page;

        echo json_encode($result);
    }

    public function fetchRows()
    {
        $this->load->model('SummaryCollection');
        $this->load->model('AdvisersCollection');

        $fetch_data = $this->SummaryCollection->make_datatables();
        $data = [];

        foreach ($fetch_data as $k => $row) {
            $buttons = '';
            $buttons_data = '';

            $sub_array = [];
            $sub_array[] = $row->filename;

            $adviser_arr = explode(',', $row->adviser_id);
            $adviserList = '';

            if (sizeof($adviser_arr) >= 1) {
                $adviser_arr = array_unique($adviser_arr);
                $adviser_arr_new = array_values($adviser_arr);

                foreach ($adviser_arr_new as $k1 => $v1) {
                    $adviserInfo = $this->AdvisersCollection->getActiveAdvisersById($adviser_arr_new[$k1]);
                    $adviserName = $adviserInfo->first_name . ' ' . $adviserInfo->last_name;

                    if ('' == $adviserList) {
                        $adviserList = '<ul>';
                        $adviserList .= '<li>' . $adviserName . '</li>';
                    } else {
                        $adviserList .= '<li>' . $adviserName . '</li>';
                    }
                }

                $adviserList .= '</ul>';
            }
            $sub_array[] = $adviserList;
            $sub_array[] = $row->date_generated;

            // $buttons_data .= ' data-results_id="'.$row->results_id.'" ';
            foreach ($row as $k1 => $v1) {
                $buttons_data .= ' data-' . $k1 . '="' . $v1 . '" ';
            }

            $buttons .= ' <a id="viewSummaryForm" '
                      . ' class="viewSummaryForm" data-key="view" style="text-decoration: none;" '
                      . ' href="' . base_url() . 'Summary/viewSummaryForm" '
                      . $buttons_data
                      . ' > '
                      . ' <button class="btn btn-primary btn-round btn-fab btn-fab-mini" data-toggle="tooltip" data-placement="top" title="View Summary">'
                      . ' <i class="material-icons">remove_red_eye</i> '
                      . ' </button> '
                      . ' </a> ';
            $buttons .= ' <a id="deleteSummary" '
                      . ' class="deleteSummary" style="text-decoration: none;" '
                      . ' href="' . base_url() . 'Summary/deleteSummary" '
                      . $buttons_data
                      . ' > '
                      . ' <button class="btn btn-danger btn-round btn-fab btn-fab-mini" data-toggle="tooltip" data-placement="top" title="Delete Summary">'
                      . ' <i class="material-icons">delete</i> '
                      . ' </button> '
                      . ' </a> ';
            $buttons .= ' <a id="sendSummaryEmailForm" '
                      . ' class="sendSummaryEmailForm" style="text-decoration: none;" '
                      . ' href="' . base_url() . 'Pdf/sendSummaryEmailForm" '
                      . $buttons_data
                      . ' > '
                      . ' <button class="btn btn-warning btn-round btn-fab btn-fab-mini" data-toggle="tooltip" data-placement="top" title="Email PDF">'
                      . ' <i class="material-icons">mail</i> '
                      . ' </button> '
                      . ' </a> ';
            $sub_array[] = $buttons;
            $data[] = $sub_array;
        }
        $output = [
            'draw' => intval($_POST['draw']),
            'recordsTotal' => $this->SummaryCollection->get_all_data(),
            'recordsFiltered' => $this->SummaryCollection->get_filtered_data(),
            'data' => $data,
        ];
        echo json_encode($output);
    }

    public function fetchFilteredRows()
    {
        $this->load->model('SummaryCollection');
        $fetch_data = $this->SummaryCollection->make_datatables_v2();
        $data = [];

        foreach ($fetch_data as $k => $row) {
            $buttons = '';
            $buttons_data = '';

            $sub_array = [];

            //policy type start
            $policy_type_arr = explode(',', $row->policy_type);
            $policy_type_list = '';

            if (sizeof($policy_type_arr) >= 1) {
                $policy_type_arr = array_unique($policy_type_arr);
                $policy_type_arr_new = array_values($policy_type_arr);

                foreach ($policy_type_arr_new as $k1 => $v1) {
                    $policy_type_name = $this->SummaryCollection->getPolicyNameById($policy_type_arr_new[$k1]);
                    if($policy_type_name != '') {
                        if ('' == $policy_type_list) {
                            $policy_type_list = '<ul>';
                            $policy_type_list .= '<li>' . $policy_type_name . '</li>';
                        } else {
                            $policy_type_list .= '<li>' . $policy_type_name . '</li>';
                        }
                    }  
                }

                $policy_type_list .= '</ul>';
            }
            //policy type end

            //provider start
            $providers_arr = explode(',', $row->providers);
            $providers_list = '';

            if (sizeof($providers_arr) >= 1) {
                $providers_arr = array_unique($providers_arr);
                $providers_arr_new = array_values($providers_arr);

                foreach ($providers_arr_new as $k1 => $v1) {
                    $providers_name = $this->SummaryCollection->getProvidersNameById($providers_arr_new[$k1]);
                    if($providers_name != '') {
                        if ('' == $providers_list) {
                            $providers_list = '<ul>';
                            $providers_list .= '<li>' . $providers_name . '</li>';
                        } else {
                            $providers_list .= '<li>' . $providers_name . '</li>';
                        }
                    } 
                }

                $providers_list .= '</ul>';
            }
            //provider end

            $answers = isset($row->answers) ? json_decode($row->answers, true) : [];

            //step 1 computation start
            $step1_score = 0;
            $step1_total_questions = sizeof($answers['step1']);
            foreach ($answers['step1'] as $key => $value) {
                $step1_score += $answers['step1'][$key]['value'];
            }
            $step1_max_score = $step1_total_questions * 2;
            $step1_score_percentage = ($step1_score / $step1_max_score) * 100;
            $step1_score_percentage = round((float)$step1_score_percentage, 2, PHP_ROUND_HALF_UP);
            $step1_score_disp = $step1_score."/".$step1_max_score." (".$step1_score_percentage."%)";
            //step 1 computation end

            //step 2 computation start
            $step2_score = 0;
            $step2_total_questions = sizeof($answers['step2']);
            foreach ($answers['step2'] as $key => $value) {
                $step2_score += $answers['step2'][$key]['value'];
            }
            $step2_max_score = $step2_total_questions * 2;
            $step2_score_percentage = ($step2_score / $step2_max_score) * 100;
            $step2_score_percentage = round((float)$step2_score_percentage, 2, PHP_ROUND_HALF_UP);
            $step2_score_disp = $step2_score."/".$step2_max_score." (".$step2_score_percentage."%)";
            //step 2 computation end

            //step 3 computation start
            $step3_score = 0;
            $step3_total_questions = sizeof($answers['step3']);
            foreach ($answers['step3'] as $key => $value) {
                $step3_score += $answers['step3'][$key]['value'];
            }
            $step3_max_score = $step3_total_questions * 2;
            $step3_score_percentage = ($step3_score / $step3_max_score) * 100;
            $step3_score_percentage = round((float)$step3_score_percentage, 2, PHP_ROUND_HALF_UP);
            $step3_score_disp = $step3_score."/".$step3_max_score." (".$step3_score_percentage."%)";
            //step 3 computation end

            //step 4 computation start
            $step4_score = 0;
            $step4_total_questions = sizeof($answers['step4']);
            foreach ($answers['step4'] as $key => $value) {
                $step4_score += $answers['step4'][$key]['value'];
            }
            $step4_max_score = $step4_total_questions * 2;
            $step4_score_percentage = ($step4_score / $step4_max_score) * 100;
            $step4_score_percentage = round((float)$step4_score_percentage, 2, PHP_ROUND_HALF_UP);
            $step4_score_disp = $step4_score."/".$step4_max_score." (".$step4_score_percentage."%)";
            //step 4 computation end

            //step 5 computation start
            $step5_score = 0;
            $step5_total_questions = sizeof($answers['step5']);
            foreach ($answers['step5'] as $key => $value) {
                $step5_score += $answers['step5'][$key]['value'];
            }
            $step5_max_score = $step5_total_questions * 2;
            $step5_score_percentage = ($step5_score / $step5_max_score) * 100;
            $step5_score_percentage = round((float)$step5_score_percentage, 2, PHP_ROUND_HALF_UP);
            $step5_score_disp = $step5_score."/".$step5_max_score." (".$step5_score_percentage."%)";
            //step 5 computation end

            //step 6 computation start
            $step6_score = 0;
            $step6_total_questions = sizeof($answers['step6']);
            foreach ($answers['step6'] as $key => $value) {
                $step6_score += $answers['step6'][$key]['value'];
            }
            $step6_max_score = $step6_total_questions * 6;
            $step6_score_percentage = ($step6_score / $step6_max_score) * 100;
            $step6_score_percentage = round((float)$step6_score_percentage, 2, PHP_ROUND_HALF_UP);
            $step6_score_disp = $step6_score."/".$step6_max_score." (".$step6_score_percentage."%)";
            //step 6 computation end

            //total score computation start
            for ($i = 1; $i <= 6; $i++) {
                $total_question += sizeof($answers['step' . $i]);
            }

            $max_score = $total_question * 2;
            $score_percentage = ($row->score / $max_score) * 100;
            $score_percentage = round((float)$score_percentage, 2, PHP_ROUND_HALF_UP);
            $total_question = 0;

            $total_score_disp = $row->score."/".$max_score." (".$score_percentage."%)";
            //total score computation end
            
            $sub_array['clients'] = $row->clients;
            $sub_array['step1'] = $step1_score_disp;
            $sub_array['step2'] = $step2_score_disp;
            $sub_array['step3'] = $step3_score_disp;
            $sub_array['step4'] = $step4_score_disp;
            $sub_array['step5'] = $step5_score_disp;
            $sub_array['step6'] = $step6_score_disp;
            $sub_array['total_score'] = $total_score_disp;
            $sub_array['replacement'] = ($row->replacement == '') ? 'N/A' : $row->replacement;
            $sub_array['policy_type'] = $policy_type_list;
            $sub_array['providers'] = $providers_list;
            $sub_array['score_status'] = ($row->score_status == 'Based on percentage') ? (($score_status >= 75) ? '<span style="color:green">Passed</span>' : '<span style="color:red">Failed</span>') : (($row->score_status == "Passed") ? '<span style="color:green">Passed</span>' : '<span style="color:red">Failed</span>');
            // $buttons_data .= ' data-results_id="'.$row->results_id.'" ';
            foreach ($row as $k1 => $v1) {
                if($k1 != 'answers')
                    $buttons_data .= ' data-' . $k1 . '="' . $v1 . '" ';
            }

            $buttons .= ' <a id="viewPdfForm" '
                      . ' class="viewPdfForm" data-key="view" style="text-decoration: none;" '
                      . ' href="'. base_url().'Pdf/viewPdfForm" '
                      . $buttons_data
                      . ' > '
                      . ' <button class="btn btn-primary btn-round btn-fab btn-fab-mini" data-toggle="tooltip" data-placement="top" title="View file review report">'
                      . ' <i class="material-icons">remove_red_eye</i> '
                      . ' </button> '
                      . ' </a> ';
            $sub_array['actions'] = $buttons;
            $data[] = $sub_array;
        }
        $output = [
            'draw' => intval($_POST['draw']),
            'recordsTotal' => $this->SummaryCollection->get_all_data_v2(),
            'recordsFiltered' => $this->SummaryCollection->get_filtered_data_v2(),
            'data' => $data,
        ];
        echo json_encode($output);
    }

    public function fetchSummaryDetails(){
        $this->load->model('SummaryCollection');
        $fetch_data = $this->SummaryCollection->getFilteredSummary();
        $data = [];

        $step1_passed = 0;
        $step2_passed = 0;
        $step3_passed = 0;
        $step4_passed = 0;
        $step5_passed = 0;
        $step6_passed = 0;

        $step1_failed = 0;
        $step2_failed = 0;
        $step3_failed = 0;
        $step4_failed = 0;
        $step5_failed = 0;
        $step6_failed = 0;

        $policy_type_list = array();
        $providers_list = array();
        $replacement_list = array();

        foreach ($fetch_data as $k => $row) {
            $buttons = '';
            $buttons_data = '';

            $sub_array = [];
            if($row->replacement == "") $row->replacement = "N/A";
            if(isset($replacement_list[$row->replacement]))
                $replacement_list[$row->replacement] = $replacement_list[$row->replacement] + 1;
            else
                $replacement_list[$row->replacement] = 1; 

            //policy type start
            $policy_type_arr = explode(',', $row->policy_type);
            if (sizeof($policy_type_arr) >= 1) {
                $policy_type_arr = array_unique($policy_type_arr);
                $policy_type_arr_new = array_values($policy_type_arr);

                foreach ($policy_type_arr_new as $k1 => $v1) {
                    $policy_type_name = $this->SummaryCollection->getPolicyNameById($policy_type_arr_new[$k1]);
                    if($policy_type_name != '') {
                        if(isset($policy_type_list[$policy_type_name]))
                            $policy_type_list[$policy_type_name] = $policy_type_list[$policy_type_name] + 1;
                        else
                            $policy_type_list[$policy_type_name] = 1;     
                    }  
                }
            }
            //policy type end

            //provider start
            $providers_arr = explode(',', $row->providers);
            if (sizeof($providers_arr) >= 1) {
                $providers_arr = array_unique($providers_arr);
                $providers_arr_new = array_values($providers_arr);

                foreach ($providers_arr_new as $k1 => $v1) {
                    $providers_name = $this->SummaryCollection->getProvidersNameById($providers_arr_new[$k1]);
                    if($providers_name != '') {
                        if(isset($providers_list[$providers_name]))
                            $providers_list[$providers_name] = $providers_list[$providers_name] + 1;
                        else
                            $providers_list[$providers_name] = 1;
                    } 
                }
            }
            //provider end

            $answers = isset($row->answers) ? json_decode($row->answers, true) : [];

            //step 1 computation start
            $step1_score = 0;
            $step1_total_questions = sizeof($answers['step1']);
            foreach ($answers['step1'] as $key => $value) {
                $step1_score += $answers['step1'][$key]['value'];
            }
            $step1_max_score = $step1_total_questions * 2;
            $step1_score_percentage = ($step1_score / $step1_max_score) * 100;
            $step1_score_percentage = round((float)$step1_score_percentage, 2, PHP_ROUND_HALF_UP);
            if($step1_score_percentage >= 75) $step1_passed++;
            else $step1_failed++;
            //step 1 computation end

            //step 2 computation start
            $step2_score = 0;
            $step2_total_questions = sizeof($answers['step2']);
            foreach ($answers['step2'] as $key => $value) {
                $step2_score += $answers['step2'][$key]['value'];
            }
            $step2_max_score = $step2_total_questions * 2;
            $step2_score_percentage = ($step2_score / $step2_max_score) * 100;
            $step2_score_percentage = round((float)$step2_score_percentage, 2, PHP_ROUND_HALF_UP);
            if($step2_score_percentage >= 75) $step2_passed++;
            else $step2_failed++;
            //step 2 computation end

            //step 3 computation start
            $step3_score = 0;
            $step3_total_questions = sizeof($answers['step3']);
            foreach ($answers['step3'] as $key => $value) {
                $step3_score += $answers['step3'][$key]['value'];
            }
            $step3_max_score = $step3_total_questions * 2;
            $step3_score_percentage = ($step3_score / $step3_max_score) * 100;
            $step3_score_percentage = round((float)$step3_score_percentage, 2, PHP_ROUND_HALF_UP);
            if($step3_score_percentage >= 75) $step3_passed++;
            else $step3_failed++;
            //step 3 computation end

            //step 4 computation start
            $step4_score = 0;
            $step4_total_questions = sizeof($answers['step4']);
            foreach ($answers['step4'] as $key => $value) {
                $step4_score += $answers['step4'][$key]['value'];
            }
            $step4_max_score = $step4_total_questions * 2;
            $step4_score_percentage = ($step4_score / $step4_max_score) * 100;
            $step4_score_percentage = round((float)$step4_score_percentage, 2, PHP_ROUND_HALF_UP);
            if($step4_score_percentage >= 75) $step4_passed++;
            else $step4_failed++;
            //step 4 computation end

            //step 5 computation start
            $step5_score = 0;
            $step5_total_questions = sizeof($answers['step5']);
            foreach ($answers['step5'] as $key => $value) {
                $step5_score += $answers['step5'][$key]['value'];
            }
            $step5_max_score = $step5_total_questions * 2;
            $step5_score_percentage = ($step5_score / $step5_max_score) * 100;
            $step5_score_percentage = round((float)$step5_score_percentage, 2, PHP_ROUND_HALF_UP);
            if($step5_score_percentage >= 75) $step5_passed++;
            else $step5_failed++;
            //step 5 computation end

            //step 6 computation start
            $step6_score = 0;
            $step6_total_questions = sizeof($answers['step6']);
            foreach ($answers['step6'] as $key => $value) {
                $step6_score += $answers['step6'][$key]['value'];
            }
            $step6_max_score = $step6_total_questions * 6;
            $step6_score_percentage = ($step6_score / $step6_max_score) * 100;
            $step6_score_percentage = round((float)$step6_score_percentage, 2, PHP_ROUND_HALF_UP);
            if($step6_score_percentage >= 75) $step6_passed++;
            else $step6_failed++;
            //step 6 computation end

            //total score computation start
            for ($i = 1; $i <= 6; $i++) {
                $total_question += sizeof($answers['step' . $i]);
            }

            $max_score = $total_question * 2;
            $score_percentage = ($row->score / $max_score) * 100;
            $score_percentage = round((float)$score_percentage, 2, PHP_ROUND_HALF_UP);
            $total_question = 0;

            $total_score_disp = $row->score."/".$max_score." (".$score_percentage."%)";
            //total score computation end
            
        }


        $data = array(
            "step1_passed" => $step1_passed,
            "step2_passed" => $step2_passed,
            "step3_passed" => $step3_passed,
            "step4_passed" => $step4_passed,
            "step5_passed" => $step5_passed,
            "step6_passed" => $step6_passed,
            "step1_failed" => $step1_failed,
            "step2_failed" => $step2_failed,
            "step3_failed" => $step3_failed,
            "step4_failed" => $step4_failed,
            "step5_failed" => $step5_failed,
            "step6_failed" => $step6_failed,
            "policy_type_arr"   => $policy_type_list,
            "providers_arr"     => $providers_list,
            "replacement_arr"   => $replacement_list
        );

        echo json_encode($data);
    }
}
