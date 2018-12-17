<?php
require_once APPPATH . 'libraries/REST_Controller.php';
require_once APPPATH . 'libraries/clients/api_admin_client.php';

class api_admin extends REST_Controller {

	public function __construct()
	{
		parent::__construct();
		if (! isset($this->Guest))
		{
			$this->load->model('Admin', '', TRUE);
		}
		if (! isset($this->Content_Control))
		{
			$this->load->model('Content_Control', '', TRUE);
		}
	}

	/**
	 * @method get
	 * @return json/xml data
	 */
	public function admins_get()
	{		
		$get = $this->input->get();
		$data = $this->Admin->getAllAdmins($get);
		$result = !empty($data) ? array('result'=>$data) : array('error'=>'No record found');
		$this->response($result);
	}	
	
}