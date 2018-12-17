<?php
require_once APPPATH . '/controllers/test/Toast.php';

class Guest_tests extends Toast
{
	private $_intEventAttendeeID;
	private $_intUserID;

	function Guest_tests()
	{
		parent::Toast(__FILE__);

		if (! isset($this->Guest))
		{
			$this->load->model('Guest', '', TRUE);
		}

		if (! isset($this->User))
		{
			$this->load->model('User', '', TRUE);
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
		if (!empty($this->_intEventAttendeeID)) {
			$data = array();
			$data['eventAttendeeID'] = $this->_intEventAttendeeID;
			$this->Guest->deleteGuest($data);
		}

		if (!empty($this->_intUserID)) {
			$data = array();
			$data['userID'] = $this->_intUserID;
			$this->User->deleteUser($data);
		}
	}

	function test_addGuest(){
		$guestData = array();
		$guestData['user_id'] = '79';
		$guestData['event_id'] = '100';
		$guestData['reference_type'] = 'breakout';
		$guestData['reference_id'] = '99';
		$guestData['role_id'] = '2';
		$guestData['team'] = 'Team Name - Add Guest';

		$this->_intEventAttendeeID = $this->Guest->addGuest($guestData);
		$this->_assert_not_empty($this->_intEventAttendeeID );
	}

	function test_updateGuest(){
		$guestData = array();
		$guestData['user_id'] = '79';
		$guestData['event_id'] = '100';
		$guestData['reference_type'] = 'breakout';
		$guestData['reference_id'] = '99';
		$guestData['role_id'] = '2';
		$guestData['team'] = 'Team Name - Guest';

		$this->_intEventAttendeeID  = $this->Guest->addGuest($guestData);

		$guestData['user_id'] = '79';
		$guestData['event_id'] = '100';
		$guestData['reference_type'] = 'breakout';
		$guestData['reference_id'] = '99';
		$guestData['role_id'] = '2';
		$guestData['team'] = 'Team Name - Update Guest';

		$this->_intEventAttendeeID = $this->Guest->updateGuest($guestData, $this->_intEventAttendeeID);
		$this->_assert_not_empty($this->_intEventAttendeeID);
	}

	function test_deleteGuest(){
		$guestData = array();
		$guestData['user_id'] = '79';
		$guestData['event_id'] = '100';
		$guestData['reference_type'] = 'breakout';
		$guestData['reference_id'] = '99';
		$guestData['role_id'] = '2';
		$guestData['team'] = 'Team Name - Delete Guest';

		$this->_intEventAttendeeID = $this->Guest->addGuest($guestData);

		$option = array();
		$option['eventAttendeeID'] = $this->_intEventAttendeeID;
		$this->_assert_true($this->Guest->deleteGuest($option));
	}

	function test_deleteEventGuest(){
		$userData = array();
		$userData['email'] = 'test@rcggs.com';
		$userData['password'] = '12345password';
		$userData['first_name'] = 'John';
		$userData['last_name'] = 'Doe';
		$userData['affiliation'] = 'Affiliation';
		$userData['industry'] = 'additional info';
		$userData['title'] = 'title';
		$userData['bio'] = 'info here';
		$userData['is_primary'] = '1';
		$this->_intUserID = $this->User->addUser($userData);
		
		$guestData = array();
		$guestData['user_id'] = $this->_intUserID;
		$guestData['event_id'] = '100';
		$guestData['reference_type'] = 'breakout';
		$guestData['reference_id'] = '99';
		$guestData['role_id'] = '2';
		$guestData['team'] = 'Team Name - Delete Event Guest';

		$this->_intEventAttendeeID = $this->Guest->addGuest($guestData);

		$option = array();
		$option['user_id'] = $guestData['user_id'];
		$option['event_id'] = $guestData['event_id'];
		$this->_assert_true($this->Guest->deleteEventGuest($option));
	}

	function test_deleteGuestByReferenceID(){
		$userData = array();
		$userData['email'] = 'test@rcggs.com';
		$userData['password'] = '12345password';
		$userData['first_name'] = 'John';
		$userData['last_name'] = 'Doe';
		$userData['affiliation'] = 'Affiliation';
		$userData['industry'] = 'additional info';
		$userData['title'] = 'title';
		$userData['bio'] = 'info here';
		$userData['is_primary'] = '1';
		$this->_intUserID = $this->User->addUser($userData);
		
		$guestData = array();
		$guestData['user_id'] = $this->_intUserID;
		$guestData['event_id'] = '100';
		$guestData['reference_type'] = 'breakout';
		$guestData['reference_id'] = '88888';
		$guestData['role_id'] = '2';
		$guestData['team'] = 'Team Name - Delete Guest By Reference ID';

		$this->_intEventAttendeeID = $this->Guest->addGuest($guestData);

		$option = array();
		$option['reference_id'] = $guestData['reference_id'];
		$this->_assert_true($this->Guest->deleteGuestByReferenceID($option));
	}

	function test_deleteGuestByUserID(){
		$userData = array();
		$userData['email'] = 'test@rcggs.com';
		$userData['password'] = '12345password';
		$userData['first_name'] = 'John';
		$userData['last_name'] = 'Doe';
		$userData['affiliation'] = 'Affiliation';
		$userData['industry'] = 'additional info';
		$userData['title'] = 'title';
		$userData['bio'] = 'info here';
		$userData['is_primary'] = '1';
		$this->_intUserID = $this->User->addUser($userData);
		
		$guestData = array();
		$guestData['user_id'] = $this->_intUserID;
		$guestData['event_id'] = '100';
		$guestData['reference_type'] = 'breakout';
		$guestData['reference_id'] = '99';
		$guestData['role_id'] = '2';
		$guestData['team'] = 'Team Name - Delete Guest By User ID';

		$this->_intEventAttendeeID = $this->Guest->addGuest($guestData);

		$option = array();
		$option['uid'] = $guestData['user_id'];
		$this->_assert_true($this->Guest->deleteGuestByUserID($option));
	}

	function test_getAllGuests(){
		$userData = array();
		$userData['email'] = 'test@rcggs.com';
		$userData['password'] = '12345password';
		$userData['first_name'] = 'John';
		$userData['last_name'] = 'Doe';
		$userData['affiliation'] = 'Affiliation';
		$userData['industry'] = 'additional info';
		$userData['title'] = 'title';
		$userData['bio'] = 'info here';
		$userData['is_primary'] = '1';
		$this->_intUserID = $this->User->addUser($userData);
		
		$guestData = array();
		$guestData['user_id'] = $this->_intUserID;
		$guestData['event_id'] = '100';
		$guestData['reference_type'] = 'breakout';
		$guestData['reference_id'] = '99';
		$guestData['role_id'] = '2';
		$guestData['team'] = 'Team - Get All Guests';

		$this->_intEventAttendeeID = $this->Guest->addGuest($guestData);
			
		$searchData = array();
		$searchData['userID'] = $guestData['user_id'];
		$this->_assert_not_empty($this->Guest->getAllGuests($searchData));
	}

	function test_getNumGuests(){
		$this->_assert_not_empty($this->Guest->getNumGuests());
	}

	function test_getEventSpeaker(){
		$this->_assert_not_empty($this->Guest->getEventSpeaker());
	}

	function test_searchGuestByName(){
		$userData = array();
		$userData['email'] = 'test@rcggs.com';
		$userData['password'] = '12345password';
		$userData['first_name'] = 'John';
		$userData['last_name'] = 'Doe';
		$userData['affiliation'] = 'Affiliation';
		$userData['industry'] = 'additional info';
		$userData['title'] = 'title';
		$userData['bio'] = 'info here';
		$userData['is_primary'] = '1';
		$this->_intUserID = $this->User->addUser($userData);

		$guestData = array();
		$guestData['user_id'] = $this->_intUserID;
		$guestData['event_id'] = '100';
		$guestData['reference_type'] = 'breakout';
		$guestData['reference_id'] = '99';
		$guestData['role_id'] = '2';
		$guestData['team'] = 'Team - Search Guest By Name';

		$this->_intEventAttendeeID = $this->Guest->addGuest($guestData);

		$searchData = array();
		$searchData['name'] = 'Doe';
		$intSearchResult = 0;
		$intSearchResult = $this->Guest->searchGuestByName($searchData);
		$this->_assert_not_empty($intSearchResult);
	}
}