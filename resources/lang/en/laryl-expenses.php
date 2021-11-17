<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Laryl Blade EN lines
	|--------------------------------------------------------------------------
	*/

	'create-new'	=> 'New Expense',

	'heading' => [
		'list'		=> 'Expenses Master List',
		'new'		=> 'New Expense',
		'show'	    => 'Expense :expense',
		'edit'   	=> 'Editing Expense <span class="d-none d-sm-inline">:expense</span>',
	],

	'table' => [
		'#'					=> '#',
		'expenseSerial'		=> 'Expense Serial',
		'date'				=> 'Expense Date',
		'dueDate'			=> 'Expense Due Date',
		'amount'			=> 'Amount',
		'description'		=> 'Description',
		'chequeNo'			=> 'Cheque No',
		'ref'				=> 'Reference',
		'account_id'		=> 'Account',
		'person'			=> 'Person',
		'expenseStatus'		=> 'Expense Status',
		'options'			=> 'Options',
	],

	'form' => [
		'label' => [
			'expenseSerial'		=> 'Expense Serial',
			'date'				=> 'Expense Date',
			'dueDate'			=> 'Expense Due Date',
			'amount'			=> 'Amount',
			'description'		=> 'Description',
			'chequeNo'			=> 'Cheque No',
			'ref'				=> 'Reference',
			'account_id'		=> 'Account',
			'person'			=> 'Person',
			'expenseStatus'		=> 'Expense Status',
		]
	],

	'buttons' => [
		'create-new'    	=> '<span class="hidden-xs hidden-sm">New Expense</span>',
		'back-to-expenses'	=> '<i class="fa fa-angle-double-left"></i>&emsp;Back <span class="d-none d-sm-inline">to Expenses List</span>',
		'back-to-expense'	=> '<i class="fa fa-angle-double-left"></i>&emsp;Back <span class="d-none d-sm-inline">to Expense</span>',
		'save-expense'		=> '<i class="fa fa-save"></i>&emsp;<span>Save Expense</span>',
		'update-expense'	=> '<i class="fa fa-save"></i>&emsp;<span>Update Expense</span>',
	],
];
