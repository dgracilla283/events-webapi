<?php
class Activity_Preference_Option extends CI_Model{
	
	protected $cacheAdapter = 'file';
	protected $cacheBackupAdapter = 'file';
	private $tableName = 'activity_preference_option'; 
	
	public function __construct() {
		parent::__construct();
		$this->load->driver('cache', array('adapter'=>$this->cacheAdapter, 'backup'=>$this->cacheBackupAdapter));
	}
	
	/**
	 *
	 * Creates a record in the activity_preference table
	 */
	function addActivityPreferenceOption($options){
		$requiredFields = array(
			'activityPreferenceID',  
			'title', 
			'description',
			'dateCreated', 
			'dateUpdated'
		);
		foreach($requiredFields as $field) {
			if(isset($options[$field]))
			$this->db->set($field, $options[$field]);
		}
		
		// delete caching
		$this->db->cache_delete('api_activity_preference_option', $this->tableName);

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
	function updateActivityPreferenceOption($options){
		$requiredFields = array(
			'activityPreferenceID',  
			'title', 
			'description',
			'dateCreated', 
			'dateUpdated'
		);

		$data = array();
		foreach($requiredFields as $field) {
			if(isset($options[$field]))
			$data[$field] = $options[$field];
		}
		$this->db->where('activityPreferenceOptionID', $options['activityPreferenceOptionID']);
		$this->db->update($this->tableName, $data);
		
		// delete cache
		$this->db->cache_delete_all();

		return $options['activityPreferenceOptionID'];
	}

	/**
	 *
	 * Delete a record in the activity_preference table
	 */
	function deleteActivityPreferenceOption($filters = false){		
		if(!empty($filters['activityPreferenceOptionID'])) {
			$this->db->where('activityPreferenceOptionID', $filters['activityPreferenceOptionID']);
		}
		if(!empty($filters['activityPreferenceID'])) {
			$this->db->where('activityPreferenceID', $filters['activityPreferenceID']);
		}
		// delete cache		
		$this->db->cache_delete_all();			
		return $this->db->delete($this->tableName);
				
	}


	/**
	 *
	 * Retrieve activity_preferences_options 
	 */
	function getActivityPreferenceOptions($filters = false){
		if(!empty($filters['activityPreferenceOptionID'])) {
			$this->db->where('activityPreferenceOptionID', $filters['activityPreferenceOptionID']);
		}
		if(!empty($filters['activityPreferenceID'])) {
			$this->db->where('activityPreferenceID', $filters['activityPreferenceID']);
		}
		// turn-on cache
		$this->db->cache_on();		
		$query= $this->db->get($this->tableName);
		$data = array(); 
		if($query->num_rows()>0){
			// return result set as an associative array
			$data = $query->result_array();
		}
		return $data; 
	}

	// get total number of activity_preferences
	function getNumActivityPreferenceOptions(){
		return $this->db->count_all($this->tableName);
	}
	
	
}