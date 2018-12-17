<?php
class Admin extends CI_Model{
	
	protected $cacheAdapter = 'file';
	protected $cacheBackupAdapter = 'file';
	
	public function __construct() {
		parent::__construct();
		$this->load->driver('cache', array('adapter'=>$this->cacheAdapter, 'backup'=>$this->cacheBackupAdapter));
	}	
	
	/**
	 *
	 * Retrieve admins
	 */
	function getAllAdmins(){
		$this->db->select('*')->from('admin');
		$query = $this->db->get();
		$data = array();
		if($query->num_rows() > 0){
			// return result set as an associative array
			$data = $query->result_array();
		}
		return $data;
	}
}