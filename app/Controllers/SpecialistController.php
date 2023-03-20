<?php

use Google\Service\Classroom\Topic;

class FachkraftController
{
	// This page gives an overview about all reports and apprenticeses
    public function overview(){		
		// Load overview view file
		require 'app/Views/fachkraft/overview.view.php';
	}
}