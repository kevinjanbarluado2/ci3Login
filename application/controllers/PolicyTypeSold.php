<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PolicyTypeSold extends CI_Controller {
	// public function index() {
	// 	var_export("TEST");die();
	// }

	//accessing view form for viewing of records
	public function viewForm() {
		$formData = array();
		$result = array();
		$result['key'] = 'view';
		$formData['key'] = $result['key'];

		$this->load->model('PolicyTypeSoldCollection');
		$result['form'] = $this->load->view('forms/policytypesoldform.php', $formData, TRUE);
		echo json_encode($result);
	}

	//accessing view form for updating of records
	public function updateForm() {
		$formData = array();
		$result = array();
		$result['key'] = 'update';
		$formData['key'] = $result['key'];

		$this->load->model('PolicyTypeSoldCollection');
		$result['form'] = $this->load->view('forms/policytypesoldform.php', $formData, TRUE);
		echo json_encode($result);
	}

	//function responsible for updating records
	public function update(){
		$result = array();
		$page = 'update';
		$result['message'] = "There was an error in the connection. Please contact the administrator for updates.";

		if($this->input->post() && $this->input->post() != null){
			$post_data = array();
			foreach ($this->input->post() as $k => $v) {
				$post_data[$k] = $this->input->post($k,true);
			}

			$this->load->model('PolicyTypeSoldCollection');
			if($this->PolicyTypeSoldCollection->updateRows($post_data)) {
				$result['message'] = "Successfully updated provider.";
			} else {
				$result['message'] = "Failed to update provider details.";
			}
		} 

		$result['key'] = $page;
		
		echo json_encode($result);
	}

	//accessing form to be filled out
	public function addForm(){
		$formData = array();
		$result = array();
		$result['key'] = 'add';

		$formData['key'] = $result['key'];

		$this->load->model('PolicyTypeSoldCollection');
		$result['form'] = $this->load->view('forms/policytypesoldform.php', $formData, TRUE);
		echo json_encode($result);
	}

	//function responsible for inserting records
	public function add(){
		$result = array();
		$page = 'add';
		$result['message'] = "There was an error in the connection. Please contact the administrator for updates.";

		if($this->input->post() && $this->input->post() != null){
			$post_data = array();
			foreach ($this->input->post() as $k => $v) {
				$post_data[$k] = $this->input->post($k,true);
			}

			$this->load->model('PolicyTypeSoldCollection');
			if($this->PolicyTypeSoldCollection->addRows($post_data)) {
				$result['message'] = "Successfully inserted record.";
			} else {
				$result['message'] = "Failed to add record.";
			}
		} 

		$result['key'] = $page;
		
		echo json_encode($result);
	}

	//function responsible for activating records
	public function activate(){
		$result = array();
		$page = 'activate';
		$result['message'] = "There was an error in the connection. Please contact the administrator for updates.";

		if($this->input->post() && $this->input->post() != null) {
			$post_data = array();
			foreach ($this->input->post() as $k => $v) {
				$post_data[$k] = $this->input->post($k,true);
			}

			$this->load->model('PolicyTypeSoldCollection');
			if($this->PolicyTypeSoldCollection->activateRows($post_data)) {
				$result['message'] = "Successfully activated record.";
			} else {
				$result['message'] = "Failed to activate record.";
			}
		} 

		$result['key'] = $page;

		echo json_encode($result);
	}

	//function responsible for deactivating records
	public function deactivate(){
		$result = array();
		$page = 'deactivate';
		$result['message'] = "There was an error in the connection. Please contact the administrator for updates.";
		if($this->input->post() && $this->input->post() != null) {
			$post_data = array();
			foreach ($this->input->post() as $k => $v) {
				$post_data[$k] = $this->input->post($k,true);
			}

			$this->load->model('PolicyTypeSoldCollection');
			if($this->PolicyTypeSoldCollection->deactivateRows($post_data)) {
				$result['message'] = "Successfully deactivated record.";
			} else {
				$result['message'] = "Failed to deactivate record.";
			}
		} 

		$result['key'] = $page;

		echo json_encode($result);
	}

	function fetchRows(){ 
		$filter = $this->input->post('filter');

		$this->load->model('PolicyTypeSoldCollection');
        $fetch_data = $this->PolicyTypeSoldCollection->make_datatables();  
        $data = array();  
        foreach($fetch_data as $k => $row){ 
        	$buttons = "";
        	$buttons_data = "";

            $sub_array = array();    
		    $sub_array[] = $row->code;
		    $sub_array[] = $row->name;

            $status_color = "text-danger";
            if($row->status == "Active"){
            	$status_color = "text-success";
            	$status = "ACTIVE";
            }
            else{
            	$status_color = "text-danger";
            	$status = "INACTIVE";
            }

            $sub_array[] = '<b><span class="'.$status_color.'">'.$status.'</span><b>';

            foreach($row as $k1=>$v1){
            	if($k1 == "idproduct_category") 
            		$buttons_data .= ' data-id="'.$v1.'" ';
            	else
            		$buttons_data .= ' data-'.$k1.'="'.$v1.'" ';
            }

            $buttons .= ' <a id="viewForm" ' 
            		  . ' class="viewForm" style="text-decoration: none;" '
            		  . ' href="'. base_url().'PolicyTypeSold/viewForm" '
            		  . $buttons_data
            		  . ' > '
            		  . ' <button class="btn btn-primary btn-round btn-fab btn-fab-mini" data-toggle="tooltip" data-placement="top" title="View Details">'
            		  . ' <i class="material-icons">remove_red_eye</i> '
            		  . ' </button> '
            		  . ' </a> ';
            $buttons .= ' <a id="updateForm" ' 
            		  . ' class="updateForm" style="text-decoration: none;" '
            		  . ' href="'. base_url().'PolicyTypeSold/updateForm" '
            		  . $buttons_data
            		  . ' > '
            		  . ' <button class="btn btn-info btn-round btn-fab btn-fab-mini" data-toggle="tooltip" data-placement="top" title="Update">'
            		  . ' <i class="material-icons">mode_edit</i> '
            		  . ' </button> '
            		  . ' </a> ';
           	if($row->status == "Active"){
	            $buttons  .= ' <a id="deactivate" ' 
	            		  . ' class="deactivate" style="text-decoration: none;" '
	            		  . ' href="'. base_url().'PolicyTypeSold/deactivate" '
	            		  . $buttons_data
	            		  . ' > '
	            		  . ' <button class="btn btn-danger btn-round btn-fab btn-fab-mini" data-toggle="tooltip" data-placement="top" title="Deactivate">'
	            		  . ' <i class="material-icons">do_not_disturb</i> '
	            		  . ' </button> '
	            		  . ' </a> ';
	        } else {
	        	$buttons  .= ' <a id="activate" ' 
	            		  . ' class="activate" style="text-decoration: none;" '
	            		  . ' href="'. base_url().'PolicyTypeSold/activate" '
	            		  . $buttons_data
	            		  . ' > '
	            		  . ' <button class="btn btn-success btn-round btn-fab btn-fab-mini" data-toggle="tooltip" data-placement="top" title="Activate">'
	            		  . ' <i class="material-icons">done</i> '
	            		  . ' </button> '
	            		  . ' </a> ';
	        } 


            $sub_array[] = $buttons;
            $data[] = $sub_array;  
        }  
        $output = array(  
            "draw"                  =>     intval($_POST["draw"]),  
            "recordsTotal"          =>      $this->PolicyTypeSoldCollection->get_all_data(),  
            "recordsFiltered"     	=>     $this->PolicyTypeSoldCollection->get_filtered_data(),  
            "data"                  =>     $data  
        );  
        echo json_encode($output);  
    }
}
