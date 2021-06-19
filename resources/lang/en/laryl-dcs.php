<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Laryl Blade EN lines
	|--------------------------------------------------------------------------
	*/

	'create-new'	=> 'New Dc',

	'heading' => [
		'list'		=> 'Dcs Master List',
		'new'		=> 'New Dc',
		'show'	    => 'Dc :dc',
		'edit'   	=> 'Editing Dc <span class="d-none d-sm-inline">:dc</span>',
	],

	'table' => [
		'#'					=> '#',
		'issueDate'			=> 'DC Date',
		'dueDate'			=> 'Due Date',
		'dcStatus'			=> 'Dc Status',
		'grandValue'		=> 'Grand Total',
		'customer'			=> 'Customer',
		'options'			=> 'Options',
	],

	'form' => [
		'label' => [
			'otherCharges'		=> 'Other Charges',
			'vehicleNo'			=> 'Vehicle No.',
			'dcSerial'		=> 'Dc Serial',
			'issueDate'			=> 'Dc Date',
			'dueDate'			=> 'Dc Due Date',
			'customerName'		=> 'Customer Name',
			'customerGstin'		=> 'Customer GSTIN',
			'customerMobile'	=> 'Customer Mobile',
			'billingAddress'	=> 'Billing Address',
			'shippingAddress'	=> 'Shipping Address',
			'placeOfSupply'		=> 'Place of Supply',
			'discountRate'		=> 'Discount (%)',
			'dcStatus'		=> 'Dc Status',
		]
	],

	'buttons' => [
		'create-new'    	=> '<span class="hidden-xs hidden-sm">New Dc</span>',
		'back-to-dcs'	=> '<i class="fa fa-angle-double-left"></i>&emsp;Back <span class="d-none d-sm-inline">to Dcs List</span>',
		'back-to-dc'	=> '<i class="fa fa-angle-double-left"></i>&emsp;Back <span class="d-none d-sm-inline">to Dc</span>',
		'save-dc'		=> '<i class="fa fa-save"></i>&emsp;<span>Save Dc</span>',
		'update-dc'	=> '<i class="fa fa-save"></i>&emsp;<span>Update Dc</span>',
	],
];
