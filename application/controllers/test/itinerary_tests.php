<?php
require_once APPPATH . '/controllers/test/Toast.php';

class Itinerary_tests extends Toast
{
	private $_intItineraryID;
	private $_intEventID;

	function Itinerary_tests()
	{
		parent::Toast(__FILE__);

		if (! isset($this->Itinerary))
		{
			$this->load->model('Itinerary', '', TRUE);
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
		if (!empty($this->_intItineraryID)) {
			$data = array();
			$data['itineraryID'] = $this->_intItineraryID;
			$data['event_id'] = $this->_intEventID;
			$this->Itinerary->deleteItinerary($data);
		}
	}

	function test_addItinerary(){
		$itineraryData = array();
		$itineraryData['event_id'] = '40';
		$itineraryData['title'] = 'itinerary - itinerary';
		$itineraryData['description'] = 'some description';
		$itineraryData['start_date_time'] = '2013-03-02 19:00:00';
		$itineraryData['end_date_time'] = '2013-03-02 21:00:00';
		$itineraryData['location'] = 'Clubhouse Test';
		$itineraryData['status'] = '0';		
		
		$this->_intEventID = $itineraryData['event_id'];
		$this->_intItineraryID = $this->Itinerary->addItinerary($itineraryData);
		$this->_assert_not_empty($this->_intItineraryID );
	}

	function test_updateEvent(){
		$itineraryData = array();
		$itineraryData['event_id'] = '40';
		$itineraryData['title'] = 'itinerary - itinerary';
		$itineraryData['description'] = 'some description';
		$itineraryData['start_date_time'] = '2013-03-02 19:00:00';
		$itineraryData['end_date_time'] = '2013-03-02 21:00:00';
		$itineraryData['location'] = 'Clubhouse Test';
		$itineraryData['status'] = '0';		

		$itineraryData['itineraryID'] = $this->Itinerary->addItinerary($itineraryData);

		$itineraryData['event_id'] = '40';
		$itineraryData['title'] = 'itinerary - update itinerary';
		$itineraryData['description'] = 'some description';
		$itineraryData['start_date_time'] = '2013-03-02 19:00:00';
		$itineraryData['end_date_time'] = '2013-03-02 21:00:00';
		$itineraryData['location'] = 'Clubhouse Test';
		$itineraryData['status'] = '0';
		
		$this->_intEventID = $itineraryData['event_id'];
		$this->_intItineraryID = $this->Itinerary->updateItinerary($itineraryData);
		$this->_assert_not_empty($this->_intItineraryID);
	}

	function test_deleteItinerary(){
		$itineraryData = array();
		$itineraryData['event_id'] = '40';
		$itineraryData['title'] = 'itinerary - delete itinerary';
		$itineraryData['description'] = 'some description';
		$itineraryData['start_date_time'] = '2013-03-02 19:00:00';
		$itineraryData['end_date_time'] = '2013-03-02 21:00:00';
		$itineraryData['location'] = 'Clubhouse Test';
		$itineraryData['status'] = '0';		

		$itineraryData['itineraryID'] = $this->Itinerary->addItinerary($itineraryData);

		$this->_assert_true($this->Itinerary->deleteItinerary($itineraryData));
	}

	function test_getEventItineraries(){
		$itineraryData = array();
		$itineraryData['event_id'] = '40';
		$itineraryData['title'] = 'itinerary - get event itinerary';
		$itineraryData['description'] = 'some description';
		$itineraryData['start_date_time'] = '2013-03-02 19:00:00';
		$itineraryData['end_date_time'] = '2013-03-02 21:00:00';
		$itineraryData['location'] = 'Clubhouse Test';
		$itineraryData['status'] = '0';		

		$this->_intEventID = $itineraryData['event_id'];
		$this->_intItineraryID = $this->Itinerary->addItinerary($itineraryData);
		$this->_assert_not_empty($this->Itinerary->getEventItineraries($itineraryData['event_id']));
	}

	function test_getAllItineraries(){
		$this->_assert_not_empty($this->Itinerary->getAllItineraries());
	}

	function test_getNumItineraries(){
		$intSearchResult = 0;
		$intSearchResult = $this->Itinerary->getNumItineraries();
		$this->_assert_not_empty($intSearchResult);
	}
}