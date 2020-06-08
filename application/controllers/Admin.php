<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Admin_model', 'am');
		$this->load->model('Main_model', 'mm');
		$this->load->model('Jabatan_model', 'jm');
	}

	public function index()
	{
		$this->mm->check_status_login();
		$data['dataUser'] = $this->mm->getDataUser();
		$data['title'] = 'Dasbor - ' . $data['dataUser']['username'];
		$this->load->view('templates/header-admin', $data);
		$this->load->view('admin/index', $data);
		$this->load->view('templates/footer-admin', $data);
	}

	public function profile()
	{
		$this->mm->check_status_login();
		$data['dataUser'] = $this->mm->getDataUser();
		$data['jabatan'] = $this->jm->getAllJabatan();
		$data['title'] = 'Profil - ' . $data['dataUser']['username'];
		$this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required|trim');
		$this->form_validation->set_rules('id_jabatan', 'Nama Jabatan', 'required');
		if ($this->form_validation->run() == false) {
		    $this->load->view('templates/header-admin', $data);
			$this->load->view('admin/profile', $data);
			$this->load->view('templates/footer-admin', $data);
		} else {
		    $this->am->editProfile();
		}
	}

	public function gantiPassword()
	{
		$this->mm->check_status_login();
		$data['dataUser'] = $this->mm->getDataUser();
		$data['jabatan'] = $this->jm->getAllJabatan();
		$data['title'] = 'Profil - ' . $data['dataUser']['username'];
		$this->form_validation->set_rules('password_old', 'Password Lama', 'required');
		$this->form_validation->set_rules('password_new', 'Password Baru', 'required|matches[password_verify]');
		$this->form_validation->set_rules('password_verify', 'Password Verifikasi', 'required|matches[password_new]');
		if ($this->form_validation->run() == false) {
		    $this->load->view('templates/header-admin', $data);
			$this->load->view('admin/profile', $data);
			$this->load->view('templates/footer-admin', $data);
		} else {
		    $this->am->changePassword();
		}
	}
}