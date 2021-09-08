<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 

class Auth extends CI_Model{

function __construct(){
	parent::__construct();
	$this->adviceprocess_db = $this->load->database('adviceprocess',TRUE);
}

function validate(){
	$data['email'] = $this->input->post('inputEmail');
	$data['password'] = md5($this->input->post('inputPassword'));

	$query = $this->db->get_where('user_tbl',$data);
	if ($query->num_rows() > 0) {
	    $result = $query->row();
	    return $result;
	} else {
		unset($data['email']);
		$data['username'] = $this->input->post('inputEmail');

		$query = $this->adviceprocess_db->get_where('login',$data);
		if($query->num_rows() > 0) {
			$params['idusers'] = $query->row('users_idusers');
			$result = $this->adviceprocess_db->get_where('users',$params)->row();

			$result->name = $result->first_name." ".$result->last_name;
			$result->img = $result->photo;
			$result->admin = 0;
			$result->privileges = 'advisernotes';
			$result->id = $result->idusers;
			
			return $result;
		} 
		return false;
	}
}
	



}










 ?>