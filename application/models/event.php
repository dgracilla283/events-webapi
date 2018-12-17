<?php
class Event extends CI_Model{

	protected $cacheAdapter = 'file';
	protected $cacheBackupAdapter = 'file';
	private $tableName = 'events';

	public function __construct() {
		parent::__construct();
		$this->load->driver('cache', array('adapter'=>$this->cacheAdapter, 'backup'=>$this->cacheBackupAdapter));
	}

	/**
	 *
	 * Creates a record in the event table
	 */
	function addEvent($options){
		$requiredField = array(
							'title',
							'location',
							'description',
							'start_date_time',
							'end_date_time',
							'status',
							'additional_info',
							'attendees_limit'
							);
							foreach($requiredField as $field) {
								if(isset($options[$field]))
								$this->db->set($field, $options[$field]);
							}

							// delete caching
							$this->db->cache_delete('api_event', $this->tableName);

							// Execute the query
							$this->db->insert($this->tableName);

							// delete cache
							$this->db->cache_delete_all();

							return $this->db->insert_id();
	}

	/**
	 *
	 * Update a record in the event table
	 */
	function updateEvent($options){
		$requiredField = array(
							'title',
							'location',
							'description',
							'start_date_time',
							'end_date_time',
							'status',
							'additional_info',
							'attendees_limit'
							);

							$data = array();
							foreach($requiredField as $field) {
								if(isset($options[$field]))
								$data[$field] = $options[$field];
							}
							$this->db->where('eventID', $options['eventID']);
							$this->db->update($this->tableName, $data);

							// delete cache
							$this->db->cache_delete_all();

							return $options['eventID'];
	}

	/**
	 *
	 * Delete a record in the event table
	 */
	function deleteEvent($options){
		$this->db->where('eventID', $options['eventID']);
		// delete cache
		$this->db->cache_delete_all();
		return $this->db->delete($this->tableName);
	}


	/**
	 *
	 * Retrieve events
	 */
	function getAllEvents($options = array()){
		// turn-on cache
		//$this->db->cache_on();
		$current_date = 'NOW()';
		$sortField = 'start_date_time';
		$sortOrder = 'DESC';
		
		
		if (isset($options['add_offset']) && $options['add_offset']){
			$current_date = 'NOW() + INTERVAL 15 HOUR';
		}

		if(isset($options['title']) && !empty($options['title'])) {
			$this->db->where('title', $options['title']);
		}

		if(isset($options['status'])) {
			$this->db->where('status', $options['status']);
		}

		//To determine if event has already started
		if(isset($options['has_started']) && $options['has_started']) {
			if(isset($options['my_event']) && $options['my_event']) {
				$this->db->where("end_date_time >= ", $current_date, FALSE); 
			} else {
				$this->db->where("end_date_time > ", $current_date, FALSE); 
			}
		}

		//To determine if past event
		if(isset($options['is_past_event']) && $options['is_past_event']) {
			$this->db->where('end_date_time < '. $current_date);
		}
		
		if(isset($options['is_current_event']) && $options['is_past_event']) {
			$this->db->where('end_date_time >= '. $current_date);
		}

		if(isset($options['sort_field']) && !empty($options['sort_field']) &&
		isset($options['sort_order']) && !empty($options['sort_order'])) {
			$sortField = $options['sort_field'];
			$sortOrder = $options['sort_order'];
		}
		$this->db->order_by($sortField, $sortOrder);

		$query= $this->db->get($this->tableName);

		return $this->db->last_query();	
		if($query->num_rows()>0){
			// return result set as an associative array
			return $query->result_array();
		}
	}

	// get total number of events
	function getNumEvents(){
		return $this->db->count_all($this->tableName);
	}

}