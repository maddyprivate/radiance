<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Laryl Blade EN lines
	|--------------------------------------------------------------------------
	*/

	'create-new'	=> 'New Transaction',

	'heading' => [
		'list'		=> 'Transactions Master List',
		'new'		=> 'New Transaction',
		'show'	    => 'Transaction :transaction',
		'edit'   	=> 'Editing Transaction <span class="d-none d-sm-inline">:transaction</span>',
	],

	'table' => [
		'#'					=> '#',
		'transactionSerial'	=> 'Transaction Serial',
		'date'				=> 'Date',
		'dueDate'			=> 'Transaction Due Date',
		'amount'			=> 'Amount',
		'description'		=> 'Description',
		'cr'				=> 'Cr.',
		'ref'				=> 'Reference',
		'account'			=> 'Account',
		'dr'				=> 'Dr.',
		'person'			=> 'Person',
		'type'				=> 'Type',
		'options'			=> 'Options',
		'balance'			=> 'Balance',
	],

	'form' => [
		'label' => [
			'transactionSerial'		=> 'Transaction Serial',
			'date'				=> 'Transaction Date',
			'dueDate'			=> 'Transaction Due Date',
			'amount'			=> 'Amount',
			'description'		=> 'Description',
			'cr'				=> 'Cr.',
			'ref'				=> 'Reference',
			'fromAccountId'		=> 'From Account',
			'toAccountId'		=> 'To Account',
			'person'			=> 'Person',
			'method'			=> 'Method',
		]
	],

	'buttons' => [
		'create-new'    	=> '<span class="hidden-xs hidden-sm">New Transaction</span>',
		'back-to-transactions'	=> '<i class="fa fa-angle-double-left"></i>&emsp;Back <span class="d-none d-sm-inline">to Transactions List</span>',
		'back-to-transaction'	=> '<i class="fa fa-angle-double-left"></i>&emsp;Back <span class="d-none d-sm-inline">to Transaction</span>',
		'save-transaction'		=> '<i class="fa fa-save"></i>&emsp;<span>Save Transaction</span>',
		'update-transaction'	=> '<i class="fa fa-save"></i>&emsp;<span>Update Transaction</span>',
	],
];
