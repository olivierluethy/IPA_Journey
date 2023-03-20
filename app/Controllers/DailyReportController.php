<?php

class DailyReportController
{
	/* The page to show daily raports made by user */
    public function dailyraport() {
		// Load dailyraport view
		require 'app/Views/lernender/dailyraport.view.php';
	}
	
	/* The page to add daily journal */
	public function adddailyjournal() {
		// Load the daily journal form view
		require 'app/Views/lernender/adddailyjournal.view.php';
	}	

	/* The page to edit a daily report */
    public function editDailyReport(){}		

	/* The page to delete a daily report */
	public function deleteDailyReport() {}	

	/* The URL to release a daily report */
	public function releaseDailyReport(){}	

	/* The page to see a written daily report */
	public function seeDaily(){}	
}