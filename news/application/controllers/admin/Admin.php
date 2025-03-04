<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		if (!$this->ion_auth->is_admin()) redirect("https://" . parse_url(BASE_URL)['host'] . "/admin");

		define("HOOSK_ADMIN", 1);
		$this->load->helper(array('admincontrol', 'url', 'hoosk_admin', 'form'));
		//$this->load->library('session');
		$this->load->model('Hoosk_model');
		define('LANG', $this->Hoosk_model->getLang());
		$this->lang->load('admin', LANG);
		define('SITE_NAME', $this->Hoosk_model->getSiteName());
		define('THEME', $this->Hoosk_model->getTheme());
		define('THEME_FOLDER', BASE_URL . '/theme/' . THEME);
	}

	public function index()
	{
		$this->data['current'] = $this->uri->segment(2);
		$this->data['recenltyUpdated'] = $this->Hoosk_model->getUpdatedPages();
		if (RSS_FEED) {
			$this->load->library('rssparser');
			$this->rssparser->set_feed_url('http://hoosk.org/feed/rss');
			$this->rssparser->set_cache_life(30);
			$this->data['hooskFeed'] = $this->rssparser->getFeed(3);
		}
		$this->data['maintenaceActive'] = $this->Hoosk_model->checkMaintenance();
		$this->data['header'] = $this->load->view('admin/header', $this->data, true);
		$this->data['footer'] = $this->load->view('admin/footer', '', true);
		$this->load->view('admin/home', $this->data);
	}
	public function upload()
	{

		$attachment = $this->input->post('attachment');
		$uploadedFile = $_FILES['attachment']['tmp_name']['file'];

		$path = str_replace("/application/", "", APPPATH) . '/images';
		$url = BASE_URL . '/images';

		// create an image name
		$fileName = $attachment['name'];

		// upload the image
		move_uploaded_file($uploadedFile, $path . '/' . $fileName);

		$this->output->set_output(
			json_encode(array('file' => array(
				'url' => $url . '/' . $fileName,
				'filename' => $fileName
			))),
			200,
			array('Content-Type' => 'application/json')
		);
	}

	public function login()
	{
		$this->data['header'] = $this->load->view('admin/headerlog', '', true);
		$this->data['footer'] = $this->load->view('admin/footer', '', true);
		$this->load->view('admin/login', $this->data);
	}

	public function loginCheck()
	{
		$username = $this->input->post('username');
		$password = md5($this->input->post('password') . SALT);
		$result = $this->Hoosk_model->login($username, $password);
		if ($result) {
			redirect(BASE_URL . '/admin/posts', 'refresh');
		} else {
			$this->data['error'] = "1";
			$this->login();
		}
	}
	// function ajaxLogin()
	// {
	// 	$username = $this->input->post('username');
	// 	$password = md5($this->input->post('password') . SALT);
	// 	$result = $this->Hoosk_model->login($username, $password);
	// 	if ($result) {
	// 		echo 1;
	// 	} else {
	// 		echo 0;
	// 	}
	// }
	public function logout()
	{
		$data = array(
			'userID'    => 	'',
			'userName'  => 	'',
			'logged_in'	=> 	FALSE,
		);
		$this->session->unset_userdata($data);
		$this->session->sess_destroy();
		$this->login();
	}


	public function settings()
	{

		$this->load->helper('directory');
		$this->data['themesdir'] = directory_map(str_replace("/application/", "", APPPATH) . '/theme/', 1);
		$this->data['langdir'] = directory_map(APPPATH . '/language/', 1);

		$this->data['settings'] = $this->Hoosk_model->getSettings();
		$this->data['current'] = $this->uri->segment(2);
		$this->data['header'] = $this->load->view('admin/header', $this->data, true);
		$this->data['footer'] = $this->load->view('admin/footer', '', true);
		$this->load->view('admin/settings', $this->data);
	}

	public function updateSettings()
	{

		$path_upload = str_replace("/application/", "", APPPATH) . '/uploads/';
		$path_images = str_replace("/application/", "", APPPATH) . '/images/';
		if ($this->input->post('siteLogo') != "") {
			rename($path_upload . $this->input->post('siteLogo'), $path_images . $this->input->post('siteLogo'));
		}
		if ($this->input->post('siteFavicon') != "") {
			rename($path_upload . $this->input->post('siteFavicon'), $path_images . $this->input->post('siteFavicon'));
		}
		$this->Hoosk_model->updateSettings();
		redirect(BASE_URL . '/admin', 'refresh');
	}

	public function uploadLogo()
	{

		$config['upload_path']          = './uploads/';
		$config['allowed_types']        = 'gif|jpg|png';

		$this->load->library('upload', $config);
		foreach ($_FILES as $key => $value) {
			if (!$this->upload->do_upload($key)) {
				$error = array('error' => $this->upload->display_errors());
				echo 0;
			} else {
				echo '"' . $this->upload->data('file_name') . '"';
			}
		}
	}

	public function social()
	{
		$this->data['social'] = $this->Hoosk_model->getSocial();
		$this->data['current'] = $this->uri->segment(2);
		$this->data['header'] = $this->load->view('admin/header', $this->data, true);
		$this->data['footer'] = $this->load->view('admin/footer', '', true);
		$this->load->view('admin/social', $this->data);
	}

	public function updateSocial()
	{

		$this->Hoosk_model->updateSocial();
		redirect(BASE_URL . '/admin', 'refresh');
	}

	public function checkSession()
	{
		if ($this->ion_auth->is_admin()) {
			return 1;
		} else {
			return 0;
		}
	}

	public function complete()
	{
		unlink(FCPATH . "install/hoosk.sql");
		unlink(FCPATH . "install/index.php");
		redirect(BASE_URL . '/admin', 'refresh');
	}
}
