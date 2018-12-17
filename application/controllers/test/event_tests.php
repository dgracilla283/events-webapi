<?php
require_once APPPATH . '/controllers/test/Toast.php';

class Event_tests extends Toast
{
	private $_intEventID;

	function Event_tests()
	{
		parent::Toast(__FILE__);

		//load Event_Option model
		if (! isset($this->Event))
		{
			$this->load->model('Event', '', TRUE);
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
		if (!empty($this->_intEventID)) {
			$data = array();
			$data['eventID'] = $this->_intEventID;
			$this->Event->deleteEvent($data);
		}
	}

	function test_addEvent(){
		$eventData = array();
		$eventData['title'] = 'Event';
		$eventData['description'] = 'description';
		$eventData['start_date_time'] = '2013-03-28 08:00:00';
		$eventData['end_date_time'] = '2013-03-02 21:00:00';
		$eventData['location'] = 'Some Preference Name Delete';
		$eventData['additional_info'] = 'additional info';
		$eventData['status'] = '0';

		$this->_intEventID = $this->Event->addEvent($eventData);
		$this->_assert_not_empty($this->_intEventID );
	}

	function test_updateEvent(){
		$eventData = array();
		$eventData['title'] = 'Event';
		$eventData['description'] = 'description';
		$eventData['start_date_time'] = '2013-03-28 08:00:00';
		$eventData['end_date_time'] = '2013-03-02 21:00:00';
		$eventData['location'] = 'Some Preference Name Delete';
		$eventData['additional_info'] = 'additional info';
		$eventData['status'] = '0';

		$eventData['eventID'] = $this->Event->addEvent($eventData);
		
		$eventData['title'] = 'Event - Update Event';
		$eventData['description'] = 'description';
		$eventData['start_date_time'] = '2013-03-28 08:00:00';
		$eventData['end_date_time'] = '2013-03-02 21:00:00';
		$eventData['location'] = 'Some Preference Name Delete';
		$eventData['additional_info'] = 'additional info';
		$eventData['status'] = '0';

		$this->_intEventID = $this->Event->updateEvent($eventData);
		$this->_assert_not_empty($this->_intEventID);
	}

	function test_deleteEvent(){
		$eventData = array();
		$eventData['title'] = 'Event - Delete Event';
		$eventData['description'] = 'description';
		$eventData['start_date_time'] = '2013-03-28 08:00:00';
		$eventData['end_date_time'] = '2013-03-02 21:00:00';
		$eventData['location'] = 'Some Preference Name Delete';
		$eventData['additional_info'] = 'additional info';
		$eventData['status'] = '0';

		$eventData['eventID'] = $this->Event->addEvent($eventData);

		$this->_assert_true($this->Event->deleteEvent($eventData));
	}
	
	function test_getAllEvents(){		
		$eventData = array();
		$eventData['title'] = 'Event - Get All Event';
		$eventData['description'] = 'some description';
		$eventData['start_date_time'] = '2013-03-28 08:00:00';
		$eventData['end_date_time'] = '2013-03-02 21:00:00';
		$eventData['location'] = 'Some Preference Name Delete';
		$eventData['additional_info'] = 'additional info';
		$eventData['status'] = '0';

		$this->_intEventID = $this->Event->addEvent($eventData);
		
		$searchData = array();
		$searchData['eventID'] = $this->_intEventID;
		$this->_assert_not_empty($this->Event->getAllEvents($searchData));
	}
	
	function test_getNumEvents(){
		$intSearchResult = 0;
		$intSearchResult = $this->Event->getNumEvents();
		$this->_assert_not_empty($intSearchResult);
	}
}