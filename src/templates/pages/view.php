<?php
global $IC;
global $action;
global $itemtype;

$sindex =  $action[0];

$page_item = $IC->getItem(array("sindex" => $sindex, "extend" => array("comments" => true, "user" => true, "mediae" => true, "tags" => true)));
if($page_item) {
	$this->sharingMetaData($page_item);
}
?>

<div class="scene page i:scene">

<? if($page_item && $page_item["status"]): 
	$media = $IC->sliceMedia($page_item); ?>
	<div class="article i:article id:<?= $page_item["item_id"] ?>" itemscope itemtype="http://schema.org/Article">

		<? if($page_item["tags"]):
			$editing_tag = arrayKeyValue($page_item["tags"], "context", "editing");
			if($editing_tag !== false): ?>
		<ul class="tags">
			<li class="editing" title="This page is work in progress"><?= $page_item["tags"][$editing_tag]["value"] == "true" ? "Still editing" : $page_item["tags"][$editing_tag]["value"] ?></li>
		</ul>
			<? endif; ?>
		<? endif; ?>

		<? if($media): ?>
		<div class="image item_id:<?= $page_item["item_id"] ?> format:<?= $media["format"] ?> variant:<?= $media["variant"] ?>"></div>
		<? endif; ?>

		<h1 itemprop="headline"><?= $page_item["name"] ?></h1>

		<? if($page_item["subheader"]): ?>
		<h2 itemprop="alternativeHeadline"><?= $page_item["subheader"] ?></h2>
		<? endif; ?>

		<ul class="info">
			<li class="published_at" itemprop="datePublished" content="<?= date("Y-m-d", strtotime($page_item["published_at"])) ?>"><?= date("Y-m-d, H:i", strtotime($page_item["published_at"])) ?></li>
			<li class="modified_at" itemprop="dateModified" content="<?= date("Y-m-d", strtotime($page_item["modified_at"])) ?>"><?= date("Y-m-d, H:i", strtotime($page_item["published_at"])) ?></li>
			<li class="author" itemprop="author"><?= $page_item["user_nickname"] ?></li>
			<li class="main_entity share" itemprop="mainEntityOfPage"><?= SITE_URL."/pages/". $sindex ?></li>
			<li class="publisher" itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
				<ul class="publisher_info">
					<li class="name" itemprop="name">think.dk</li>
					<li class="logo" itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
						<span class="image_url" itemprop="url" content="<?= SITE_URL ?>/img/logo-large.png"></span>
						<span class="image_width" itemprop="width" content="720"></span>
						<span class="image_height" itemprop="height" content="405"></span>
					</li>
				</ul>
			</li>
			<li class="image_info" itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
			<? if($media): ?>
				<span class="image_url" itemprop="url" content="<?= SITE_URL ?>/images/<?= $page_item["item_id"] ?>/<?= $media["variant"] ?>/720x.<?= $media["format"] ?>"></span>
				<span class="image_width" itemprop="width" content="720"></span>
				<span class="image_height" itemprop="height" content="<?= floor(720 / ($media["width"] / $media["height"])) ?>"></span>
			<? else: ?>
				<span class="image_url" itemprop="url" content="<?= SITE_URL ?>/img/logo-large.png"></span>
				<span class="image_width" itemprop="width" content="720"></span>
				<span class="image_height" itemprop="height" content="405"></span>
			<? endif; ?>
			</li>
		</ul>

		<? if($page_item["html"]): ?>
		<div class="articlebody" itemprop="articleBody">
			<?= $page_item["html"] ?>
		</div>
		<? endif; ?>


		<div class="comments i:comments item_id:<?= $page_item["item_id"] ?>" 
			data-comment-add="<?= $this->validPath("/janitor/admin/page/addComment") ?>" 
			data-csrf-token="<?= session()->value("csrf") ?>"
			>
			<h2 class="comments">Comments for &quot;<?= $page_item["name"] ?>&quot;</h2>
			<? if($page_item["comments"]): ?>
			<ul class="comments">
				<? foreach($page_item["comments"] as $comment): ?>
				<li class="comment comment_id:<?= $comment["id"] ?>" itemprop="comment" itemscope itemtype="https://schema.org/Comment">
					<ul class="info">
						<li class="published_at" itemprop="datePublished" content="<?= date("Y-m-d", strtotime($comment["created_at"])) ?>"><?= date("Y-m-d, H:i", strtotime($comment["created_at"])) ?></li>
						<li class="author" itemprop="author"><?= $comment["nickname"] ?></li>
					</ul>
					<p class="comment" itemprop="text"><?= $comment["comment"] ?></p>
				</li>
				<? endforeach; ?>
			</ul>
			<? else: ?>
			<p>No comments yet</p>
			<? endif; ?>
		</div>

	</div>



<? else:?>

	<h1>Technology clearly doesn't solve everything on it's own.</h1>
	<h2>Technology needs humanity.</h2>
	<p>We could not find the specified page.</p>

<? endif; ?>


</div>