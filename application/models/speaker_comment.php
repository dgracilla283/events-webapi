<?php
class Speaker_Comment extends CI_Model{	
	protected $cacheAdapter = 'file';
	protected $cacheBackupAdapter = 'file';
	private $tableName = 'speaker_comments';
	
	public function __construct() {
		parent::__construct();
		$this->load->driver('cache', array('adapter' => $this->cacheAdapter, 'backup' => $this->cacheBackupAdapter));
	}
	/**
	 *
	 * Creates a record in the speaker_comment table
	 */
	function addSpeakerComment($options){
		$requiredField = array(
            'event_attendee_id',
			'comment', 
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
	 * Update a record in the speaker_comment table
	 */
	function updateSpeakerComment(){
		// to follow
	}

	/**
	 *
	 * Delete a record in the speaker_comments table
	 */
	function deleteSpeakerComment($options){
		$this->db->where('speakerCommentID', $options['speakerCommentID']);
		$this->db->where('event_attendee_id', $options['event_attendee_id']);
		$this->db->cache_delete_all();
		return $this->db->delete($this->tableName);
	}

	/**
	 *
	 * Retrieve all speaker comments
	 */
	function getAllSpeakerComments(){
		$query= $this->db->get($this->tableName);
		if($query->num_rows() > 0){
			// return result set as an associative array
			return $query->result_array();
		}
	}

    /**
	 *
	 * Get total number of speaker comments
	 */	
	function getNumSpeakerComments(){
		return $this->db->count_all($this->tableName);
	}
}