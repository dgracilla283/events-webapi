<?php
require_once APPPATH . 'libraries/REST_Controller.php';
require_once APPPATH . 'libraries/clients/api_itinerary_client.php';

class api_itinerary extends REST_Controller {

	function __construct()
	{
		parent::__construct();
		// load users model
		if (! isset($this->Itinerary))
		{
			$this->load->model('Itinerary', '', TRUE);
		}
		if (! isset($this->Content_Control))
		{
			$this->load->model('Content_Control', '', TRUE);
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
	 * @return json/xml data
	 */
	public function itineraries_get()
	{
		$ItineraryData = array();
		$ItineraryData = $this->Itinerary->getAllItineraries();
		$arrResponse = array(
			'result' => $ItineraryData
		);
			
		$this->response($arrResponse);
	}

	/**
	 * @method get
	 * @param int id // the id of the Itinerary to fetch
	 * @return json/xml data
	 */
	public function itinerary_get()
	{
		$id = $this->input->get('id');
		$objItineraryClient = new api_itinerary_client();
		$data = $objItineraryClient->itineraries_get(false, 'json');
		
		$newItineraryData = array();
		foreach($data['result'] as $ItineraryData) {
			$newItineraryData[$ItineraryData['itineraryID']] = $ItineraryData;
		}
		$result = array('result'=>false);
		if (!empty($newItineraryData[$id])) {
			$result = array('result'=>$newItineraryData[$id]);
		}
		$this->response($result);
	}
	
	/**
	 * @method get
	 * @param int event_id // the id of the Event to fetch
	 * @return json/xml data
	 */
	public function event_itineraries_get()
	{
		$event_id = $this->input->get('event_id');
		$objItineraryClient = new api_itinerary_client();
		$data = $objItineraryClient->itineraries_get(false, 'json');
		
		$eventItineraries = array();
		foreach($data['result'] as $ItineraryData) {
			if($ItineraryData['event_id'] === $event_id)
				$eventItineraries[] = $ItineraryData;
		}
		$result = array('result'=>false);
		if (!empty($eventItineraries)) {
			$result = array('result'=>$eventItineraries);
		}
		$this->response($result);
	}

	/**
	 * @method post
	 * @param int itineraryID // optional id of Itinerary
	 * @param int event_id // event id
	 * @param string title // Itinerary title
	 * @param string description // Itinerary description
	 * @param string start_date_time // Itinerary start date
	 * @param string end_date_time // Itinerary end date
	 * @param string location // Itinerary location
	 * @param int breakout_status // Breakout status
	 * @param int attendees_limit // Itinerary attendees limit
	 * @return json/xml data
	 */
	public function itinerary_post()
	{
		$post = $this->input->post();
		$objItineraryClient = new api_itinerary_client();
		$data = array();
		if (!empty($post)) {
			if (!$post['itineraryID']){  
				$itineraryId = $this->Itinerary->addItinerary($post);
			} else {
				$itineraryId = $this->Itinerary->updateItinerary($post);
			}
			$data = $objItineraryClient->itinerary_get(array('id'=>$itineraryId), 'json');
			$this->Content_Control->addContentControl();
		}		 
		$this->response($data);
	}
		
	/**
	 * @method get
	 * @param int itineraryID // id of Itinerary
	 * @param int event_id // id of Event
	 * @return json/xml data
	 */
	public function itinerary_remove_get()
	{	
		$iid = $this->input->get('itineraryID'); 
		$params = array(
			'itineraryID' => $iid,  
			'event_id' => $this->input->get('event_id'),
		);		 
		if ($iid){   
			$breakouts = $this->Breakout->getItineraryBreakouts($iid); 
			if(!empty($breakouts)){
				foreach($breakouts as $breakout) {
					$this->Guest->deleteGuestByReferenceID(array('reference_id' => $breakout['breakoutID']));	
					$this->Breakout->deleteBreakout(array('breakoutID' => $breakout['breakoutID']));	
				}
			}
			$result = $this->Itinerary->deleteItinerary($params);			
			$this->Content_Control->addContentControl();			
		}
		$result['params'] = $params; 		  		
		$this->response($result);
	}
}