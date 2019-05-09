<?php
$access_item = false;
if(isset($read_access) && $read_access) {
	return;
}

include_once($_SERVER["FRAMEWORK_PATH"]."/config/init.php");


$action = $page->actions();
$IC = new Items();
$itemtype = "event";


$page->bodyClass("events");
$page->pageTitle("Events");


// news list for tags
// /posts/#sindex#
// Used by calendar to go back through months
// /events/past/#year#/#month#
if(count($action) == 1) {

	$page->page(array(
		"templates" => "events/view.php"
	));
	exit();

}
// Used by calendar to go back through months
// /events/past/#year#/#month#
else if(count($action) == 3 && $action[0] == "past" && is_numeric($action[1]) && is_numeric($action[2])) {

	$page->page(array(
		"templates" => "events/month.php"
	));
	exit();

}
else if(count($action) == 3 && $action[0] == "print" && is_numeric($action[1]) && is_numeric($action[2])) {

	$page->page(array(
		"templates" => "events/month-print.php"
	));
	exit();

}


// /events
// /events/#year#/#month#
$page->page(array(
	"templates" => "events/index.php"
));
exit();

?>
