DROP DATABASE IF EXISTS journal;
CREATE DATABASE journal;
USE journal;

--
-- Table 'User'
--

CREATE TABLE user (
  `userId` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `email` varchar(100) NOT NULL DEFAULT '',
  `first_name` varchar(50) NOT NULL DEFAULT '',
  `last_name` varchar(50) NOT NULL DEFAULT '',
  `gender` varchar(50) DEFAULT '',
  `full_name` varchar(100) NOT NULL DEFAULT '',
  `picture` varchar(255) NOT NULL DEFAULT '',
  `verifiedEmail` int(11) NOT NULL DEFAULT 0,
  `token` varchar(255) NOT NULL DEFAULT '',
  `role` TINYINT(2) NOT NULL, /* Learner: 0, Specialist: 1, Administrator: 2 */
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
);

--
-- Table 'Journal'
--

CREATE TABLE journal (
  journalId INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  text TEXT NOT NULL,
  status TINYINT(1), /* Open: 0, Shared: 1 */
  date DATETIME DEFAULT CURRENT_TIMESTAMP, /* Date of creation */
  released DATETIME,
  fk_userId INT NOT NULL,
  FOREIGN KEY (fk_userId) REFERENCES benutzer(userId)
);

--
-- Table 'weeklyReport'
--

CREATE TABLE weeklyReport (
  weeklyReportId INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  calendarWeek INT NOT NULL,
  doneWork TEXT NOT NULL,
  ongoingWork TEXT NOT NULL,
  reflection TEXT NOT NULL,
  occurredProblems TEXT NOT NULL,
  status TINYINT(1), /* Open: 0, Shared: 1 */
  date DATETIME DEFAULT CURRENT_TIMESTAMP,
  fk_userId INT NOT NULL,
  FOREIGN KEY (fk_userId) REFERENCES user(userId)
);

--
-- Table 'Topic'
--

CREATE TABLE topic (
  topicId INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  topic VARCHAR(255) NOT NULL,
  fk_userId INT NOT NULL,
  FOREIGN KEY (fk_userId) REFERENCES user(userId)
);

--
-- Table 'selectedTopics'
--

CREATE TABLE selectedTopics (
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	fk_topicId INT NULL,
  fk_journalId INT NULL,
	FOREIGN KEY (fk_topicId) REFERENCES topic(topicId),
  FOREIGN KEY (fk_journalId) REFERENCES journal(journalId)
);

/* Lernender */
-- 'olivier.luethy@kauz.ch'

/* Fachkraft */
-- 'aurel.wicki@kauz.ch'

/* Administrator */
-- 'janik.lüthi@kauz.ch'