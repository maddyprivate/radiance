<?php

namespace App\Http\Controllers\Backend;

use App\Account;
use Illuminate\Http\Request;
use App\Http\Controllers\AceController\Controller;
use Validator;
use Redirect;

class BalanceSheetController extends Controller
{
    public function __construct(Request $request)
    {
        $request->route()->setParameter('page-heading', 'Balance Sheet');        
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $balancesheet = Account::get();
        return view('backend.balancesheet.balancesheet_list', compact('balancesheet'));
    }
}
