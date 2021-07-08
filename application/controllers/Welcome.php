<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Dotenv\Dotenv;

class Welcome extends CI_Controller
{

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.htmls
	 */

	public function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('admin')) {
			redirect('login');	
		}

	}


	public function index()
	{
		$data = array();
		$data['activeNav'] = "dashboard";
		$this->load->view('header', $data);
		$this->load->view('pages/dashboard');
		$this->load->view('footer');
	}
	public function users()
	{
		$data = array();
		$data['activeNav'] = "users";
		$this->load->view('header', $data);
		$this->load->view('pages/users');
		$this->load->view('footer');
	}
	public function compliance()
	{


		$this->load->model('AdvisersCollection');
		$this->load->model('CompanyProviderCollection');
		$this->load->model('PolicyTypeSoldCollection');
		$this->load->model('PdfCollection');

		$data = array();
		$data['activeNav'] = "compliance";
		$data['advisers'] = $this->AdvisersCollection->getActiveAdvisers();
		$data['providers'] = $this->CompanyProviderCollection->getActiveProviders();
		$data['policies'] = $this->PolicyTypeSoldCollection->getActivePolicies();

		//encrypted id
		$token = isset($_GET['v']) ? $_GET['v'] : '';


		//$results_id=($this->input->get('v')!=="")?$this->input->get('v'):"";
		$result = array();
		$result['data'] = $this->PdfCollection->get_one_data($token, 'token');



		$this->load->view('header', $data);
		$this->load->view('pages/compliance', $result);
		$this->load->view('footer', $data);
	}
	public function advisers()
	{
		$data = array();
		$data['activeNav'] = "advisers";
		$this->load->view('header', $data);
		$this->load->view('pages/advisers');
		$this->load->view('footer', $data);
	}
	public function fieldmanagement()
	{
		$data = array();
		$data['activeNav'] = "fieldmanagement";
		$this->load->view('header', $data);
		$this->load->view('pages/fieldmanagement');
		$this->load->view('footer', $data);
	}
	public function pdf()
	{
		$data = array();
		$data['activeNav'] = "pdf";
		$this->load->view('header', $data);
		$this->load->view('pages/pdf');
		$this->load->view('footer', $data);
	}
	public function summary()
	{
		$this->load->model('AdvisersCollection');
		$this->load->model('CompanyProviderCollection');
		$this->load->model('PolicyTypeSoldCollection');
		$this->load->model('PdfCollection');

		$data = array();
		$data['activeNav'] = "summary";
		$data['advisers'] = $this->AdvisersCollection->getActiveAdvisers();
		$data['providers'] = $this->CompanyProviderCollection->getActiveProviders();
		$data['policies'] = $this->PolicyTypeSoldCollection->getActivePolicies();


		$this->load->view('header', $data);
		$this->load->view('pages/summary');
		$this->load->view('footer', $data);
	}
}
