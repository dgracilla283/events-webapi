<?php
class Activation_Key extends CI_Model{

	protected $cacheAdapter = 'file';
	protected $cacheBackupAdapter = 'file';

	public function __construct() {
		parent::__construct();
		$this->load->driver('cache', array('adapter'=>$this->cacheAdapter, 'backup'=>$this->cacheBackupAdapter));
	}

	/**
	 *
	 * Retrieve activation keys
	 */
	function getAllActivationKeys(){
		$this->db->select('*')->from('activation_key');

		$query = $this->db->get();
		if($query->num_rows() > 0){
			// return result set as an associative array
			return $query->result_array();
		}
	}

	function addActivationKey($data){
		$requiredField = array(
							'user_id', 
							'key',
		);
		foreach($requiredField as $field) {
			if(isset($data[$field]))
			$this->db->set($field, $data[$field]);
		}

		$this->db->set('created_at', date('Y-m-d H:i:s'));
			
		// Execute the query
		$this->db->insert('activation_key');
		$activationKeyID = $this->db->insert_id();

		return $activationKeyID;
	}
	
	function updateActivationKey($data){
		$requiredField = array(
							'user_id', 
							'key',
							'status',
		);
		foreach($requiredField as $field) {
			if(isset($data[$field]))
			$this->db->set($field, $data[$field]);
		}
			
		// Execute the query
		$this->db->where('activationKeyID', $data['activationKeyID']);
		$this->db->update('activation_key');

		return $data['activationKeyID'];
	}
	
	function deleteActivationKey($options){
		$this->db->where('activationKeyID', $options['activationKeyID']);
		// delete cache
		$this->db->cache_delete_all();
    	return $this->db->delete('activation_key');
	}
}