<?php

use Google\Service\Classroom\Topic;

class SpecialistController
{
	// This page gives an overview about all reports and apprenticeses
    public function overview(){		
		// Load configuration file
		require_once 'app/Views/general/config.php';

		// Check if user is logged in and has role of 1
		if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
			if($_SESSION['role'] == 1){
				// Create instances of Fachkraft and Keyword classes
				$Specialist = new Specialist();
						
				// Retrieve all daily rapports from database
				$arrayDailyRaports = $Specialist->getDailyRaports()->fetchAll();

				// Retrieve all weekly rapports from database
				$arrayWeeklyRaports = $Specialist->getWeeklyRaports()->fetchAll();
				
				// Load overview view file
				require 'app/Views/specialist/overview.view.php';
			}
		}
	}
}