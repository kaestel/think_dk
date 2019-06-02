<?php
global $action;
global $model;

$IC = new Items();
$UC = new User();

$page_item = $IC->getItem(array("tags" => "page:memberships", "extend" => array("user" => true, "mediae" => true, "tags" => true)));
if($page_item) {
	$this->sharingMetaData($page_item);
}

$email = $model->getProperty("email", "value");

$memberships = $IC->getItems(array("itemtype" => "membership", "tags" => "membership:v2", "order" => "position ASC", "status" => 1, "extend" => array("prices" => true, "subscription_method" => true)));


// $maillist = session()->value("user_id") === 1 ? true : false;

?>
<div class="scene signup i:memberships">

<? if($page_item && $page_item["status"]): 
	$media = $IC->sliceMedia($page_item); ?>
	<div class="article i:article id:<?= $page_item["item_id"] ?>" itemscope itemtype="http://schema.org/Article">

		<? if($media): ?>
		<div class="image item_id:<?= $page_item["item_id"] ?> format:<?= $media["format"] ?> variant:<?= $media["variant"] ?>"></div>
		<? endif; ?>


		<?= $HTML->articleTags($page_item, [
			"context" => false
		]) ?>


		<h1 itemprop="headline"><?= $page_item["name"] ?></h1>

		<? if($page_item["subheader"]): ?>
		<h2 itemprop="alternativeHeadline"><?= $page_item["subheader"] ?></h2>
		<? endif; ?>


		<?= $HTML->articleInfo($page_item, "/memberships", [
			"media" => $media,
			"sharing" => true
		]) ?>


		<? if($page_item["html"]): ?>
		<div class="articlebody" itemprop="articleBody">
			<?= $page_item["html"] ?>
		</div>
		<? endif; ?>

	</div>
<? else:?>
	<h1>Memberships</h1>
<? endif; ?>



<? if($memberships): ?>

	<div class="memberships">


		<?= $HTML->serverMessages() ?>


		<ul class="memberships">
			<? foreach($memberships as $membership): ?>
			<li class="membership<?= $membership["classname"] ? " ".$membership["classname"] : "" ?>" itemprop="offers">
				<h3><?= $membership["name"] ?></h3>

				<?= $HTML->frontendOffer($membership, SITE_URL."/memberships", $membership["introduction"]) ?>

				<? if($membership["classname"] == "cowork"): ?>

				<ul class="actions">
					<?= $model->link("Read more", "/bulletin/think-dk-co-working-space", array("wrapper" => "li.readmore")) ?>
					<?= $model->link("Join", "/bulletin/think-dk-co-working-space", array("class" => "button primary", "wrapper" => "li.signup")) ?>
				</ul>

				<? else: ?>

				<?= $model->formStart("/memberships/addToCart", array("class" => "signup labelstyle:inject")) ?>
					<?= $model->input("quantity", array("value" => 1, "type" => "hidden")); ?>
					<?= $model->input("item_id", array("value" => $membership["item_id"], "type" => "hidden")); ?>

					<ul class="actions">
						<?= $model->link("Read more", "/memberships/".$membership["sindex"], array("wrapper" => "li.readmore")) ?>
						<?= $model->submit("Join", array("class" => "primary", "wrapper" => "li.signup")) ?>
					</ul>
				<?= $model->formEnd() ?>

				<? endif; ?>

			</li>
			<? endforeach; ?>
		</ul>
	</div>

<? endif; ?>


	<div class="maillist">
		<?= $UC->formStart("/maillist/addToMaillist", array("class" => "maillist labelstyle:inject")) ?>
			<?= $UC->input("maillist", array("value" => "curious", "type" => "hidden")); ?>
			<fieldset>
				<?= $UC->input("email", array("value" => $email, "required" => true, "hint_message" => "Enter your email")); ?>
				<?= $UC->input("terms"); ?>
			</fieldset>

			<ul class="actions">
				<?= $UC->submit("Sign up", array("class" => "primary", "wrapper" => "li.signup")) ?>
			</ul>
		<?= $UC->formEnd() ?>
	</div>

</div>
