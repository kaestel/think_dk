<?php
global $IC;
global $action;
global $itemtype;
$model = $IC->typeObject($itemtype);


$year = $action[1];
$month = $action[2];

// get items from  year/month
$items = $IC->getItems(array("itemtype" => "event", "status" => 1, "where" => "event.starting_at < '".date("Y-m-d", mktime(0,0,0, $month+1, 1, $year))."' AND event.starting_at > '".date("Y-m-d", mktime(0,0,0, $month, 1, $year))."'", "order" => "event.starting_at ASC", "extend" => true));

?>

<div class="scene events i:events">


	<div class="all_events">
		<h2>Events</h2>

	<? if($items): ?>

		<ul class="items events">
		<? foreach($items as $item): ?>
			<li class="item event item_id:<?= $item["item_id"] ?>">

				<dl class="occurs_at">
					<dt class="starting_at">Starts</dt>
					<dd class="starting_at" content="<?= date("Y-m-d H:i", strtotime($item["starting_at"])) ?>"><?= date("l, F j, Y - H:i", strtotime($item["starting_at"])) ?></dd>
				</dl>

				<h3><? if($item["event_status"] != 1): 
					?><span class="event_status <?= strtolower($model->event_status_schema_values[$item["event_status"]]) ?>"><?= strtoupper($model->event_status_options[$item["event_status"]]).": " ?></span><?
				endif; ?><a href="/events/<?= $item["sindex"] ?>"><?= strip_tags($item["name"]) ?></a></h3>

				<? if($item["description"]): ?>
				<div class="description">
					<p><? if($item["event_status"] != 1):
						?><span class="event_status <?= strtolower($model->event_status_schema_values[$item["event_status"]]) ?>"><?= strtoupper($model->event_status_options[$item["event_status"]]).": " ?></span><?
					endif; ?><?= nl2br($item["description"]) ?></p>
				</div>
				<? endif; ?>

			</li>
		<?	endforeach; ?>
		</ul>

	<? else: ?>

		<p>No scheduled events.</p>

	<? endif; ?>

	</div>

</div>
