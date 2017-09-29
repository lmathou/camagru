<?php

class DBAccess
{
	public $db;

	public function __construct($DB_DSN, $DB_USER, $DB_PASSWORD)
	{
		if (empty($DB_PASSWORD))
			$db = new PDO ($DB_DSN, $DB_USER);
		else
			$db = new PDO ($DB_DSN, $DB_USER, $DB_PASSWORD);
		$this->db = $db;
		$this->db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	}

	public function countAllUsers()
	{
		$count = $this->db->query('select count(*) from User')->fetchColumn();
		return $count;
	}
}
