<?php

class WeeklyReportController
{
    public function weeklyraport(){		
		require 'app/Views/lernender/weeklyraport.view.php';
	}

	public function addweeklyjournal(){
		// Load the add weekly journal entry form view
		require 'app/Views/lernender/addweeklyjournal.view.php';
	}	

    public function editWeeklyRaport(){
		require 'app/Views/lernender/editWeeklyJournal.view.php';
	}	

	public function deleteWeeklyRaport(){}

	public function releaseWeeklyReport(){}	

	public function seeWeekly(){
		// Load the view to display the weekly report data
		require 'app/Views/lernender/seeWeekly.view.php';
	}	
}