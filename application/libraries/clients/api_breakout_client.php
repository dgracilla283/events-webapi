<?php
/**
 * Generated automatically through the api client generator
 * @created    Wed, 22 Jan 2014 03:37:10 -0500
 */

require_once APPPATH . 'libraries/Api.php';
class api_breakout_client{
	private $_ci;
    private $_api;
    
    public function __construct() {
        $this->_ci =& get_instance();
        $this->_ci->config->load('config_services', true, true);
        $arrServices = $this->_ci->config->item('config_services');
        $this->_api = new Api($arrServices['services']['api_breakout']);
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
    public function breakouts_get($params = array(), $format = 'json')
    {
    	return $this->_api->fetch('api_breakout/breakouts', $params, false, $format);
    }
	/**
	 * @method get
	 * @param int id // the id of the Breakout to fetch
	 * @return json/xml data
	 */
    public function breakout_get($params = array(), $format = 'json')
    {
    	return $this->_api->fetch('api_breakout/breakout', $params, false, $format);
    }
	/**
	 * @method post
	 * @param int bid // optional id of Breakout
	 * @param int itinerary_id // itinerary_id of Breakout
	 * @param string title // Breakout title
	 * @param string description // Breakout description
	 * @param string location // Breakout location
	 * @param string start_date_time // Breakout start date
	 * @param string start_date_time // Breakout end date
	 * @param int attendees_limit // Breakout attendees limit
	 * @return json/xml data
	 */
    public function breakout_post($params = array(), $format = 'json')
    {
    	return $this->_api->fetch('api_breakout/breakout', $params, true, $format);
    }
	/**
	 * @method get
	 * @param int bid // optional id of Breakout
	*/
    public function remove_breakout_get($params = array(), $format = 'json')
    {
    	return $this->_api->fetch('api_breakout/remove_breakout', $params, false, $format);
    }
}
