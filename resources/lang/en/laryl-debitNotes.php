<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Laryl Blade EN lines
	|--------------------------------------------------------------------------
	*/

	'create-new'	=> 'New Debit Note',

	'heading' => [
		'list'		=> 'Debit Notes Master List',
		'new'		=> 'New Debit Note',
		'show'	    => 'Debit Note :debitNote',
		'edit'   	=> 'Editing Debit Note <span class="d-none d-sm-inline">:debitNote</span>',
	],

	'table' => [
		'#'					=> 'Sr.No.',
		'issueDate'			=> 'Debit Note Date',
		'dueDate'			=> 'Due Date',
		'debitNoteStatus'		=> 'Debit Note Status',
		'grandValue'		=> 'Grand Total',
		'dealer'			=> 'Dealer',
		'options'			=> 'Options',
		'pendingBalance'	=> 'Pending Balance',
		'debitNoteNo'			=> 'Debit Note No.',
	],

	'form' => [
		'label' => [
			'otherCharges'		=> 'Other Charges',
			'vehicleNo'			=> 'Vehicle No.',
			'debitNoteSerial'		=> 'Debit Note Serial',
			'issueDate'			=> 'Debit Note Date',
			'dueDate'			=> 'Debit Note Due Date',
			'dealerName'		=> 'Dealer Name',
			'dealerGstin'		=> 'Dealer GSTIN',
			'dealerMobile'	=> 'Dealer Mobile',
			'billingAddress'	=> 'Billing Address',
			'shippingAddress'	=> 'Shipping Address',
			'placeOfSupply'		=> 'Place of Supply',
			'discountRate'		=> 'Discount (%)',
			'debitNoteStatus'		=> 'Debit Note Status',
		]
	],

	'buttons' => [
		'create-new'    	=> '<span class="hidden-xs hidden-sm">New Debit Note</span>',
		'back-to-debitNotes'	=> '<i class="fa fa-angle-double-left"></i>&emsp;Back <span class="d-none d-sm-inline">to Debit Notes List</span>',
		'back-to-debitNote'	=> '<i class="fa fa-angle-double-left"></i>&emsp;Back <span class="d-none d-sm-inline">to Debit Note</span>',
		'save-debitNote'		=> '<i class="fa fa-save"></i>&emsp;<span>Save Debit Note</span>',
		'update-debitNote'	=> '<i class="fa fa-save"></i>&emsp;<span>Update Debit Note</span>',
	],
];
