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

    public function addKeywords($thema){
		$statement = $this->db->prepare('INSERT INTO `topic` (topic, fk_userId) VALUES (:thema, :id)');
		$statement->bindParam(':thema', $thema, PDO::PARAM_STR);
		$statement->bindParam(':id', $_SESSION["id"], PDO::PARAM_STR);
		$statement->execute();
	}

    public function getKeyword($id){
		$statement = $this->db->prepare('SELECT * FROM topic WHERE topicId = :id');
		$statement->bindParam(':id', $id, PDO::PARAM_STR);
		$statement->execute();
        return $statement;
	}

	public function editKeyword($id, $titel){
		$statement = $this->db->prepare('UPDATE topic SET topic = :thema WHERE topicId = :id');
		$statement->bindParam(':thema', $titel, PDO::PARAM_STR);
		$statement->bindParam(':id', $id, PDO::PARAM_STR);
		$statement->execute();
	}

	public function getSelectedKeywords($journalId){
		$statement = $this->db->prepare('SELECT DISTINCT topic.topicId, topic.topic FROM topic
		INNER JOIN selectedtopics ON fk_topicId = topic.topicId WHERE selectedtopics.fk_journalId = :id');
		$statement->bindParam(':id', $journalId, PDO::PARAM_STR);
		$statement->execute();
        return $statement;
	}
}