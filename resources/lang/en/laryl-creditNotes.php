<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Laryl Blade EN lines
	|--------------------------------------------------------------------------
	*/

	'create-new'	=> 'New Credit Note',

	'heading' => [
		'list'		=> 'Credit Notes Master List',
		'new'		=> 'New Credit Note',
		'show'	    => 'Credit Note :creditNote',
		'edit'   	=> 'Editing Credit Note <span class="d-none d-sm-inline">:creditNote</span>',
	],

	'table' => [
		'#'					=> 'Sr.No.',
		'issueDate'			=> 'Credit Note Date',
		'dueDate'			=> 'Due Date',
		'creditNoteStatus'		=> 'Credit Note Status',
		'grandValue'		=> 'Grand Total',
		'customer'			=> 'Customer',
		'options'			=> 'Options',
		'pendingBalance'	=> 'Pending Balance',
		'creditNoteNo'			=> 'Credit Note No.',
	],

	'form' => [
		'label' => [
			'otherCharges'		=> 'Other Charges',
			'vehicleNo'			=> 'Vehicle No.',
			'creditNoteSerial'		=> 'Credit Note Serial',
			'issueDate'			=> 'Credit Note Date',
			'dueDate'			=> 'Credit Note Due Date',
			'customerName'		=> 'Customer Name',
			'customerGstin'		=> 'Customer GSTIN',
			'customerMobile'	=> 'Customer Mobile',
			'billingAddress'	=> 'Billing Address',
			'shippingAddress'	=> 'Shipping Address',
			'placeOfSupply'		=> 'Place of Supply',
			'discountRate'		=> 'Discount (%)',
			'creditNoteStatus'		=> 'Credit Note Status',
		]
	],

	'buttons' => [
		'create-new'    	=> '<span class="hidden-xs hidden-sm">New Credit Note</span>',
		'back-to-creditNotes'	=> '<i class="fa fa-angle-double-left"></i>&emsp;Back <span class="d-none d-sm-inline">to Credit Notes List</span>',
		'back-to-creditNote'	=> '<i class="fa fa-angle-double-left"></i>&emsp;Back <span class="d-none d-sm-inline">to Credit Note</span>',
		'save-creditNote'		=> '<i class="fa fa-save"></i>&emsp;<span>Save Credit Note</span>',
		'update-creditNote'	=> '<i class="fa fa-save"></i>&emsp;<span>Update Credit Note</span>',
	],
];
