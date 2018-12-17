<?php
class Guest extends CI_Model{
	
	protected $cacheAdapter = 'file';
	protected $cacheBackupAdapter = 'file';
	
	private $tableName = 'event_attendee';
	
	public function __construct() {
		parent::__construct();
		$this->load->driver('cache', array('adapter'=>$this->cacheAdapter, 'backup'=>$this->cacheBackupAdapter));
	}
	/**
	 *
	 * Creates a record in the guest table
	 */
	function addGuest($options){
		$requiredField = array(
			'user_id', 
			'event_id',
			'reference_type', 
			'reference_id',
			'role_id', 
			'team', 
			'status'  
		);

		foreach($requiredField as $field) {
			if(isset($options[$field]))
			$this->db->set($field, $options[$field]);
		}

		// Execute the query
		$this->db->insert($this->tableName);
		$this->db->cache_delete_all();

		return $this->db->insert_id();
	}

	/**
	 *
	 * Update a record in the guest table
	 */
	function updateGuest($options, $eventAttendeeID){
		$requiredField = array(
			'user_id',
			'event_id',
			'reference_type',
			'reference_id',
			'role_id', 
			'team', 
			'status'
		);
		foreach($requiredField as $field) {
			if(isset($options[$field]))
				$data[$field] = $options[$field];
		}
		
		$this->db->where('eventAttendeeID', $eventAttendeeID);
		$this->db->update($this->tableName, $data);
		$this->db->cache_delete_all();
		return $eventAttendeeID;
	}

	/**
	 *
	 * Delete a record in the guest table
	 */
	function deleteGuest($options){		
		$where = array(); 
		if(!empty($options['eventAttendeeID']))
			$where['eventAttendeeID'] = $options['eventAttendeeID']; 
		if(!empty($options['event_id']))
			$where['event_id'] = $options['event_id'];	
		if(!empty($options['reference_id']))
			$where['reference_id'] = $options['reference_id'];	
		if(!empty($options['user_id']))
			$where['user_id'] = $options['user_id'];	
		if(!empty($options['role_id']))
			$where['role_id'] = $options['role_id'];
			
		$this->db->where($where);
		$this->db->cache_delete_all();
		$result = array('result' => $this->db->delete($this->tableName));
		return $result;
	}
	
	/**
	 *
	 * Delete a record in the guest table according to event 
	 */
	function deleteEventGuest($options){
		$where = array('user_id' => $options['user_id'], 'event_id' => $options['event_id']); 
		$this->db->where($where);
		$this->db->cache_delete_all();
		return $this->db->delete($this->tableName);
	}
	
	/**
	 *
	 * Delete a record in the guest table according to reference id 
	 */
	function deleteGuestByReferenceID($options){
		$where = array('reference_id' => $options['reference_id']); 
		$this->db->where($where);
		$this->db->cache_delete_all();
		return $this->db->delete($this->tableName);
	}
	
	/**
	 *
	 * Delete a record in the guest table according to user id 
	 */
	function deleteGuestByUserID($options){
		$where = array('user_id' => $options['uid']); 
		$this->db->where($where);
		$this->db->cache_delete_all();
		return $this->db->delete($this->tableName);
	}

	/**
	 *
	 * Retrieve guest
	 */
	function getAllGuests($filter=array()){
		$response = array();
		$this->db->cache_on();
		$this->db->select('*')->from($this->tableName);
		
		if (!empty($filter['eventAttendeeID'])) {
			$this->db->where('eventAttendeeID', $filter['eventAttendeeID']);
		}
		if (!empty($filter['event_id'])) {
			$this->db->where('event_id', $filter['event_id']);
		}
		if (!empty($filter['user_id'])) {
			$this->db->where('user_id', $filter['user_id']);
		}
		if (!empty($filter['reference_id'])) {
			$this->db->where('reference_id', $filter['reference_id']);
		}		
		if (!empty($filter['role_id'])) {
			$this->db->where('role_id', $filter['role_id']);
		}
		if (!empty($filter['event_id'])) {
			$this->db->where('event_id', $filter['event_id']);
		}
		if (!empty($filter['reference_type'])) {
			$this->db->where('reference_type', $filter['reference_type']);
		}
		if (!empty($filter['status'])) {
			$this->db->where('status', $filter['status']);
		}
		
		if (!empty($filter['order_by'])) {
			$this->db->order_by($filter['order_by'], "asc"); 
		}
		
		if(!empty($filter['page']) && !empty($filter['per_page']))
			$this->db->limit($filter['per_page'], ($filter['page'] - 1) * $filter['per_page']);
				
		$query = $this->db->get(); 
		if($query->num_rows() > 0){
			// return result set as an associative array
			$response = $query->result_array();
		} 
		return $response;
	}

	/**
	 * Counting rows with optional filter
	 */
	function getNumGuests($filter=array()){
		if (!empty($filter['eventAttendeeID'])) {
			$this->db->where('eventAttendeeID', $filter['eventAttendeeID']);
		}
		if (!empty($filter['event_id'])) {
			$this->db->where('event_id', $filter['event_id']);
		}
		if (!empty($filter['user_id'])) {
			$this->db->where('user_id', $filter['user_id']);
		}
		if (!empty($filter['reference_id'])) {
			$this->db->where('reference_id', $filter['reference_id']);
		}
		if (!empty($filter['role_id'])) {
			$this->db->where('role_id', $filter['role_id']);
		}
		$this->db->select('*')->from($this->tableName);
		
		return !empty($filter) ? $this->db->count_all_results() : $this->db->count_all($this->tableName);
	}
	
	/**
	 * Get event speaker
	 */
	public function getEventSpeaker($filter=array()) {
		$this->db->cache_on();
		$this->db->select('*')->from($this->tableName);
		if (!empty($filter['event_id'])) {
			$this->db->where('event_id', $filter['event_id']);
		}
		if (!empty($filter['reference_id'])) {
			$this->db->where('reference_id', $filter['reference_id']);
		}
		$query = $this->db->get();
		return $query->result_array();
	}
	

	/**
	 * Searches event guest by name
	 */
	public function searchGuestByName( $filter )
	{
		$this->db->cache_on();
		$this->db->select('user.userID, 
				user.first_name, user.last_name,
				user.email, user.affiliation,
				user.title, event_attendee.eventAttendeeID')
			->from('user')
			->join($this->tableName, 'user.userID = event_attendee.user_id');
				
		if(isset($filter['name']) && !empty($filter['name'])) {
			$this->db->like('user.last_name', $filter['name']);
		}
		if(isset($filter['event_id']) && !empty($filter['event_id'])) {
			$this->db->where('event_attendee.event_id', $filter['event_id']);
		}
				
		$this->db->group_by('user.userID');
		$query = $this->db->get();
		
		return $query->result_array();
	}

	/**
	 *
	 * Retrieve guest
	 */
	function getUserConcurrentActivities($filter=array()){
		
		$this->db->cache_on();
		
		$userId = $filter['user_id'];
		$startDate = $filter['start_date'];
		$endDate = $filter['end_date'];
		
		$this->db->select('user_id, first_name, last_name, itinerary.title, itinerary.description,reference_id, itinerary.start_date_time, itinerary.end_date_time');
		$this->db->from('event_attendee');
		$this->db->join('itinerary', 'reference_id = itinerary.itineraryID', 'inner');
		$this->db->join('user','user_id=user.userID','left');
		$where = "user_id = '$userId' AND ((itinerary.start_date_time<='$startDate' AND itinerary.end_date_time>='$startDate') 
		OR (itinerary.start_date_time>='$startDate' AND itinerary.start_date_time<'$endDate')) GROUP BY reference_id";
		$this->db->where($where);
		
		/*
		SELECT user_id, reference_id, itinerary.start_date_time, itinerary.end_date_time
		FROM event_attendee 
		INNER JOIN itinerary
		WHERE reference_id=itinerary.itineraryID
		AND user_id = 36
		AND ((itinerary.start_date_time<='2013-02-07 9:00:00' AND itinerary.end_date_time>='2013-02-07 9:00:00') 
		OR (itinerary.end_date_time <= '2013-02-07 11:00:00'))
		
		&start_date=2013-02-07 9:00:00&end_date=2013-02-07 11:00:00
		 */
		
		$query = $this->db->get();
		return $query->result_array();
	}
	
	
	/**
	 *
	 * Deletes guest according to reference type and reference id
	 */
	public function deleteGuestByReference($options)
	{
		$where = array(
			'user_id' => $options['user_id'],
			'reference_type' => $options['reference_type'],
			'reference_id' => $options['reference_id']
		); 
		$this->db->where($where);
		$this->db->cache_delete_all();
		return $this->db->delete($this->tableName);
	}
	
	
	/*
	 * Update Status
	 */
	public function updateStatus($options)
	{
		if(!empty($options['eventAttendeeIDs'])){
			$count = 0;
			$eventAttenddeIDs = explode(',', $options['eventAttendeeIDs']);			
			foreach($eventAttenddeIDs as $id){
				if($count = 0){
					$this->db->where('eventAttendeeID', $id);
				}else{
					$this->db->or_where('eventAttendeeID', $id);
				}
				$count++; 
			}
		}		
		$data['status'] = $options['status'];
		$this->db->cache_delete_all();
		return  $this->db->update($this->tableName, $data);
	}
	
}