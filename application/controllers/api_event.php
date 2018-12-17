<?php
require_once APPPATH . 'libraries/REST_Controller.php';
require_once APPPATH . 'libraries/clients/api_event_client.php';

class api_event extends REST_Controller {

	function __construct()
	{
		parent::__construct();
		// load users model
		if (! isset($this->Event))
		{
			$this->load->model('Event', '', TRUE);
		}
		if (! isset($this->Content_Control))
		{
			$this->load->model('Content_Control', '', TRUE);
		}
		if (! isset($this->Itinerary))
		{
			$this->load->model('Itinerary', '', TRUE);
		}		
		if (! isset($this->Breakout))
		{
			$this->load->model('Breakout', '', TRUE);
		}
		if (! isset($this->Guest))
		{
			$this->load->model('Guest', '', TRUE);
		}
	}

	/**
	 * @method get
	 * @param string category	// id parameter of type integer
	 * @param string sort_field // the field to sort
	 * @param string sort_order // ASC|DESC sort order
	 * @param int page // the current page in the pagination
	 * @param int per_page // the limit of rows per page
	 * @param int status	//1= published events, 0=unpublished events
	 * @return json/xml data
	 */
	public function events_get()
	{		
		$options = $this->input->get();
		print_r($options); exit;  
		$eventData = array();
		$eventData = $this->Event->getAllEvents($options);
		$arrResponse = array(
			'result' => $eventData
		);
			
		$this->response($arrResponse);
	}

	/**
	 * @method get
	 * @param int id // the id of the event to fetch
	 * @return json/xml data
	 */
	public function event_get()
	{	
		$id = $this->input->get('id');
		$objEventClient = new api_event_client();
		$data = $objEventClient->events_get(false, 'json');
		
		$newEventData = array();
		foreach($data['result'] as $eventData) {
			$newEventData[$eventData['eventID']] = $eventData;
		}
		 
		$result = array('result'=>false);
		if (!empty($newEventData[$id])) {
			$result = array('result'=>$newEventData[$id]);
		}
		
		//$result = array('result' => array('one', 'two', 'three'));
		$this->response($result);
	}

	/**
	 * @method post
	 * @param int eid // optional id of event
	 * @param string title // event title
	 * @param string location // event location
	 * @param string description // event description
	 * @param string start_date_time // event start date
	 * @param string end_date_time // event end date
	 * @param int status // flag for showing/hiding event
	 * @param int additional_info // flag for showing/hiding event
	 * @param int attendees_limit // limit of attendees
	 * @return json/xml data
	 */
	public function event_post()
	{
		$post = $this->input->post();
		$objEventClient = new api_event_client();
		$data = array();
		if (!empty($post)) {
			if (!$post['eventID']){ 
				$eventId = $this->Event->addEvent($post);
			} else {
				$eventId = $this->Event->updateEvent($post);
			}			
			$data = $objEventClient->event_get(array('id'=>$eventId), 'json');
			$this->Content_Control->addContentControl();  
		}		 
		$this->response($data);
	}
	
	/**
	 * @method get
	 * @param int eid // id of Event
	 * @return json/xml data
	 */
	public function event_remove_get()
	{
		$eid = $this->input->get('eventID');
		$delete = 0; 
		if ($eid){  
			$itineraries = $this->Itinerary->getEventItineraries($eid);			 
			if(!empty($itineraries)){
				foreach($itineraries as $itinerary){
					$breakouts = $this->Breakout->getItineraryBreakouts($itinerary['eventID']);					  
					if(!empty($breakouts)){
						foreach($breakouts as $breakout){
							$this->Guest->deleteGuestByReferenceID(array('reference_id' => $breakout['breakoutID']));	
							$this->Breakout->deleteBreakout(array('bid' => $breakout['breakoutID']));	
						}
						$this->Itinerary->deleteItinerary($itinerary['breakoutID']); 
					}
				} 
			}
			$delete = $this->Event->deleteEvent(array('eventID' => $eid));					
		}
		$result = array('result'=>false);
		if (!empty($delete)) {
			$result = array('result'=>$delete);
			$this->Content_Control->addContentControl();
		}		 	
		$this->response($result);
	}

}