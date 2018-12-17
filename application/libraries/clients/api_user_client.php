<?php
/**
 * Generated automatically through the api client generator
 * @created    Wed, 22 Jan 2014 03:37:10 -0500
 */

require_once APPPATH . 'libraries/Api.php';
class api_user_client{
	private $_ci;
    private $_api;
    
    public function __construct() {
        $this->_ci =& get_instance();
        $this->_ci->config->load('config_services', true, true);
        $arrServices = $this->_ci->config->item('config_services');
        $this->_api = new Api($arrServices['services']['api_user']);
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
    public function users_get($params = array(), $format = 'json')
    {
    	return $this->_api->fetch('api_user/users', $params, false, $format);
    }
	/**
	 * @method get
	 * @param int is_primary // user type
	 */
    public function num_users_get($params = array(), $format = 'json')
    {
    	return $this->_api->fetch('api_user/num_users', $params, false, $format);
    }
	/**
	 * @method get
	 * @param int id // the id of the user to fetch
	 * @return json/xml data
	 */
    public function user_get($params = array(), $format = 'json')
    {
    	return $this->_api->fetch('api_user/user', $params, false, $format);
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
    public function user_post($params = array(), $format = 'json')
    {
    	return $this->_api->fetch('api_user/user', $params, true, $format);
    }
	/**
	 * @method get
	 * @param string email
	 * @param string password
	 * @return json/xml userData
	 */
    public function login_get($params = array(), $format = 'json')
    {
    	return $this->_api->fetch('api_user/login', $params, false, $format);
    }
	/**
	 * @method get
	 * @param int uid // user id
	 * @return json/xml data
	 */
    public function remove_user_get($params = array(), $format = 'json')
    {
    	return $this->_api->fetch('api_user/remove_user', $params, false, $format);
    }
	/**
	 * @method get
	 * @param int uid // user id
	 * @return json/xml data
	 */
    public function remove_guest_user_get($params = array(), $format = 'json')
    {
    	return $this->_api->fetch('api_user/remove_guest_user', $params, false, $format);
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
    public function activate_user_get($params = array(), $format = 'json')
    {
    	return $this->_api->fetch('api_user/activate_user', $params, false, $format);
    }
}
