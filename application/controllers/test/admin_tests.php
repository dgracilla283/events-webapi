<?php
require_once APPPATH . '/controllers/test/Toast.php';

class Admin_tests extends Toast
{
	private $_intAdminID;

	function Admin_tests()
	{
		parent::Toast(__FILE__);

		//load Activity_Preference_Option model
		if (! isset($this->Admin))
		{
			$this->load->model('Admin', '', TRUE);
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
	}
	
	function test_getAllAdmins(){
		$arrResult = array();
		$arrResult = $this->Admin->getAllAdmins();
		$this->_assert_not_empty($arrResult);
	}
}