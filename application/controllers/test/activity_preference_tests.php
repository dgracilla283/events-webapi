<?php
require_once APPPATH . '/controllers/test/Toast.php';

class Activity_preference_tests extends Toast
{
	private $_intActivityPreferenceID;

	function Activity_preference_tests()
	{
		parent::Toast(__FILE__);

		//load Activity_Preference_Option model
		if (! isset($this->Activity_Preference))
		{
			$this->load->model('Activity_Preference', '', TRUE);
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
		if (!empty($this->_intActivityPreferenceID)) {
			$data = array();
			$data['activityPreferenceID'] = $this->_intActivityPreferenceID;
			$this->Activity_Preference->deleteActivityPreference($data);
		}
	}

	function test_addActivityPreference(){
		$activityPreferenceData = array();
		$activityPreferenceData['referenceID'] = '123';
		$activityPreferenceData['eventID'] = '12';
		$activityPreferenceData['referenceType'] = 'agenda';
		$activityPreferenceData['optionDisplayType'] = 'checkbox';
		$activityPreferenceData['title'] = 'Some Preference Name';
		$activityPreferenceData['description'] = 'Description of preference';
		$activityPreferenceData['isRequired'] = '0';

		$this->_intActivityPreferenceID = $this->Activity_Preference->addActivityPreference($activityPreferenceData);
		$this->_assert_not_empty($this->_intActivityPreferenceID );
	}

	function test_updateActivityPreference(){
		$activityPreferenceData = array();
		$activityPreferenceData['referenceID'] = '123';
		$activityPreferenceData['eventID'] = '12';
		$activityPreferenceData['referenceType'] = 'agenda';
		$activityPreferenceData['optionDisplayType'] = 'checkbox';
		$activityPreferenceData['title'] = 'Some Preference Name';
		$activityPreferenceData['description'] = 'Description of preference';
		$activityPreferenceData['isRequired'] = '0';

		$activityPreferenceData['activityPreferenceID'] = $this->Activity_Preference->addActivityPreference($activityPreferenceData);

		$activityPreferenceData['referenceID'] = '123';
		$activityPreferenceData['eventID'] = '12';
		$activityPreferenceData['referenceType'] = 'agenda';
		$activityPreferenceData['optionDisplayType'] = 'checkbox';
		$activityPreferenceData['title'] = 'Some Preference Name Update';
		$activityPreferenceData['description'] = 'Description of updated preference';
		$activityPreferenceData['isRequired'] = '0';

		$this->_intActivityPreferenceID = $this->Activity_Preference->updateActivityPreference($activityPreferenceData);
		$this->_assert_not_empty($this->_intActivityPreferenceID );
	}

	function test_deleteActivityPreference(){
		$activityPreferenceData = array();
		$activityPreferenceData['referenceID'] = '123';
		$activityPreferenceData['eventID'] = '12';
		$activityPreferenceData['referenceType'] = 'agenda';
		$activityPreferenceData['optionDisplayType'] = 'checkbox';
		$activityPreferenceData['title'] = 'Some Preference Name Delete';
		$activityPreferenceData['description'] = 'Description of preference';
		$activityPreferenceData['isRequired'] = '0';

		$activityPreferenceData['activityPreferenceID'] = $this->Activity_Preference->addActivityPreference($activityPreferenceData);

		$this->_assert_true($this->Activity_Preference->deleteActivityPreference($activityPreferenceData));
	}
	
	function test_getActivityPreferences(){
		//create first entry
		$activityPreferenceData = array();
		$activityPreferenceData['referenceID'] = '123';
		$activityPreferenceData['eventID'] = '12';
		$activityPreferenceData['referenceType'] = 'agenda';
		$activityPreferenceData['optionDisplayType'] = 'checkbox';
		$activityPreferenceData['title'] = 'Some Preference Name Delete';
		$activityPreferenceData['description'] = 'Description of preference';
		$activityPreferenceData['isRequired'] = '0';

		$this->_intActivityPreferenceID = $this->Activity_Preference->addActivityPreference($activityPreferenceData);
		
		$searchData = array();
		$searchData['activityPreferenceID'] = $this->_intActivityPreferenceID;
		$this->_assert_not_empty($this->Activity_Preference->getActivityPreferences($searchData));
	}
	
	function test_getNumActivityPreferences(){
		$intSearchResult = 0;
		$intSearchResult = $this->Activity_Preference->getNumActivityPreferences();
		$this->_assert_not_empty($intSearchResult);
	}
}