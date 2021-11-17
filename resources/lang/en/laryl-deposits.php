<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Laryl Blade EN lines
	|--------------------------------------------------------------------------
	*/

	'create-new'	=> 'New Deposit',

	'heading' => [
		'list'		=> 'Deposits Master List',
		'new'		=> 'New Deposit',
		'show'	    => 'Deposit :deposit',
		'edit'   	=> 'Editing Deposit <span class="d-none d-sm-inline">:deposit</span>',
	],

	'table' => [
		'#'					=> '#',
		'depositSerial'		=> 'Deposit Serial',
		'date'				=> 'Deposit Date',
		'dueDate'			=> 'Deposit Due Date',
		'amount'			=> 'Amount',
		'description'		=> 'Description',
		'chequeNo'			=> 'Cheque No',
		'ref'				=> 'Reference',
		'account_id'		=> 'Account',
		'person'			=> 'Person',
		'depositStatus'		=> 'Deposit Status',
		'options'			=> 'Options',
	],

	'form' => [
		'label' => [
			'depositSerial'		=> 'Deposit Serial',
			'date'				=> 'Deposit Date',
			'dueDate'			=> 'Deposit Due Date',
			'amount'			=> 'Amount',
			'description'		=> 'Description',
			'chequeNo'			=> 'Cheque No',
			'ref'				=> 'Reference',
			'account_id'		=> 'Account',
			'person'			=> 'Person',
			'depositStatus'		=> 'Deposit Status',
		]
	],

	'buttons' => [
		'create-new'    	=> '<span class="hidden-xs hidden-sm">New Deposit</span>',
		'back-to-deposits'	=> '<i class="fa fa-angle-double-left"></i>&emsp;Back <span class="d-none d-sm-inline">to Deposits List</span>',
		'back-to-deposit'	=> '<i class="fa fa-angle-double-left"></i>&emsp;Back <span class="d-none d-sm-inline">to Deposit</span>',
		'save-deposit'		=> '<i class="fa fa-save"></i>&emsp;<span>Save Deposit</span>',
		'update-deposit'	=> '<i class="fa fa-save"></i>&emsp;<span>Update Deposit</span>',
	],
];
