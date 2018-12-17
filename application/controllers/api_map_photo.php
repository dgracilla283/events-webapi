<?php
require_once APPPATH . 'libraries/REST_Controller.php';
require_once APPPATH . 'libraries/clients/api_map_photo_client.php';

class api_map_photo extends REST_Controller {

	function __construct()
	{
		parent::__construct();
		// load users model
		if (! isset($this->Map_Photo))
		{
			$this->load->model('Map_Photo', '', TRUE);
		}
		
	}

	/**
	 * @method get
	 * @param int mapPhotoID // primary key
	 * @param int event_id // fk userid 
	 * @param string sort_field // the field to sort
	 * @param string sort_order // ASC|DESC sort order
	 * @param int page // the current page in the pagination
	 * @param int per_page // the limit of rows per page
	 * @return json/xml data
	 */
	public function map_photo_get()
	{ 
		$arrResponse = array();
		$get = $this->input->get();
		if (!empty($get)) {
			$arrResponse = $this->Map_Photo->fetch($get);
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
	public function map_photo_post()
	{
		$arrResponse = array();
		
		$post = $this->input->post();
		$last_insert_id = null;
		
		if (!empty($post)) {
			$last_insert_id = $this->Map_Photo->add($post);
			
		}
		
		if (!empty($last_insert_id)) {
			$apiMapPhotoClient = new api_map_photo_client();
			$arrResponse = $apiMapPhotoClient->map_photo_get(array('mapPhotoID'=>$last_insert_id));
		}
					
		$this->response($arrResponse);
	}
	
	
	/**
	 * @method get
	 * @param int p_i_pid // photo id
	 * @return json/xml data
	 */
	public function remove_photo_get()
	{
		$arrResponse = array();
		$post = $this->input->get();
		if (!empty($post)) {
			$arrResponse = $this->Map_Photo->delete($post);			
			$this->response($arrResponse);
		}
	}
	
	/**
	 * @method get
	 * @param string uids // comma delimitted list of user ids
	 */
	public function fetch_multi_by_userid_get() {
		$uids = $this->input->get('uids');
		
		$arrUids = explode(',',$uids);
		$result = $this->Map_Photo->fetch(array('fk_i_uid'=>$arrUids));
		$this->response($result);
	}
	
}