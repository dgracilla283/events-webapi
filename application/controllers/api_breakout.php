<?php
require_once APPPATH . 'libraries/REST_Controller.php';
require_once APPPATH . 'libraries/clients/api_breakout_client.php';

class api_breakout extends REST_Controller {

	function __construct()
	{
		parent::__construct();
		// load users model
		if (! isset($this->Breakout))
		{
			$this->load->model('Breakout', '', TRUE);
		}
		if (! isset($this->Content_Control))
		{
			$this->load->model('Content_Control', '', TRUE);
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
	public function breakouts_get()
	{
		$get = $this->input->get();
		$BreakoutData = array();
		$BreakoutData = $this->Breakout->getAllBreakouts($get);
		$arrResponse = array(
			'result' => $BreakoutData
		);			
		$this->response($arrResponse);
	}

	/**
	 * @method get
	 * @param int id // the id of the Breakout to fetch
	 * @return json/xml data
	 */
	public function breakout_get()
	{
		$id = $this->input->get('id');
		$objBreakoutClient = new api_breakout_client();
		$data = $objBreakoutClient->breakouts_get(false, 'json');
		
		$newBreakoutData = array();
		foreach($data['result'] as $BreakoutData) {
			$newBreakoutData[$BreakoutData['breakoutID']] = $BreakoutData;
		}
		$result = array('result'=>false);
		if (!empty($newBreakoutData[$id])) {
			$result = array('result'=>$newBreakoutData[$id]);
		}
		$this->response($result);
	}

	/**
	 * @method post
	 * @param int bid // optional id of Breakout
	 * @param int itinerary_id // itinerary_id of Breakout
	 * @param string title // Breakout title
	 * @param string description // Breakout description
	 * @param string location // Breakout location
	 * @param string start_date_time // Breakout start date
	 * @param string start_date_time // Breakout end date
	 * @param int attendees_limit // Breakout attendees limit
	 * @return json/xml data
	 */
	public function breakout_post()
	{
		$post = $this->input->post();
		$objBreakoutClient = new api_breakout_client();
		$data = array();
		if (!empty($post)) {
			if (!$post['breakoutID']){ 
				$breakoutId = $this->Breakout->addBreakout($post);
			} else {
				$breakoutId = $this->Breakout->updateBreakout($post);
			}
			$data = $objBreakoutClient->breakout_get(array('id'=>$breakoutId), 'json');
			$this->Content_Control->addContentControl();
		}		 
		$this->response($data);
	}
	
	/**
	 * @method get
	 * @param int bid // optional id of Breakout
	*/ 
	public function remove_breakout_get()
	{
		$bid = $this->input->get('bid');		
		$this->Guest->deleteGuestByReferenceID(array('reference_id' => $bid));
		$data = $this->Breakout->deleteBreakout(array('breakoutID' => $bid));		 
		$this->Content_Control->addContentControl();		 
		$this->response($data);
	}

}