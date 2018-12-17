<?php
require_once APPPATH . 'libraries/REST_Controller.php';
require_once APPPATH . 'libraries/clients/api_presentation_client.php';

class api_presentation extends REST_Controller {

	function __construct()
	{
		parent::__construct();		
		if (! isset($this->Presentation))
		{
			$this->load->model('Presentation', '', TRUE);
		}
		if (! isset($this->Content_Control))
		{
			$this->load->model('Content_Control', '', TRUE);
		}
	}

	/**
	 * @method get
	 * @param int presentationID	// id of presentation 
	 * @param int presentation_category_id	// id of presentation category 
	 * @param string title	// title 
	 * @param string sort_field // the field to sort
	 * @param string sort_order // ASC|DESC sort order
	 * @param int page // the current page in the pagination
	 * @param int per_page // the limit of rows per page
	 * @return json/xml data
	 */
	public function presentation_get()
	{		
		$get = $this->input->get();		
		$presentations = $this->Presentation->getPresentation($get);
		$arrResponse = array(
			'result' => $presentations
		);		 	
		$this->response($arrResponse);
	}
	
	/**
	 * @method post
	 * @param int presentationID	// id parameter optional of type integer
	 * @param int presentation_category_id	// id of category 
	 * @param string title      // title of presentation
	 * @param string url      // link of presentation
	 * @return json/xml data
	 */
	public function presentation_post()
	{
		$post = $this->input->post();		
		$objPresentation = new api_presentation_client();		
		$data = array(); 
		if (!empty($post)) {
			if (!$post['presentationID']){ 
				$presentationID = $this->Presentation->addPresentation($post);
			} else {
				$presentationID = $this->Presentation->updatePresentation($post);
			}			
			$data = $objPresentation->presentation_get(array('presentationID'=>$presentationID), 'json');
			$this->Content_Control->addContentControl();  
		}		  	 
		$this->response($data);
	}
	
	/**
	 * @method get
	 * @param int presentationID	// presentation id
	 * @param int presenation_category_id	// presentation categoryid
	 * @return json/xml data
	 */
	public function presentation_remove_get()
	{
		$get = $this->input->get();
		$data = array(); 		
		if(!empty($get)) {
			$data = $this->Presentation->deletePresentation($get); 
			$this->Content_Control->addContentControl();  
		}
		$this->response($data);
	}

}