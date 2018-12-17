<?php
class Itinerary extends CI_Model{
	protected $cacheAdapter = 'file';
	protected $cacheBackupAdapter = 'file';
	
	public function __construct() {
		parent::__construct();
		$this->load->driver('cache', array('adapter'=>$this->cacheAdapter, 'backup'=>$this->cacheBackupAdapter));
	}
	/**
	 *
	 * Creates a record in the itinerary table
	 */
	function addItinerary($options){
		$requiredField = array(
							'event_id',
							'title', 
							'description', 
							'start_date_time', 
							'end_date_time',
							'location',
							'breakout_status',
							'attendees_limit'
		);

		foreach($requiredField as $field) {
			if(isset($options[$field]))
			$this->db->set($field, $options[$field]);
		}

		// Execute the query
		$this->db->insert('itinerary');
		$this->db->cache_delete_all();
		
		return $this->db->insert_id();
	}

	/**
	 *
	 * Update a record in the itineray table
	 */
	function updateItinerary($options){
		$requiredField = array(
							'event_id',
							'title', 
							'description', 
							'start_date_time', 
							'end_date_time',
							'location',
							'breakout_status',
							'attendees_limit'
		);

		$data = array();
		foreach($requiredField as $field) {
			if(isset($options[$field]))
				$data[$field] = $options[$field];
		}
		
		$this->db->where('itineraryID', $options['itineraryID']);
		$this->db->update('itinerary', $data);
		$this->db->cache_delete_all();

		return $options['itineraryID'];
	}

	/**
	 *
	 * Delete a record in the itinerary table
	 */
	function deleteItinerary($data){	
		$this->db->where('itineraryID', $data['itineraryID']);
		$this->db->where('event_id', $data['event_id']);
		$delete = $this->db->delete('itinerary');
		$this->db->cache_delete_all();
		return array('status' => $delete); 
	}

	/**
	 *
	 * Retrieve event Itineraries
	 */
	function getEventItineraries($eid){
		$this->db->cache_on(); 
		$this->db->where('event_id', $eid);
		$query= $this->db->get('itinerary');
		if($query->num_rows()>0){
			// return result set as an associative array
			return $query->result_array();
		}
	}	

	/**
	 *
	 * Retrieve events
	 */
	function getAllItineraries($id=null){
		$this->db->cache_on();
		if($id==null){
			$this->db->order_by("start_date_time", "asc");
			$query= $this->db->get('itinerary');
		}else{
			$this->db->order_by("start_date_time", "asc");
			foreach($id as $indId ):
				$this->db->or_where('event_id', $indId);
			endforeach;
			$query= $this->db->get('itinerary');
		}
		
		if($query->num_rows()>0){
			// return result set as an associative array
			return $query->result_array();
		}
	}

	// get total number of events
	function getNumItineraries(){
		return $this->db->count_all('itinerary');
	}

}