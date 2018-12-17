<?php
require_once APPPATH . 'libraries/Rest.php';

class api
{
	private $_data = array();
	private $_rest;
	private $_ci;
	
	public function __construct($service_url) {
	    $this->_ci =& get_instance();
	    //$this->_ci->load->library('rest', array('server'=>$service_url));
	    //$this->_rest = $this->_ci->rest;
	    $this->_rest = new Rest(array('server'=>$service_url));

	}

	public function response() {
		$response = $this->_data();
        return $response;
	}

	public function data() {
		return $this->_data;
	}
	
	public function add($key, $val) {
		$this->_data[$key] = $val;
	}
	
	public function get($key) {
		return $this->_data[$key];
	}
	
	public function fetch($uri, $args = array(), $post = false, $format)
	{
        
	    // start timer
		$start = microtime(true);
		//@TODO: add logging mechanism
		//@TODO: add timeouts for rest request/response
        if (!$post) {
       		$result = $this->_rest->get($uri, $args, $format);
        } else if ($post) {
       		$result = $this->_rest->post($uri, $args, $format);
        }
        $end = microtime(true) - $start;

		return $result;
	}

}


