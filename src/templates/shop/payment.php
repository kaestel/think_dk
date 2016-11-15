<?php
global $action;
global $model;
$UC = new User();

// get current user id
$user_id = session()->value("user_id");
$order_no = $action[1];
$amount = "";


$order = $model->getOrders(array("order_no" => $order_no));
$membership = $UC->getMembership();

if($order && $order["payment_status"] != 2) {

	$total_order_price = $model->getTotalOrderPrice($order["id"]);
	if($total_order_price) {
		$amount = formatPrice($total_order_price);
	}

	// TODO: should calculate remaining payment (in case partially paid)

}

$payment_methods = $this->paymentMethods();

?>
<div class="scene shopPayment i:payment">
	<h1>Payment</h1>

<? if($order && $amount): ?>

	<dl class="amount">
		<dt class="amount">Due amount</dt>
		<dd class="amount"><?= $amount ?></dd>
	</dl>


	<h2>Please be so kind ...</h2>

	<p>
		Choose your preferred payment method:
	</p>

	<ul class="payment_methods">

		<? foreach($payment_methods as $payment_method): ?>
		<li class="payment_method<?= $payment_method["classname"] ? " ".$payment_method["classname"] : "" ?>">

			<ul class="actions">
			<? if($payment_method["classname"] == "disabled"): ?>

				<li><a class="button disabled"><?= $payment_method["name"] ?></a></li>

			<? else: ?>

				<?= $JML->oneButtonForm($payment_method["name"], "/shop/selectPaymentMethod", array(
					"inputs" => array("order_id" => $order["id"], "payment_method" => $payment_method["id"]),
					"confirm-value" => false,
					"static" => true,
					"class" => "primary",
					"name" => "continue",
					"wrapper" => "li.continue.".$payment_method["classname"],
				)) ?>

			<? endif; ?>
			</ul>
			<p><?= $payment_method["description"] ?></p>

		</li>
		<? endforeach; ?>

	</ul>

	<p class="note">We cover the transaction fee – so feel free to choose a suited option with the smallest fee.</p>

<? else: ?>

	<h2>Looking to make a payment?</h2>
	<p>You should <a href="/login">log in</a> to your account and initiate your payment from there.</p>

<? endif;?>

</div>