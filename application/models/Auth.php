<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 

class Auth extends CI_Model{

function __construct(){
	parent::__construct();

}

function validate(){
		

$data['email'] = $this->input->post('inputEmail');
$data['password'] = md5($this->input->post('inputPassword'));

return $this->db->get_where('user_tbl',$data)->row();



}
	



}










 ?>