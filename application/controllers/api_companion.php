<?php
require_once APPPATH . 'libraries/REST_Controller.php';
require_once APPPATH . 'libraries/clients/api_companion_client.php';

class api_companion extends REST_Controller {

	public function __construct()
	{
		parent::__construct();
		if (! isset($this->Guest))
		{
			$this->load->model('Companion', '', TRUE);
		}
		if (! isset($this->Content_Control))
		{
			$this->load->model('Content_Control', '', TRUE);
		}
	}

	/**
	 * @method get
	 * @param int primary_user_id // primary_user_id
	 * @param string type // companion type('child','adult')
	 * @return json/xml data
	 */
	public function companions_get()
	{		
		$get = $this->input->get();
		$data = $this->Companion->getAllCompanions($get);
		$result = !empty($data) ? array('result'=>$data) : array('error'=>'No record found');
		$this->response($result);
	}
	
	/**
	 * @method get
	 * @param int user_id // user id
	 * @return json/xml data
	 */
	public function companion_primary_user_get()
	{		
		$get = $this->input->get();
		$data = $this->Companion->getPrimaryUser($get);
		$result =  array('result'=>$data);
		$this->response($result);
	}	
}