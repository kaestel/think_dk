<?php
global $action;
global $IC;
global $model;
global $itemtype;


$user_id = session()->value("user_id");


$items = $IC->getItems(array("itemtype" => $itemtype, "where" => $itemtype.".starting_at > NOW()", "tags" => "eventtype:member", "order" => "status DESC, ".$itemtype.".starting_at ASC", "extend" => array("tags" => true, "mediae" => true)));
$filtered_events = [];
foreach($items as $item) {
	if($item["event_owner"] == $user_id || $item["backer_1"] == $user_id || $item["backer_2"] == $user_id) {
		
		array_push($filtered_events, $item);

	}
}

?>
<div class="scene i:scene defaultList <?= $itemtype ?>List">
	<h1>Events</h1>

	
	<div class="all_items i:defaultList taggable filters"<?= $JML->jsData() ?>>
<?		if($filtered_events): ?>
		<ul class="items">

<?			if($filtered_events): ?>
<?			foreach($filtered_events as $item): ?>
			<li class="item item_id:<?= $item["id"] ?>">
				<h3><?= strip_tags($item["name"]) ?></h3>
				<dl class="info">
					<dt>Starting</dt>
					<dd class="starting_at"><?= date("Y-m-d @ H:i", strtotime($item["starting_at"])) ?></dd>
				</dl>

				<?= $JML->tagList($item["tags"]) ?>

				<?= $JML->listActions($item, ["modify" => [
					"edit" => [
						"url" => "/janitor/event/host-edit/". $item["id"]
					],
					"delete" => false
				]]) ?>
			 </li>
<?			endforeach; ?>
<?			endif; ?>

		</ul>
<?		else: ?>
		<p>You do not own or back any events.</p>
<?		endif; ?>
	</div>

</div>