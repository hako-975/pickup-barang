<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Auth_model', 'am');
	}
	
	public function index()
	{
		if ($this->session->userdata('id_user')) {
			redirect('admin');
		}

		$data['title'] = 'Masuk - Pickup Barang';
		$this->form_validation->set_rules('username', 'Username', 'required|trim');
		$this->form_validation->set_rules('password', 'Password', 'required');
		if ($this->form_validation->run() == FALSE) {
			$this->load->view('templates/header-auth', $data);
			$this->load->view('auth/login', $data);
			$this->load->view('templates/footer-auth', $data);
		} else {
			$this->am->login();
		}
	}

	public function logout()
	{
		if ($this->session->userdata('id_user')) {
			$this->mm->createLog('Pengguna ' . $this->session->userdata('username') . ' berhasil logout' , $this->session->userdata('id_user'));
		}

		$this->session->unset_userdata('id_user');
		$this->session->unset_userdata('id_outlet');
		$this->session->unset_userdata('id_jabatan');
		$this->session->unset_userdata('username');
		session_destroy();
		redirect('auth');
	}
}
