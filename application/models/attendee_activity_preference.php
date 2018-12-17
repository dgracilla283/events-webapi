<?php
class Attendee_Activity_Preference extends CI_Model{
	
protected $cacheAdapter = 'file';
	protected $cacheBackupAdapter = 'file';
	private $tableName = 'attendee_activity_preference'; 
	
	public function __construct() {
		parent::__construct();
		$this->load->driver('cache', array('adapter'=>$this->cacheAdapter, 'backup'=>$this->cacheBackupAdapter));
	}
	
	/**
	 *
	 * Creates a record in the activity_preference table
	 */
	function addAttendeeActivityPreference($options){
		$requiredFields = array(
			'activityPreferenceID',  
			'activityPreferenceOptionID', 
			'userID',
			'value', 
			'dateCreated', 
			'dateUpdated'
		);
		foreach($requiredFields as $field) {
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
	 * Update a record in the activity_preference table
	 */
	function updateAttendeeActivityPreference($options){
		$requiredFields = array(
			'activityPreferenceID',  
			'activityPreferenceOptionID', 
			'userID',
			'value', 
			'dateCreated', 
			'dateUpdated'
		);

		$data = array();
		foreach($requiredFields as $field) {
			if(isset($options[$field]))
			$data[$field] = $options[$field];
		}
		$this->db->where('attendeeActivityPreferenceID', $options['attendeeActivityPreferenceID']);
		$this->db->update($this->tableName, $data);
		
		// delete cache
		$this->db->cache_delete_all();

		return $options['attendeeActivityPreferenceID'];
	}

	/**
	 *
	 * Delete a record in the activity_preference table
	 */
	function deleteAttendeeActivityPreference($filters){		
		if(!empty($filters['attendeeActivityPreferenceID'])){
			$this->db->where('attendeeActivityPreferenceID', $filters['attendeeActivityPreferenceID']);
		}
		if(!empty($filters['activityPreferenceID'])){
			$this->db->where('activityPreferenceID', $filters['activityPreferenceID']);
		}
		if(!empty($filters['activityPreferenceOptionID'])){
			$this->db->where('activityPreferenceOptionID', $filters['activityPreferenceOptionID']);
		}
		if(!empty($filters['userID'])){
			$this->db->where('userID', $filters['userID']);
		}
		// delete cache
		$this->db->cache_delete_all();
		return $this->db->delete($this->tableName);
	}


	/**
	 *
	 * Retrieve activity_preferences_options 
	 */
	function getAttendeeActivityPreferences($filters = false){
		if(!empty($filters['attendeeActivityPreferenceID'])){
			$this->db->where('attendeeActivityPreferenceID', $filters['attendeeActivityPreferenceID']);
		}
		if(!empty($filters['activityPreferenceID'])){
			$this->db->where('activityPreferenceID', $filters['activityPreferenceID']);
		}
		if(!empty($filters['activityPreferenceOptionID'])){
			$this->db->where('activityPreferenceOptionID', $filters['activityPreferenceOptionID']);
		}
		if(!empty($filters['userID'])){
			$this->db->where('userID', $filters['userID']);
		}
		// turn-on cache
		$this->db->cache_on();
		$query= $this->db->get($this->tableName);
		if($query->num_rows()>0){
			// return result set as an associative array
			return $query->result_array();
		}
	}

	// get total number of activity_preferences
	function getNumAttendeeActivityPreferences(){
		return $this->db->count_all($this->tableName);
	}
	
}