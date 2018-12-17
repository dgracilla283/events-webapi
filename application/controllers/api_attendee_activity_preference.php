<?php
require_once APPPATH . 'libraries/REST_Controller.php';

class api_attendee_activity_preference extends REST_Controller {

	function __construct()
	{
		parent::__construct();		
		if (! isset($this->Attendee_Activity_Preference))
		{
			$this->load->model('Attendee_Activity_Preference', '', TRUE);
		}
		if (! isset($this->Content_Control))
		{
			$this->load->model('Content_Control', '', TRUE);
		}
	}

	/**
	 * @method get
	 * @param int attendeeActivityPreferenceID	// id of attendee activity preferences 
	 * @param int activityPreferenceID  // preference id
	 * @param int activityPreferenceOptionID // Option id
	 * @param int userID  // user id  
	 * @param string sort_field // the field to sort
	 * @param string sort_order // ASC|DESC sort order
	 * @param int page // the current page in the pagination
	 * @param int per_page // the limit of rows per page
	 * @return json/xml data
	 */
	public function attendee_activity_preference_get()
	{		
		$get = $this->input->get();		
		$attendeeActivityPreferences = $this->Attendee_Activity_Preference->getAttendeeActivityPreferences($get);
		$arrResponse = array(
			'result' => $attendeeActivityPreferences
		);		 	
		$this->response($arrResponse);
	}
	
	/**
	 * @method post
	 * @param int attendeeActivityPreferenceID	// id of attendee activity preferences 
	 * @param int activityPreferenceID  // preference id
	 * @param int activityPreferenceOptionID // Option id
	 * @param int userID  // user id 
	 * @param string value     // Optional will be set if Option Display Type is textbox or textarea 
	 * @param date dateCreated   // created date
	 * @param date dateUpdated	 // updated date 
	 * @return json/xml data
	 */
	public function attendee_activity_preference_post()
	{
		$post = $this->input->post();				
		$data = array(); 
		if (!empty($post)) {
			if (!$post['attendeeActivityPreferenceID']){ 
				$attendeeActivityPreferenceID = $this->Attendee_Activity_Preference->addAttendeeActivityPreference($post);
			} else {
				$attendeeActivityPreferenceID = $this->Attendee_Activity_Preference->updateAttendeeActivityPreference($post);
			}			
			$data = $this->Attendee_Activity_Preference->getAttendeeActivityPreferences(array('attendeeActivityPreferenceID'=>$attendeeActivityPreferenceID), 'json');
			$this->Content_Control->addContentControl();  
		}		  	 
		$this->response($data);
	}
	
	/**
	 * @method get
	 * @param int attendeeActivityPreferenceID	// id of attendee activity preferences 
	 * @param int activityPreferenceID  // preference id
	 * @param int activityPreferenceOptionID // Option id
	 * @param int userID // user id
	 * @return json/xml data
	 */
	public function attendee_activity_preference_remove_get()
	{
		$get = $this->input->get();
		$data = array(); 		
		if(!empty($get)) {
			$data = $this->Attendee_Activity_Preference->deleteAttendeeActivityPreference($get); 
			$this->Content_Control->addContentControl();  
		}
		$this->response($data);
	}

}