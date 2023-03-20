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
		}else {
			// Retrieve all daily journals that are released
			$Journal = new Journal();
			$arrayJournalsInRelease = $Journal->getAllDailyJournalsInRelease()->fetchAll();
	
			// Retrieve all weekly reports that are released
			$Wochenrapport = new WeeklyReport();
			$arrayWeeklyIsInRelease = $Wochenrapport->getAllWeeklyInRelease()->fetchAll();
	
			// Load the home view
			require 'app/Views/home.view.php';
		}
	}	

	public function releasedreports(){		
		require_once 'app/Views/general/config.php';

		require 'app/Views/fachkraft/releasedreports.view.php';
	}
}