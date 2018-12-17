<?php
/**
 * Generated automatically through the api client generator
 * @created    Tue, 28 Jan 2014 01:37:08 -0500
 */

require_once APPPATH . 'libraries/Api.php';
class api_user_photo_client{
	private $_ci;
    private $_api;
    
    public function __construct() {
        $this->_ci =& get_instance();
        $this->_ci->config->load('config_services', true, true);
        $arrServices = $this->_ci->config->item('config_services');
        $this->_api = new Api($arrServices['services']['api_user_photo']);
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
    public function user_photo_get($params = array(), $format = 'json')
    {
    	return $this->_api->fetch('api_user_photo/user_photo', $params, false, $format);
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
    public function user_photo_post($params = array(), $format = 'json')
    {
    	return $this->_api->fetch('api_user_photo/user_photo', $params, true, $format);
    }
	/**
	 * @method get
	 * @param int p_i_pid // photo id
	 * @return json/xml data
	 */
    public function remove_photo_get($params = array(), $format = 'json')
    {
    	return $this->_api->fetch('api_user_photo/remove_photo', $params, false, $format);
    }
	/**
	 * @method get
	 * @param string uids // comma delimitted list of user ids
	 */
    public function fetch_multi_by_userid_get($params = array(), $format = 'json')
    {
    	return $this->_api->fetch('api_user_photo/fetch_multi_by_userid', $params, false, $format);
    }
}
