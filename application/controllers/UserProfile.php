<?php
defined('BASEPATH') or exit('No direct script access allowed');

class UserProfile extends CI_Controller {
	public function index() {
		var_export("TEST");die();
	}

	//accessing user form for viewing of records
	public function viewUserProfileForm() {
		$formData = array();
		$result = array();
		$result['key'] = 'viewUserProfile';
		$formData['key'] = $result['key'];

		$this->load->model('UserProfileCollection');
		$formData['privileges'] = $this->UserProfileCollection->getPrivileges();
		$result['form'] = $this->load->view('forms/userprofileform.php', $formData, TRUE);
		echo json_encode($result);
	}

	//accessing user form for viewing of records
	public function updateUserProfileForm() {
		$formData = array();
		$result = array();
		$result['key'] = 'updateUserProfile';
		$formData['key'] = $result['key'];

		$this->load->model('UserProfileCollection');
		$formData['privileges'] = $this->UserProfileCollection->getPrivileges();
		$result['form'] = $this->load->view('forms/userprofileform.php', $formData, TRUE);
		echo json_encode($result);
	}

	//function responsible for updating records
	public function updateUserProfile(){
		$result = array();
		$page = 'updateUserProfile';
		$result['message'] = "There was an error in the connection. Please contact the administrator for updates.";

		if($this->input->post() && $this->input->post() != null){
			$post_data = array();
			foreach ($this->input->post() as $k => $v) {
				$post_data[$k] = $this->input->post($k,true);
			}

			$this->load->model('UserProfileCollection');
			if($this->UserProfileCollection->updateRows($post_data)) {
				$result['message'] = "Successfully updated user details.";
			} else {
				$result['message'] = "Failed to update user details.";
			}
		} 

		$result['key'] = $page;
		
		echo json_encode($result);
	}

	//accessing user form filled out
	public function addUserProfileForm(){
		$formData = array();
		$result = array();
		$result['key'] = 'addUserProfile';

		$formData['key'] = $result['key'];

		$this->load->model('UserProfileCollection');
		$formData['privileges'] = $this->UserProfileCollection->getPrivileges();
		$result['form'] = $this->load->view('forms/userprofileform.php', $formData, TRUE);
		echo json_encode($result);
	}

	//function responsible for inserting records
	public function addUserProfile(){
		$result = array();
		$page = 'addUserProfile';
		$result['message'] = "There was an error in the connection. Please contact the administrator for updates.";

		if($this->input->post() && $this->input->post() != null){
			$post_data = array();
			foreach ($this->input->post() as $k => $v) {
				$post_data[$k] = $this->input->post($k,true);
			}

			$this->load->model('UserProfileCollection');
			if($this->UserProfileCollection->addRows($post_data)) {
				$result['message'] = "Successfully inserted user.";
			} else {
				$result['message'] = "Failed to add user.";
			}
		} 

		$result['key'] = $page;
		
		echo json_encode($result);
	}

	//function responsible for deleting records
	public function deleteUserProfile(){
		$result = array();
		$page = 'deleteUserProfile';
		$result['message'] = "There was an error in the connection. Please contact the administrator for updates.";

		if($this->input->post() && $this->input->post() != null) {
			$post_data = array();
			foreach ($this->input->post() as $k => $v) {
				$post_data[$k] = $this->input->post($k,true);
			}

			$this->load->model('UserProfileCollection');
			if($this->UserProfileCollection->deleteRows($post_data)) {
				$result['message'] = "Successfully deleted user.";
			} else {
				$result['message'] = "Failed to delete user.";
			}
		} 

		$result['key'] = $page;

		echo json_encode($result);
	}

	function fetchRows(){ 
		$this->load->model('UserProfileCollection');
        $fetch_data = $this->UserProfileCollection->make_datatables();  
        $data = array();  
        foreach($fetch_data as $k => $row){ 
        	$buttons = "";
        	$buttons_data = "";

            $sub_array = array();    
            $sub_array[] = $row->name;
            $sub_array[] = $row->email;  
            $sub_array[] = $row->privileges;

            foreach($row as $k1=>$v1){
            	$buttons_data .= ' data-'.$k1.'="'.$v1.'" ';
            }

            $buttons .= ' <a id="viewUserProfileForm" ' 
            		  . ' class="viewUserProfileForm" style="text-decoration: none;" '
            		  . ' href="'. base_url().'UserProfile/viewUserProfileForm" '
            		  . $buttons_data
            		  . ' > '
            		  . ' <button class="btn btn-primary btn-round btn-fab btn-fab-mini" data-toggle="tooltip" data-placement="top" title="View Details">'
            		  . ' <i class="material-icons">remove_red_eye</i> '
            		  . ' </button> '
            		  . ' </a> ';
            $buttons .= ' <a id="updateUserProfileForm" ' 
            		  . ' class="updateUserProfileForm" style="text-decoration: none;" '
            		  . ' href="'. base_url().'UserProfile/updateUserProfileForm" '
            		  . $buttons_data
            		  . ' > '
            		  . ' <button class="btn btn-info btn-round btn-fab btn-fab-mini" data-toggle="tooltip" data-placement="top" title="Update">'
            		  . ' <i class="material-icons">mode_edit</i> '
            		  . ' </button> '
            		  . ' </a> ';

           	if($_SESSION['id'] <> $row->id) :
	           	$buttons .= ' <a id="deleteUserProfile" ' 
	            		  . ' class="deleteUserProfile" style="text-decoration: none;" '
	            		  . ' href="'. base_url().'UserProfile/deleteUserProfile" '
	            		  . $buttons_data
	            		  . ' > '
	            		  . ' <button class="btn btn-danger btn-round btn-fab btn-fab-mini" data-toggle="tooltip" data-placement="top" title="Delete">'
	            		  . ' <i class="material-icons">delete</i> '
	            		  . ' </button> '
	            		  . ' </a> ';
           	endif;

            $sub_array[] = $buttons;
            $data[] = $sub_array;  
        }  
        $output = array(  
            "draw"                  =>     intval($_POST["draw"]),  
            "recordsTotal"          =>      $this->UserProfileCollection->get_all_data(),  
            "recordsFiltered"     	=>     $this->UserProfileCollection->get_filtered_data(),  
            "data"                  =>     $data  
        );  
        echo json_encode($output);  
    }
}
