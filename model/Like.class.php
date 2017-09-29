<?php
require __DIR__ . '/../config/database.php';

class Like
{
	public $id;
	public $image_id;
	public $liker_id;
	public $creation_date;

	public function __construct($data = null)
	{
		if (is_array($data)) {
			if (isset($data['image_id']))
				$this->image_id = $data['image_id'];
			if (isset($data['liker_id']))
				$this->liker_id = $data['liker_id'];
		}
	}

	public function exists($db)
	{
		$sql = 'SELECT id, creation_date FROM Like_table WHERE image_id ="'.$this->image_id.'" AND liker_id = "'.$this->liker_id.'"';
		$statement = $db->prepare($sql);
		$statement->execute();
		$result = $statement->fetchAll();

		if (count($result) === 0)
			return false;
		$value = $result[0];
		$this->id = $value['id'];
		$this->creation_date = $value['creation_date'];
		return true;
	}

	public function persist($db)
	{
		$statement = $db->prepare('INSERT INTO Like_table (image_id, liker_id) VALUES (:image_id, :liker_id)');
		$statement->bindParam(':image_id', $this->image_id);
		$statement->bindParam(':liker_id', $this->liker_id);
		return $statement->execute();
	}

	public function delete($db)
	{
		$sql = 'DELETE FROM Like_table WHERE image_id ="'.$this->image_id.'" AND liker_id = "'.$this->liker_id.'"';
		$statement = $db->prepare($sql);
		return $statement->execute();
	}
}
