<?php

use App\Contact;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


/************************* Initialization Routes *****/
Route::get('/install', [
    'as'        => 'InitInstall',
    'uses'      =>  'InitController@index'
]);
Route::post('/install/execute', [
    'as'        => 'InitExecute',
    'uses'      =>  'InitController@execute'
]);

/************************* Home Frontend *****/
Route::get('/', [
    'as'        => 'Home',
    'uses'      =>  'Frontend\PagesController@index'
]);
Route::get('/about', [
    'as'        => 'About',
    'uses'      =>  'Frontend\PagesController@about'
]);

/************************* Authentication *****/
Auth::routes();

/************************* Backend *****/
Route::get('/dashboard', [
    'as'    => 'Dashboard',
    'uses'  => 'Backend\DashboardController@index',
    'page-heading'  => 'DB Dashboard'
]);

Route::resource('users', 'Backend\UsersController', [
    'as'            => 'Users',
])->middleware('AuthAdmin');

Route::resource('contacts', 'Backend\ContactsController', [
    'as'            => 'Contacts',
    'page-heading'  =>  'CM',
])->middleware('AuthUser');

Route::get('/customers', 'Backend\ContactsController@customer', [
    'as'            => 'customers',
    'page-heading'  => 'Costomers List'
])->middleware('AuthUser');

Route::get('/dealers', 'Backend\ContactsController@dealer', [
    'as'            => 'Dealers',
    'page-heading'  => 'Dealers List'
])->middleware('AuthUser');

Route::post('/products/uploadexcel', 'Backend\ProductsController@uploadexcel', [
	'as'            => 'ProductsUpload',
])->middleware('AuthUser');

Route::get('/products/downloadexcel', 'Backend\ProductsController@downloadexcel', [
	'as'            => 'ProductsDownload',
])->middleware('AuthUser');

Route::resource('products', 'Backend\ProductsController', [
    'as'            => 'Products',
])->middleware('AuthUser');

Route::get('/invoices/select_customer/{customerName}', 'Backend\InvoicesController@selectCustomer', [
    'as'            => 'SelectCustomer',
])->middleware('AuthUser');
Route::get('/invoices/select_product/{description}', 'Backend\InvoicesController@selectProduct', [
    'as'            => 'SelectProduct',
])->middleware('AuthUser');

Route::get('/invoices/print/{id}/{copy}', [
    'as'    => 'PrintInvoice',
    'uses'  => 'Backend\InvoicesController@printinvoice',
])->middleware('AuthUser');

Route::get('/view-all-invoices', [
    'as'    => 'ViewAllInvoices',
    'uses'  => 'Backend\InvoicesController@viewAllInvoices',
])->middleware('AuthUser');

Route::any('/payInvoiceBalance', [
    'as'    => 'payInvoiceBalance',
    'uses'  => 'Backend\InvoicesController@payInvoiceBalance',
])->middleware('AuthUser');

Route::get('/view-all-purchases', [
    'as'    => 'ViewAllPurchases',
    'uses'  => 'Backend\PurchasesController@ViewAllPurchases',
])->middleware('AuthUser');

Route::resource('invoices', 'Backend\InvoicesController', [
    'as'            => 'Invoices',
])->middleware('AuthUser');

Route::resource('debitNotes', 'Backend\DebitNotesController', [
    'as'            => 'DebitNotes',
])->middleware('AuthUser');

Route::get('/debitNotes/select_dealer/{dealerName}', 'Backend\DebitNotesController@selectDealer', [
    'as'            => 'SelectDealer',
])->middleware('AuthUser');


Route::get('/debitNotes/select_product/{description}', 'Backend\DebitNotesController@selectProduct', [
    'as'            => 'SelectProduct',
])->middleware('AuthUser');

Route::get('/debitNotes/print/{id}/{copy}', [
    'as'    => 'PrintDebitNote',
    'uses'  => 'Backend\DebitNotesController@printDebitNote',
])->middleware('AuthUser');


Route::resource('creditNotes', 'Backend\CreditNotesController', [
    'as'            => 'CreditNotes',
])->middleware('AuthUser');

Route::get('/creditNotes/select_customer/{customerName}', 'Backend\CreditNotesController@selectCustomer', [
    'as'            => 'SelectCustomer',
])->middleware('AuthUser');


Route::get('/creditNotes/select_product/{description}', 'Backend\CreditNotesController@selectProduct', [
    'as'            => 'SelectProduct',
])->middleware('AuthUser');

Route::get('/creditNotes/print/{id}/{copy}', [
    'as'    => 'PrintCreditNote',
    'uses'  => 'Backend\CreditNotesController@printCreditNote',
])->middleware('AuthUser');

Route::get('/purchases/select_dealer/{dealerName}', 'Backend\PurchasesController@selectDealer', [
    'as'            => 'SelectDealer',
])->middleware('AuthUser');

Route::get('/purchases/select_product/{description}', 'Backend\PurchasesController@selectProduct', [
    'as'            => 'SelectProduct',
])->middleware('AuthUser');

Route::get('/purchases/print/{id}/{copy}', [
    'as'    => 'PrintPurchase',
    'uses'  => 'Backend\PurchasesController@printpurchase',
])->middleware('AuthUser');

Route::resource('purchases', 'Backend\PurchasesController', [
    'as'            => 'Purchases',
])->middleware('AuthUser');

Route::get('/dcs/select_customer/{customerName}', 'Backend\DcsController@selectCustomer', [
    'as'            => 'SelectCustomer',
])->middleware('AuthUser');
Route::get('/dcs/select_product/{description}', 'Backend\InvoicesController@selectProduct', [
    'as'            => 'SelectProduct',
])->middleware('AuthUser');

Route::get('/dcs/print/{id}/{copy}', [
    'as'    => 'PrintDc',
    'uses'  => 'Backend\DcsController@printdc',
])->middleware('AuthUser');

Route::resource('dcs', 'Backend\DcsController', [
    'as'            => 'Dcs',
])->middleware('AuthUser');

Route::post('/payOutstandingBalance', [
    'as'    => 'PayOutstandingBalance',
    'uses'  => 'Backend\ContactsController@payOutstandingBalance',
])->middleware('AuthUser');

Route::post('/changeInvoiceStatus', [
    'as'    => 'ChangeInvoiceStatus',
    'uses'  => 'Backend\InvoicesController@changeInvoiceStatus',
])->middleware('AuthUser');


Route::post('/changePurchaseStatus', [
    'as'    => 'ChangePurchaseStatus',
    'uses'  => 'Backend\PurchasesController@changePurchaseStatus',
])->middleware('AuthUser');


Route::resource('expenses', 'Backend\ExpensesController', [
    'as'            => 'Expenses',
])->middleware('AuthUser');

Route::resource('deposits', 'Backend\DepositsController', [
    'as'            => 'Deposits',
])->middleware('AuthUser');

Route::resource('transfers', 'Backend\TransferController', [
'as'            => 'Transfers',
])->middleware('AuthUser');

Route::resource('transactions', 'Backend\TransactionController', [
'as'            => 'Transactions',
])->middleware('AuthUser');

Route::resource('balancesheet', 'Backend\BalanceSheetController', [
'as'            => 'BalanceSheet',
])->middleware('AuthUser');

/************************* Setting Group *****/
Route::group(['prefix' => 'settings', 'namespace' => 'Backend\Settings'], function()
{
    Route::resource('profile', 'ProfileSettingsController', [
        'as'            => 'Settings',
    ])->middleware('AuthAdmin');

    Route::resource('invoice', 'InvoiceSettingsController', [
        'as'            => 'Settings',
    ])->middleware('AuthAdmin');

    Route::resource('account', 'AccountsSettingsController', [
        'as'            => 'Settings',
    ])->middleware('AuthAdmin');
    
});

