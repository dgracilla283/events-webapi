<?php
class Map_Reference extends CI_Model{
	
	protected $cacheAdapter = 'file';
	protected $cacheBackupAdapter = 'file';
	
	public function __construct() {
		parent::__construct();
		$this->load->driver('cache', array('adapter'=>$this->cacheAdapter, 'backup'=>$this->cacheBackupAdapter));
	}
	/**
	 *
	 * Creates a record in the user table
	 */
	function add($options){

		if (empty($options['map_photo_id'])) {
			return false;
		}
		
		$requiredField = array(
			'map_photo_id',
			'reference_type',
			'reference_id', 
		);
		
		foreach($requiredField as $field) {
			if(isset($options[$field])) 
				$this->db->set($field, $options[$field]);	
		}


		// Execute the query
   		$this->db->insert('map_reference');
   		$this->db->cache_delete_all();
		
		return $this->db->insert_id();
	}
	
	/**
	 *
	 * Update a record in the user table
	 */
	function update($options, $pid) {
		
		if (empty($options['mapReferenceID'])) {
				return false;
		}
		
		$requiredField = array(
			'map_photo_id',
			'reference_type',
			'reference_id', 
		);
		
		foreach($requiredField as $field) {
			if(isset($options[$field])) {
				$this->db->set($field, $options[$field]);
			}	
		}
		$this->db->set('updated_at', date('Y-m-d H:i:s'));
		
		$this->db->where('mapReferenceID', $options['mapReferenceID']);
		$this->db->update('map_reference', $data);
		$this->db->cache_delete_all();
		
		return $options['mapReferenceID'];
		
		/*if (empty($options['s_mapname'])) {
			return false;
		}
		
		$requiredField = array(
							'event_id', 
							'reference_type', 
							'reference_id',
							's_mapname',
							's_origdata',
							'b_is_deleted'
						);
						
		unset($options['userPhotoID']);
		
		$data = array();
		foreach($requiredField as $field) {
			if(isset($options[$field]))
				$this->db->set($field, $options[$field]);
		}
		
		$this->db->where('userPhotoID', $pid);
		$this->db->update('user_photo', $data);
		$this->db->cache_delete_all();
		
		return $pid;*/
	}
	
	/**
	 *
	 * Delete a record in the user table
	 */
	function delete($options){
		if (empty($options['mapReferenceID'])) {
			return false;
		}
		$this->db->where('mapReferenceID', $options['mapReferenceID']);
		$this->db->cache_delete_all();		
    	return $this->db->delete('map_reference');
	}
	

	/**
	 * 
	 * Retrieve user
	 */
	function fetch($options = array()){
		$this->db->cache_on(); 
		$sortOrder = !empty($options['sort_order']) ? $options['sort_order'] : 'ASC'; 
		$sortBy = !empty($options['sort_field']) ? $options['sort_field'] : 'mapReferenceID';
		
		
		$this->db->select('*')->from('map_reference');
		if (!empty($options['mapReferenceID'])) {
			$this->db->where('mapReferenceID', $options['mapReferenceID']);
		}		
		$this->db->order_by($sortBy, $sortOrder);			 
		$query = $this->db->get();		
		
		if($query->num_rows()>0){
			// return result set as an associative array
			return $query->result_array();
		}
		
		return array();
	}


}