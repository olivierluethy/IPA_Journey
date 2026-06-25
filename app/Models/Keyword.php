<?php
class Keyword
{
    public $db;

    public function __construct()
    {
        $this->db = connectDatabase();
    }

	/* Gets all keywords which has been created by the user */
    public function getAllKeywords(){
		$statement = $this->db->prepare('SELECT * FROM topic WHERE fk_userId = :id');
		$statement->bindParam(':id', $_SESSION["id"], PDO::PARAM_STR);
		$statement->execute();
        return $statement;
	}

	/* Delets the keyword */
	public function deleteKeyword($id){
		$statement = $this->db->prepare('DELETE FROM `selectedtopics` WHERE fk_topicId = :id');
        $statement->bindParam(':id', $id, PDO::PARAM_STR);
        $statement->execute();

		$statement = $this->db->prepare('DELETE FROM `topic` WHERE topicId = :id');
        $statement->bindParam(':id', $id, PDO::PARAM_STR);
        $statement->execute();
	}

	/* Adds a keyword, returns the new topic id */
    public function addKeywords($topic){
		$statement = $this->db->prepare('INSERT INTO `topic` (topic, fk_userId) VALUES (:topic, :id)');
		$statement->bindParam(':topic', $topic, PDO::PARAM_STR);
		$statement->bindParam(':id', $_SESSION["id"], PDO::PARAM_STR);
		$statement->execute();
		return $this->db->lastInsertId();
	}

	/* Gets a keyword */
    public function getKeyword($id){
		$statement = $this->db->prepare('SELECT * FROM topic WHERE topicId = :id');
		$statement->bindParam(':id', $id, PDO::PARAM_STR);
		$statement->execute();
        return $statement;
	}

	/* Edits a keyword */
	public function editKeyword($id, $titel){
		$statement = $this->db->prepare('UPDATE topic SET topic = :topic WHERE topicId = :id');
		$statement->bindParam(':topic', $titel, PDO::PARAM_STR);
		$statement->bindParam(':id', $id, PDO::PARAM_STR);
		$statement->execute();
	}

	/* Usage per keyword for a user: how many daily reports use each topic.
	   (Weekly reports carry no keyword association in the schema, so weekly = 0.) */
	public function getKeywordUsage($userId){
		$statement = $this->db->prepare("SELECT t.topicId, t.topic, COUNT(st.fk_journalId) AS daily_count
			FROM topic t
			LEFT JOIN selectedtopics st ON st.fk_topicId = t.topicId
			WHERE t.fk_userId = :id
			GROUP BY t.topicId, t.topic
			ORDER BY daily_count DESC, t.topic ASC");
		$statement->bindParam(':id', $userId, PDO::PARAM_INT);
		$statement->execute();
		return $statement->fetchAll();
	}

	/* Get all selected keywords */
	public function getSelectedKeywords(){
		$statement = $this->db->prepare('SELECT DISTINCT topic.topicId, topic.topic FROM topic
		INNER JOIN selectedtopics ON fk_topicId = topic.topicId');
		$statement->execute();
        return $statement;
	}
}