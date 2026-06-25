<?php
require 'core/bootstrap.php';

$routes = [
	'' => 'JournalController@home',

	/* For Learners*/
	'home' => 'JournalController@home',
	'dailyRaport' => 'DailyReportController@dailyRaport',
	'weeklyRaport' => 'WeeklyReportController@weeklyRaport',

	'keywords' => 'KeywordController@keywords',
	'editKeyword' => 'KeywordController@editKeyword',
	'deleteKeyword' => 'KeywordController@deleteKeyword',

	'editWeeklyRaport' => 'WeeklyReportController@editWeeklyRaport',
	'deleteWeeklyRaport' => 'WeeklyReportController@deleteWeeklyRaport',
	'releaseWeeklyReport' => 'WeeklyReportController@releaseWeeklyReport',

	'editUser' => 'AdminController@editUser',
	'deleteUser' => 'AdminController@deleteUser',

	'editDailyReport' => 'DailyReportController@editDailyReport',
	'deleteDailyReport' => 'DailyReportController@deleteDailyReport',
	'releaseDailyReport' => 'DailyReportController@releaseDailyReport',

	'addDailyJournal' => 'DailyReportController@addDailyJournal',
	'addWeeklyJournal' => 'WeeklyReportController@addWeeklyJournal',
	'addKeyword' => 'KeywordController@addKeyword',
	'uploadImage' => 'UploadController@image',

	/* For Specialists */
	'overview' => 'SpecialistController@overview',
	'releasedReports' => 'JournalController@releasedReports',

	/* For Admin */
	'userOverview' => 'AdminController@userOverview',

	/* For everyone */
	'logout' => 'LoginController@logout',
	'login' => 'LoginController@login',

	'addUser' => 'LoginController@addUser',
	'doesUserExist' => 'LoginController@doesUserExist',

	/* Developer login bypass (only active when APP_ENV != production) */
	'devLogin' => 'LoginController@devLogin',
];

$db = [
	'name'     => 'journal',
	'username' => 'root',
	'password' => '',
];

$router = new Router($routes);
$router->run($_GET['url'] ?? '');