<?php
/**
 * Generated automatically through the api client generator
 * @created    Wed, 22 Jan 2014 03:37:10 -0500
 */

require_once APPPATH . 'libraries/Api.php';
class api_speaker_comment_client{
	private $_ci;
    private $_api;
    
    public function __construct() {
        $this->_ci =& get_instance();
        $this->_ci->config->load('config_services', true, true);
        $arrServices = $this->_ci->config->item('config_services');
        $this->_api = new Api($arrServices['services']['api_speaker_comment']);
    }
    
	/**
	 * @method get
	 * @param int speakerCommentID // optional speaker comment id
     * @param int event_attendee_id // speaker comment event attendee id
	 * @param string comment // speaker comment	 
     * @param string sort_field // the field to sort
	 * @param string sort_order // ASC|DESC sort order
	 * @param int page // the current page in the pagination
	 * @param int per_page // the limit of rows per page
	 * @return json/xml data
	 */
    public function speaker_comments_get($params = array(), $format = 'json')
    {
    	return $this->_api->fetch('api_speaker_comment/speaker_comments', $params, false, $format);
    }
	/**
	 * @method get
	 * @param int speakerCommentID // the id of the speaker comment to fetch
	 * @return json/xml data
	 */
    public function speaker_comment_get($params = array(), $format = 'json')
    {
    	return $this->_api->fetch('api_speaker_comment/speaker_comment', $params, false, $format);
    }
	/**
	 * @method post
	 * @param int speakerCommentID // optional speaker comment id
     * @param int event_attendee_id // speaker comment event attendee id
	 * @param string comment // speaker comment	 
	 * @return json/xml data
	 */
    public function speaker_comment_post($params = array(), $format = 'json')
    {
    	return $this->_api->fetch('api_speaker_comment/speaker_comment', $params, true, $format);
    }
	/**
	 * @method get
	 * @param int speakerCommentID // id of Speaker Comment
	 * @param int event_attendee_id // id of Event Attendee
	 * @return json/xml data
	 */
    public function speaker_comment_remove_get($params = array(), $format = 'json')
    {
    	return $this->_api->fetch('api_speaker_comment/speaker_comment_remove', $params, false, $format);
    }
}
