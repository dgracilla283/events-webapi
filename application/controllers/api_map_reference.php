<?php
require_once APPPATH . 'libraries/REST_Controller.php';
require_once APPPATH . 'libraries/clients/api_map_reference_client.php';

class api_map_reference extends REST_Controller {

	function __construct()
	{
		parent::__construct();
		// load users model
		if (! isset($this->Map_Reference))
		{
			$this->load->model('Map_Reference', '', TRUE);
		}
		
	}

	/**
	 * @method get
	 * @param int mapReferenceID // primary key
	 * @param int map_photo_id // fk map photo id
	 * @param string reference_type // enum('event, itinerary, activity') - 'event' is soon deprecated
	 * @param int reference_id // reference id
	 * @param string sort_field // the field to sort
	 * @param string sort_order // ASC|DESC sort order
	 * @param int page // the current page in the pagination
	 * @param int per_page // the limit of rows per page
	 * @return json/xml data
	 */
	public function map_reference_get()
	{ 
		$arrResponse = array();
		$get = $this->input->get();
		if (!empty($get)) {
			$arrResponse = $this->Map_Reference->fetch($get);
		}
		$this->response($arrResponse);
	}
	
	/**
	 * @method post
	 * @param int mapPhotoID	//primary key
	 * @param int fk_i_eid // foreign key event id
	 * @param string title // map title name
	 * @param string s_fname // filename
	 * @param string s_origdata // serialize array original image data
	 * @param int b_is_deleted // flag primary photo
	 * @return json/xml data
	 */
	public function map_reference_post()
	{
		$arrResponse = array();
		
		$post = $this->input->post();
		$mapReferenceId = null;
		
		if (!empty($post)) {
			//-- Edit
			if(!empty($post['mapReferenceID']) && !empty($post['map_photo_id'])) {
				$mapReferenceId = $this->Map_Reference->update($post);	
			} elseif(empty($post['mapReferenceID']) && !empty($post['map_photo_id'])) {
				$mapReferenceId = $this->Map_Reference->add($post);	
			} elseif(!empty($post['mapReferenceID']) && empty($post['map_photo_id'])) {
				$this->Map_Reference->delete($post);	
			}
		}
		
		if (!empty($mapReferenceId)) {
			$apiMapReference = new api_map_reference_client();
			$arrResponse = $apiMapReference->map_reference_get(array('mapReferenceID'=>$mapReferenceId));
		}
					
		$this->response($arrResponse);
	}
	
	
	/**
	 * @method get
	 * @param int p_i_pid // photo id
	 * @return json/xml data
	 */
	public function remove_map_reference_get()
	{
		$arrResponse = array();
		$post = $this->input->get();
		if (!empty($post)) {
			$arrResponse = $this->Map_Reference->delete($post);			
			$this->response($arrResponse);
		}
	}
	
}