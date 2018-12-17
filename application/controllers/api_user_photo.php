<?php
require_once APPPATH . 'libraries/REST_Controller.php';
require_once APPPATH . 'libraries/clients/api_user_photo_client.php';

class api_user_photo extends REST_Controller {

	function __construct()
	{
		parent::__construct();
		// load users model
		if (! isset($this->User_Photo))
		{
			$this->load->model('User_Photo', '', TRUE);
		}
		
	}

	/**
	 * @method get
	 * @param int p_i_pid // primary key
	 * @param int fk_i_uid // fk userid 
	 * @param string sort_field // the field to sort
	 * @param string sort_order // ASC|DESC sort order
	 * @param int page // the current page in the pagination
	 * @param int per_page // the limit of rows per page
	 * @return json/xml data
	 */
	public function user_photo_get()
	{ 
		$arrResponse = array();
		$get = $this->input->get();
		if (!empty($get)) {
			$arrResponse = $this->User_Photo->fetch($get);
		}
		$this->response($arrResponse);
	}
	
	/**
	 * @method post
	 * @param int p_i_pid // optional, if set the data will be updated
	 * @param int fk_i_uid // foreign key user id
	 * @param string s_fname // filename
	 * @param string s_origdata // serialize array original image data
	 * @param int b_is_primary // flag primary photo
	 * @param int b_is_deleted // flag primary photo
	 * @return json/xml data
	 */
	public function user_photo_post()
	{
		$arrResponse = array();
		
		$post = $this->input->post();
		$userPhotoID = (int) $post['userPhotoID'];
		$last_insert_id = null;
		
		if (!empty($post)) {
			if (!empty($userPhotoID)) {
				$last_insert_id = $this->User_Photo->update($post, $userPhotoID);
			} else {
				if (!empty($post)) {
					$last_insert_id = $this->User_Photo->add($post);
				}
			}
		}
		
		if (!empty($last_insert_id)) {
			$apiUserPhotoClient = new api_user_photo_client();
			$arrResponse = $apiUserPhotoClient->user_photo_get(array('userPhotoID'=>$last_insert_id));
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
			$arrResponse = $this->User_Photo->delete($post);			
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
		$result = $this->User_Photo->fetch(array('fk_i_uid'=>$arrUids));
		$this->response($result);
	}
	
}