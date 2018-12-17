<?php
class User extends CI_Model{

	protected $cacheAdapter = 'file';
	protected $cacheBackupAdapter = 'file';

	private $tableName = 'user';

	public function __construct() {
		parent::__construct();
		//$this->load->driver('cache', array('adapter'=>$this->cacheAdapter, 'backup'=>$this->cacheBackupAdapter));
	}

	/**
	 *
	 * Creates a record in the user table
	 */
	function addUser($options){

		// check if email is set
		if (empty($options['email'])) {
			return false;
		}

		// validate email if exists
		$dupEmail = $this->getByEmail($options['email']);
		if (!empty($dupEmail)) {
			return false;
		}

		$requiredField = array(
							'email',
							'password',
							'first_name',
							'last_name',
							'affiliation',
							'industry',
							'title',
							'bio',
							'is_primary',
							'active',
						);


		foreach($requiredField as $field) {
			if(isset($options[$field]))
				$this->db->set($field, $options[$field]);
		}

		$salt = $this->_salt();
		$this->db->set('salt', $salt);
		$this->db->set('password', sha1($salt . $options['password']));
		$this->db->set('created_at', date('Y-m-d H:i:s'));

		// Execute the query
   		$this->db->insert($this->tableName);

   		 // delete cache
		$this->db->cache_delete_all();

		return $this->db->insert_id();
	}

	/**
	 *
	 * Creates a record in the user table
	 */
	function addGuestUser($options){

		$requiredField = array(
							'first_name',
							'last_name',
							'is_primary',
						);


		foreach($requiredField as $field) {
			if(isset($options[$field]))
				$this->db->set($field, $options[$field]);
		}

		$this->db->set('created_at', date('Y-m-d H:i:s'));

		// Execute the query
   		$this->db->insert($this->tableName);
   		$user_id = $this->db->insert_id();

   		// add entry in companion table
   		$this->db->set('primary_user_id', $options['primary_user_id']);
   		$this->db->set('user_id', $user_id);
   		$this->db->set('type',  $options['type']);
   		$this->db->insert('event_attendee_companion');

   		 // delete cache
		$this->db->cache_delete_all();

		return $user_id;
	}

	/**
	 *
	 * Update a record in the user table
	 */
	function updateUser($options){
		// check if email is set

		if (empty($options['email'])) {
			return false;
		}

		$requiredField = array(
							'email',
							'first_name',
							'last_name',
							'affiliation',
							'industry',
							'title',
							'bio',
							'is_primary',
							'active',
						);

		$data = array();

		foreach($requiredField as $field) {
			if(isset($options[$field]))
				$this->db->set($field, $options[$field]);
		}

		if (isset($options['password'])) {
			$salt = $this->_salt();
			$data['salt'] = $salt;
			$data['password'] = sha1($salt . $options['password']);
			$data['email'] = $options['email'];
		}

		$this->db->where('userID', $options['userID']);
		$this->db->update($this->tableName, $data);

		// delete cache
		$this->db->cache_delete_all();
   		$this->cache->save(sha1('cache'.$data['email']), array($data), 3600);

		return $options['userID'];
	}

	/**
	 *
	 * Update a record in the user table
	 */
	function updateGuestUser($options){
		$requiredField = array(
							'first_name',
							'last_name',
						);

		$data = array();
		foreach($requiredField as $field) {
			if(isset($options[$field]))
				$this->db->set($field, $options[$field]);
		}

		$this->db->where('userID', $options['userID']);
		$this->db->update($this->tableName);

		$this->db->set('primary_user_id', $options['primary_user_id']);
		$this->db->set('type', $options['type']);
		$this->db->where('user_id', $options['userID']);
		$this->db->update('event_attendee_companion');

		// delete cache
		$this->db->cache_delete_all();

		return $options['userID'];
	}

	/**
	 *
	 * Delete a record in the user table
	 */
	function deleteUser($options){
		$this->db->where('userID', $options['userID']);
		// delete cache
		$this->db->cache_delete_all();
    	return $this->db->delete($this->tableName);
	}


	/**
	 *
	 * Delete a record in the user table
	 */
	function deleteGuestUser($options){
		$this->db->where('user_id', $options['userID']);
		$this->db->delete('event_attendee_companion');

		$this->db->where('userID', $options['userID']);
		// delete cache
		$this->db->cache_delete_all();
    	return $this->db->delete($this->tableName);
	}


	/**
	 *
	 * Retrieve user
	 */
	function getAllUsers($options = array()){
		$sortOrder = !empty($options['sort_order']) ? $options['sort_order'] : 'ASC';
		$sortBy = !empty($options['sort_field']) ? $options['sort_field'] : 'last_name';

		$where = '';
		if (isset($options['is_primary'])){
			$where = "user.is_primary = '" . $options['is_primary'] . "'";
		}

		if (isset($options['name'])){
			$open = $close = '';
			if (!empty($where)) {
				$open = ' and (';
				$close = ' ) ';
			}
			$where = $where . $open . "first_name like '%" . $options['name'] . "%' or last_name like '%" . $options['name'] . "%'" . $close;
		}
		if (!empty($where)) {
			$this->db->where($where);
		}

		$this->db->order_by($sortBy, $sortOrder);
		$this->db->from($this->tableName);

		$this->db->join('user_photo', 'user_photo.fk_i_uid = user.userID', 'left');

		if(!empty($options['page']) && !empty($options['per_page']))
			$this->db->limit($options['per_page'], ($options['page'] - 1) * $options['per_page']);

		$query= $this->db->get();

		$this->db->cache_on();
		$data = array();
		if($query->num_rows()>0){
			// return result set as an associative array
			$data = $query->result_array();
		}

		return $data;
	}

	// get total number of user
	function getNumUsers($options){
		if (isset($options['is_primary']) && $options['is_primary'] != ''){
			$this->db->where('is_primary', $options['is_primary']);
		}
		$query= $this->db->get('user');
		return $query->num_rows();
	}

	/**
	 * get user data via email
	 */
	public function getByEmail($email) {
		$qry = $this->db->get_where($this->tableName, array('email'=>$email));
		$arrResult = $qry->result_array();
		/* $this->load->driver('cache', array('adapter'=>'file'));
		$cacheKey = sha1('cache' . $email);
		if (!$arrResult = $this->cache->get($cacheKey)) {
			$arrResult = $qry->result_array();
			$this->cache->save($cacheKey, $arrResult, 3600);
		} */
		return $arrResult;
	}

	public function loginUser($email, $password) {

		$data = $this->getByEmail($email);
		if (empty($data)) {
			return array('error' => 'Invalid user');
		}

		$data = current($data);
		$salt = $data['salt'];
		$dbPassword = $data['password'];
		$isPasswordOk = ($data['password'] === sha1($salt . $password));
		if (!$isPasswordOk) {
			return array('error' => 'Invalid password');
		}

		unset($data['password'], $data['salt']);
		return array('result'=>$data);
	}

	/**
	 *
	 * Activates a record in the user table
	 */
	function activateUser($options){
		return true;
		// check if email is set
		if (empty($options['email']) || empty($options['password']) ||
			empty($options['activation_key'])) {
			return false;
		}

		$data = $this->loginUser($options['email'], $options['password']);
		if(isset($data['error'])) {
			return $data;
		}
		/** Assuming that is_activated is field name in "user" table,
		 * force true for the meantime  for testing
		 *
		$user = $data['result'];
		$this->db->where('uid', $user['uid'])
				->update($this->tableName, array('is_activated', 1));
		*/
		return true;
	}

	private function _salt($len = 15) {
		$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%&*?';
		$i = 0;
		$salt = '';
		while ($i < $len) {
			$salt .= $chars{mt_rand(0,(strlen($chars)) - 1 )};
			$i++;
		}
		return $salt;
	}


}