<?php
class Content_Control extends CI_Model{
	private $tableName = 'content_control'; 
	/**
	 *
	 * Creates a record in the event table
	 */
	function addContentControl(){
		$this->db->set('last_update', date( "Y-m-d H:i:s",time())); 
   		$this->db->insert('content_control');		
		return $this->db->insert_id();
	}		

	/**
	 *
	 * Retrieve last update
	 */
	function getLastUpdate(){
		$this->db->order_by("last_update", "desc"); 
		$query= $this->db->get($this->tableName, 1);
		$data = array();
		if($query->num_rows()>0){
			// return result set as an associative array
			$data = $query->result_array();
		}
		return $data;
	}
	
	/**
	 *
	 * Delete a record in the content control table
	 */
	function deleteContentControl($contentControlID){
		$this->db->where('id', $contentControlID);		
		$this->db->cache_delete_all();
		return $this->db->delete($this->tableName);
	}
}