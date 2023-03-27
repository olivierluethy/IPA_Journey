<?php
class WeeklyReport
{
    public $db;

    public function __construct()
    {
        $this->db = connectDatabase();
    }

    public function getAllWeeklyJournals(){
		$statement = $this->db->prepare('SELECT * FROM weeklyreport WHERE fk_userId = :id AND status = 1
		ORDER BY date DESC');
		$statement->bindParam(':id', $_SESSION["id"], PDO::PARAM_STR);
		$statement->execute();
        return $statement;
	}

    public function addweeklyRaport($calendar_week, $completed_tasks, $still_in_work, $reflection, $issues, $status){
		$statement = $this->db->prepare('INSERT INTO `weeklyreport` (calendarWeek, doneWork, ongoingWork, reflection, occurredProblems, status, fk_userId) 
		VALUES (:kalenderwoche, :erledigte_arbeiten, :laufende_arbeiten, :reflexion, :aufgetretene_probleme, :status, :id)');
		$statement->bindParam(':kalenderwoche', $calendar_week, PDO::PARAM_STR);
		$statement->bindParam(':erledigte_arbeiten', $completed_tasks, PDO::PARAM_STR);
		$statement->bindParam(':laufende_arbeiten', $still_in_work, PDO::PARAM_STR);
		$statement->bindParam(':reflexion', $reflection, PDO::PARAM_STR);
		$statement->bindParam(':aufgetretene_probleme', $issues, PDO::PARAM_STR);
		$statement->bindParam(':status', $status, PDO::PARAM_STR);
		$statement->bindParam(':id', $_SESSION["id"], PDO::PARAM_STR);
		$statement->execute();
	}

    public function getAllWeeklyInProcess(){
		$statement = $this->db->prepare('SELECT weeklyreport.weeklyReportId, weeklyreport.calendarWeek, weeklyreport.doneWork, 
		weeklyreport.ongoingWork, weeklyreport.reflection, weeklyreport.occurredProblems, 
		weeklyreport.status, weeklyreport.date, user.full_name FROM weeklyreport INNER JOIN user ON user.userId = weeklyreport.fk_userId WHERE status = 0');
		$statement->execute();
        return $statement;
	}

	public function getAllWeeklyInRelease(){
		$statement = $this->db->prepare('SELECT weeklyreport.weeklyReportId, weeklyreport.calendarWeek, weeklyreport.doneWork, 
		weeklyreport.ongoingWork, weeklyreport.reflection, weeklyreport.occurredProblems, 
		weeklyreport.status, weeklyreport.date, user.full_name FROM weeklyreport INNER JOIN user ON user.userId = weeklyreport.fk_userId WHERE status = 1');
		$statement->execute();
        return $statement;
	}

    public function deleteWeeklyReport($id){
		$statement = $this->db->prepare('DELETE FROM `weeklyreport` WHERE weeklyReportId = :id');
        $statement->bindParam(':id', $id, PDO::PARAM_STR);
        $statement->execute();
	}

	public function releaseWeeklyReport($id){
		$statement = $this->db->prepare('UPDATE weeklyreport SET status = 1 WHERE weeklyReportId = :id');
		$statement->bindParam(':id', $id, PDO::PARAM_STR);
		$statement->execute();
	}

	public function editWeeklyReport($calendar_week, $completed_tasks, $still_in_work, $reflection, $issues, $id){
		$statement = $this->db->prepare('UPDATE weeklyreport SET calendarWeek = :kalenderwoche, doneWork = :erledigte_arbeiten, ongoingWork = :laufende_arbeiten, reflection = :reflexion, occurredProblems = :aufgetretene_probleme WHERE weeklyReportId = :id');
		$statement->bindParam(':kalenderwoche', $calendar_week, PDO::PARAM_STR);
		$statement->bindParam(':erledigte_arbeiten', $completed_tasks, PDO::PARAM_STR);
		$statement->bindParam(':laufende_arbeiten', $still_in_work, PDO::PARAM_STR);
		$statement->bindParam(':reflexion', $reflection, PDO::PARAM_STR);
		$statement->bindParam(':aufgetretene_probleme', $issues, PDO::PARAM_STR);
		$statement->bindParam(':id', $id, PDO::PARAM_STR);
		$statement->execute();
	}

	public function getWeeklyReport($id){
		$statement = $this->db->prepare('SELECT * FROM weeklyreport WHERE weeklyReportId = :id');
		$statement->bindParam(':id', $id, PDO::PARAM_STR);
		$statement->execute();
        return $statement;
	}

	public function seeWeekly($id){
		$statement = $this->db->prepare('SELECT * FROM weeklyreport WHERE weeklyReportId = :id');
		$statement->bindParam(':id', $id, PDO::PARAM_STR);
		$statement->execute();
        return $statement;
	}
}