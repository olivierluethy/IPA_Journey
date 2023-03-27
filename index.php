<?php
require 'core/bootstrap.php';

$routes = [
	'' => 'JournalController@home',

	/* For Learners*/
	'home' => 'JournalController@home',
	'dailyraport' => 'DailyReportController@dailyraport',
	'weeklyraport' => 'WeeklyReportController@weeklyraport',

	'keywords' => 'KeywordController@keywords',
	'editKeyword' => 'KeywordController@editkeywords',
	'deleteKeyword' => 'KeywordController@deleteKeyword',

	'editWeeklyRaport' => 'WeeklyReportController@editWeeklyRaport',
	'deleteWeeklyRaport' => 'WeeklyReportController@deleteWeeklyRaport',
	'releaseWeeklyReport' => 'WeeklyReportController@releaseWeeklyReport',

	'editUser' => 'AdminController@editUser',
	'deleteUser' => 'AdminController@deleteUser',

	'editDailyReport' => 'DailyReportController@editDailyReport',
	'deleteDailyReport' => 'DailyReportController@deleteDailyReport',
	'releaseDailyReport' => 'DailyReportController@releaseDailyReport',

	'adddailyjournal' => 'DailyReportController@adddailyjournal',
	'addweeklyjournal' => 'WeeklyReportController@addweeklyjournal',
	'addkeyword' => 'KeywordController@addkeyword',

	/* For Specialists */
	'overview' => 'SpecialistController@overview',
	'releasedreports' => 'JournalController@releasedreports',
	'seeDaily' => 'DailyReportController@seeDaily',
	'seeWeekly' => 'WeeklyReportController@seeWeekly',

	/* For Admin */
	'useroverview' => 'AdminController@useroverview',

	/* For everyone */
	'logout' => 'LoginController@logout',
	'login' => 'LoginController@login',

	'addUser' => 'LoginController@addUser',
	'doesUserExist' => 'LoginController@doesUserExist',
];

$db = [
	'name'     => 'journal',
	'username' => 'root',
	'password' => '',
];

$router = new Router($routes);
$router->run($_GET['url'] ?? '');