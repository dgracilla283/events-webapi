<?php
class Presentation_Category extends CI_Model{
	
	protected $cacheAdapter = 'file';
	protected $cacheBackupAdapter = 'file';
	private $tableName = 'presentation_category'; 
	
	public function __construct() {
		parent::__construct();
		$this->load->driver('cache', array('adapter'=>$this->cacheAdapter, 'backup'=>$this->cacheBackupAdapter));
	}
	
	/**
	 *
	 * Creates a record in the presentation_category table
	 */
	function addPresentationCategory($options){		  
		$requiredFields = array(
			'name', 
			'event_id', 
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
	 * Update a record in the presentation_category table
	 */
	function updatePresentationCategory($options){
		$requiredFields = array(
			'name', 
			'event_id',
		);

		$data = array();
		foreach($requiredFields as $field) {
			if(isset($options[$field]))
			$data[$field] = $options[$field];
		}
		$this->db->where('presentationCategoryID', $options['presentationCategoryID']);
		$this->db->update($this->tableName, $data);
		
		// delete cache
		$this->db->cache_delete_all();

		return $options['presentationCategoryID'];
	}

	/**
	 *
	 * Delete a record in the presentation_category table
	 */
	function deletePresentationCategory($filters = false){
		if(!empty($filters['presentationCategoryID'])) {
			$this->db->where('presentationCategoryID', $filters['presentationCategoryID']);
		}  
		if(!empty($filters['event_id'])) {
			$this->db->where('event_id', $filters['event_id']);
		}
		// delete cache		
		$this->db->cache_delete_all();
		return $this->db->delete($this->tableName);
			
	}


	/**
	 *
	 * Retrieve presentation_categories
	 */
	function getPresentationCategories($filters = false){
		if(!empty($filters['presentationCategoryID'])) {
			$this->db->where('presentationCategoryID', $filters['presentationCategoryID']);
		} 
		if(!empty($filters['event_id'])) {
			$this->db->where('event_id', $filters['event_id']);
		}  	
		$query= $this->db->get($this->tableName);
		$data = array();		  
		if($query->num_rows()>0){
			// return result set as an associative array
			$data = $query->result_array();
		}
		return $data; 
	}

	// get total number of presentation_categories
	function getNumPresentationCategories(){ 
		return $this->db->count_all('presentation_category');
	}
	
	
}