<?php

namespace App\Http\Controllers\Backend;

use App\Transaction;
use App\Account;
use App\Transfer;
use Illuminate\Http\Request;
use App\Http\Controllers\AceController\Controller;
use Validator;
use Redirect;

class TransferController extends Controller
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
        $transfers = Transfer::paginate(10);
        return view('backend.transfers.transfers_list', compact('transfers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $accounts = Account::get();
        return view('backend.transfers.create_transfer',compact('accounts'));
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
            'toAccount'       => 'required',
            'amount'            => 'required',
            'description'       => 'required',
            'method'          => 'required',
         /*   'ref'               => 'required',
            'person'            => 'required',*/
        );

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {

            toast('Rectify errors and re-submit!','error','top-right')->autoclose(3500);

            return Redirect::to('transfers/create')
                ->withErrors($validator)
                ->withInput($request->input());

        } else {

            $transferData = $request->all();

            $transfer = Transfer::create($transferData);
            $transfer->save();

            $fromaccount = Account::find($request->fromAccountId);
            $fromaccount->balance = $fromaccount->balance-$request->amount;
            $fromaccount->save();

            // $toaccount = Account::find($request->toAccountId);
            // $toaccount->balance = $toaccount->balance+$request->amount;
            // $toaccount->save();

            $transactionData['payerid'] = $request->fromAccountId;
            // $transactionData['payeeid'] = $request->toAccountId;
            $transactionData['toAccount'] = $request->toAccount;
            $transactionData['type'] = 'Transfer';
            $transactionData['amount'] = $request->amount;
            $transactionData['description'] = $request->description;
            $transactionData['date'] = $request->date;

            $transactionData['account'] = $transfer->fromaccounts->accountName;
            $transactionData['dr'] = $request->amount;
            $transactionData['cr'] = 0;
            $transactionData['bal'] = $fromaccount->balance;
            $transfer1 = Transaction::create($transactionData);
            
            $transactionData['account'] = $transfer->toAccount;
            $transactionData['cr'] = $request->amount;
            $transactionData['dr'] = 0;
            $transactionData['bal'] = $request->amount; 

            $transfer2 = Transaction::create($transactionData);

            toast('Transfer Created Successfully!','success','top-right')->autoclose(3500);
            return Redirect::to('transfers/');
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
        $transfer = Transfer::find($id);

        return view('backend.transfers.edit_transfer', compact('transfer'));
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
