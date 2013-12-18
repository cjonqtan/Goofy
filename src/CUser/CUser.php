<?php

class CUser extends CDatabase {


	public function __construct($options) {
		if($this->db == null) {
			parent::__construct($options);
		}
	}
	/**
	 * Does the login
	 * @param  $_POST $data Post data from form
	 * 
	 */
	public function login($data) {
		$sql = "SELECT acronym, name FROM USER_kmom4 WHERE acronym = ? AND password = md5(concat(?, salt))";
		$pass = isset($data['password']) ? htmlentities($data['password']) : null;
		$user = isset($data['username']) ? htmlentities($data['username']) : null;
		
		if(!$res = $this->Select($sql,array($user, $user))) {
			header('Location: login.php?error');
			exit;
		}
		$_SESSION['user'] = $res[0];
		header('Location: index.php');
		exit;
	}
	/**
	 * unsets session user
	 * 
	 */
	public function logout() {
		unset($_SESSION['user']);
		header('Location: index.php');
	}
	/**
	 * Checks whether the user is logged in or not
	 * @return boolean [description]
	 */
	public function isUserLoggedIn() {
		return (isset($_SESSION['user']) ? true : false);
	}
}