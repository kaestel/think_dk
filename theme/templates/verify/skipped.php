<?php
global $action;
global $model;

$IC = new Items();
$SC = new Shop();

$page_item = $IC->getItem(array("tags" => "page:verify-skipped", "status" => 1, "extend" => array("user" => true, "tags" => true, "mediae" => true)));
if($page_item) {
	$this->sharingMetaData($page_item);
}

// values save while redirecting in controller
$username = session()->value("signup_email");
session()->reset("signup_email");

$cart = $SC->getCart();


?>
<div class="scene verify skipped i:scene">

<? if($page_item): 
	$media = $IC->sliceMediae($page_item, "single_media"); ?>
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


		<?= $HTML->articleInfo($page_item, "/verify/skipped", [
			"media" => $media
		]) ?>



		<? if($page_item["html"]): ?>
		<div class="articlebody" itemprop="articleBody">
			<?= preg_replace("/{username}/", $username, $page_item["html"]) ?>
		</div>
		<? endif; ?>
	</div>
<? else:?>

	<h1>Not verified</h1>
	<p>Your account has been created, but not has not yet been verified. Please check your inbox and verify your account now.</p>

<? endif; ?>

<? if($cart && $cart["items"]): ?>

	<h2>Checkout</h2>
	<p>You have <?= pluralize(count($cart["items"]), "item", "items") ?> in your cart.</p>
	<ul class="actions">
		<li class="checkout"><a href="/shop/checkout" class="button primary">Proceed to checkout</a></li>
	</ul>

<? endif; ?>

</div>