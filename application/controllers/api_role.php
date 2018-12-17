<?php
require_once APPPATH . 'libraries/REST_Controller.php';
require_once APPPATH . 'libraries/clients/api_role_client.php';

class api_role extends REST_Controller {

	function __construct()
	{
		parent::__construct();
		// load users model
		if (! isset($this->Role))
		{
			$this->load->model('Role', '', TRUE);
		}
	}

	/**
	 * @method get
	 * @param string category	// id parameter of type integer
	 * @param string sort_field // the field to sort
	 * @param string sort_order // ASC|DESC sort order
	 * @param int page // the current page in the pagination
	 * @param int per_page // the limit of rows per page
	 * @return json/xml data
	 */
	public function roles_get()
	{
		$RoleData = array();
		$RoleData = $this->Role->getAllRoles();
		$arrResponse = array(
			'result' => $RoleData
		);
			
		$this->response($arrResponse);
	}

	/**
	 * @method get
	 * @param int id // the id of the Role to fetch
	 * @return json/xml data
	 */
	public function role_get()
	{
		$id = $this->input->get('id');
		$objRoleClient = new api_role_client();
		$data = $objRoleClient->roles_get(false, 'json');
		
		$newRoleData = array();
		foreach($data['result'] as $RoleData) {
			$newRoleData[$RoleData['roleID']] = $RoleData;
		}
		$result = array('result'=>false);
		if (!empty($newRoleData[$id])) {
			$result = array('result'=>$newRoleData[$id]);
		}
		$this->response($result);
	}

	/**
	 * @method post
	 * @param int eid // optional id of Role
	 * @param string title // Role title
	 * @param string description // Role description
	 * @param string date_start // Role start date
	 * @param string date_end // Role end date
	 * @return json/xml data
	 */
	public function role_post()
	{
		$post = $this->input->post();
		$this->response(array('result'=>$post));
	}

	//@TODO: research on implementation
	/* public function role_delete()
	 {
		$data = array('returned: '. $this->delete('id'));
		$this->response($data);
		} */

}