<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Advisers extends CI_Controller {
	public function index() {
		// $this->load->model('AdvisersCollection');
		// $res = $this->AdvisersCollection->getActiveAdvisersById("24");
		// var_export($res);die();
	}

	//accessing adviser form for viewing of records
	public function viewAdvisersForm() {
		$formData = array();
		$result = array();
		$result['key'] = 'viewAdvisers';
		$formData['key'] = $result['key'];

		$result['form'] = $this->load->view('forms/advisersform.php', $formData, TRUE);
		echo json_encode($result);
	}

	//accessing adviser form for viewing of records
	public function updateAdvisersForm() {
		$formData = array();
		$result = array();
		$result['key'] = 'updateAdvisers';
		$formData['key'] = $result['key'];

		$result['form'] = $this->load->view('forms/advisersform.php', $formData, TRUE);
		echo json_encode($result);
	}

	//function responsible for updating records
	public function updateAdvisers(){
		$result = array();
		$page = 'updateAdvisers';
		$result['message'] = "There was an error in the connection. Please contact the administrator for updates.";

		if($this->input->post() && $this->input->post() != null){
			$post_data = array();
			foreach ($this->input->post() as $k => $v) {
				$post_data[$k] = $this->input->post($k,true);
			}

			$this->load->model('AdvisersCollection');
			if($this->AdvisersCollection->updateRows($post_data)) {
				$result['message'] = "Successfully updated adviser details.";
			} else {
				$result['message'] = "Failed to update adviser details.";
			}
		} 

		$result['key'] = $page;
		
		echo json_encode($result);
	}

	//accessing adviser form to be filled out
	public function addAdvisersForm(){
		$formData = array();
		$result = array();
		$result['key'] = 'addAdvisers';
		$formData['key'] = $result['key'];

		$result['form'] = $this->load->view('forms/advisersform.php', $formData, TRUE);
		echo json_encode($result);
	}

	//function responsible for inserting records
	public function addAdvisers(){
		$result = array();
		$page = 'addAdvisers';
		$result['message'] = "There was an error in the connection. Please contact the administrator for updates.";

		if($this->input->post() && $this->input->post() != null){
			$post_data = array();
			foreach ($this->input->post() as $k => $v) {
				$post_data[$k] = $this->input->post($k,true);
			}

			$this->load->model('AdvisersCollection');
			if($this->AdvisersCollection->addRows($post_data)) {
				$result['message'] = "Successfully inserted adviser.";
			} else {
				$result['message'] = "Failed to add adviser.";
			}
		} 

		$result['key'] = $page;
		
		echo json_encode($result);
	}

	//function responsible for deleting records
	public function deleteAdvisers(){
		$result = array();
		$page = 'deleteAdvisers';
		$result['message'] = "There was an error in the connection. Please contact the administrator for updates.";

		if($this->input->post() && $this->input->post() != null) {
			$post_data = array();
			foreach ($this->input->post() as $k => $v) {
				$post_data[$k] = $this->input->post($k,true);
			}

			$this->load->model('AdvisersCollection');
			if($this->AdvisersCollection->deleteRows($post_data)) {
				$result['message'] = "Successfully deleted adviser.";
			} else {
				$result['message'] = "Failed to delete adviser.";
			}
		} 

		$result['key'] = $page;

		echo json_encode($result);
	}

	function fetchRows(){ 
		$this->load->model('AdvisersCollection');
        $fetch_data = $this->AdvisersCollection->make_datatables();  
        $data = array();  
        foreach($fetch_data as $k => $row){ 
        	$buttons = "";
        	$buttons_data = "";

            $sub_array = array();    
            $sub_array[] = $row->last_name.", ".$row->first_name." ".((isset($row->middle_name) && $row->middle_name <> "") ? substr($row->middle_name, 0, 1)."." : "");
            $sub_array[] = $row->email;  
            $sub_array[] = $row->fspr_number;
            $sub_array[] = $row->address;
            $sub_array[] = $row->trading_name;
            $sub_array[] = $row->telephone_no;
            foreach($row as $k1=>$v1){
            	$buttons_data .= ' data-'.$k1.'="'.$v1.'" ';
            }

            $buttons .= ' <a id="viewAdvisersForm" ' 
            		  . ' class="viewAdvisersForm" style="text-decoration: none;" '
            		  . ' href="'. base_url().'Advisers/viewAdvisersForm" '
            		  . $buttons_data
            		  . ' > '
            		  . ' <button class="btn btn-primary btn-round btn-fab btn-fab-mini" data-toggle="tooltip" data-placement="top" title="View Details">'
            		  . ' <i class="material-icons">remove_red_eye</i> '
            		  . ' </button> '
            		  . ' </a> ';
            // $buttons .= ' <a id="updateAdvisersForm" ' 
            		//   . ' class="updateAdvisersForm" style="text-decoration: none;" '
            		//   . ' href="'. base_url().'Advisers/updateAdvisersForm" '
            		//   . $buttons_data
            		//   . ' > '
            		//   . ' <button class="btn btn-info btn-round btn-fab btn-fab-mini" data-toggle="tooltip" data-placement="top" title="Update">'
            		//   . ' <i class="material-icons">mode_edit</i> '
            		//   . ' </button> '
            		//   . ' </a> ';
            // $buttons .= ' <a id="deleteAdvisers" ' 
            		//   . ' class="deleteAdvisers" style="text-decoration: none;" '
            		//   . ' href="'. base_url().'Advisers/deleteAdvisers" '
            		//   . $buttons_data
            		//   . ' > '
            		//   . ' <button class="btn btn-danger btn-round btn-fab btn-fab-mini" data-toggle="tooltip" data-placement="top" title="Delete">'
            		//   . ' <i class="material-icons">delete</i> '
            		//   . ' </button> '
            		//   . ' </a> ';
            $sub_array[] = $buttons;
            $data[] = $sub_array;  
        }  
        $output = array(  
            "draw"                  =>     intval($_POST["draw"]),  
            "recordsTotal"          =>      $this->AdvisersCollection->get_all_data(),  
            "recordsFiltered"     	=>     $this->AdvisersCollection->get_filtered_data(),  
            "data"                  =>     $data  
        );  
        echo json_encode($output);  
    }
}
