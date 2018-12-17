<?php
class Activity_Preference extends CI_Model{
	
	protected $cacheAdapter = 'file';
	protected $cacheBackupAdapter = 'file';
	private $tableName = 'activity_preference'; 
	
	public function __construct() {
		parent::__construct();
		$this->load->driver('cache', array('adapter'=>$this->cacheAdapter, 'backup'=>$this->cacheBackupAdapter));
	}
	
	/**
	 *
	 * Creates a record in the activity_preference table
	 */
	function addActivityPreference($options){		  
		$requiredFields = array(
			'referenceID', 
			'eventID',
			'referenceType', 
			'optionDisplayType', 
			'title', 
			'description',
			'isRequired',  
			'dateCreated', 
			'dateUpdated'
		);
		foreach($requiredFields as $field) {
			if(isset($options[$field]))
			$this->db->set($field, $options[$field]);
		}
		 
		// delete caching
		$this->db->cache_delete('api_activity_reference', $this->tableName);

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
	function updateActivityPreference($options){
		$requiredFields = array(
			'referenceID', 
			'eventID',
			'referenceType',
			'optionDisplayType',  
			'title', 
			'description',
			'isRequired', 
			'dateCreated', 
			'dateUpdated'
		);

		$data = array();
		foreach($requiredFields as $field) {
			if(isset($options[$field]))
			$data[$field] = $options[$field];
		}
		$this->db->where('activityPreferenceID', $options['activityPreferenceID']);
		$this->db->update($this->tableName, $data);
		
		// delete cache
		$this->db->cache_delete_all();

		return $options['activityPreferenceID'];
	}

	/**
	 *
	 * Delete a record in the activity_preference table
	 */
	function deleteActivityPreference($filters = false){
		if(!empty($filters['activityPreferenceID'])) {
			$this->db->where('activityPreferenceID', $filters['activityPreferenceID']);
		}  
		if(!empty($filters['referenceID'])) {
			$this->db->where('referenceID', $filters['referenceID']);
		}
		if(!empty($filters['referenceType'])) {
			$this->db->where('referenceType', $filters['referenceType']);
		}
		if(!empty($filters['eventID'])) {
			$this->db->where('eventID', $filters['eventID']);
		}
		// delete cache		
		$this->db->cache_delete_all();
		return $this->db->delete($this->tableName);
			
	}


	/**
	 *
	 * Retrieve activity_preferences
	 */
	function getActivityPreferences($filters = false){
		if(!empty($filters['activityPreferenceID'])) {
			$this->db->where('activityPreferenceID', $filters['activityPreferenceID']);
		}  
		if(!empty($filters['referenceID'])) {
			$this->db->where('referenceID', $filters['referenceID']);
		}
		if(!empty($filters['referenceType'])) {
			$this->db->where('referenceType', $filters['referenceType']);
		}
		if(!empty($filters['eventID'])) {
			$this->db->where('eventID', $filters['eventID']);
		}
		$query= $this->db->get($this->tableName);
		$data = array();		  
		if($query->num_rows()>0){
			// return result set as an associative array
			$data = $query->result_array();
		}
		return $data; 
	}

	// get total number of activity_preferences
	function getNumActivityPreferences(){ 
		return $this->db->count_all('activity_preference');
	}
	
	
}