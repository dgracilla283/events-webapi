<?php
require_once APPPATH . '/controllers/test/Toast.php';

class Activity_preference_option_tests extends Toast
{
	private $_intActivityPreferenceOptionID;

	function Activity_preference_option_tests()
	{
		parent::Toast(__FILE__);

		if (! isset($this->Activity_Preference_Option))
		{
			$this->load->model('Activity_Preference_Option', '', TRUE);
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
		if (!empty($this->_intActivityPreferenceOptionID)) {
			$data = array();
			$data['activityPreferenceOptionID'] = $this->_intActivityPreferenceOptionID;
			$this->Activity_Preference_Option->deleteActivityPreferenceOption($data);
		}
	}

	function test_addActivityPreferenceOption(){
		$activityPreferenceOptionData = array();
		$activityPreferenceOptionData['activityPreferenceID'] = '100';
		$activityPreferenceOptionData['title'] = 'Option Here - Test Add';
		$activityPreferenceOptionData['description'] = 'Description Here';

		$this->_intActivityPreferenceOptionID  = $this->Activity_Preference_Option->addActivityPreferenceOption($activityPreferenceOptionData);
		$this->_assert_not_empty($this->_intActivityPreferenceOptionID );
	}

	function test_updateActivityPreferenceOption(){
		$activityPreferenceOptionData = array();
		$activityPreferenceOptionData['activityPreferenceID'] = '100';
		$activityPreferenceOptionData['title'] = 'Option Here - Test Update';
		$activityPreferenceOptionData['description'] = 'Description Here';

		$activityPreferenceOptionData['activityPreferenceOptionID'] = $this->Activity_Preference_Option->addActivityPreferenceOption($activityPreferenceOptionData);

		$activityPreferenceOptionData['activityPreferenceID'] = '100';
		$activityPreferenceOptionData['title'] = 'Updated Option Here';
		$activityPreferenceOptionData['description'] = 'Updated Description Here';

		$this->_intActivityPreferenceOptionID = $this->Activity_Preference_Option->updateActivityPreferenceOption($activityPreferenceOptionData);
		$this->_assert_not_empty($this->_intActivityPreferenceOptionID );
	}

	function test_deleteActivityPreferenceOption(){
		$activityPreferenceOptionData = array();
		$activityPreferenceOptionData['activityPreferenceID'] = '100';
		$activityPreferenceOptionData['title'] = 'Option Here - Test Delete';
		$activityPreferenceOptionData['description'] = 'Description Here';

		$activityPreferenceOptionData['activityPreferenceOptionID'] = $this->Activity_Preference_Option->addActivityPreferenceOption($activityPreferenceOptionData);

		$this->_assert_true($this->Activity_Preference_Option->deleteActivityPreferenceOption($activityPreferenceOptionData));
	}

	function test_getActivityPreferenceOptions(){
		$activityPreferenceOptionData = array();
		$activityPreferenceOptionData['activityPreferenceID'] = '100';
		$activityPreferenceOptionData['title'] = 'Option Here - Test Get Activity Preference Options';
		$activityPreferenceOptionData['description'] = 'Description Here';

		$this->_intActivityPreferenceOptionID = $this->Activity_Preference_Option->addActivityPreferenceOption($activityPreferenceOptionData);
		
		$searchData = array();
		$searchData['activityPreferenceOptionID'] = $this->_intActivityPreferenceOptionID;
		$this->_assert_not_empty($this->Activity_Preference_Option->getActivityPreferenceOptions($searchData));
	}

	function test_getNumActivityPreferenceOptions(){
		$intSearchResult = 0;
		$intSearchResult = $this->Activity_Preference_Option->getNumActivityPreferenceOptions();
		$this->_assert_not_empty($intSearchResult);
	}


}