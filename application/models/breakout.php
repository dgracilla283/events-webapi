<?php
class Breakout extends CI_Model{
	
	protected $cacheAdapter = 'file';
	protected $cacheBackupAdapter = 'file';
	
	public function __construct() {
		parent::__construct();
		$this->load->driver('cache', array('adapter'=>$this->cacheAdapter, 'backup'=>$this->cacheBackupAdapter));
	}
	/**
	 *
	 * Creates a record in the breakout table
	 */
	function addBreakout($options){
		$requiredField = array(
							'itinerary_id', 
							'title',
							'description',
							'start_date_time',
							'end_date_time',
							'created_at',
							'updated_at',
							'author_id',
							'location',
							'attendees_limit'
		);

		foreach($requiredField as $field) {
			if(isset($options[$field]))
			$this->db->set($field, $options[$field]);
		}

		// Execute the query
		$this->db->insert('breakout');
		// delete cache
		$this->db->cache_delete_all();

		return $this->db->insert_id();
	}

	/**
	 *
	 * Update a record in the breakout table
	 */
	function updateBreakout($options){
		$requiredField = array(
							'itinerary_id', 
							'title', 
							'description', 
							'start_date_time',
							'end_date_time',
							'created_at',
							'updated_at',
							'author_id',
							'location',
							'attendees_limit'
		);
		
		$data = array();
		foreach($requiredField as $field) {
			if(isset($options[$field]))
				$this->db->set($field, $options[$field]);
		}
		$this->db->where('breakoutID', $options['breakoutID']);
		$this->db->update('breakout', $data);
		// delete cache
		$this->db->cache_delete_all();

		return $options['breakoutID'];
	}

	/**
	 *
	 * Delete a record in the breakout table
	 */
	function deleteBreakout($options){
		$this->db->where('breakoutID', $options['breakoutID']);		
		$this->db->cache_delete_all();
		return $this->db->delete('breakout');
	}
	
	/**
	 *
	 * Retrieve Event breakout
	 */
	function getItineraryBreakouts($iid){
		$this->db->cache_on();
		$this->db->where('itinerary_id', $iid);
		$query= $this->db->get('breakout');		
		$data = array();
		if($query->num_rows()>0){
			// return result set as an associative array
			$data =  $query->result_array();
		}
		return $data;
	}

	/**
	 *
	 * Retrieve breakout
	 */
	function getAllBreakouts($filter=array()){
		$this->db->cache_on();
		if (!empty($filter['itinerary_id'])) {
			$this->db->where('itinerary_id', $filter['itinerary_id']);
		}
		
		if (!empty($filter['breakoutID'])) {
			$this->db->where('breakoutID', $filter['breakoutID']);
		}
		
		$query = $this->db->get('breakout');
		
		$data = array();
		if($query->num_rows()>0){
			$data = $query->result_array();
		}
		return $data;
	}

	// get total number of breakout
	function getNumBreakouts(){
		return $this->db->count_all('breakout');
	}

}