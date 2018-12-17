<?php
require_once APPPATH . '/controllers/test/Toast.php';

class Role_tests extends Toast
{
	private $_intRoleID;

	function Role_tests()
	{
		parent::Toast(__FILE__);

		//load Role_Option model
		if (! isset($this->Role))
		{
			$this->load->model('Role', '', TRUE);
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
		if (!empty($this->_intRoleID)) {
			$data = array();
			$data['roleID'] = $this->_intRoleID;
			$this->Role->deleteRole($data);
		}
	}

	function test_addRole(){
		$roleData = array();
		$roleData['title'] = 'Add - Delete';

		$this->_intRoleID = $this->Role->addRole($roleData);
		$this->_assert_not_empty($this->_intRoleID );
	}	

	function test_deleteRole(){
		$roleData = array();
		$roleData['title'] = 'Role - Delete';
		
		$roleData['roleID'] = $this->Role->addRole($roleData);
		$this->_assert_true($this->Role->deleteRole($roleData));
	}
	
	function test_getAllRoles(){		
		$this->_assert_not_empty($this->Role->getAllRoles());
	}
	
	function test_getNumRoles(){
		$intSearchResult = 0;
		$intSearchResult = $this->Role->getNumRoles();
		$this->_assert_not_empty($intSearchResult);
	}
}