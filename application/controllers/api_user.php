<?php
require_once APPPATH . 'libraries/REST_Controller.php';
require_once APPPATH . 'libraries/clients/api_user_client.php';

class api_user extends REST_Controller {

	function __construct()
	{
		parent::__construct();
		// load users model
		if (! isset($this->User))
		{
			$this->load->model('User', '', TRUE);
		}
		if (! isset($this->Guest))
		{
			$this->load->model('Guest', '', TRUE);
		}
		if (! isset($this->Content_Control))
		{
			$this->load->model('Content_Control', '', TRUE);
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
	public function users_get()
	{ 
		$options = $this->input->get(); 
		$userData = array();
		$userData = $this->User->getAllUsers($options);
		$arrResponse = array(
			'result' => $userData
		);			
		$this->response($arrResponse);
	}
	
	/**
	 * @method get
	 * @param int is_primary // user type
	 */  
	public function num_users_get()
	{ 
		$options = $this->input->get(); 
		$total = $this->User->getNumUsers($options);		
		$arrResponse = array(
			'result' => $total
		);			
		$this->response($arrResponse);
	}

	/**
	 * @method get
	 * @param int id // the id of the user to fetch
	 * @return json/xml data
	 */
	public function user_get()
	{
		$id = $this->input->get('id');
		$objuserClient = new api_user_client();
		$data = $objuserClient->users_get(false, 'json');
		
		$newUserData = array();
		foreach($data['result'] as $userData) {
			$newUserData[$userData['userID']] = $userData;
		}
		$result = array('result'=>false);
		if (!empty($newUserData[$id])) {
			$result = array('result'=>$newUserData[$id]);
		}
		$this->response($result);
	}

	/**
	 * @method post
	 * @param string userID // optional user id
	 * @param string email // user email
	 * @param string password // user password
	 * @param string first_name // user first name
	 * @param string last_name // user last name
	 * @param string affiliation // user affiliation
	 * @param string industry // user industry
	 * @param string title // user title
	 * @param string bio // user bio
	 * @return json/xml data
	 */
	public function user_post()
	{
		$post = $this->input->post();
		$objUserClient = new api_user_client();
		$data = array();
		if (!empty($post)) {
			if (!$post['userID']){ 
				if ((int)$post['is_primary'] == 1)
					$userId = $this->User->addUser($post);
				else
					$userId = $this->User->addGuestUser($post);
			} else {
				if ((int)$post['is_primary'] == 1)
					$userId = $this->User->updateUser($post);
				else
					$userId = $this->User->updateGuestUser($post);
			}
			$data = $objUserClient->user_get(array('id'=>$userId), 'json');
			$this->Content_Control->addContentControl();
		}		
		$this->response($data);
	}
	
	/**
	 * @method get
	 * @param string email
	 * @param string password
	 * @return json/xml userData
	 */
	public function login_get() {
		$email = $this->input->get('email');
		$password = $this->input->get('password');
		$data = array();
		if (!empty($email) && !empty($password)) {
			$data = $this->User->loginUser($email, $password);
		}
		$this->response($data);
	}
	
	/**
	 * @method get
	 * @param int uid // user id
	 * @return json/xml data
	 */
	public function remove_user_get()
	{
		$uid = $this->input->get('userID');
		$this->Guest->deleteGuestByUserID(array('userID' => $uid)); 
		$result = $this->User->deleteUser(array('userID' => $uid));		
		$this->Content_Control->addContentControl();		
		$this->response($result);
	}
	
	/**
	 * @method get
	 * @param int uid // user id
	 * @return json/xml data
	 */
	public function remove_guest_user_get()
	{
		$uid = $this->input->get('userID');
		$this->Guest->deleteGuestByUserID(array('userID' => $uid)); 
		$result = $this->User->deleteGuestUser(array('userID' => $uid));		
		$this->Content_Control->addContentControl();		
		$this->response($result);
	}
	
	/** 
	 * @method get
	 * @param string email //email
	 * @param string password //password
	 * @param string activation_key //Activation key
	 * @return none
	 * 
	 * Test scripts in the meantime, no actual working functionality yet 
	 * TODO: do actual functionalities to follow. no generated client yet
	 */
	public function activate_user_get()
	{
		
		$email = $this->input->get('email');
		$password = $this->input->get('password');
		
		$options = array(
			'email' 	=> $email,
			'password' 	=> $password,
			'activation_key' => $this->input->get('activation_key')
		);
		if( true === $this->User->activateUser($options) ) {
			//do webapp redirection here with auto log in
		}
		
	}
	
}