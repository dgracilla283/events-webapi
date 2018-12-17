<?php
require_once APPPATH . 'libraries/REST_Controller.php';
require_once APPPATH . 'libraries/clients/api_presentation_category_client.php';

class api_presentation_category extends REST_Controller {

	function __construct()
	{
		parent::__construct();		
		if (! isset($this->Presentation_Category))
		{
			$this->load->model('Presentation_Category', '', TRUE);
		}
		if (! isset($this->Content_Control))
		{
			$this->load->model('Content_Control', '', TRUE);
		}
	}

	/**
	 * @method get
	 * @param int presentationCategoryID	// id of presentation category 
	 * @param int event_id	// id of event 
	 * @param string sort_field // the field to sort
	 * @param string sort_order // ASC|DESC sort order
	 * @param int page // the current page in the pagination
	 * @param int per_page // the limit of rows per page
	 * @return json/xml data
	 */
	public function presentation_category_get()
	{		
		$get = $this->input->get();		
		$presentationCategories = $this->Presentation_Category->getPresentationCategories($get);
		$arrResponse = array(
			'result' => $presentationCategories
		);		 	
		$this->response($arrResponse);
	}
	
	/**
	 * @method post
	 * @param int presentationCategoryID	// id parameter optional of type integer
	 * @param int event_id	// id of event 
	 * @param string name      // title of activity preference
	 * @return json/xml data
	 */
	public function presentation_category_post()
	{
		$post = $this->input->post();		
		$objPresentationCategory = new api_presentation_category_client();		
		$data = array(); 
		if (!empty($post)) {
			if (!$post['presentationCategoryID']){ 
				$presentationCategoryID = $this->Presentation_Category->addPresentationCategory($post);
			} else {
				$presentationCategoryID = $this->Presentation_Category->updatePresentationCategory($post);
			}			
			$data = $objPresentationCategory->presentation_category_get(array('presentationCategoryID'=>$presentationCategoryID), 'json');
			$this->Content_Control->addContentControl();  
		}		  	 
		$this->response($data);
	}
	
	/**
	 * @method get
	 * @param int presentationCategoryID	// activity preference id
	 * @return json/xml data
	 */
	public function presentation_category_remove_get()
	{
		$get = $this->input->get();
		$data = array(); 		
		if(!empty($get)) {
			$data = $this->Presentation_Category->deletePresentationCategory($get); 
			$this->Content_Control->addContentControl();  
		}
		$this->response($data);
	}

}