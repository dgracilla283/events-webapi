<?php
require_once APPPATH . '/controllers/test/Toast.php';

class Breakout_tests extends Toast
{
	private $_intBreakoutID;

	function Breakout_tests()
	{
		parent::Toast(__FILE__);

		//load Breakout_Option model
		if (! isset($this->Breakout))
		{
			$this->load->model('Breakout', '', TRUE);
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
		if (!empty($this->_intBreakoutID)) {
			$data = array();
			$data['breakoutID'] = $this->_intBreakoutID;
			$this->Breakout->deleteBreakout($data);
		}
	}

	function test_addBreakout(){
		$breakoutData = array();
		$breakoutData['itinerary_id'] = '1000';
		$breakoutData['title'] = 'breakout - add breakout';
		$breakoutData['description'] = 'description of breakout';
		$breakoutData['start_date_time'] = '2013-03-27 16:00:00';
		$breakoutData['end_date_time'] = '2013-03-27 19:30:00';
		$breakoutData['location'] = 'Clubhouse';

		$this->_intBreakoutID = $this->Breakout->addBreakout($breakoutData);
		$this->_assert_not_empty($this->_intBreakoutID );
	}

	function test_updateBreakout(){
		$breakoutData = array();
		$breakoutData['itinerary_id'] = '1000';
		$breakoutData['title'] = 'breakout';
		$breakoutData['description'] = 'description of breakout';
		$breakoutData['start_date_time'] = '2013-03-27 16:00:00';
		$breakoutData['end_date_time'] = '2013-03-27 19:30:00';
		$breakoutData['location'] = 'Clubhouse';

		$breakoutData['breakoutID'] = $this->Breakout->addBreakout($breakoutData);
		
		$breakoutData['itinerary_id'] = '1000';
		$breakoutData['title'] = 'breakout - update breakout';
		$breakoutData['description'] = 'description of breakout';
		$breakoutData['start_date_time'] = '2013-03-27 16:00:00';
		$breakoutData['end_date_time'] = '2013-03-27 19:30:00';
		$breakoutData['location'] = 'Clubhouse';

		$this->_intBreakoutID = $this->Breakout->updateBreakout($breakoutData);
		$this->_assert_not_empty($this->_intBreakoutID );
	}

	function test_deleteBreakout(){
		$breakoutData = array();
		$breakoutData['itinerary_id'] = '1000';
		$breakoutData['title'] = 'breakout - delete breakout';
		$breakoutData['description'] = 'description of breakout';
		$breakoutData['start_date_time'] = '2013-03-27 16:00:00';
		$breakoutData['end_date_time'] = '2013-03-27 19:30:00';
		$breakoutData['location'] = 'Clubhouse';

		$breakoutData['breakoutID'] = $this->Breakout->addBreakout($breakoutData);

		$this->_assert_true($this->Breakout->deleteBreakout($breakoutData));
	}
	
	function test_getItineraryBreakouts(){
		$breakoutData = array();
		$breakoutData['itinerary_id'] = '1000';
		$breakoutData['title'] = 'breakout - get itinerary breakout';
		$breakoutData['description'] = 'description of breakout';
		$breakoutData['start_date_time'] = '2013-03-27 16:00:00';
		$breakoutData['end_date_time'] = '2013-03-27 19:30:00';
		$breakoutData['location'] = 'Clubhouse';

		$this->_intBreakoutID = $this->Breakout->addBreakout($breakoutData);		
		
		$searchData = array();
		$searchData['breakoutID'] = $this->_intBreakoutID;
		$this->_assert_not_empty($this->Breakout->getItineraryBreakouts($breakoutData['itinerary_id']));
	}
	
	function test_getAllBreakouts(){
		$breakoutData = array();
		$breakoutData['itinerary_id'] = '1000';
		$breakoutData['title'] = 'breakout - get all breakout';
		$breakoutData['description'] = 'description of breakout';
		$breakoutData['start_date_time'] = '2013-03-27 16:00:00';
		$breakoutData['end_date_time'] = '2013-03-27 19:30:00';
		$breakoutData['location'] = 'Clubhouse';

		$this->_intBreakoutID = $this->Breakout->addBreakout($breakoutData);		
		
		$searchData = array();
		$searchData['breakoutID'] = $this->_intBreakoutID;
		$this->_assert_not_empty($this->Breakout->getAllBreakouts($searchData));
	}
	
	function test_getNumBreakouts(){
		$intSearchResult = 0;
		$intSearchResult = $this->Breakout->getNumBreakouts();
		$this->_assert_not_empty($intSearchResult);
	}
}