<?php
require_once APPPATH . '/controllers/test/Toast.php';
require_once APPPATH . 'libraries/clients/api_activation_key_client.php';

class Activation_key_tests extends Toast
{
	private $_intActivationKeyID;
	
	function Activation_key_tests()
	{
		parent::Toast(__FILE__);
		
		//load activation_key model	
	// load users model
		if (! isset($this->Activation_Key))
		{
			$this->load->model('Activation_Key', '', TRUE);
		}
	}

	/**
	 * anything here will be run before each test
	 */
	function _pre() {
	
	}

	/**
	 * post process
	 */
	function _post() {
		if (!empty($this->_intActivationKeyID)) {
			$data = array();
			$data['activationKeyID'] = $this->_intActivationKeyID;
			$this->Activation_Key->deleteActivationKey($data);
		}
	}

	function test_getAllActivationKeys()
	{
		$arrResult = $this->Activation_Key->getAllActivationKeys();		
		$this->_assert_not_empty($arrResult);
	}
	
	function test_addActivationKey()
	{
		$data = array();
		$data['user_id'] = '1';
		$data['key'] = 'ABCDEFGHIJ';
		
		$this->_intActivationKeyID = $this->Activation_Key->addActivationKey($data);		
		$this->_assert_not_empty($this->_intActivationKeyID);
	}
	
	function test_updateActivationKey()
	{
		$data = array();
		$data['user_id'] = '1';
		$data['key'] = 'ABCDEFGHIJ';
		$data['activationKeyID'] = $this->Activation_Key->addActivationKey($data);
		
		$data['status'] = '1';		
		$this->_intActivationKeyID = $this->Activation_Key->updateActivationKey($data);		
		$this->_assert_not_empty($this->_intActivationKeyID);
	}
	
	function test_deleteActivationKey()
	{
		$data = array();
		$data['user_id'] = '1';
		$data['key'] = 'ABCDEFGHIJ';
		$data['activationKeyID'] = $this->Activation_Key->addActivationKey($data);
		
		$this->_assert_true($this->Activation_Key->deleteActivationKey($data));
	}
		
}