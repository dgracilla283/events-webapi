<?php
require_once APPPATH . '/controllers/test/Toast.php';

class Companion_tests extends Toast
{
	private $_intCompanionID;

	function Companion_tests()
	{
		parent::Toast(__FILE__);

		//load Companion_Option model
		if (! isset($this->Companion))
		{
			$this->load->model('Companion', '', TRUE);
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
		if (!empty($this->_intCompanionID)) {
			$data = array();
			$data['companionID'] = $this->_intCompanionID;
			$this->Companion->deleteCompanion($data);
		}
	}

	function test_addCompanion(){
		$companionData = array();
		$companionData['primary_user_id'] = '1111';
		$companionData['user_id'] = '1000';

		$this->_intCompanionID = $this->Companion->addCompanion($companionData);
		$this->_assert_not_empty($this->_intCompanionID );
	}


	function test_getAllCompanions(){
		//create first entry
		$companionData = array();
		$companionData['primary_user_id'] = '1112';
		$companionData['user_id'] = '2000';

		$this->_intCompanionID = $this->Companion->addCompanion($companionData);

		$searchData = array();
		$searchData['primary_user_id'] = '1112';
		$this->_assert_not_empty($this->Companion->getAllCompanions($searchData));
	}

	function test_getPrimaryUser(){
		//create first entry
		$companionData = array();
		$companionData['primary_user_id'] = '1113';
		$companionData['user_id'] = '3000';

		$this->_intCompanionID = $this->Companion->addCompanion($companionData);

		$searchData = array();
		$searchData['user_id'] = '3000';
		$this->_assert_not_empty($this->Companion->getPrimaryUser($searchData));
	}
	
	function test_deleteCompanion(){
		$companionData = array();
		$companionData['primary_user_id'] = '1114';
		$companionData['user_id'] = '4';

		$companionData['companionID'] = $this->Companion->addCompanion($companionData);

		$this->_assert_true($this->Companion->deleteCompanion($companionData));
	}
}