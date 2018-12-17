<?php
require_once APPPATH . '/controllers/test/Toast.php';

class Attendee_activity_preference_tests extends Toast
{
	private $_intAttendeeActivityPreferenceID;

	function Attendee_activity_preference_tests()
	{
		parent::Toast(__FILE__);

		if (! isset($this->Attendee_Activity_Preference))
		{
			$this->load->model('Attendee_Activity_Preference', '', TRUE);
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
		if (!empty($this->_intAttendeeActivityPreferenceID)) {
			$data = array();
			$data['attendeeActivityPreferenceID'] = $this->_intAttendeeActivityPreferenceID;
			$this->Attendee_Activity_Preference->deleteAttendeeActivityPreference($data);
		}
	}

	function test_addAttendeeActivityPreference(){
		$attendeeActivityPreference = array();
		$attendeeActivityPreference['activityPreferenceID'] = '123';
		$attendeeActivityPreference['activityPreferenceOptionID'] = '1';
		$attendeeActivityPreference['userID'] = '79';
		$attendeeActivityPreference['value'] = '1';

		$this->_intAttendeeActivityPreferenceID = $this->Attendee_Activity_Preference->addAttendeeActivityPreference($attendeeActivityPreference);
		$this->_assert_not_empty($this->_intAttendeeActivityPreferenceID );
	}

	function test_updateAttendeeActivityPreference(){
		$attendeeActivityPreference = array();
		$attendeeActivityPreference['activityPreferenceID'] = '123';
		$attendeeActivityPreference['activityPreferenceOptionID'] = '1';
		$attendeeActivityPreference['userID'] = '79';
		$attendeeActivityPreference['value'] = '1';

		$attendeeActivityPreference['attendeeActivityPreferenceID'] = $this->Attendee_Activity_Preference->addAttendeeActivityPreference($attendeeActivityPreference);

		$attendeeActivityPreference['activityPreferenceID'] = '123';
		$attendeeActivityPreference['activityPreferenceOptionID'] = '1';
		$attendeeActivityPreference['userID'] = '79';
		$attendeeActivityPreference['value'] = '2';

		$this->_intAttendeeActivityPreferenceID = $this->Attendee_Activity_Preference->updateAttendeeActivityPreference($attendeeActivityPreference);
		$this->_assert_not_empty($this->_intAttendeeActivityPreferenceID );
	}

	function test_deleteAttendeeActivityPreference(){
		$attendeeActivityPreference = array();
		$attendeeActivityPreference['activityPreferenceID'] = '123';
		$attendeeActivityPreference['activityPreferenceOptionID'] = '1';
		$attendeeActivityPreference['userID'] = '79';
		$attendeeActivityPreference['value'] = '1';

		$attendeeActivityPreference['attendeeActivityPreferenceID'] = $this->Attendee_Activity_Preference->addAttendeeActivityPreference($attendeeActivityPreference);

		$this->_assert_true($this->Attendee_Activity_Preference->deleteAttendeeActivityPreference($attendeeActivityPreference));
	}
	
	function test_getAttendeeActivityPreferences(){
		$attendeeActivityPreference = array();
		$attendeeActivityPreference['activityPreferenceID'] = '123';
		$attendeeActivityPreference['activityPreferenceOptionID'] = '1';
		$attendeeActivityPreference['userID'] = '79';
		$attendeeActivityPreference['value'] = '1';

		$this->_intAttendeeActivityPreferenceID = $this->Attendee_Activity_Preference->addAttendeeActivityPreference($attendeeActivityPreference);
		
		$searchData = array();
		$searchData['attendeeActivityPreferenceID'] = $this->_intAttendeeActivityPreferenceID;
		$this->_assert_not_empty($this->Attendee_Activity_Preference->getAttendeeActivityPreferences($searchData));
	}
	
	function test_getNumAttendeeActivityPreferences(){
		$intSearchResult = 0;
		$intSearchResult = $this->Attendee_Activity_Preference->getNumAttendeeActivityPreferences();
		$this->_assert_not_empty($intSearchResult);
	}
}