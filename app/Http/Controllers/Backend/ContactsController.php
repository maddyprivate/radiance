<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\AceController\Controller;

use App\Transaction;
use App\Account;
use App\Contact;

use Rule;
use Validator;
use Redirect;

class ContactsController extends Controller
{
	public function __construct(Request $request)
	{
		$request->route()->setParameter('page-heading', 'Contacts');
	}
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$contacts = Contact::paginate(10);
		$accounts = Account::get();
		return view('backend.contacts.contacts_list', compact('contacts','accounts'));
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function customer()
	{
		request()->route()->setParameter('page-heading', 'Customers');
		$contacts = Contact::where('type','customer')->paginate(10);
		$accounts = Account::get();
		return view('backend.contacts.contacts_list', compact('contacts','accounts'));
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function dealer()
	{
		request()->route()->setParameter('page-heading', 'Dealers');
		$contacts = Contact::where('type','dealer')->paginate(10);
		$accounts = Account::get();
		return view('backend.contacts.contacts_list', compact('contacts','accounts'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view('backend.contacts.create_contact');
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
			'name'		=> 'required|string|max:255',
			'gstin'     => 'required',
			'country'   => 'required',
			'state'		=> 'required',
			'person'	=> 'required',
			'mobile'    => 'required|unique:contacts',
			'pan'      	=> 'nullable',
			'address'   => 'required',
			'pincode'   => 'required',
			'city'      => 'required',
			// 'email'		=> 'required|string|email|max:255|unique:contacts',
		);

		$validator = Validator::make($request->all(), $rules);

		if ($validator->fails()) {

			// Redirecting
			toast('Rectify errors and re-submit!','error','top-right')->autoclose(3500);
			return back()
				->withErrors($validator)
				->withInput($request->input());

		} else {

			// Calculating PAN from GSTIN
			$pan = substr($request->gstin, 2, 10);
			$request->request->add(['pan' => $pan]);

			$contact = Contact::create($request->all());
			$contact->save();

			// Redirecting
			toast('Contact Created Successfully!','success','top-right')->autoclose(3500);
			return Redirect::to('contacts');
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
		$contact = Contact::find($id);
        return view('backend.contacts.view_contact', compact('contact'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$contact = Contact::find($id);
        return view('backend.contacts.edit_contact', compact('contact'));
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
			'name'		=> 'required|string|max:255',
			'gstin'     => 'required|regex:/\d{2}[a-zA-Z]{5}\d{4}[a-zA-Z]{1}[0-9]{1}[zZ][0-9]{1}/',
			'country'   => 'required',
			'state'		=> 'required',
			'person'	=> 'required',
			'mobile'    => 'required|unique:contacts,mobile,'.$id,
			'pan'      	=> 'nullable',
			'address'   => 'required',
			'pincode'   => 'required',
			'city'      => 'required',
			'email'		=> 'required|string|email|max:255|unique:contacts,email,'.$id,
		);

		$validator = Validator::make($request->all(), $rules);

		if ($validator->fails()) {
			
			// Redirecting
			toast('Rectify errors and re-submit!','error','top-right')->autoclose(3500);
			return Redirect::to('contacts/' . $id . '/edit')
				->withErrors($validator)
				->withInput($request->input());

		} else {

			Contact::whereId($id)->update($request->except('_token', '_method'));
			// Redirecting
			toast('Contact Updated Successfully!','success','top-right')->autoclose(3500);
			return Redirect::to('contacts');
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
		return redirect()->route('Contacts.contacts.show', $id);
	}
	public function payOutstandingBalance(Request $request)
	{
		$contact = Contact::find($request->id);
		$balance = $contact->outstandingBalance - $request->outstandingPayment;
		
		$contact->outstandingBalance = $balance;
		$contact->save();

		$accounts = Account::find($request->account_id);
		if($contact->type=='dealer')
			$accounts->balance = $accounts->balance-$request->outstandingPayment;
		else
			$accounts->balance = $accounts->balance+$request->outstandingPayment;
		
		$accounts->save();

		$transaction['payerid'] = $request->id;
		$transaction['payeeid'] = $request->account_id;
		$transaction['account'] = $accounts->accountName;
		$transaction['type'] 	= 'Payment';
		$transaction['amount'] = $request->outstandingPayment;
		$transaction['description'] = $request->description;
		$transaction['date'] = date('Y-m-d');
		$transaction['cr'] = $request->outstandingPayment;
		$transaction['bal'] = $accounts->balance;

		$transfer = Transaction::create($transaction);

		toast('Payment done Successfully!','success','top-right')->autoclose(3500);
		return Redirect::to('contacts');
	}
}
