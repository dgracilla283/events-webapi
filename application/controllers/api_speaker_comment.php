<?php
require_once APPPATH . 'libraries/REST_Controller.php';
require_once APPPATH . 'libraries/clients/api_speaker_comment_client.php';

class api_speaker_comment extends REST_Controller {

	function __construct()
	{
		parent::__construct();
		// load speaker comment model
		if (! isset($this->Speaker_Comment))
		{
			$this->load->model('Speaker_Comment', '', TRUE);
		}
	}

	/**
	 * @method get
	 * @param int speakerCommentID // optional speaker comment id
     * @param int event_attendee_id // speaker comment event attendee id
	 * @param string comment // speaker comment	 
     * @param string sort_field // the field to sort
	 * @param string sort_order // ASC|DESC sort order
	 * @param int page // the current page in the pagination
	 * @param int per_page // the limit of rows per page
	 * @return json/xml data
	 */
	public function speaker_comments_get()
	{
		$SpeakerCommentData = array();
		$SpeakerCommentData = $this->Speaker_comment->getAllSpeakerComments();
		$arrResponse = array(
			'result' => $SpeakerCommentData
		);
			
		$this->response($arrResponse);
	}

	/**
	 * @method get
	 * @param int speakerCommentID // the id of the speaker comment to fetch
	 * @return json/xml data
	 */
	public function speaker_comment_get()
	{
		$id = $this->input->get('id');
		$objSpeakerCommentClient = new api_speaker_comment_client();
		$data = $objSpeakerCommentClient->speaker_comments_get(false, 'json');
		
		$newSpeakerCommentData = array();
		foreach($data['result'] as $SpeakerCommentData) {
			$newSpeakerCommentData[$SpeakerCommentData['speakerCommentID']] = $SpeakerCommentData;
		}
		$result = array('result' => false);
		if (!empty($newSpeakerCommentData[$id])) {
			$result = array('result' => $newSpeakerCommentData[$id]);
		}
		$this->response($result);
	}

	/**
	 * @method post
	 * @param int speakerCommentID // optional speaker comment id
     * @param int event_attendee_id // speaker comment event attendee id
	 * @param string comment // speaker comment	 
	 * @return json/xml data
	 */
	public function speaker_comment_post(){
		$post = $this->input->post();
		if (!empty($post)) {			
			$speakerCommentID = $this->Speaker_Comment->addSpeakerComment($post);
			$apiGuest = new api_guest_client();
			$result = $apiGuest->guests_get(array('speakerCommentID'=>$speakerCommentID));
			$this->Content_Control->addContentControl();
		}			
		$this->response($result);
	}
	
	/**
	 * @method get
	 * @param int speakerCommentID // id of Speaker Comment
	 * @param int event_attendee_id // id of Event Attendee
	 * @return json/xml data
	 */
	public function speaker_comment_remove_get()
	{
		$scid = $this->input->get('speakerCommentID');
		$params = array(
				'speakerCommentID' => $scid,
				'event_attendee_id' => $this->input->get('event_attendee_id'),
		);
		if ($scid){			
			$result = $this->Speaker_Comment->deleteSpeakerComment($params);
			$this->Content_Control->addContentControl();
		}
		$result['params'] = $params;
		$this->response($result);
	}
}