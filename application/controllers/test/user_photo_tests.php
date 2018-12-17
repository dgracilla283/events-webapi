<?php
require_once APPPATH . '/controllers/test/Toast.php';

class User_photo_tests extends Toast
{
	private $_intUserPhotoID;

	function User_photo_tests()
	{
		parent::Toast(__FILE__);

		if (! isset($this->User_Photo))
		{
			$this->load->model('User_Photo', '', TRUE);
		}
	}

	/**
	 * anything here will be run before each test
	 */
	function _pre() {

	}

	/**
	 * post process
	 */
	function _post() {
		if (!empty($this->_intUserPhotoID)) {
			$data = array();
			$data['userPhotoID'] = $this->_intUserPhotoID;
			$this->User_Photo->delete($data);
		}
	}

	function test_add(){
		$userPhotoData = array();
		$userPhotoData = array();
		$userPhotoData['fk_i_uid'] = '1111';
		$userPhotoData['s_fname'] = 'fddb71bc49b7c831689025437d4863a355952340.jpg';
		$userPhotoData['s_origdata'] = 'a:7:{i:0;i:1024;i:1;i:768;i:2;i:2;i:3;s:25:"width="1024" height="768"";s:4:"bits";i:8;s:8:"channels";i:3;s:4:"mime";s:10:"image/jpeg";}';
		$userPhotoData['b_is_primary'] = '1';
		$userPhotoData['b_is_deleted'] = '0';

		$this->_intUserPhotoID = $this->User_Photo->add($userPhotoData);
		$this->_assert_not_empty($this->_intUserPhotoID );
	}

	function test_update(){
		$userPhotoData = array();
		$userPhotoData['fk_i_uid'] = '1111';
		$userPhotoData['s_fname'] = 'fddb71bc49b7c831689025437d4863a355952340.jpg';
		$userPhotoData['s_origdata'] = 'a:7:{i:0;i:1024;i:1;i:768;i:2;i:2;i:3;s:25:"width="1024" height="768"";s:4:"bits";i:8;s:8:"channels";i:3;s:4:"mime";s:10:"image/jpeg";}';
		$userPhotoData['b_is_primary'] = '1';
		$userPhotoData['b_is_deleted'] = '0';

		$userPhotoData['userPhotoID'] = $this->User_Photo->add($userPhotoData);

		$userPhotoData['fk_i_uid'] = '1111';
		$userPhotoData['s_fname'] = 'fddb71bc49b7c831689025437d4863a355952340.jpg';
		$userPhotoData['s_origdata'] = 'a:7:{i:0;i:1024;i:1;i:768;i:2;i:2;i:3;s:25:"width="1024" height="768"";s:4:"bits";i:8;s:8:"channels";i:3;s:4:"mime";s:10:"image/jpeg";}';
		$userPhotoData['b_is_primary'] = '1';
		$userPhotoData['b_is_deleted'] = '1';
		
		$this->_intUserPhotoID = $this->User_Photo->update($userPhotoData, $userPhotoData['userPhotoID']);
		$this->_assert_not_empty($this->_intUserPhotoID);
	}

	function test_delete(){
		$userPhotoData = array();
		$userPhotoData['fk_i_uid'] = '1111';
		$userPhotoData['s_fname'] = 'fddb71bc49b7c831689025437d4863a355952340.jpg';
		$userPhotoData['s_origdata'] = 'a:7:{i:0;i:1024;i:1;i:768;i:2;i:2;i:3;s:25:"width="1024" height="768"";s:4:"bits";i:8;s:8:"channels";i:3;s:4:"mime";s:10:"image/jpeg";}';
		$userPhotoData['b_is_primary'] = '1';
		$userPhotoData['b_is_deleted'] = '0';


		$userPhotoData['userPhotoID'] = $this->User_Photo->add($userPhotoData);
		$this->_assert_true($this->User_Photo->delete($userPhotoData));
	}

	function test_fetch(){
		$userPhotoData = array();
		$userPhotoData['fk_i_uid'] = '1111';
		$userPhotoData['s_fname'] = 'fddb71bc49b7c831689025437d4863a355952340.jpg';
		$userPhotoData['s_origdata'] = 'a:7:{i:0;i:1024;i:1;i:768;i:2;i:2;i:3;s:25:"width="1024" height="768"";s:4:"bits";i:8;s:8:"channels";i:3;s:4:"mime";s:10:"image/jpeg";}';
		$userPhotoData['b_is_primary'] = '1';
		$userPhotoData['b_is_deleted'] = '0';

		$this->_intUserPhotoID = $this->User_Photo->add($userPhotoData);

		$searchData = array();
		$searchData['userPhotoID'] = $this->_intUserPhotoID;
		$this->_assert_not_empty($this->User_Photo->fetch($searchData));
	}
}