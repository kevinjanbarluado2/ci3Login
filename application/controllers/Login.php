<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use TCPDF as tcpdf;
use Dotenv\Dotenv;

class Login extends CI_Controller {

	public function __construct()
	{
        parent::__construct();
        $dotenv = Dotenv::createImmutable(FCPATH);
        $dotenv->load();
		
     }

     public function index(){
     if($this->session->userdata('admin')){
        	redirect('welcome');
        }
     	$this->load->view('login',array('version'=>$_ENV['version']));
     	
     }


	public function verify(){
	$this->load->model('auth');
	$check = $this->auth->validate();


		if($check){
		$this->session->set_userdata('name',$check->name);
		$this->session->set_userdata('img',$check->img);
		$this->session->set_userdata('admin',$check->admin);
		$this->session->set_userdata('privileges',$check->privileges);
		$this->session->set_userdata('id',$check->id);
		
		redirect('welcome');
		
		}else{
			redirect('login?invalid=1');
		}

	}

	public function md5(){

	echo isset($_GET['str'])?md5($_GET['str']):'';
	}

	public function signout(){
	$this->session->sess_destroy();
	redirect('login');
	}

	







 }


