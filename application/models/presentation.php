<?php
class Presentation extends CI_Model{

	protected $cacheAdapter = 'file';
	protected $cacheBackupAdapter = 'file';
	private $tableName = 'presentation';

	public function __construct() {
		parent::__construct();
		$this->load->driver('cache', array('adapter'=>$this->cacheAdapter, 'backup'=>$this->cacheBackupAdapter));
	}

	/**
	 *
	 * Creates a record in the presentation table
	 */
	function addPresentation($options){
		$requiredFields = array(
			'title',
			'url',
			'presentation_category_id',
			'display_type',
			'document_meta'
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
	 * Update a record in the presentation table
	 */
	function updatePresentation($options){
		$requiredFields = array(
			'title',
			'url',
			'presentation_category_id',
			'order',
			'display_type',
			'document_meta'
		);

		$data = array();
		foreach($requiredFields as $field) {
			if(isset($options[$field]))
			$data[$field] = $options[$field];
		}
		$this->db->where('presentationID', $options['presentationID']);
		$this->db->update($this->tableName, $data);

		// delete cache
		$this->db->cache_delete_all();

		return $options['presentationID'];
	}

	/**
	 *
	 * Delete a record in the presentation table
	 */
	function deletePresentation($filters = false){
		if(!empty($filters['presentationID'])) {
			$this->db->where('presentationID', $filters['presentationID']);
		}
		if(!empty($filters['presentation_category_id'])) {
			$this->db->where('presentation_category_id', $filters['presentation_category_id']);
		}
		// delete cache
		$this->db->cache_delete_all();
		return $this->db->delete($this->tableName);

	}


	/**
	 *
	 * Retrieve presentation
	 */
	function getPresentation($filters = false){
		if(!empty($filters['presentationID'])) {
			$this->db->where('presentationID', $filters['presentationID']);
		}
		if(!empty($filters['presentation_category_id'])) {
			$this->db->where('presentation_category_id', $filters['presentation_category_id']);
		}

		if(isset($filters['sort_field']) && !empty($filters['sort_field']) &&
		isset($filters['sort_order']) && !empty($filters['sort_order'])) {
			$sortField = $filters['sort_field'];
			$sortOrder = $filters['sort_order'];
			$this->db->order_by($sortField, $sortOrder);
		}

		$query= $this->db->get($this->tableName);
		$data = array();
		if($query->num_rows()>0){
			// return result set as an associative array
			$data = $query->result_array();
		}
		return $data;
	}

}