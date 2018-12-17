<?php
require_once APPPATH . 'libraries/REST_Controller.php';

class api_activity_preference_option extends REST_Controller {

	function __construct()
	{
		parent::__construct();		
		if (! isset($this->Activity_Preference_Option))
		{
			$this->load->model('Activity_Preference_Option', '', TRUE);
		}
		if (! isset($this->Content_Control))
		{
			$this->load->model('Content_Control', '', TRUE);
		}
	}

	/**
	 * @method get
	 * @param int activityPreferenceOptionID	// id optional  
	 * @param int activityPreferenceID  // activity preference id
	 * @param string sort_field // the field to sort
	 * @param string sort_order // ASC|DESC sort order
	 * @param int page // the current page in the pagination
	 * @param int per_page // the limit of rows per page
	 * @return json/xml data
	 */
	public function activity_preference_option_get()
	{		
		$get = $this->input->get();		
		$activityPreferenceOptions = $this->Activity_Preference_Option->getActivityPreferenceOptions($get);
		$arrResponse = array(
			'result' => $activityPreferenceOptions
		);		 	
		$this->response($arrResponse);
	}
	
	/**
	 * @method post
	 * @param int activityPreferenceOptionID	// id parameter optional of type integer
	 * @param int activityPreferenceID  // activity preference id	 
	 * @param string title      // title of activity preference
	 * @param string description // description of activity preference
	 * @param date dateCreated   // created date
	 * @param date dateUpdated	 // updated date 
	 * @return json/xml data
	 */
	public function activity_preference_option_post()
	{
		$post = $this->input->post();				
		$data = array(); 
		if (!empty($post)) {
			if (!$post['activityPreferenceOptionID']){ 
				$activityPreferenceOptionID = $this->Activity_Preference_Option->addActivityPreferenceOption($post);
			} else {
				$activityPreferenceOptionID = $this->Activity_Preference_Option->updateActivityPreferenceOption($post);
			}			
			$data = $this->Activity_Preference_Option->getActivityPreferenceOptions(array('activityPreferenceOptionID'=>$activityPreferenceOptionID), 'json');
			$this->Content_Control->addContentControl();  
		}		  	 
		$this->response($data);
	}
	
	/**
	 * @method get
	 * @param int activityPreferenceOptionID	// activity preference options - option id
	 * @param int activityPreferenceID  // activity preference id	 
	 * @return json/xml data
	 */
	public function activity_preference_option_remove_get()
	{
		$get = $this->input->get();
		$data = array(); 		
		if(!empty($get)) {
			$data = $this->Activity_Preference_Option->deleteActivityPreferenceOption($get); 
			$this->Content_Control->addContentControl();  
		}
		$this->response($data);
	}

}