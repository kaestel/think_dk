<?php
global $action;
global $model;

$IC = new Items();
$page = $IC->getItem(array("tags" => "page:newsletter", "extend" => array("user" => true, "mediae" => true)));


$this->sharingMetaData($page);


$email = $model->getProperty("email", "value");
?>
<div class="scene newsletter i:newsletter">

<? if($page && $page["status"]): 
	$media = $IC->sliceMedia($page); ?>
	<div class="article i:article id:<?= $page["item_id"] ?>" itemscope itemtype="http://schema.org/Article">

		<? if($media): ?>
		<div class="image item_id:<?= $page["item_id"] ?> format:<?= $media["format"] ?> variant:<?= $media["variant"] ?>">
			<p>Image: <a href="/images/<?= $page["item_id"] ?>/<?= $media["variant"] ?>/500x.<?= $media["format"] ?>"><?= $media["name"] ?></a></p>
		</div>
		<? endif; ?>

		<h1 itemprop="headline"><?= $page["name"] ?></h1>

		<? if($page["subheader"]): ?>
		<h2 itemprop="alternativeHeadline"><?= $page["subheader"] ?></h2>
		<? endif; ?>

		<ul class="info">
			<li class="published_at" itemprop="datePublished" content="<?= date("Y-m-d", strtotime($page["published_at"])) ?>"><?= date("Y-m-d, H:i", strtotime($page["published_at"])) ?></li>
			<li class="modified_at" itemprop="dateModified" content="<?= date("Y-m-d", strtotime($page["modified_at"])) ?>"><?= date("Y-m-d, H:i", strtotime($page["published_at"])) ?></li>
			<li class="author" itemprop="author"><?= $page["user_nickname"] ?></li>
			<li class="main_entity" itemprop="mainEntityOfPage"><?= SITE_URL."/curious" ?></li>
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
				<span class="image_url" itemprop="url" content="<?= SITE_URL ?>/images/<?= $page["item_id"] ?>/<?= $media["variant"] ?>/720x.<?= $media["format"] ?>"></span>
				<span class="image_width" itemprop="width" content="720"></span>
				<span class="image_height" itemprop="height" content="<?= floor(720 / ($media["width"] / $media["height"])) ?>"></span>
			<? else: ?>
				<span class="image_url" itemprop="url" content="<?= SITE_URL ?>/img/logo-large.png"></span>
				<span class="image_width" itemprop="width" content="720"></span>
				<span class="image_height" itemprop="height" content="405"></span>
			<? endif; ?>
			</li>
		</ul>

		<? if($page["html"]): ?>
		<div class="articlebody" itemprop="articleBody">
			<?= $page["html"] ?>
		</div>
		<? endif; ?>
	</div>
<? else:?>
	<h1>Newsletter</h1>
<? endif; ?>

	<?= $model->formStart("/curious/signup", array("class" => "labelstyle:inject")) ?>

<?	if(message()->hasMessages(array("type" => "error"))): ?>
		<p class="errormessage">
<?		$messages = message()->getMessages(array("type" => "error"));
		message()->resetMessages();
		foreach($messages as $message): ?>
			<?= $message ?><br>
<?		endforeach;?>
		</p>
<?	endif; ?>

		<fieldset>
			<?= $model->input("newsletter", array("type" => "hidden", "value" => "curious")); ?>
			<?= $model->input("email", array("label" => "Your email", "required" => true, "value" => $email, "hint_message" => "Type your email.", "error_message" => "You entered an invalid email.")); ?>
		</fieldset>

		<ul class="actions">
			<?= $model->submit("Join", array("class" => "primary", "wrapper" => "li.signup")) ?>
		</ul>
	<?= $model->formEnd() ?>

</div>