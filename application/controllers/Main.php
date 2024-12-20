<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

	public $userData = [];

	public function __construct() {
		parent::__construct();

		// $this->load->model('CommonModel');

	}

	function index() {
		$data['title'] = 'CodeIgniter Simple Login form With Session';
		$this->load->view("login", $data);
	}

	function login() {
		$data['title'] = 'CodeIgniter Simple Login form With Session';
		$this->load->view("login", $data);
	}

	function login_validation() {

		$this->load->library('form_validation');
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		if ($this->form_validation->run()) {

			$UserName = $this->input->post('username');
			$Password = $this->input->post('password');

			$Url = getenv('SERVICE_HOST').'/api/users/verify-user';
			$PostData = json_encode(["UserName"=>$UserName, "Password" => $Password]);
			$Header = array('Authorization: Bearer ', 'Content-Type: application/json');
			$ServiceResponse = $this->curlrequest->ServiceRequest($Url, 'POST', $Header, $PostData);

			if($ServiceResponse->Status) {

				if(!$ServiceResponse->Data->Data->UserID) {
					$this->session->set_flashdata('error', 'OOPS! Something went wrong.!');
					redirect(base_url() . 'main/login');
				} else {

					$this->load->library('rediscache');

					$getCacheData = $this->rediscache->get(base64_encode($ServiceResponse->Data->Data->UserID));
					if($getCacheData->Status) {

						set_cookie(getenv('JWT_COOKIE_NAME'), $getCacheData->Data->JwtToken, 43200);
						redirect(base_url() . 'main/enter');

					} else {

						$this->session->set_flashdata('error', 'OOPS! Something went wrong.!');
						redirect(base_url() . 'main/login');

					}

				}

			} else {
				$this->session->set_flashdata('error', $ServiceResponse->Message);
				redirect(base_url() . 'main/login');
			}

		} else {
			$this->login();
		}

	}

	function enter() {
		
		$data['medicine_qty'] = 0; //count($this->CommonModel->get_all_info('create_medicine_name')); //

		//Toda's Puchase Amount
		$where_array = array(
			"date" => date('Y-m-d')
		);
		$today_purchase = []; //$this->CommonModel->group_by_data_where("insert_purchase_info", $where_array, "purchase_id");
		$total_today_purchase = 0;
		foreach ($today_purchase as $today_sales_info) {
			$total_today_purchase += $today_sales_info->purchase_price;
		}
		$data['today_purchase_number'] = $total_today_purchase;

		//Due Puchase Amount
		$purchase_due = []; // $this->CommonModel->get_all_info("insert_purchase_info");
		$total_due = 0; $price=0;$pay=0;
		foreach ($purchase_due as $info) {
			$price= $info->purchase_price;
			$pay= $info->purchase_paid;
			$total_due +=$price - $pay;
		}
		$data['today_due'] = $total_due;

		// Sales of Month
		$array_check = array(
			"date>=" => date('Y-m-d', strtotime('-1 month')),
			"date<=" => date('Y-m-d')
		);
		$monthly_sales_result = []; // $this->CommonModel->group_by_data_where("sales_product", $array_check, "sales_id");
		$total_monthly_sales = 0;
		foreach ($monthly_sales_result as $monthly_sales_info) {
			$total_monthly_sales += $monthly_sales_info->discount_price;
		}
		$data['monthly_sales_number'] = $total_monthly_sales;

		//Toda's Sales Amount
		$where_array_sale = array(
			"date" => date('Y-m-d')
		);
		$today_sale = []; //$this->CommonModel->group_by_data_where("sales_product", $where_array_sale, "sales_id");
		$total_today_sales = 0;
		foreach ($today_sale as $today_sales_info) {
			$total_today_sales += $today_sales_info->discount_price;
		}
		$data['today_sale_number'] = $total_today_sales;
		//Expire Date
		$array_check_near_expire = array(
			"expiredate<=" => date('Y-m-d')
		);
		$data['near_expired_product'] = 0; //count($this->CommonModel->get_all_info_by_array('insert_purchase_info', $array_check_near_expire));

		//END Dash Data

		$this->load->view("header");
		$this->load->view("dashboard",$data);
		$this->load->view("footer");
			
	}

	function logout() {

		if(empty($this->userData)) {
			redirect(base_url() . 'main/login');
		} else {

			$this->load->library('rediscache');
			$RedisStatus = $this->rediscache->delete($this->userData['RedisKey']);

			delete_cookie(getenv('JWT_COOKIE_NAME'));

			redirect(base_url() . 'main/login');

		}

	}

}