<?php
require_once APPPATH . 'libraries/REST_Controller.php';

class api_activity_preference extends REST_Controller {

	function __construct()
	{
		parent::__construct();		
		if (! isset($this->Activity_Preference))
		{
			$this->load->model('Activity_Preference', '', TRUE);
		}
		if (! isset($this->Content_Control))
		{
			$this->load->model('Content_Control', '', TRUE);
		}
	}

	/**
	 * @method get
	 * @param int activityPreferenceID	// id of activity preferences 
	 * @param int referenceID  // reference id
	 * @param int referenceType // reference type
	 * @param int eventID  // event id  
	 * @param string sort_field // the field to sort
	 * @param string sort_order // ASC|DESC sort order
	 * @param int page // the current page in the pagination
	 * @param int per_page // the limit of rows per page
	 * @return json/xml data
	 */
	public function activity_preference_get()
	{		
		$get = $this->input->get();		
		$activityPreferences = $this->Activity_Preference->getActivityPreferences($get);
		$arrResponse = array(
			'result' => $activityPreferences
		);		 	
		$this->response($arrResponse);
	}
	
	/**
	 * @method post
	 * @param int activityPreferenceID	// id parameter optional of type integer
	 * @param int referenceID  // reference id
	 * @param string referenceType // reference type ('agenda','activity')
	 * @param int eventID  // event id
	 * @param string title      // title of activity preference
	 * @param string description // description of activity preference
	 * @param string optionDisplayType // display type (selectbox, radio, checkbox, textbox, textarea)
	 * @param int isRequired	 // activity preference is required 
	 * @param date dateCreated   // created date
	 * @param date dateUpdated	 // updated date 
	 * @return json/xml data
	 */
	public function activity_preference_post()
	{
		$post = $this->input->post();				
		$data = array(); 
		if (!empty($post)) {
			if (!$post['activityPreferenceID']){ 
				$activityPreferenceID = $this->Activity_Preference->addActivityPreference($post);
			} else {
				$activityPreferenceID = $this->Activity_Preference->updateActivityPreference($post);
			}			
			$data = $this->Activity_Preference->getActivityPreferences(array('activityPreferenceID'=>$activityPreferenceID), 'json');
			$this->Content_Control->addContentControl();  
		}		  	 
		$this->response($data);
	}
	
	/**
	 * @method get
	 * @param int activityPreferenceID	// activity preference id
	 * @param int referenceID  // reference id
	 * @param string referenceType // reference type ('agenda','activity')
	 * @param int eventID  // event id
	 * @return json/xml data
	 */
	public function activity_preference_remove_get()
	{
		$get = $this->input->get();
		$data = array(); 		
		if(!empty($get)) {
			$data = $this->Activity_Preference->deleteActivityPreference($get); 
			$this->Content_Control->addContentControl();  
		}
		$this->response($data);
	}

}