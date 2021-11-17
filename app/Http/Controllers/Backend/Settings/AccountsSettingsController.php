<?php

namespace App\Http\Controllers\Backend\Settings;

use App\Transaction;
use App\Account;
use Illuminate\Http\Request;
use App\Http\Controllers\AceController\Controller;
use Validator;
use Redirect;

class AccountsSettingsController extends Controller
{
    public function __construct(Request $request)
    {
        $request->route()->setParameter('page-heading', 'Settings');        
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $accounts = Account::get();
        return view('backend.settings.account.account_list', compact('accounts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.settings.account.create_account');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = array(
            'accountName'       => 'required|string|max:255',
            /*'bankName'          => 'required|string|max:255',
            'accountNo'         => 'required|string|max:255',
            'balance'           => 'required',
            'ifscCode'          => 'required',
            'address'           => 'required|string|max:500',
            'branch'            => 'required|string|max:255',
            'description'       => 'required|string|max:255',   */         
        );

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            toast('Rectify errors and re-submit!','error','top-right')->autoclose(3500);
            return Redirect::to('settings/account/create')
                ->withErrors($validator)
                ->withInput($request->input());
        } else {
            $account = Account::create($request->all());
            $account->save();
            $transferData['account'] = $request->accountName;
            $transferData['type'] = 'Income';
            $transferData['amount'] = $request->balance;
            $transferData['description'] = 'Initial Balance';
            $transferData['date'] = date('Y-m-d');
            $transferData['cr'] = $request->balance;
            $transferData['bal'] = $request->balance;
            $transferData['updated_by'] = auth()->user()->name;;
            $transfer = Transaction::create($transferData);
            toast('Account Created Successfully!','success','top-right')->autoclose(3500);
            return Redirect::to('settings/account/');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $account = Account::find($id);
        return view('backend.settings.account.edit_account', compact('account'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = array(
            'description'       => 'required|string|max:255',
            'type'              => 'required|in:goods, service',
            'hsn'               => 'required|regex:/\d{8}/',
            'sku'               => 'required|alpha_dash',
            'taxRate'           => 'required',
            'cessValue'         => 'required',
            'saleValue'         => 'required',
            'unit'              => 'required',
            'discountRate'      => 'required',
        );

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            toast('Rectify errors and re-submit!','error','top-right')->autoclose(3500);
            return Redirect::to('accounts/' . $id . '/edit')
                ->withErrors($validator)
                ->withInput($request->input());
        } else {
            Product::whereId($id)->update($request->except('_token', '_method'));
            toast('Product Updated Successfully!','success','top-right')->autoclose(3500);
            return Redirect::to('accounts');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
