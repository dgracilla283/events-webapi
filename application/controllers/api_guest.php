<?php
require_once APPPATH . 'libraries/REST_Controller.php';
require_once APPPATH . 'libraries/clients/api_guest_client.php';

class api_guest extends REST_Controller {

	public function __construct()
	{
		parent::__construct();
		if (! isset($this->Guest))
		{
			$this->load->model('Guest', '', TRUE);
		}
		if (! isset($this->Companion))
		{
			$this->load->model('Companion', '', TRUE);
		}
		if (! isset($this->Content_Control))
		{
			$this->load->model('Content_Control', '', TRUE);
		}
	}

	/**
	 * @method get
	 * @param string eventAttendeeID // pk id
	 * @param int user_id // guest userid
	 * @param int event_id // event id
	 * @param string reference_id	// reference_id
	 * @param string role_id	// role
	 * @param string reference_type // enum ('event', 'itinerary','activity')
	 * @param string team // guest team
	 * @param string status // enum( 'approved', 'pending', 'rejected')
	 * @param string sort_order // ASC|DESC sort order
	 * @param string sort_by
	 * @param int page // the current page in the pagination
	 * @param int per_page // the limit of rows per page
	 * @return json/xml data
	 */
	public function guests_get()
	{		
		$get = $this->input->get();
		$data = $this->Guest->getAllGuests($get);
		$result = !empty($data) ? array('result'=>$data) : array('error'=>'No record found');
		$this->response($result);
	}

	/**
	 * @method post
	 * @param int eventAttendeeID // optional pk
	 * @param int event_id // event id fk
	 * @param int user_id // guest userid
	 * @param string reference_type // enum ('itinerary', 'breakout', 'activity') 
	 * @param int reference_id // remote id of which guest will be attending
	 * @param int role_id // guest role
	 * @param string team // guest team
	 * @param string status // enum( 'approved', 'pending', 'rejected')
	 * @param string isSpeaker // optional
	 * @return json/xml data
	 */
	public function guest_post()
	{
		$post = $this->input->post();
		if(empty($post['status']))
			$post['status'] = 'pending'; 
		
		if($post['status'] == 'rejected' && $post['eventAttendeeID'] && $post['isSpeaker']){
			$post['status'] = 'rejected';
			$post['team'] = '';
			$post['role_id'] = '0';
		}elseif($post['status'] == 'rejected' && $post['eventAttendeeID']){
			$post['status'] = 'pending';
		}
		
		$result = array();
		$eventAttendeeID = 0;
		if (!empty($post)) {
			if (empty($post['eventAttendeeID'])) {
				$eventAttendeeID = $this->Guest->addGuest($post);
			} else {
				$eventAttendeeID = $this->Guest->updateGuest($post, $post['eventAttendeeID']);
			}
			
			$apiGuest = new api_guest_client();
			$result = $apiGuest->guests_get(array('eventAttendeeID'=>$eventAttendeeID));
			$this->Content_Control->addContentControl();
		}			
		$this->response($result);
	}
	
	
	/**
	 * @method get
	 * @param int eventAttendeeID // gid 
	 * @param int event_id // event id	 	  
	 * @param int reference_id // reference id optional
	 * @param int user_id // event id optional
	 * @param int role_id // role id optional
	 * @return json/xml data
	 */
	public function remove_guest_get()
	{
		$get = $this->input->get();
		$result = $this->Guest->deleteGuest($get);
		$this->Content_Control->addContentControl();
		$this->response($result);
	}
	
	/**
	 * @method get
	 * @param int user_id // user_id
	 * @param int event_id // event_id
	 * @return json/xml data
	 */
	public function remove_event_guest_get()
	{
		$get = $this->input->get();
		$result = $this->Guest->deleteEventGuest($get);
		$this->Content_Control->addContentControl();		 
		$this->response($result);
	}
	
	/**
	 * @method get
	 * @param int reference_id // reference_id
	 * @return json/xml data
	 */
	public function remove_guest_by_referenceid_get()
	{
		$get = $this->input->get();
		$result = $this->Guest->deleteGuestByReferenceID($get);
		$this->Content_Control->addContentControl();		 
		$this->response($result);
	}
	
	/**
	 * @method get
	 * @param string name //filter of search
	 * @param int event_id //event id
	 * @return json/xml data
	 */
	public function search_guest_by_name_get()
	{
		$get = $this->input->get();
		$result = $this->Guest->searchGuestByName($get);
		//$this->Content_Control->addContentControl();		 
		$this->response($result);
	}
	
	/**
	 * @method get
	 * @return json/xml data
	 */
	public function user_concurrent_activities_get()
	{
		$get = $this->input->get();
		$result = $this->Guest->getUserConcurrentActivities($get);
		//$this->Content_Control->addContentControl();		 
		$this->response($result);
	}
	
	/**
	 * @method get
	 * @param int user_id // user_id
	 * @param string reference_type // reference_type
	 * @param int reference_id // reference_id
	 * @return json/xml data
	 */
	public function remove_guest_by_reference_get()
	{
		$get = $this->input->get();
		$result = $this->Guest->deleteGuestByReference($get);
		$this->Content_Control->addContentControl();		 
		$this->response($result);
	}	
	
	/**
	 * @method post
	 * @param int eventAttendeeIDs // event attendee ids comma separated
	 * @param int status // status ('approved','pending', 'rejected')
	 * @return json/xml data
	 */
	public function multi_update_status_post()
	{
		$post = $this->input->post();		
		$result = $this->Guest->updateStatus($post); 
		$this->response($result);
	}
	
}