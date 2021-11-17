<?php

namespace App\Http\Controllers\Backend;

use App\Account;
use App\CreditNote;
use App\CreditNotePayment;
use App\CreditNoteCustomer;
use App\CreditNoteProduct;
use App\CreditNoteSetting;
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

class CreditNotesController extends Controller
{
	public function __construct(Request $request)
	{
		$request->route()->setParameter('page-heading', 'CreditNotes');		
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$creditNotes = CreditNote::orderBy('id','desc')->paginate(10);
		$accounts = Account::get();
		return view('backend.creditNotes.creditNotes_list', compact('creditNotes','accounts'));
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function viewAllCreditNotes()
	{
		$creditNotes = CreditNote::get();

		return view('backend.creditNotes.all_creditNotes_list', compact('creditNotes'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$creditNoteSettings = CreditNoteSetting::find(1);

		$creditNote['serialPrefix'] = $creditNoteSettings['serialPrefix'];

		// Finding the creditNotes with set prefix
		$creditNotesCreated = CreditNote::where('serialPrefix', $creditNoteSettings['serialPrefix'])->get();
		// $creditNotesCreatedCount = CreditNote::count('serialPrefix', $creditNoteSettings['serialPrefix']);
		$creditNotesCreatedCount = $creditNotesCreated->count();

		if($creditNotesCreatedCount) {

			// Assuming the last user serial is the the one which is set in settings
			$serialNumberLastUsed = $creditNoteSettings['serialNumberStart'];

			// Finding the greatest number under used serials with the prefix from settings
			foreach($creditNotesCreated as $creditNoteCreated) {
				if($creditNoteCreated['serialNumber'] > $serialNumberLastUsed) {
					$serialNumberLastUsed = $creditNoteCreated['serialNumber'];
				}
			}

			$creditNote['serialNumber'] = str_pad(intval($serialNumberLastUsed) + 1, strlen($creditNoteSettings['serialNumberStart']), '0', STR_PAD_LEFT);

		} else {

			$creditNote['serialNumber'] = $creditNoteSettings['serialNumberStart'];

		}

		$profileSettings = ProfileSetting::find(1);

		$creditNote['placeOfOrigin'] = $profileSettings['placeOfOrigin'];
		$creditNote['businessName'] = $profileSettings['businessName'];

		$creditNote = (object) $creditNote;
		clock($creditNote);
		return view('backend.creditNotes.create_creditNote', compact('creditNote'));
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
			'creditNoteProducts.*.description' => 'creditNote product description',
		 );
		
		$rules = array(
			'placeOfSupply'				=> 'required',
			'customer.name'				=> 'required',
			'customer.mobile'			=> 'required|regex:/\+91[[:space:]]\d{10}/',
			'creditNoteProducts.*.description'	=> 'required',
		);

		$validator = Validator::make($request->all(), $rules);
		$validator->setAttributeNames($attributeNames);

		if ($validator->fails()) {

			return Response::json(array(
				'status' => 0,
				'errors' => $validator->errors()
			), 400);

		} else {
			$creditNoteData = $request->except('customer', 'creditNoteProducts', '_token','customerId');
			$creditNoteData['pendingBalance'] = $creditNoteData['grandValue'];
			$creditNoteCustomerData = $request->input('customer');
			$creditNoteProductsData = $request->input('creditNoteProducts');

			// dd($creditNoteData,$creditNoteCustomerData,$creditNoteProductsData);
			$creditNote = CreditNote::updateOrCreate(['serialPrefix' => $request->input('serialPrefix'), 'serialNumber' => $request->input('serialNumber')], $creditNoteData);
			$creditNote->save();

			$creditNoteCustomer = CreditNoteCustomer::updateOrCreate(['credit_note_id' => $creditNote['id']], $creditNoteCustomerData);
			$creditNote->customer()->save($creditNoteCustomer);

			foreach($creditNoteProductsData as $creditNoteProduct){
				$creditNoteProduct = CreditNoteProduct::updateOrCreate(['credit_note_id' => $creditNote['id'], 'creditNoteSerial' => $creditNoteProduct['creditNoteSerial']], $creditNoteProduct);
				$creditNote->product()->save($creditNoteProduct);

				$creditNoteProductIds[] = $creditNoteProduct['creditNoteSerial'];
			}

			$deleteMissingProducts = CreditNoteProduct::where('credit_note_id', $creditNote['id'])
						->whereNotIn('creditNoteSerial', $creditNoteProductIds)
						->delete();
			$customer = Contact::find($creditNoteCustomerData['customerId']);
			$balance = $customer->outstandingBalance-$request->input('grandValue');
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
		$creditNote = CreditNote::with('customer', 'product')->find($id);

		$amountInWords = $this->amountToWords($creditNote['grandValue']);
		$creditNote['amountInWords'] = $amountInWords;

		$profileSettings = ProfileSetting::find(1);
		$creditNote['profile'] = $profileSettings;

		$creditNoteSettings = CreditNoteSetting::find(1);
		$creditNote['creditNote'] = $creditNoteSettings;

		$creditNote = (object) $creditNote;

		clock($creditNote);

		return view('backend.creditNotes.view_creditNote', compact('creditNote'));
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
		$creditNote = CreditNote::with('customer', 'product')->find($id);

		$profileSettings = ProfileSetting::find(1);
		$creditNote['profile'] = $profileSettings;

		$creditNoteSettings = CreditNoteSetting::find(1);
		$creditNote['creditNote'] = $creditNoteSettings;

		$creditNote = (object) $creditNote;

		clock($creditNote);

		return view('backend.creditNotes.edit_creditNote', compact('creditNote'));
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
			'creditNoteProducts.*.description' => 'creditNote product description',
		 );
		
		$rules = array(
			'placeOfSupply'				=> 'required',
			'customer.name'				=> 'required',
			'customer.mobile'			=> 'required|regex:/\+91[[:space:]]\d{10}/',
			'creditNoteProducts.*.description'	=> 'required',
		);

		$validator = Validator::make($request->all(), $rules);
		$validator->setAttributeNames($attributeNames);

		if ($validator->fails()) {

			return Response::json(array(
				'status' => 0,
				'errors' => $validator->errors()
			), 400);

		} else {

			$creditNoteData = $request->except('customer', 'creditNoteProducts', '_token', '_method','customerId');
			$creditNoteCustomerData = $request->input('customer');
			$creditNoteProductsData = $request->input('creditNoteProducts');

			$creditNote = CreditNote::with('customer')->find($id);
			$prevBalance = $creditNote->grandValue;
			CreditNote::whereId($id)->update($creditNoteData);

			$creditNote->customer->update($creditNoteCustomerData);

			foreach($creditNoteProductsData as $creditNoteProduct){
				$creditNote->product()->where('creditNoteSerial', $creditNoteProduct['creditNoteSerial'])->updateOrCreate(['credit_note_id' => $creditNote['id'], 'creditNoteSerial' => $creditNoteProduct['creditNoteSerial']], $creditNoteProduct);

				$creditNoteProductIds[] = $creditNoteProduct['creditNoteSerial'];
			}

			$deleteMissingProducts = CreditNoteProduct::where('credit_note_id', $creditNote['id'])
						->whereNotIn('creditNoteSerial', $creditNoteProductIds)
						->delete();
						
			$customer = Contact::find($creditNoteCustomerData['customerId']);
			$balance = $customer->outstandingBalance-$request->input('grandValue')-$prevBalance;
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

	public function printcreditNote($id, $copy)
	{
		$creditNote = CreditNote::with('customer', 'product')->find($id);

		$amountInWords = $this->amountToWords($creditNote['grandValue']);
		$creditNote['amountInWords'] = $amountInWords;

		$profileSettings = ProfileSetting::find(1);
		$creditNote['profile'] = $profileSettings;

		$creditNoteSettings = CreditNoteSetting::find(1);
		$creditNote['creditNote'] = $creditNoteSettings;

		$creditNote['copy'] = $copy;

		$creditNote = (object) $creditNote;
		if($copy=='DC'){	
			$pdf = PDF::loadView('backend.creditNoteTemplates.DC', $creditNote);
			return $pdf->stream($creditNote['serialPrefix'].$creditNote['serialNumber'].'_'.ucfirst($copy).'.pdf');
		} else {
			$pdf = PDF::loadView('backend.creditNoteTemplates.template1', $creditNote);
			return $pdf->stream($creditNote['serialPrefix'].$creditNote['serialNumber'].'_'.ucfirst($copy).'.pdf');
		}

	}
	public function changeCreditNoteStatus(Request $request)
	{
		// dd($request->all());
		$creditNote = CreditNote::find($request->id);
		// dd($creditNote);
		$creditNote->creditNoteStatus = $request->creditNoteStatus;
		$creditNote->save();
		toast('Status changed Successfully!','success','top-right')->autoclose(3500);
		return Redirect::to('creditNotes');
	}

	public function payCreditNoteBalance(Request $request)
	{
		$creditNote = CreditNote::find($request->id);
		$creditNotePaymentData['credit_note_id'] =  $request->id;
		$creditNotePaymentData['paymentDate'] =  $request->paymentDate;
		$creditNotePaymentData['amount'] =  $request->creditNotePayment;
		$creditNotePaymentData['balance'] =  $creditNote->pendingBalance - $request->creditNotePayment;
		$creditNotePaymentData['user_id'] =  auth()->user()->id;
		$creditNotePaymentData['account_id'] =  $request->account_id;
		$creditNotePaymentData['description'] =  $request->description;
		$creditNotePaymentData['method'] =  $request->method;
		$creditNotepayment = CreditNotePayment::create($creditNotePaymentData);
		
		if($creditNotePaymentData['balance']==0)
			$creditNote->creditNoteStatus = 'paid';
		else
			$creditNote->creditNoteStatus = 'partial';
		$creditNote->amountRecieved = $creditNote->amountRecieved+$request->creditNotePayment;
		$creditNote->pendingBalance = $creditNotePaymentData['balance'];
		$creditNote->save();

		$accounts = Account::find($request->account_id);
		$accounts->balance = $accounts->balance+$request->creditNotePayment;
		$accounts->save();

		$transaction['payerid'] = $creditNote->customer->customerId;
		$transaction['payeeid'] = $request->account_id;
		$transaction['account'] = $accounts->accountName;
		$transaction['type'] 	= 'Payment';
		$transaction['amount'] = $request->creditNotePayment;
		$transaction['description'] = $request->description;
		$transaction['date'] = $request->paymentDate;
		$transaction['cr'] = $request->creditNotePayment;
		$transaction['bal'] = $accounts->balance;
		$transfer = Transaction::create($transaction);
		
		$contact = Contact::find($creditNote->customer->customerId);
		$balance = $contact->outstandingBalance - $request->creditNotePayment;

		$contact->outstandingBalance = $balance;
		$contact->save();

		toast('Payment has been done successfully!','success','top-right')->autoclose(3500);
		return Redirect::to('creditNotes');
	}
}
