<?php

use Google\Service\Classroom\Topic;

class FachkraftController
{
	// This page gives an overview about all reports and apprenticeses
    public function overview(){		
		// Load configuration file
		require_once 'app/Views/general/config.php';

		// Check if user is logged in and has role of 1
		if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
			if($_SESSION['role'] == 1){
				// Create instances of Fachkraft and Keyword classes
				$Fachkraft = new Fachkraft();
				$Keyword = new Keyword();
						
				// Retrieve all daily rapports from database
				$arrayDailyRaports = $Fachkraft->getDailyRaports()->fetchAll();

				// Retrieve all weekly rapports from database
				$arrayWeeklyRaports = $Fachkraft->getWeeklyRaports()->fetchAll();

				// Retrieve all apprentices from database
				$arrayLernende = $Fachkraft->getAllLernende()->fetchAll();

				// Retrieve all keywords from database
				$arrayTopics = $Keyword->getAllKeywords()->fetchAll();
				
				// Load overview view file
				require 'app/Views/fachkraft/overview.view.php';
			}
		}
	}
}