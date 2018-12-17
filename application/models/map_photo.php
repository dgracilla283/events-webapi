<?php
class Map_Photo extends CI_Model{
	
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

		if (empty($options['s_fname'])) {
			return false;
		}
		
		$requiredField = array(
			's_fname',
			'title',
			'event_id', 
			'title', 
			's_origdata',
			'b_is_deleted'
		);
		
		foreach($requiredField as $field) {
			if(isset($options[$field])) 
				$this->db->set($field, $options[$field]);	
		}
		
		$this->db->set('created_at', date('Y-m-d H:i:s'));

		// Execute the query
   		$this->db->insert('map_photo');
   		$this->db->cache_delete_all();
		
		return $this->db->insert_id();
	}
	
	/**
	 *
	 * Update a record in the user table
	 */
	function update($options, $pid){

		if (empty($options['s_mapname'])) {
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
		
		return $pid;
	}
	
	/**
	 *
	 * Delete a record in the user table
	 */
	function delete($options){
		if (empty($options['mapPhotoID'])) {
			return false;
		}
		$this->db->where('mapPhotoID', $options['mapPhotoID']);
		$this->db->cache_delete_all();		
    	return $this->db->delete('map_photo');
	}
	

	/**
	 * 
	 * Retrieve user
	 */
	function fetch($options = array()){
		$this->db->cache_on(); 
		$sortOrder = !empty($options['sort_order']) ? $options['sort_order'] : 'ASC'; 
		$sortBy = !empty($options['sort_field']) ? $options['sort_field'] : 'mapPhotoID';
		
		if (!empty($options['event_id'])) {
			if (is_array($options['event_id'])) {
				return $this->_getMulti('event_id', $options);
			} else {
				return $this->_getPhotoByEvent($options['event_id']);
			}
		}
		
		$this->db->select('*')->from('map_photo');
		if (!empty($options['mapPhotoID'])) {
			$this->db->where('mapPhotoID', $options['mapPhotoID']);
		}		
		$this->db->order_by($sortBy, $sortOrder);			 
		$query = $this->db->get();		
		
		if($query->num_rows()>0){
			// return result set as an associative array
			return $query->result_array();
		}
		
		return array();
	}
	
	private function _getPhotoByEvent($eventId) {
		return $this->db->get_where('map_photo', array('event_id'=>$eventId))->result_array();
	}
	
	private function _getPhotoById($photoid) {
		return $this->db->get_where('map_photo', array('mapPhotoID'=>$photoid), 1, 0)->result();
	}
	
	private function _getMulti($field, $options = array()) {
		if (empty($options[$field])) {
			return array();
		}
		
		return $this->db->where_in($field, $options[$field])->get('map_photo')->result();
	}

}