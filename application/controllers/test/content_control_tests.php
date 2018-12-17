<?php
require_once APPPATH . '/controllers/test/Toast.php';

class Content_control_tests extends Toast
{
	private $_intContentControlID;

	function Content_control_tests()
	{
		parent::Toast(__FILE__);

		//load Content_control_Option model
		if (! isset($this->Content_Control))
		{
			$this->load->model('Content_Control', '', TRUE);
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
		if (!empty($this->_intContentControlID)) {
			$data = array();
			$this->Content_Control->deleteContentControl($this->_intContentControlID);
		}
	}	
	
	function test_addContentControl(){
		$this->_intContentControlID = $this->Content_Control->addContentControl();		
		$this->_assert_not_empty($this->_intContentControlID);
	}
	
	function test_getLastUpdate(){
		$this->_assert_not_empty($this->Content_Control->getLastUpdate());
	}
	
	function test_deleteContentControl(){
		$intContentControlID = $this->Content_Control->addContentControl();
		$this->_assert_true($this->Content_Control->deleteContentControl($intContentControlID));
	}
}