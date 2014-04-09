<?php
/**
 *
 * @author Jonatan Karlsson, me@jonatankarlsson.se
 * @copyright Jonatan Karlsson 2014
 * @package Goofy
 * 
 */
class CUser extends CDatabase {

	protected $database = array();

	public function __construct($options) {
		if($this->db == null) {
			parent::__construct($options);
		}

		$default = array(
				'database' => 'jokd13', 
				'table' => 'Users_kmom07'
		);

		$this->database = array_merge($default, $options);
	}
	/**
	 * Does the login
	 * @param  $_POST $data Post data from form
	 * 
	 */
	public function login($data) {
		$sql = "SELECT username, auth FROM {$this->database['table']}  WHERE username = ? AND password = md5(concat(?, salt))";
		$pass = isset($data['password']) ? htmlentities($data['password']) : null;
		$user = isset($data['username']) ? htmlentities($data['username']) : null;
		
		if(!$res = $this->Select($sql,array($user, $pass),DEBUG)) {
			dump($this->stmt->errorInfo());
			dump($res);
			header('Location: login.php?error');
			exit();	
		} else {
			$_SESSION['user'] = $res[0];
			$_SESSION['auth'] = $res[1];
			header('Location: index.php');
		}
		exit;
	}
	/**
	 * Send in a post request for creating a new user
	 * @param  array $data username and password
	 * @return void        returns nothing
	 */
	public function createUser($data) {
		$username = isset($data[0]['username']) ? strip_tags($data[0]['username']) : null;
		$password = isset($data[0]['password']) ? strip_tags($data[0]['password']) : null;
		
		$sql = "INSERT INTO {$this->database['table']} (username, password, salt) VALUES ('{$username}','{$password}',unix_timestamp())";

		if(!$this->Execute($sql,array(),DEBUG)) {
			throw new Exception("Something went wrong when executing this: {$sql}", 1);			
		}

		$sql = "UPDATE {$this->database['table']} SET password = md5(concat(?,salt)) WHERE username = ? ; ";

		if(!$this->Execute($sql,array($password,$username),DEBUG)) {
			throw new Exception("Something went wrong when executing this: {$sql}", 1);			
		}
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