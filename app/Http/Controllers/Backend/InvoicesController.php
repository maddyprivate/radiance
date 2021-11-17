<?php

namespace App\Http\Controllers\Backend;

use App\Account;
use App\Invoice;
use App\InvoicePayment;
use App\InvoiceCustomer;
use App\InvoiceProduct;
use App\InvoiceSetting;
use App\ProfileSetting;
use App\Contact;
use App\Product;
use App\Transaction;

use Validator;
use Response;
use Redirect;
use View;
use PDF;

use Illuminate\Http\Request;
use App\Http\Controllers\AceController\Controller;

class InvoicesController extends Controller
{
	public function __construct(Request $request)
	{
		$request->route()->setParameter('page-heading', 'Invoices');		
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$invoices = Invoice::orderBy('id','desc')->paginate(10);
		$accounts = Account::get();
		return view('backend.invoices.invoices_list', compact('invoices','accounts'));
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function viewAllInvoices()
	{
		$invoices = Invoice::get();
		$accounts = Account::get();
		return view('backend.invoices.all_invoices_list', compact('invoices','accounts'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$invoiceSettings = InvoiceSetting::find(1);

		$invoice['serialPrefix'] = $invoiceSettings['serialPrefix'];

		// Finding the invoices with set prefix
		$invoicesCreated = Invoice::where('serialPrefix', $invoiceSettings['serialPrefix'])->get();
		// $invoicesCreatedCount = Invoice::count('serialPrefix', $invoiceSettings['serialPrefix']);
		$invoicesCreatedCount = $invoicesCreated->count();

		if($invoicesCreatedCount) {

			// Assuming the last user serial is the the one which is set in settings
			$serialNumberLastUsed = $invoiceSettings['serialNumberStart'];

			// Finding the greatest number under used serials with the prefix from settings
			foreach($invoicesCreated as $invoiceCreated) {
				if($invoiceCreated['serialNumber'] > $serialNumberLastUsed) {
					$serialNumberLastUsed = $invoiceCreated['serialNumber'];
				}
			}

			$invoice['serialNumber'] = str_pad(intval($serialNumberLastUsed) + 1, strlen($invoiceSettings['serialNumberStart']), '0', STR_PAD_LEFT);

		} else {

			$invoice['serialNumber'] = $invoiceSettings['serialNumberStart'];

		}

		$profileSettings = ProfileSetting::find(1);

		$invoice['placeOfOrigin'] = $profileSettings['placeOfOrigin'];
		$invoice['businessName'] = $profileSettings['businessName'];

		$invoice = (object) $invoice;
		clock($invoice);
		return view('backend.invoices.create_invoice', compact('invoice'));
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
			'invoiceProducts.*.description' => 'invoice product description',
		 );
		
		$rules = array(
			'placeOfSupply'				=> 'required',
			'customer.name'				=> 'required',
			'customer.mobile'			=> 'required|regex:/\+91[[:space:]]\d{10}/',
			'invoiceProducts.*.description'	=> 'required',
		);

		$validator = Validator::make($request->all(), $rules);
		$validator->setAttributeNames($attributeNames);

		if ($validator->fails()) {

			return Response::json(array(
				'status' => 0,
				'errors' => $validator->errors()
			), 400);

		} else {
			$invoiceData = $request->except('customer', 'invoiceProducts', '_token','customerId');
			$invoiceData['pendingBalance'] = $invoiceData['grandValue'];
			// dd($invoiceData);
			$invoiceCustomerData = $request->input('customer');
			$invoiceProductsData = $request->input('invoiceProducts');

			$invoice = Invoice::updateOrCreate(['serialPrefix' => $request->input('serialPrefix'), 'serialNumber' => $request->input('serialNumber')], $invoiceData);
			$invoice->save();

			$invoiceCustomer = InvoiceCustomer::updateOrCreate(['invoice_id' => $invoice['id']], $invoiceCustomerData);
			$invoice->customer()->save($invoiceCustomer);

			foreach($invoiceProductsData as $invoiceProduct){
				$invoiceProduct = InvoiceProduct::updateOrCreate(['invoice_id' => $invoice['id'], 'invoiceSerial' => $invoiceProduct['invoiceSerial']], $invoiceProduct);
				$invoice->product()->save($invoiceProduct);

				$invoiceProductIds[] = $invoiceProduct['invoiceSerial'];
			}

			$deleteMissingProducts = InvoiceProduct::where('invoice_id', $invoice['id'])
						->whereNotIn('invoiceSerial', $invoiceProductIds)
						->delete();
			$customer = Contact::find($invoiceCustomerData['customerId']);
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
		$invoice = Invoice::with('customer', 'product')->find($id);

		$amountInWords = $this->amountToWords($invoice['grandValue']);
		$invoice['amountInWords'] = $amountInWords;

		$profileSettings = ProfileSetting::find(1);
		$invoice['profile'] = $profileSettings;

		$invoiceSettings = InvoiceSetting::find(1);
		$invoice['invoice'] = $invoiceSettings;

		$invoice = (object) $invoice;

		clock($invoice);

		return view('backend.invoices.view_invoice', compact('invoice'));
	}

	public function amountToWords(float $amount){
		$amount_after_decimal = round($amount - ($num = floor($amount)), 2) * 100;
		$amt_hundred = null;
		$count_length = strlen($num);
		$x = 0;
		$string = array();
		$change_words = array(0 => '', 1 => 'One', 2 => 'Two',
			3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
			7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
			10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
			13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
			16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
			19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
			40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
			70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety');
		$here_digits = array('', 'Hundred','Thousand','Lakh', 'Crore');
		while( $x < $count_length ) {
			$get_divider = ($x == 2) ? 10 : 100;
			$amount = floor($num % $get_divider);
			$num = floor($num / $get_divider);
			$x += $get_divider == 10 ? 1 : 2;
			if ($amount) {
				$add_plural = (($counter = count($string)) && $amount > 9) ? 's' : null;
				$amt_hundred = ($counter == 1 && $string[0]) ? ' and ' : null;
				$string [] = ($amount < 21) ? $change_words[$amount].' '. $here_digits[$counter]. $add_plural.' 
				'.$amt_hundred:$change_words[floor($amount / 10) * 10].' '.$change_words[$amount % 10]. ' 
				'.$here_digits[$counter].$add_plural.' '.$amt_hundred;
			}
			else $string[] = null;
		}
		$implode_to_Rupees = implode('', array_reverse($string));
		$get_paise = ($amount_after_decimal > 0) ? "And " . ($change_words[$amount_after_decimal / 10] . " 
			" . $change_words[$amount_after_decimal % 10]) . ' Paise' : '';
		return ($implode_to_Rupees ? $implode_to_Rupees . 'Rupees ' : '') . $get_paise;
	}
	public function amountToWords11($number){

		$amountInWords = "";

        $words = array(
					'0' => '', 
					'1' => 'one', 
					'2' => 'two',
					'3' => 'three', 
					'4' => 'four', 
					'5' => 'five', 
					'6' => 'six',
					'7' => 'seven', 
					'8' => 'eight', 
					'9' => 'nine',
					'10' => 'ten', 
					'11' => 'eleven', 
					'12' => 'twelve',
					'13' => 'thirteen', 
					'14' => 'fourteen',
					'15' => 'fifteen', 
					'16' => 'sixteen', 
					'17' => 'seventeen',
					'18' => 'eighteen', 
					'19' =>'nineteen', 
					'20' => 'twenty',
					'30' => 'thirty', 
					'40' => 'forty', 
					'50' => 'fifty',
					'60' => 'sixty', 
					'70' => 'seventy',
					'80' => 'eighty', 
					'90' => 'ninety'
				);

		$digits = array('', '', 'hundred', 'thousand', 'lakh', 'crore');
		
		$number = explode(".", $number);
		$number[1] = str_pad($number[1], 2, "0", STR_PAD_RIGHT);

        $result = array("", "");
		$j =0;
		
		foreach($number as $val){
            // loop each part of number, right and left of dot
            for($i=0; $i<strlen($val); $i++){
                // look at each part of the number separately  [1] [5] [4] [2]  and  [5] [8]
                
				$numberpart = str_pad($val[$i], strlen($val)-$i, "0", STR_PAD_RIGHT); // make 1 => 1000, 5 => 500, 4 => 40 etc.
				
                if($numberpart <= 20){
                    $numberpart = 1*substr($val, $i,2);
                    $i++;
                    $result[$j] .= $words[$numberpart] ." ";
                }else{
                    //echo $numberpart . "<br>\n"; //debug
                    if($numberpart > 90){  // more than 90 and it needs a $digit.
                        $result[$j] .= $words[$val[$i]] . " " . $digits[strlen($numberpart)-1] . " "; 
                    }else if($numberpart != 0){ // don't print zero
                        $result[$j] .= $words[str_pad($val[$i], strlen($val)-$i, "0", STR_PAD_RIGHT)] ." ";
                    }
                }
            }
            $j++;
		}
		
		if(trim($result[0]) != "") $amountInWords .= $result[0] . "Rupees And ";
        if($result[1] != "") $amountInWords .= $result[1] . "Paise";
		$amountInWords .= " Only";

		$amountInWords = ucwords($amountInWords);
				
		return($amountInWords);
       
	}
	
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$invoice = Invoice::with('customer', 'product')->find($id);

		$profileSettings = ProfileSetting::find(1);
		$invoice['profile'] = $profileSettings;

		$invoiceSettings = InvoiceSetting::find(1);
		$invoice['invoice'] = $invoiceSettings;

		$invoice = (object) $invoice;

		clock($invoice);

		return view('backend.invoices.edit_invoice', compact('invoice'));
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
			'invoiceProducts.*.description' => 'invoice product description',
		 );
		
		$rules = array(
			'placeOfSupply'				=> 'required',
			'customer.name'				=> 'required',
			'customer.mobile'			=> 'required|regex:/\+91[[:space:]]\d{10}/',
			'invoiceProducts.*.description'	=> 'required',
		);

		$validator = Validator::make($request->all(), $rules);
		$validator->setAttributeNames($attributeNames);

		if ($validator->fails()) {

			return Response::json(array(
				'status' => 0,
				'errors' => $validator->errors()
			), 400);

		} else {

			$invoiceData = $request->except('customer', 'invoiceProducts', '_token', '_method','customerId');
			$invoiceCustomerData = $request->input('customer');
			$invoiceProductsData = $request->input('invoiceProducts');

			$invoice = Invoice::with('customer')->find($id);
			$prevBalance = $invoice->grandValue;
			Invoice::whereId($id)->update($invoiceData);

			$invoice->customer->update($invoiceCustomerData);

			foreach($invoiceProductsData as $invoiceProduct){
				$invoice->product()->where('invoiceSerial', $invoiceProduct['invoiceSerial'])->updateOrCreate(['invoice_id' => $invoice['id'], 'invoiceSerial' => $invoiceProduct['invoiceSerial']], $invoiceProduct);

				$invoiceProductIds[] = $invoiceProduct['invoiceSerial'];
			}

			$deleteMissingProducts = InvoiceProduct::where('invoice_id', $invoice['id'])
						->whereNotIn('invoiceSerial', $invoiceProductIds)
						->delete();
						
			$customer = Contact::find($invoiceCustomerData['customerId']);
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
		$customer = Contact::where('name', 'like', '%'.$customerName.'%')->where('type','customer')->get();
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

	public function printinvoice($id, $copy)
	{
		$invoice = Invoice::with('customer', 'product')->find($id);

		$amountInWords = $this->amountToWords($invoice['grandValue']);
		$invoice['amountInWords'] = $amountInWords;

		$profileSettings = ProfileSetting::find(1);
		$invoice['profile'] = $profileSettings;

		$invoiceSettings = InvoiceSetting::find(1);
		$invoice['invoice'] = $invoiceSettings;

		$invoice['copy'] = $copy;

		$invoice = (object) $invoice;
		if($copy=='DC'){	
			$pdf = PDF::loadView('backend.invoiceTemplates.DC', $invoice);
			return $pdf->stream($invoice['serialPrefix'].$invoice['serialNumber'].'_'.ucfirst($copy).'.pdf');
		} else {
			dd($invoice);
			$pdf = PDF::loadView('backend.invoiceTemplates.template1', $invoice);
			return $pdf->stream($invoice['serialPrefix'].$invoice['serialNumber'].'_'.ucfirst($copy).'.pdf');
		}

	}
	public function changeInvoiceStatus(Request $request)
	{
		// dd($request->all());
		$invoice = Invoice::find($request->id);
		// dd($invoice);
		$invoice->invoiceStatus = $request->invoiceStatus;
		$invoice->save();
		toast('Status changed Successfully!','success','top-right')->autoclose(3500);
		return Redirect::to('invoices');
	}

	public function payInvoiceBalance(Request $request)
	{
		$invoice = Invoice::find($request->id);
		$invoicePaymentData['invoice_id'] =  $request->id;
		$invoicePaymentData['paymentDate'] =  $request->paymentDate;
		$invoicePaymentData['amount'] =  $request->invoicePayment;
		$invoicePaymentData['balance'] =  $invoice->pendingBalance - $request->invoicePayment;
		$invoicePaymentData['user_id'] =  auth()->user()->id;
		$invoicePaymentData['account_id'] =  $request->account_id;
		$invoicePaymentData['description'] =  $request->description;
		$invoicePaymentData['method'] =  $request->method;
		$invoicepayment = InvoicePayment::create($invoicePaymentData);
		
		if($invoicePaymentData['balance']==0)
			$invoice->invoiceStatus = 'paid';
		else
			$invoice->invoiceStatus = 'partial';
		$invoice->amountRecieved = $invoice->amountRecieved+$request->invoicePayment;
		$invoice->pendingBalance = $invoicePaymentData['balance'];
		$invoice->save();

		$accounts = Account::find($request->account_id);
		$accounts->balance = $accounts->balance+$request->invoicePayment;
		$accounts->save();

		$transaction['payerid'] = $invoice->customer->customerId;
		$transaction['payeeid'] = $request->account_id;
		$transaction['account'] = $accounts->accountName;
		$transaction['type'] 	= 'Invoice';
		$transaction['amount'] = $request->invoicePayment;
		$transaction['description'] = $request->description;
		$transaction['date'] = $request->paymentDate;
		$transaction['cr'] = $request->invoicePayment;
		$transaction['bal'] = $accounts->balance;
		$transfer = Transaction::create($transaction);
		
		$contact = Contact::find($invoice->customer->customerId);
		$balance = $contact->outstandingBalance - $request->invoicePayment;

		$contact->outstandingBalance = $balance;
		$contact->save();

		toast('Payment has been done successfully!','success','top-right')->autoclose(3500);
		return Redirect::to('invoices');
	}
}
