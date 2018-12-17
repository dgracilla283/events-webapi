<?php
require_once APPPATH . 'libraries/REST_Controller.php';
require_once APPPATH . 'libraries/clients/api_event_owner_client.php';

class api_event_owner extends REST_Controller {

	public function __construct()
	{
		parent::__construct();
		
		if (! isset($this->Event_Owner))
		{
			$this->load->model('Event_Owner', '', TRUE);
		}
		
		if (! isset($this->Content_Control))
		{
			$this->load->model('Content_Control', '', TRUE);
		}
	}

	/**
	 * @method get
	 * @param string eventOwnerID // pk id
	 * @param int user_id // guest userid
	 * @param int event_id // event id
	 * @param string sort_order // ASC|DESC sort order
	 * @param string sort_by
	 * @param int page // the current page in the pagination
	 * @param int per_page // the limit of rows per page
	 * @return json/xml data
	 */
	public function event_owners_get()
	{		
		$get = $this->input->get();
		$data = $this->Event_Owner->getAllEventOwners($get);
		$result = !empty($data) ? array('result'=>$data) : array('error'=>'No record found');
		$this->response($result);
	}

	/**
	 * @method post
	 * @param int eventOwnerID // optional pk
	 * @param int event_id // event id fk
	 * @param int user_id // guest userid
	 * @return json/xml data
	 */
	public function event_owner_post()
	{
		$post = $this->input->post();
		$result = array();
		$eventOwnerID = 0;
		if (!empty($post)) {
			if (empty($post['eventOwnerID'])) {
				$eventOwnerID = $this->Event_Owner->addEventOwner($post);
			} else {
				$eventOwnerID = $this->Event_Owner->updateEventOwner($post, $post['eventOwnerID']);
			}
			
			$apiOwner = new api_event_owner_client();
			$result = $apiOwner->event_owner_get(array('eventOwnerID'=>$eventOwnerID));
			$this->Content_Control->addContentControl();
		}			
		$this->response($result);
	}
	
	
	/**
	 * @method get
	 * @param int eventOwnerID // gid 
	 * @param int event_id // event id	 	  
	 * @param int user_id // event id optional
	 * @return json/xml data
	 */
	public function remove_event_owner_get()
	{
		$get = $this->input->get();
		$result = $this->Event_Owner->deleteEventOwner($get);
		$this->Content_Control->addContentControl();
		$this->response($result);
	}
	
		
	/**
	 * @method get
	 * @param string name //filter of search
	 * @param int event_id //event id
	 * @return json/xml data
	 */
	public function search_event_owner_by_name_get()
	{
		$get = $this->input->get();
		$result = $this->Event_Owner->searchEventOwnerByName($get);
		//$this->Content_Control->addContentControl();		 
		$this->response($result);
	}
	
}