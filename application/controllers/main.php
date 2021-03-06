<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

	public function index(){  //首頁
		//user_log
		if(empty($_COOKIE['log_time'])){
			$this->load->model('UserModel');
			$result = $this->UserModel->user_log('');
			setcookie('log_time','time',time()+30);
		}
		$data['css'] = array('/css/product.css');
		$this->load->view('index',$data);
	}

	public function main_page($index){  //首頁
		//user_log
		if(empty($_COOKIE['log_time'])){
			$this->load->model('UserModel');
			$result = $this->UserModel->user_log('');
			setcookie('log_time','time',time()+30);
		}

		$data['index'] = $index;
		$data['css'] = array('/css/product.css');
		$this->load->view('index',$data);
	}

	public function basket(){ //購物籃
		$data['pageTitle'] = '購物籃';
		$data['js'] = array('/js/basket_action.js','/js/basket.js');
		$this->load->view('/main/basket',$data);
	}

	public function post_data(){ //收件資料
		session_start();
		if(!isset($_SESSION['user'])){
			redirect(site_url("/user/login_page/_"));
			return false;
		}

		// 未完成訂單
		$this->load->model('OrderModel');
		$result = $this->OrderModel->get_temp_order($_SESSION['user']->ID);

		if($result){ // true 有未完成訂單 , 防止user直接打網址進來
			$data['js'] = array('/js/order.js');
			$this->load->view('/main/post_data',$data);
		}
		else{
			redirect(site_url("/"));
			return false;
		}
	}

	public function finish_buying(){ //完成訂購
		session_start();
		if(!isset($_SESSION['finish_order']) || !$_SESSION['finish_order']){
			redirect(site_url("/"));
			return false;
		}
		else{
			// unset($_SESSION['finish_order']);
			$this->load->model('OrderModel');
			$data['order'] = $this->OrderModel->get_order($_SESSION['order_id']);
			$this->load->view('/main/finish_buying',$data);
		}
	}

	public function rule(){  //首頁
		$this->load->view('/user/rule');
	}

	public function close_site(){ //關閉網站
		session_destroy();
	}

}

