<?php
/**
 * Generated automatically through the api client generator
 * @created    Wed, 22 Jan 2014 03:37:10 -0500
 */

require_once APPPATH . 'libraries/Api.php';
class api_event_client{
	private $_ci;
    private $_api;
    
    public function __construct() {
        $this->_ci =& get_instance();
        $this->_ci->config->load('config_services', true, true);
        $arrServices = $this->_ci->config->item('config_services');
        $this->_api = new Api($arrServices['services']['api_event']);
    }
    
	/**
	 * @method get
	 * @param string category	// id parameter of type integer
	 * @param string sort_field // the field to sort
	 * @param string sort_order // ASC|DESC sort order
	 * @param int page // the current page in the pagination
	 * @param int per_page // the limit of rows per page
	 * @param int status	//1= published events, 0=unpublished events
	 * @return json/xml data
	 */
    public function events_get($params = array(), $format = 'json')
    {
    	return $this->_api->fetch('api_event/events', $params, false, $format);
    }
	/**
	 * @method get
	 * @param int id // the id of the event to fetch
	 * @return json/xml data
	 */
    public function event_get($params = array(), $format = 'json')
    {
    	return $this->_api->fetch('api_event/event', $params, false, $format);
    }
	/**
	 * @method post
	 * @param int eid // optional id of event
	 * @param string title // event title
	 * @param string location // event location
	 * @param string description // event description
	 * @param string start_date_time // event start date
	 * @param string end_date_time // event end date
	 * @param int status // flag for showing/hiding event
	 * @param int additional_info // flag for showing/hiding event
	 * @param int attendees_limit // limit of attendees
	 * @return json/xml data
	 */
    public function event_post($params = array(), $format = 'json')
    {
    	return $this->_api->fetch('api_event/event', $params, true, $format);
    }
	/**
	 * @method get
	 * @param int eid // id of Event
	 * @return json/xml data
	 */
    public function event_remove_get($params = array(), $format = 'json')
    {
    	return $this->_api->fetch('api_event/event_remove', $params, false, $format);
    }
}
