<?php
class Event_Owner extends CI_Model{
	
	protected $cacheAdapter = 'file';
	protected $cacheBackupAdapter = 'file';
	
	private $tableName = 'event_owner';
	
	public function __construct() {
		parent::__construct();
		$this->load->driver('cache', array('adapter'=>$this->cacheAdapter, 'backup'=>$this->cacheBackupAdapter));
	}
	/**
	 *
	 * Creates a record in the event owner table
	 */
	function addEventOwner($options){
		$requiredField = array(
			'user_id', 
			'event_id',
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
	 * Update a record in the event owner table
	 */
	function updateEventOwner($options, $eventOwnerID){
		$requiredField = array(
			'user_id',
			'event_id'
		);
		foreach($requiredField as $field) {
			if(isset($options[$field]))
				$data[$field] = $options[$field];
		}
		
		$this->db->where('eventOwnerId', $eventOwnerID);
		$this->db->update($this->tableName, $data);
		$this->db->cache_delete_all();
		return $eventOwnerID;
	}
	
	/**
	 *
	 * Delete a record in the owner table according to event 
	 */
	function deleteEventOwner($options){
		$where = array('user_id' => $options['user_id'], 'event_id' => $options['event_id']); 
		$this->db->where($where);
		$this->db->cache_delete_all();
		return $this->db->delete($this->tableName);
	}
	
	/**
	 *
	 * Delete a record in the owner table according to user id 
	 */
	function deleteEventOwnerByUserID($options){
		$where = array('user_id' => $options['uid']); 
		$this->db->where($where);
		$this->db->cache_delete_all();
		return $this->db->delete($this->tableName);
	}

	/**
	 *
	 * Retrieve guest
	 */
	function getAllEventOwners($filter=array()){
		$this->db->cache_on();
		$this->db->select('*')->from($this->tableName);
		
		if (!empty($filter['eventOwnerID'])) {
			$this->db->where('eventOwnerID', $filter['eventOwnerID']);
		}
		if (!empty($filter['event_id'])) {
			$this->db->where('event_id', $filter['event_id']);
		}
		if (!empty($filter['user_id'])) {
			$this->db->where('user_id', $filter['user_id']);
		}
		
		if(!empty($filter['page']) && !empty($filter['per_page']))
			$this->db->limit($filter['per_page'], ($filter['page'] - 1) * $filter['per_page']);
				
		$query = $this->db->get(); 
		if($query->num_rows() > 0){
			// return result set as an associative array
			return $query->result_array();
		}
	}

	/**
	 * Counting rows with optional filter
	 */
	function getNumEventOwners($filter=array()){
		if (!empty($filter['eventOwnerID'])) {
			$this->db->where('eventOwnerID', $filter['eventOwnerID']);
		}
		
		if (!empty($filter['event_id'])) {
			$this->db->where('event_id', $filter['event_id']);
		}

		if (!empty($filter['user_id'])) {
			$this->db->where('user_id', $filter['user_id']);
		}
	
		$this->db->select('*')->from($this->tableName);
		
		return !empty($filter) ? $this->db->count_all_results() : $this->db->count_all($this->tableName);
	}
	

	/**
	 * Searches event owner by name
	 */
	public function searchEventOwnerByName( $filter )
	{
		$this->db->cache_on();
		$this->db->select('user.userID, 
				user.first_name, user.last_name,
				user.email, user.affiliation,
				user.title, event_attendee.eventOwnerID')
			->from('user')
			->join($this->tableName, 'user.userID = event_owner.user_id');
				
		if(isset($filter['name']) && !empty($filter['name'])) {
			$this->db->like('user.last_name', $filter['name']);
		}
		if(isset($filter['event_id']) && !empty($filter['event_id'])) {
			$this->db->where('event_owner.event_id', $filter['event_id']);
		}
				
		$this->db->group_by('user.userID');
		$query = $this->db->get();
		
		return $query->result_array();
	}
	
}