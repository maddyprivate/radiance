<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Laryl Blade EN lines
	|--------------------------------------------------------------------------
	*/

	'create-new'	=> 'New Transfer',

	'heading' => [
		'list'		=> 'Transfers Master List',
		'new'		=> 'New Transfer',
		'show'	    => 'Transfer :transfer',
		'edit'   	=> 'Editing Transfer <span class="d-none d-sm-inline">:transfer</span>',
	],

	'table' => [
		'#'					=> '#',
		'transferSerial'	=> 'Transfer Serial',
		'date'				=> 'Date',
		'dueDate'			=> 'Transfer Due Date',
		'amount'			=> 'Amount',
		'description'		=> 'Description',
		'chequeNo'			=> 'Cheque No',
		'ref'				=> 'Reference',
		'fromAccountId'		=> 'From Account',
		'toAccountId'		=> 'To Account',
		'person'			=> 'Person',
		'transferStatus'		=> 'Transfer Status',
		'options'			=> 'Options',
		'method'			=> 'Method',
	],

	'form' => [
		'label' => [
			'transferSerial'		=> 'Transfer Serial',
			'date'				=> 'Transfer Date',
			'dueDate'			=> 'Transfer Due Date',
			'amount'			=> 'Amount',
			'description'		=> 'Description',
			'chequeNo'			=> 'Cheque No',
			'ref'				=> 'Reference',
			'fromAccountId'		=> 'From Account',
			'toAccountId'		=> 'To Account',
			'person'			=> 'Person',
			'method'			=> 'Method',
		]
	],

	'buttons' => [
		'create-new'    	=> '<span class="hidden-xs hidden-sm">New Transfer</span>',
		'back-to-transfers'	=> '<i class="fa fa-angle-double-left"></i>&emsp;Back <span class="d-none d-sm-inline">to Transfers List</span>',
		'back-to-transfer'	=> '<i class="fa fa-angle-double-left"></i>&emsp;Back <span class="d-none d-sm-inline">to Transfer</span>',
		'save-transfer'		=> '<i class="fa fa-save"></i>&emsp;<span>Save Transfer</span>',
		'update-transfer'	=> '<i class="fa fa-save"></i>&emsp;<span>Update Transfer</span>',
	],
];
