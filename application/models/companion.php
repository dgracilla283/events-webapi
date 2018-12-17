<?php
class Companion extends CI_Model{

	protected $cacheAdapter = 'file';
	protected $cacheBackupAdapter = 'file';
	private $tableName = 'event_attendee_companion';

	public function __construct() {
		parent::__construct();
		$this->load->driver('cache', array('adapter'=>$this->cacheAdapter, 'backup'=>$this->cacheBackupAdapter));
	}

	/**
	 *
	 * Creates a record in the event_attendee_companion table
	 */
	function addCompanion($options){
		$requiredFields = array(
			'primary_user_id',
			'user_id',
			'type',
		);
		foreach($requiredFields as $field) {
			if(isset($options[$field]))
			$this->db->set($field, $options[$field]);
		}

		// Execute the query
		$this->db->insert($this->tableName);

		return $this->db->insert_id();
	}

	/**
	 *
	 * Retrieve companions
	 */
	function getAllCompanions($filter=array()){
		$this->db->select('*')->from($this->tableName);
		if (!empty($filter['primary_user_id'])) {
			$this->db->where('primary_user_id', $filter['primary_user_id']);
		}
		if (!empty($filter['type'])) {
			$this->db->where('type', $filter['type']);
		}
		if (!empty($filter['user_id'])) {
			$this->db->where('user_id', $filter['user_id']);
		}
		$query = $this->db->get();
		if($query->num_rows() > 0){
			// return result set as an associative array
			return $query->result_array();
		}
	}

	/**
	 *
	 * Retrieve primary user
	 */
	function getPrimaryUser($filter=array()){

		$this->db->select('*')->from($this->tableName);
		if (!empty($filter['user_id'])) {
			$this->db->where('user_id', $filter['user_id']);
		}
		$query = $this->db->get();
		if($query->num_rows() > 0){
			// return result set as an associative array
			return $query->result_array();
		}
	}

	/**
	 *
	 * Delete a record in the event_attendee_companion table
	 */
	function deleteCompanion($filters = false){
		if(!empty($filters['user_id'])) {
			$this->db->where('user_id', $filters['user_id']);
		}
		if(!empty($filters['primary_key_id'])) {
			$this->db->where('primary_key_id', $filters['primary_key_id']);
		}
		if(!empty($filters['companionID'])) {
			$this->db->where('companionID', $filters['companionID']);
		}
		// delete cache
		$this->db->cache_delete_all();
		return $this->db->delete($this->tableName);

	}


}