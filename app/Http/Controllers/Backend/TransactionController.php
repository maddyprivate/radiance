<?php

namespace App\Http\Controllers\Backend;

use App\Account;
use App\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\AceController\Controller;
use Validator;
use Redirect;

class TransactionController extends Controller
{
    public function __construct(Request $request)
    {
        $request->route()->setParameter('page-heading', 'Transactions');        
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transactions = Transaction::paginate(10);
        return view('backend.transactions.transactions_list', compact('transactions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $accounts = Account::get();
        return view('backend.transactions.create_transaction',compact('accounts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        clock($request->all());

        $rules = array(
            'date'              => 'required',
            'fromAccountId'     => 'required',
            'toAccountId'       => 'required',
            'amount'            => 'required',
            'description'       => 'required',
            'method'          => 'required',
         /*   'ref'               => 'required',
            'person'            => 'required',*/
        );

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {

            toast('Rectify errors and re-submit!','error','top-right')->autoclose(3500);

            return Redirect::to('transactions/create')
                ->withErrors($validator)
                ->withInput($request->input());

        } else {

            $transactionData = $request->all();

            $transaction = Transaction::create($transactionData);
            $transaction->save();
            toast('Transaction Created Successfully!','success','top-right')->autoclose(3500);
            return Redirect::to('transactions/');
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
        $transaction = Transaction::find($id);

        return view('backend.transactions.edit_transaction', compact('transaction'));
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

            return Redirect::to('products/' . $id . '/edit')
                ->withErrors($validator)
                ->withInput($request->input());

        } else {
            
            Account::whereId($id)->update($request->except('_token', '_method'));

            // redirect
            toast('Account Updated Successfully!','success','top-right')->autoclose(3500);
            return Redirect::to('products');
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
