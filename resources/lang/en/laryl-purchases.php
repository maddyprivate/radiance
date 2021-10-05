<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Laryl Blade EN lines
	|--------------------------------------------------------------------------
	*/

	'create-new'	=> 'New Purchase',

	'heading' => [
		'list'		=> 'Purchases Master List',
		'new'		=> 'New Purchase',
		'show'	    => 'Purchase :purchase',
		'edit'   	=> 'Editing Purchase <span class="d-none d-sm-inline">:purchase</span>',
	],

	'table' => [
		'#'					=> 'Sr.No.',
		'issueDate'			=> 'Purchase Date',
		'dueDate'			=> 'Due Date',
		'purchaseStatus'		=> 'Purchase Status',
		'grandValue'		=> 'Grand Total',
		'dealer'			=> 'Dealer',
		'options'			=> 'Options',
		'billNo'			=> 'Bill No.',
	],

	'form' => [
		'label' => [
			'otherCharges'		=> 'Other Charges',
			'vehicleNo'			=> 'Vehicle No.',
			'purchaseSerial'		=> 'Purchase Serial',
			'issueDate'			=> 'Purchase Date',
			'dueDate'			=> 'Purchase Due Date',
			'dealerName'		=> 'Dealer Name',
			'dealerGstin'		=> 'Dealer GSTIN',
			'dealerMobile'	=> 'Dealer Mobile',
			'billingAddress'	=> 'Billing Address',
			'shippingAddress'	=> 'Shipping Address',
			'placeOfSupply'		=> 'Place of Supply',
			'discountRate'		=> 'Discount (%)',
			'purchaseStatus'		=> 'Purchase Status',
			'billNo'		=> 'Bill No.',
		]
	],

	'buttons' => [
		'create-new'    	=> '<span class="hidden-xs hidden-sm">New Purchase</span>',
		'back-to-purchases'	=> '<i class="fa fa-angle-double-left"></i>&emsp;Back <span class="d-none d-sm-inline">to Purchases List</span>',
		'back-to-purchase'	=> '<i class="fa fa-angle-double-left"></i>&emsp;Back <span class="d-none d-sm-inline">to Purchase</span>',
		'save-purchase'		=> '<i class="fa fa-save"></i>&emsp;<span>Save Purchase</span>',
		'update-purchase'	=> '<i class="fa fa-save"></i>&emsp;<span>Update Purchase</span>',
	],
];
