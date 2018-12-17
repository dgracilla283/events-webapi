<?php
require_once APPPATH . 'libraries/REST_Controller.php';
require_once APPPATH . 'libraries/clients/api_activation_key_client.php';

class api_activation_key extends REST_Controller {

	function __construct()
	{
		parent::__construct();
		// load users model
		if (! isset($this->Activation_Key))
		{
			$this->load->model('Activation_Key', '', TRUE);
		}
	}

	/**
	 * @method get
	 * @return json/xml data
	 */
	public function activation_keys_get()
	{ 
		$options = $this->input->get(); 
		$activationKeyData = array();
		$activationKeyData = $this->Activation_Key->getAllActivationKeys();
		$arrResponse = array(
			'result' => $activationKeyData
		);
			
		$this->response($arrResponse);
	}

	/**
	 * @method get
	 * @param int user_id // the user_id of the user to fetch
	 * @param int key // key generated 
	 * @return json/xml data
	 */
	public function activation_key_get()
	{
		$user_id = $this->input->get('user_id');
		$key = $this->input->get('key');	
		
		$objActivationKeyClient = new api_activation_key_client();
		$data = $objActivationKeyClient->activation_keys_get(false, 'json');
		
		$newActivationKeyData = array();
		foreach($data['result'] as $activationKeyData) {
			$newActivationKeyData[$activationKeyData['user_id']][$activationKeyData['key']] = $activationKeyData;
		}
		$result = array('result'=>false);
		if (!empty($newActivationKeyData[$user_id][$key])) {
			$result = array('result'=>$newActivationKeyData[$user_id][$key]);
		}
		
		$this->response($result);
	}

	/**
	 * @method get
	 * @param int user_id 
	 * @param string key
	 * @param int activationKeyID 
	 * @return json/xml data
	 */
	public function add_activation_key_get()
	{
		$user_id = $this->input->get('user_id');
		$key = $this->input->get('key');
		$activationKeyID = $this->input->get('activationKeyID');
		
		$objActivationKeyClient = new api_activation_key_client();
		$data = array();
		if (!empty($user_id) && !empty($key)) {				
			$activationKeyID = $this->Activation_Key->addActivationKey(array(
										'user_id'=>$user_id,
										'key'=>$key,
										));
			$data = $objActivationKeyClient->activation_key_get(array('user_id'=>$user_id,'key'=>$key ), 'json');
			
		}		
		$this->response($data);
	}	
	
	/**
	 * @method post
	 * @return json/xml data
	 */
	public function update_activation_key_post()
	{
		$post = $this->input->post();	
		$activationKeyID = $this->Activation_Key->updateActivationKey($post);	
		
		$objActivationKeyClient = new api_activation_key_client();
		$data = $objActivationKeyClient->activation_key_get(array('user_id'=>$post['user_id'],'key'=>$post['key'] ), 'json');
		$this->response($data);
	}	
}