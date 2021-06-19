<?php

namespace App\Http\Controllers\Backend;

use App\Dc;
use App\DcCustomer;
use App\DcProduct;
use App\DcSetting;
use App\ProfileSetting;
use App\Contact;
use App\Product;

use Validator;
use Response;
use Redirect;
use View;
use PDF;

use Illuminate\Http\Request;
use App\Http\Controllers\AceController\Controller;

class DcsController extends Controller
{
	public function __construct(Request $request)
	{
		$request->route()->setParameter('page-heading', 'Dcs');		
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$dcs = Dc::paginate(10);

		return view('backend.dcs.dcs_list', compact('dcs'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$dcSettings = DcSetting::find(1);

		$dc['serialPrefix'] = $dcSettings['serialPrefix'];

		// Finding the dcs with set prefix
		$dcsCreated = Dc::where('serialPrefix', $dcSettings['serialPrefix'])->get();
		// $dcsCreatedCount = Dc::count('serialPrefix', $dcSettings['serialPrefix']);
		$dcsCreatedCount = $dcsCreated->count();

		if($dcsCreatedCount) {

			// Assuming the last user serial is the the one which is set in settings
			$serialNumberLastUsed = $dcSettings['serialNumberStart'];

			// Finding the greatest number under used serials with the prefix from settings
			foreach($dcsCreated as $dcCreated) {
				if($dcCreated['serialNumber'] > $serialNumberLastUsed) {
					$serialNumberLastUsed = $dcCreated['serialNumber'];
				}
			}

			$dc['serialNumber'] = str_pad(intval($serialNumberLastUsed) + 1, strlen($dcSettings['serialNumberStart']), '0', STR_PAD_LEFT);

		} else {

			$dc['serialNumber'] = $dcSettings['serialNumberStart'];

		}

		$profileSettings = ProfileSetting::find(1);

		$dc['placeOfOrigin'] = $profileSettings['placeOfOrigin'];
		$dc['businessName'] = $profileSettings['businessName'];

		$dc = (object) $dc;
		clock($dc);
		return view('backend.dcs.create_dc', compact('dc'));
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

		$attributeNames = array(
			'customer.name' => 'Customer Name',
			'customer.mobile' => 'Customer Mobile',
			'dcProducts.*.description' => 'dc product description',
		 );
		
		$rules = array(
			'placeOfSupply'				=> 'required',
			'customer.name'				=> 'required',
			'customer.mobile'			=> 'required|regex:/\+91[[:space:]]\d{10}/',
			'dcProducts.*.description'	=> 'required',
		);

		$validator = Validator::make($request->all(), $rules);
		$validator->setAttributeNames($attributeNames);

		if ($validator->fails()) {

			return Response::json(array(
				'status' => 0,
				'errors' => $validator->errors()
			), 400);

		} else {
			$dcData = $request->except('customer', 'dcProducts', '_token','customerId');
			$dcCustomerData = $request->input('customer');
			$dcProductsData = $request->input('dcProducts');
			$dc = Dc::updateOrCreate(['serialPrefix' => $request->input('serialPrefix'), 'serialNumber' => $request->input('serialNumber')], $dcData);
			// dd($dcData);
			$dc->save();

			$dcCustomer = DcCustomer::updateOrCreate(['dc_id' => $dc['id']], $dcCustomerData);
			$dc->customer()->save($dcCustomer);

			foreach($dcProductsData as $dcProduct){
				$dcProduct = DcProduct::updateOrCreate(['dc_id' => $dc['id'], 'dcSerial' => $dcProduct['dcSerial']], $dcProduct);
				$dc->product()->save($dcProduct);

				$dcProductIds[] = $dcProduct['dcSerial'];
			}

			$deleteMissingProducts = DcProduct::where('dc_id', $dc['id'])
						->whereNotIn('dcSerial', $dcProductIds)
						->delete();
			$customer = Contact::find($dcCustomerData['customerId']);
			$balance = $customer->outstandingBalance+$request->input('grandValue');
			$customer->outstandingBalance = $balance;
			$customer->save();
			return Response::json(array('status' => 1), 200);
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
		$dc = Dc::with('customer', 'product')->find($id);
		$profileSettings = ProfileSetting::find(1);
		$dc['profile'] = $profileSettings;

		$dcSettings = DcSetting::find(1);
		$dc['dc'] = $dcSettings;

		$dc = (object) $dc;

		clock($dc);

		return view('backend.dcs.view_dc', compact('dc'));
	}
	
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$dc = Dc::with('customer', 'product')->find($id);

		$profileSettings = ProfileSetting::find(1);
		$dc['profile'] = $profileSettings;

		$dcSettings = DcSetting::find(1);
		$dc['dc'] = $dcSettings;

		$dc = (object) $dc;

		clock($dc);

		return view('backend.dcs.edit_dc', compact('dc'));
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
		$attributeNames = array(
			'customer.name' => 'Customer Name',
			'customer.mobile' => 'Customer Mobile',
			'dcProducts.*.description' => 'dc product description',
		 );
		
		$rules = array(
			'placeOfSupply'				=> 'required',
			'customer.name'				=> 'required',
			'customer.mobile'			=> 'required|regex:/\+91[[:space:]]\d{10}/',
			'dcProducts.*.description'	=> 'required',
		);

		$validator = Validator::make($request->all(), $rules);
		$validator->setAttributeNames($attributeNames);

		if ($validator->fails()) {

			return Response::json(array(
				'status' => 0,
				'errors' => $validator->errors()
			), 400);

		} else {

			$dcData = $request->except('customer', 'dcProducts', '_token', '_method','customerId');
			$dcCustomerData = $request->input('customer');
			$dcProductsData = $request->input('dcProducts');

			$dc = Dc::with('customer')->find($id);
			$prevBalance = $dc->grandValue;
			Dc::whereId($id)->update($dcData);

			$dc->customer->update($dcCustomerData);

			foreach($dcProductsData as $dcProduct){
				$dc->product()->where('dcSerial', $dcProduct['dcSerial'])->updateOrCreate(['dc_id' => $dc['id'], 'dcSerial' => $dcProduct['dcSerial']], $dcProduct);

				$dcProductIds[] = $dcProduct['dcSerial'];
			}

			$deleteMissingProducts = DcProduct::where('dc_id', $dc['id'])
						->whereNotIn('dcSerial', $dcProductIds)
						->delete();
						
			$customer = Contact::find($dcCustomerData['customerId']);
			$balance = $customer->outstandingBalance+$request->input('grandValue')-$prevBalance;
			$customer->outstandingBalance = $balance;
			$customer->save();
			return Response::json(array('status' => 1), 200);
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

	public function selectCustomer($customerName)
	{
		clock($customerName);
		$customer = Contact::where('name', 'like', '%'.$customerName.'%')->get();
		$return = array(
			'data' => $customer
		);
		clock($return);
		echo json_encode($return);
	}


	public function selectProduct($description)
	{
		clock('searching');
		clock($description);

		$product = Product::where('description', 'like', '%'.$description.'%')->get();
		$return = array(
			'data' => $product
		);
		
		clock($return);
		echo json_encode($return);
	}

	public function printdc($id, $copy)
	{
		$dc = Dc::with('customer', 'product')->find($id);

		$profileSettings = ProfileSetting::find(1);
		$dc['profile'] = $profileSettings;

		$dcSettings = DcSetting::find(1);
		$dc['dc'] = $dcSettings;

		$dc['copy'] = $copy;

		$dc = (object) $dc;	
			$pdf = PDF::loadView('backend.dcs.DC', $dc);
			return $pdf->stream($dc['serialPrefix'].$dc['serialNumber'].'_'.ucfirst($copy).'.pdf');

	}
	public function changeDcStatus(Request $request)
	{
		// dd($request->all());
		$dc = Dc::find($request->id);
		// dd($dc);
		$dc->dcStatus = $request->dcStatus;
		$dc->save();
		toast('Status changed Successfully!','success','top-right')->autoclose(3500);
		return Redirect::to('dcs');
	}

}
