<?php

class JournalController
{
	/* Für Lernender */
	public function home(){
		require_once 'app/Views/general/config.php';

		// Redirect to login page if user is not logged in
		if (!isset($_SESSION['token'])) {
			header("Location: login");
			return;
		}

		// Administrators have their own landing page.
		if ($_SESSION['role'] == 2) {
			header("Location: userOverview");
			return;
		}

		// Supervisor (role 1): at-a-glance dashboard instead of the apprentice home.
		if ($_SESSION['role'] == 1) {
			$Specialist = new Specialist();
			$learners          = $Specialist->getAllLearner()->fetchAll();
			$dailyReleased     = $Specialist->getDailyRaports()->fetchAll();
			$weeklyReleased    = $Specialist->getWeeklyRaports()->fetchAll();
			$orgKeywords       = $Specialist->getOrgKeywordUsage();
			$lastSubs          = $Specialist->getLastSubmissions();
			$dailyTodayCounts  = $Specialist->getDailyTodayCounts();
			$weeklyWeekCounts  = $Specialist->getWeeklyWeekCounts(currentIsoWeek());
			require 'app/Views/specialist/dashboard.view.php';
			return;
		}

		// Apprentice (role 0): home with recently released reports + submission reminders.
		$Journal = new Journal();
		$arrayJournalsInRelease = $Journal->getAllDailyJournalsInRelease()->fetchAll();

		$Wochenrapport = new WeeklyReport();
		$arrayWeeklyIsInRelease = $Wochenrapport->getAllWeeklyInRelease()->fetchAll();

		// Reminder state: has the current period's report already been submitted?
		$dailySubmitted   = $Journal->countDailyToday($_SESSION['id']) > 0;
		$weeklySubmitted  = $Wochenrapport->countWeeklyForWeek($_SESSION['id'], currentIsoWeek()) > 0;
		$dailyDeadlineMs  = dailyDeadline()->getTimestamp() * 1000;
		$weeklyDeadlineMs = weeklyDeadline()->getTimestamp() * 1000;

		require 'app/Views/home.view.php';
	}
}