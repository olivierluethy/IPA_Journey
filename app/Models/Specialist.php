<?php
class Specialist
{
    public $db;

    public function __construct()
    {
        $this->db = connectDatabase();
    }

    // Gets all daily raports
	public function getDailyRaports(){
		$statement = $this->db->prepare("SELECT journal.journalId, journal.text, journal.date, user.full_name, GROUP_CONCAT(t.topic SEPARATOR ' | ') AS selected_topics
        FROM journal
        LEFT JOIN selectedtopics ON journal.journalId = selectedtopics.fk_journalId
        LEFT JOIN topic AS t ON selectedtopics.fk_topicId = t.topicId
        INNER JOIN user ON user.userId = journal.fk_userId
        WHERE journal.status = 1 AND (selectedtopics.fk_topicId IS NULL OR selectedtopics.fk_topicId != '')
        GROUP BY journal.journalId");
		$statement->execute();
        return $statement;
	}

    // Gets all weekly raports
	public function getWeeklyRaports(){
		$statement = $this->db->prepare('SELECT *, user.full_name FROM weeklyreport 
		INNER JOIN user ON user.userId = weeklyreport.fk_userId WHERE weeklyreport.status = 1');
		$statement->execute();
        return $statement;
	}

    // Gets all apprentices
    public function getAllLearner(){
        $statement = $this->db->prepare('SELECT * FROM user
        WHERE user.role = 0');
		$statement->execute();
        return $statement;
    }

    // Org-wide keyword usage (aggregated by topic name across all apprentices).
    public function getOrgKeywordUsage(){
        $statement = $this->db->prepare("SELECT t.topic, COUNT(st.fk_journalId) AS cnt
            FROM topic t
            LEFT JOIN selectedtopics st ON st.fk_topicId = t.topicId
            GROUP BY t.topic
            ORDER BY cnt DESC, t.topic ASC");
        $statement->execute();
        return $statement->fetchAll();
    }

    // Last submission datetime per apprentice (across daily + weekly reports).
    public function getLastSubmissions(){
        $statement = $this->db->prepare("SELECT u.userId, u.full_name, MAX(x.d) AS last_sub
            FROM user u
            LEFT JOIN (
                SELECT fk_userId, date AS d FROM journal
                UNION ALL
                SELECT fk_userId, date FROM weeklyreport
            ) x ON x.fk_userId = u.userId
            WHERE u.role = 0
            GROUP BY u.userId, u.full_name
            ORDER BY u.full_name");
        $statement->execute();
        return $statement->fetchAll();
    }

    // userId => count of daily reports created today.
    public function getDailyTodayCounts(){
        $statement = $this->db->prepare("SELECT fk_userId, COUNT(*) AS c FROM journal WHERE DATE(date) = CURDATE() GROUP BY fk_userId");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_KEY_PAIR);
    }

    // userId => count of weekly reports for the given ISO week.
    public function getWeeklyWeekCounts($week){
        $statement = $this->db->prepare("SELECT fk_userId, COUNT(*) AS c FROM weeklyreport WHERE calendarWeek = :w GROUP BY fk_userId");
        $statement->bindParam(':w', $week, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_KEY_PAIR);
    }
}