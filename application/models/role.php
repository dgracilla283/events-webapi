<?php
class Role extends CI_Model{
	
	protected $cacheAdapter = 'file';
	protected $cacheBackupAdapter = 'file';
	private $tableName = 'role';
	
	public function __construct() {
		parent::__construct();
		$this->load->driver('cache', array('adapter'=>$this->cacheAdapter, 'backup'=>$this->cacheBackupAdapter));
	}
	/**
	 *
	 * Creates a record in the role table
	 */
	function addRole($options){
		$requiredField = array(
							'title', 
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
	 * Update a record in the role table
	 */
	function updateRole(){
		// to follow
	}

	/**
	 *
	 * Delete a record in the role table
	 */
	function deleteRole($options){
		$this->db->where('roleID', $options['roleID']);
		$this->db->cache_delete_all();
		return $this->db->delete($this->tableName);
	}

	/**
	 *
	 * Retrieve role
	 */
	function getAllRoles(){
		$query= $this->db->get($this->tableName);
		if($query->num_rows()>0){
			// return result set as an associative array
			return $query->result_array();
		}
	}

	// get total number of role
	function getNumRoles(){
		return $this->db->count_all($this->tableName);
	}

}