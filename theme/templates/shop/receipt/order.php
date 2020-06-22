<?php
global $action;
global $model;

$this->pageTitle("Receipt");

$MC = new Member();

$user_id = session()->value("user_id");


$order = false;
$receipt_type = false;

$is_membership = false;
$subscription_method = false;
$payment_date = false;


// get current user id
$user_id = session()->value("user_id");

$order_no = $action[2];
if($order_no) {
	$order = $model->getOrders(array("order_no" => $order_no));


	// get potential user membership
	$membership = $MC->getMembership();


	if($order) {
		$total_order_price = $model->getTotalOrderPrice($order["id"]);
		$remaining_order_price = $model->getRemainingOrderPrice($order["id"]);


		if($membership && $membership["order"]) {
			// is the users membership related to this order?
			$is_membership = ($membership["order"] && $order["id"] == $membership["order"]["id"]) ? true : false;
		}

		if($is_membership && $membership && $membership["item"] && $membership["item"]["subscription_method"] && $membership["item"]["subscription_method"]["duration"]) {
			$subscription_method = $membership["item"]["subscription_method"];
			$payment_date = $membership["renewed_at"] ? date("jS", strtotime($membership["renewed_at"])) : date("jS", strtotime($membership["created_at"]));
		}

	}

}


// receipt type indicated in url
if(isset($action[3])) {
	$receipt_type = $action[3];
}


?>
<div class="scene shopReceipt i:scene">

<? if($order): ?>

	<h1>Thank you for supporting change.</h1>
	<div class="order_info">

		<h2>
			Your order is confirmed <br />
			<? if($remaining_order_price["price"] > 0): ?>
			– payment is being processed
			<? else: ?>
			– and paid
			<? endif; ?>
		</h2>

		<ul class="orders">
			<li>
				<h3>Order no: <?= $order["order_no"] . ($order["comment"] ? (" – " . $order["comment"]) : "") ?></h3>
				<ul class="orderitems">
				<? foreach($order["items"] as $order_item): ?>
					<li><?= $order_item["quantity"] ?> x <?= $order_item["name"] ?></li>
				<? endforeach; ?>
				</ul>
			</li>
		</ul>

		<h3>
			<span class="name">Total</span>
			<span class="total_price">
				<?= formatPrice($total_order_price, array("vat" => true)) ?>
			</span>
		</h3>

	</div>

	<?
	if($remaining_order_price["price"] === 0):

		$has_ticket = false;
		foreach($order["items"] as $order_item):

			$query = new Query();
			$sql = "SELECT * FROM ".SITE_DB.".user_item_tickets WHERE order_item_id = ".$order_item["id"];

			if($query->sql($sql)) {

				if(!$has_ticket): ?>
				<h2>Download your ticket(s)</h2>

				<ul class="ticketdownload">

				<? endif;
				$has_ticket = true;
				$tickets = $query->results();

				foreach($tickets as $key => $ticket): ?>
					<li class="ticket"><?= $order_item["name"] ?> - <a href="/download/<?= $ticket["item_id"] ?>/<?= $ticket["ticket_no"] ?>/<?= $ticket["ticket_no"] ?>.pdf"><?= $ticket["ticket_no"] ?><?= (count($tickets) > 1 ? " (".($key+1)."/".count($tickets).")" : "") ?></a></li>
				<? endforeach; ?>

				</ul>
			<? }
	
		endforeach;
	endif;
	?>

	<? if($is_membership): ?>
	<div class="membership_info">
		<h2>Congratulations with your new membership</h2>
		<p>We are thrilled to have you on board - you will receive a welcome email any second now. Go ahead and check out our <a href="/events">upcoming events</a> now.</p>
	</div>
	<? endif; ?>



	<? if($remaining_order_price["price"] > 0): ?>
	<div class="payment_information">

		<? if($receipt_type == "bank-transfer"): ?>
		<h2>Pay with Bank transfer</h2>

		<p>
		<? if($subscription_method && $payment_date && $remaining_order_price["price"] == $total_order_price["price"]): ?>
			Set up a re-occuring payment every <?= strtolower($subscription_method["name"]) ?> on the <?= $payment_date ?> to our bankaccount, using the information below:
		<? else: ?>
			Make a payment to our bankaccount, using the information below:
		<? endif; ?>
		</p>

		<dl>
			<dt class="amount">Amount</dt>
			<dd class="amount"><?= formatPrice($remaining_order_price) ?></dd>

			<dt class="recipient">Recipient</dt>
			<dd class="recipient">think.dk ApS</dd>

			<dt class="reference">Reference</dt>
			<? if($is_membership): ?>
			<dd class="reference">Member <?= $membership["id"] ?></dd>
			<? else: ?>
			<dd class="reference"><?= $order_no ?></dd>
			<? endif; ?>

			<dt class="bank">Bank</dt>
			<dd class="bank">Fælleskassen</dd>

			<dt class="account">Account no</dt>
			<dd class="account">8411 4145172</dd>

			<dt class="iban">IBAN</dt>
			<dd class="iban">DK3184110004145172</dd>

			<dt class="swift">SWIFT/BIC</dt>
			<dd class="swift">FAELDKK1</dd>
		</dl>


		<? elseif($receipt_type == "paypal"): ?>


		<h2>Pay with PayPal</h2>
		<p>
			Make a payment to our PayPal account, using the information below:
		</p>

		<dl>
			<dt class="amount">Amount</dt>
			<dd class="amount"><?= formatPrice($remaining_order_price) ?></dd>

			<dt class="recipient">PayPal account</dt>
			<dd class="recipient">payment@think.dk</dd>

			<dt class="reference">Reference</dt>
			<? if($is_membership): ?>
			<dd class="reference">Member <?= $membership["id"] ?></dd>
			<? else: ?>
			<dd class="reference"><?= $order_no ?></dd>
			<? endif; ?>
		</dl>


		<? elseif($receipt_type == "mobilepay"): ?>


		<h2>Pay with MobilePay</h2>
		<p>
			Make a payment to our MobilePay account, using the information below:
		</p>

		<dl>
			<dt class="amount">Amount</dt>
			<dd class="amount"><?= formatPrice($remaining_order_price) ?></dd>

			<dt class="recipient">MobilePay account</dt>
			<dd class="recipient">127888</dd>

			<dt class="reference">Reference</dt>
			<? if($is_membership): ?>
			<dd class="reference">Member <?= $membership["id"] ?></dd>
			<? else: ?>
			<dd class="reference"><?= $order_no ?></dd>
			<? endif; ?>
		</dl>


		<? elseif($receipt_type == "cash"): ?>


		<h2>Cash payment</h2>
		<p>Just bring <?= formatPrice($remaining_order_price) ?> in cash next time you come to the Center.</p>


		<? endif; ?>

	</div>
	<? endif; ?>


<? elseif($user_id > 1):?>

	<h1>Thank you for supporting change.</h1>
	<p>We were not able to match any orders with this request. Please <a href="mailto:payment@think.dk?subject=Payment%20receipt%20error&body=Order%20No:%20<?= $order_no ?>">contact us</a> to resolve the issue.</p>

<? else: ?>

	<h1>Looking for your receipt?</h1>
	<p>You must be <a href="/login?login_forward=<?= $this->url ?>">logged in</a> to your account to view receipts.</p>

<? endif; ?>


</div>