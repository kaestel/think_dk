<?php
global $action;
global $model;
$UC = new User();

// get current user id
$user_id = session()->value("user_id");
// $order_no = $action[1];
// $amount = "";
// $user = $UC->getUser();
//
// $order = $model->getOrders(array("order_no" => $order_no));
// $membership = $UC->getMembership();
//
//
//
// $is_membership = false;
// $subscription_method = false;
//
//
// if($order) {
// 	$total_order_price = $model->getTotalOrderPrice($order["id"]);
// 	if($total_order_price) {
// 		$amount = formatPrice($total_order_price);
// 	}
//
//
// 	if($membership && $membership["order"]) {
// 		$is_membership = ($membership["order"] && $order["id"] == $membership["order"]["id"]) ? true : false;
// 	}
//
//
// 	if($membership && $membership["item"] && $membership["item"]["subscription_method"] && $membership["item"]["subscription_method"]["duration"]) {
// 		$subscription_method = $membership["item"]["subscription_method"];
// 		$payment_date = $membership["renewed_at"] ? date("jS", strtotime($membership["renewed_at"])) : date("jS", strtotime($membership["created_at"]));
// 	}
//
// }



?>
<div class="scene shopReceipt i:scene">

	<h1>Receipt</h1>
	<h2>Thank you for supporting change.</h2>
	<p>We are thrilled to have you on board - now go ahead and check out our <a href="/events">upcoming events</a>!</p>

</div>