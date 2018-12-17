<?php
require_once APPPATH . '/controllers/test/Toast.php';

class User_tests extends Toast
{
	private $_intUserID;
	private $_intIsPrimary;

	function User_tests()
	{
		parent::Toast(__FILE__);

		//load User_Option model
		if (! isset($this->User))
		{
			$this->load->model('User', '', TRUE);
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
		if (!empty($this->_intUserID)) {
			$data = array();
			$data['userID'] = $this->_intUserID;
			if ('1' == $this->_intIsPrimary)
			$this->User->deleteUser($data);
			else
			$this->User->deleteGuestUser($data);

		}
	}

	function test_addUser(){
		$userData = array();
		$userData['email'] = 'test-add@rcggs.com';
		$userData['password'] = '12345';
		$userData['first_name'] = 'John';
		$userData['last_name'] = 'Doe';
		$userData['affiliation'] = 'Affiliation';
		$userData['industry'] = 'additional info';
		$userData['title'] = 'title';
		$userData['bio'] = 'info here';
		$userData['is_primary'] = '1';
		$this->_intIsPrimary = $userData['is_primary'];

		$this->_intUserID = $this->User->addUser($userData);

		$this->_assert_not_empty($this->_intUserID );
	}

	function test_addGuestUser(){
		$userData = array();

		$userData['first_name'] = 'Companion';
		$userData['last_name'] = 'Doe';
		$userData['is_primary'] = '0';
		$userData['primary_user_id'] = '79';
		$this->_intIsPrimary = $userData['is_primary'];

		$this->_intUserID = $this->User->addGuestUser($userData);

		$this->_assert_not_empty($this->_intUserID);
	}

	function test_updateUser(){
		$userData = array();
		$userData['email'] = 'test-update@rcggs.com';
		$userData['password'] = '12345';
		$userData['first_name'] = 'John';
		$userData['last_name'] = 'Doe';
		$userData['affiliation'] = 'Affiliation';
		$userData['industry'] = 'additional info';
		$userData['title'] = 'title';
		$userData['bio'] = 'info here';
		$userData['is_primary'] = '1';
		$this->_intIsPrimary = $userData['is_primary'];

		$userData['userID'] = $this->User->addUser($userData);

		$userData['email'] = 'test@rcggs.com';
		$userData['password'] = '12345';
		$userData['first_name'] = 'John';
		$userData['last_name'] = 'Doe';
		$userData['affiliation'] = 'Affiliation';
		$userData['industry'] = 'additional info';
		$userData['title'] = 'title - update user';
		$userData['bio'] = 'info here';
		$userData['is_primary'] = '1';

		$this->_intUserID = $this->User->updateUser($userData);
		$this->_assert_not_empty($this->_intUserID);
	}

	function test_updateGuestUser(){
		$userData = array();
		$userData['first_name'] = 'Companion';
		$userData['last_name'] = 'Doe';
		$userData['is_primary'] = '0';
		$userData['primary_user_id'] = '79';
		$this->_intIsPrimary = $userData['is_primary'];

		$userData['userID'] = $this->User->addGuestUser($userData);

		$userData['first_name'] = 'Companion Update';
		$userData['last_name'] = 'Doe';
		$userData['is_primary'] = '0';
		$userData['primary_user_id'] = '79';

		$this->_intUserID = $this->User->updateGuestUser($userData);
		$this->_assert_not_empty($this->_intUserID);
	}

	function test_deleteUser(){
		$userData = array();
		$userData['email'] = 'test-delete@rcggs.com';
		$userData['password'] = '12345';
		$userData['first_name'] = 'John';
		$userData['last_name'] = 'Doe';
		$userData['affiliation'] = 'Affiliation';
		$userData['industry'] = 'additional info';
		$userData['title'] = 'title - delete user';
		$userData['bio'] = 'info here';
		$userData['is_primary'] = '1';
		$this->_intIsPrimary = $userData['is_primary'];

		$userData['userID'] = $this->User->addUser($userData);

		$this->_assert_true($this->User->deleteUser($userData));
	}

	function test_deleteGuestUser(){
		$userData = array();
		$userData['first_name'] = 'Companion Delete';
		$userData['last_name'] = 'Doe';
		$userData['is_primary'] = '0';
		$userData['primary_user_id'] = '79';
		$this->_intIsPrimary = $userData['is_primary'];

		$userData['userID'] = $this->User->addGuestUser($userData);

		$this->_assert_true($this->User->deleteGuestUser($userData));
	}

	function test_getAllUsers(){
		$this->_assert_not_empty($this->User->getAllUsers());
	}

	function test_getNumUsers(){
		$intSearchResult = 0;
		$intSearchResult = $this->User->getNumUsers();
		$this->_assert_not_empty($intSearchResult);
	}

	function test_getByEmail(){
		$userData = array();
		$userData['email'] = 'test-getbyemail@rcggs.com';
		$userData['password'] = '12345';
		$userData['first_name'] = 'John';
		$userData['last_name'] = 'Doe';
		$userData['affiliation'] = 'Affiliation';
		$userData['industry'] = 'additional info';
		$userData['title'] = 'title - get by email';
		$userData['bio'] = 'info here';
		$userData['is_primary'] = '1';
		$this->_intIsPrimary = $userData['is_primary'];

		$this->_intUserID = $this->User->addUser($userData);
		$this->_assert_not_empty($this->User->getByEmail($userData['email']));
	}

	function test_loginUserInvalidPassword(){
		$userData = array();
		$userData['email'] = 'test-logininvalid@rcggs.com';
		$userData['password'] = '12345';
		$userData['first_name'] = 'John';
		$userData['last_name'] = 'Doe';
		$userData['affiliation'] = 'Affiliation';
		$userData['industry'] = 'additional info';
		$userData['title'] = 'title - login user invalid password';
		$userData['bio'] = 'info here';
		$userData['is_primary'] = '1';
		$this->_intIsPrimary = $userData['is_primary'];

		$this->_intUserID = $this->User->addUser($userData);

		$invalidPassword = '54321';

		$arrMessage = array();
		$arrMessage['error'] = '';
		$arrMessage = $this->User->loginUser($userData['email'], $invalidPassword);
		$this->_assert_equals($arrMessage['error'], 'Invalid password');
	}

	function test_loginUserValidPassword(){
		$userData = array();
		$userData['email'] = 'test-logininvalid@rcggs.com';
		$userData['password'] = '12345';
		$userData['first_name'] = 'John';
		$userData['last_name'] = 'Doe';
		$userData['affiliation'] = 'Affiliation';
		$userData['industry'] = 'additional info';
		$userData['title'] = 'title - login user valid password';
		$userData['bio'] = 'info here';
		$userData['is_primary'] = '1';
		$this->_intIsPrimary = $userData['is_primary'];

		$this->_intUserID = $this->User->addUser($userData);

		$invalidPassword = '12345';
		
		$arrMessage = array();
		$arrMessage['error'] = '';
		$arrMessage = $this->User->loginUser($userData['email'], $invalidPassword);
		$this->_assert_true(!isset($arrMessage['error']));
	}
}