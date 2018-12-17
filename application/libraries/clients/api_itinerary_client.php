<?php
/**
 * Generated automatically through the api client generator
 * @created    Wed, 22 Jan 2014 03:37:10 -0500
 */

require_once APPPATH . 'libraries/Api.php';
class api_itinerary_client{
	private $_ci;
    private $_api;
    
    public function __construct() {
        $this->_ci =& get_instance();
        $this->_ci->config->load('config_services', true, true);
        $arrServices = $this->_ci->config->item('config_services');
        $this->_api = new Api($arrServices['services']['api_itinerary']);
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
    public function itineraries_get($params = array(), $format = 'json')
    {
    	return $this->_api->fetch('api_itinerary/itineraries', $params, false, $format);
    }
	/**
	 * @method get
	 * @param int id // the id of the Itinerary to fetch
	 * @return json/xml data
	 */
    public function itinerary_get($params = array(), $format = 'json')
    {
    	return $this->_api->fetch('api_itinerary/itinerary', $params, false, $format);
    }
	/**
	 * @method get
	 * @param int event_id // the id of the Event to fetch
	 * @return json/xml data
	 */
    public function event_itineraries_get($params = array(), $format = 'json')
    {
    	return $this->_api->fetch('api_itinerary/event_itineraries', $params, false, $format);
    }
	/**
	 * @method post
	 * @param int itineraryID // optional id of Itinerary
	 * @param int event_id // event id
	 * @param string title // Itinerary title
	 * @param string description // Itinerary description
	 * @param string start_date_time // Itinerary start date
	 * @param string end_date_time // Itinerary end date
	 * @param string location // Itinerary location
	 * @param int breakout_status // Breakout status
	 * @param int attendees_limit // Itinerary attendees limit
	 * @return json/xml data
	 */
    public function itinerary_post($params = array(), $format = 'json')
    {
    	return $this->_api->fetch('api_itinerary/itinerary', $params, true, $format);
    }
	/**
	 * @method get
	 * @param int itineraryID // id of Itinerary
	 * @param int event_id // id of Event
	 * @return json/xml data
	 */
    public function itinerary_remove_get($params = array(), $format = 'json')
    {
    	return $this->_api->fetch('api_itinerary/itinerary_remove', $params, false, $format);
    }
}
