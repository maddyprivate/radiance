<?php

namespace App\Http\Controllers\Backend;

use App\Account;
use App\DebitNote;
use App\DebitNotePayment;
use App\DebitNoteDealer;
use App\DebitNoteProduct;
use App\DebitNoteSetting;
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

class DebitNotesController extends Controller
{
	public function __construct(Request $request)
	{
		$request->route()->setParameter('page-heading', 'DebitNotes');		
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$debitNotes = DebitNote::orderBy('id','desc')->paginate(10);
		$accounts = Account::get();
		return view('backend.debitNotes.debitNotes_list', compact('debitNotes','accounts'));
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function viewAllDebitNotes()
	{
		$debitNotes = DebitNote::get();

		return view('backend.debitNotes.all_debitNotes_list', compact('debitNotes'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$debitNoteSettings = DebitNoteSetting::find(1);

		$debitNote['serialPrefix'] = $debitNoteSettings['serialPrefix'];

		// Finding the debitNotes with set prefix
		$debitNotesCreated = DebitNote::where('serialPrefix', $debitNoteSettings['serialPrefix'])->get();
		// $debitNotesCreatedCount = DebitNote::count('serialPrefix', $debitNoteSettings['serialPrefix']);
		$debitNotesCreatedCount = $debitNotesCreated->count();

		if($debitNotesCreatedCount) {

			// Assuming the last user serial is the the one which is set in settings
			$serialNumberLastUsed = $debitNoteSettings['serialNumberStart'];

			// Finding the greatest number under used serials with the prefix from settings
			foreach($debitNotesCreated as $debitNoteCreated) {
				if($debitNoteCreated['serialNumber'] > $serialNumberLastUsed) {
					$serialNumberLastUsed = $debitNoteCreated['serialNumber'];
				}
			}

			$debitNote['serialNumber'] = str_pad(intval($serialNumberLastUsed) + 1, strlen($debitNoteSettings['serialNumberStart']), '0', STR_PAD_LEFT);

		} else {

			$debitNote['serialNumber'] = $debitNoteSettings['serialNumberStart'];

		}

		$profileSettings = ProfileSetting::find(1);

		$debitNote['placeOfOrigin'] = $profileSettings['placeOfOrigin'];
		$debitNote['businessName'] = $profileSettings['businessName'];

		$debitNote = (object) $debitNote;
		clock($debitNote);
		return view('backend.debitNotes.create_debitNote', compact('debitNote'));
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
			'dealer.name' => 'Dealer Name',
			'dealer.mobile' => 'Dealer Mobile',
			'debitNoteProducts.*.description' => 'debitNote product description',
		 );
		
		$rules = array(
			'placeOfSupply'				=> 'required',
			'dealer.name'				=> 'required',
			'dealer.mobile'			=> 'required|regex:/\+91[[:space:]]\d{10}/',
			'debitNoteProducts.*.description'	=> 'required',
		);

		$validator = Validator::make($request->all(), $rules);
		$validator->setAttributeNames($attributeNames);

		if ($validator->fails()) {

			return Response::json(array(
				'status' => 0,
				'errors' => $validator->errors()
			), 400);

		} else {
			$debitNoteData = $request->except('dealer', 'debitNoteProducts', '_token','dealerId');
			$debitNoteData['pendingBalance'] = $debitNoteData['grandValue'];
			$debitNoteDealerData = $request->input('dealer');
			$debitNoteProductsData = $request->input('debitNoteProducts');

			// dd($debitNoteData,$debitNoteDealerData,$debitNoteProductsData);
			$debitNote = DebitNote::updateOrCreate(['serialPrefix' => $request->input('serialPrefix'), 'serialNumber' => $request->input('serialNumber')], $debitNoteData);
			$debitNote->save();

			$debitNoteDealer = DebitNoteDealer::updateOrCreate(['debit_note_id' => $debitNote['id']], $debitNoteDealerData);
			$debitNote->dealer()->save($debitNoteDealer);

			foreach($debitNoteProductsData as $debitNoteProduct){
				$debitNoteProduct = DebitNoteProduct::updateOrCreate(['debit_note_id' => $debitNote['id'], 'debitNoteSerial' => $debitNoteProduct['debitNoteSerial']], $debitNoteProduct);
				$debitNote->product()->save($debitNoteProduct);

				$debitNoteProductIds[] = $debitNoteProduct['debitNoteSerial'];
			}

			$deleteMissingProducts = DebitNoteProduct::where('debit_note_id', $debitNote['id'])
						->whereNotIn('debitNoteSerial', $debitNoteProductIds)
						->delete();
			$dealer = Contact::find($debitNoteDealerData['dealerId']);
			$balance = $dealer->outstandingBalance+$request->input('grandValue');
			$dealer->outstandingBalance = $balance;
			$dealer->save();
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
		$debitNote = DebitNote::with('dealer', 'product')->find($id);

		$amountInWords = $this->amountToWords($debitNote['grandValue']);
		$debitNote['amountInWords'] = $amountInWords;

		$profileSettings = ProfileSetting::find(1);
		$debitNote['profile'] = $profileSettings;

		$debitNoteSettings = DebitNoteSetting::find(1);
		$debitNote['debitNote'] = $debitNoteSettings;

		$debitNote = (object) $debitNote;

		clock($debitNote);

		return view('backend.debitNotes.view_debitNote', compact('debitNote'));
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
		$debitNote = DebitNote::with('dealer', 'product')->find($id);

		$profileSettings = ProfileSetting::find(1);
		$debitNote['profile'] = $profileSettings;

		$debitNoteSettings = DebitNoteSetting::find(1);
		$debitNote['debitNote'] = $debitNoteSettings;

		$debitNote = (object) $debitNote;

		clock($debitNote);

		return view('backend.debitNotes.edit_debitNote', compact('debitNote'));
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
			'dealer.name' => 'Dealer Name',
			'dealer.mobile' => 'Dealer Mobile',
			'debitNoteProducts.*.description' => 'debitNote product description',
		 );
		
		$rules = array(
			'placeOfSupply'				=> 'required',
			'dealer.name'				=> 'required',
			'dealer.mobile'			=> 'required|regex:/\+91[[:space:]]\d{10}/',
			'debitNoteProducts.*.description'	=> 'required',
		);

		$validator = Validator::make($request->all(), $rules);
		$validator->setAttributeNames($attributeNames);

		if ($validator->fails()) {

			return Response::json(array(
				'status' => 0,
				'errors' => $validator->errors()
			), 400);

		} else {

			$debitNoteData = $request->except('dealer', 'debitNoteProducts', '_token', '_method','dealerId');
			$debitNoteDealerData = $request->input('dealer');
			$debitNoteProductsData = $request->input('debitNoteProducts');

			$debitNote = DebitNote::with('dealer')->find($id);
			$prevBalance = $debitNote->grandValue;
			DebitNote::whereId($id)->update($debitNoteData);

			$debitNote->dealer->update($debitNoteDealerData);

			foreach($debitNoteProductsData as $debitNoteProduct){
				$debitNote->product()->where('debitNoteSerial', $debitNoteProduct['debitNoteSerial'])->updateOrCreate(['debit_note_id' => $debitNote['id'], 'debitNoteSerial' => $debitNoteProduct['debitNoteSerial']], $debitNoteProduct);

				$debitNoteProductIds[] = $debitNoteProduct['debitNoteSerial'];
			}

			$deleteMissingProducts = DebitNoteProduct::where('debit_note_id', $debitNote['id'])
						->whereNotIn('debitNoteSerial', $debitNoteProductIds)
						->delete();
						
			$dealer = Contact::find($debitNoteDealerData['dealerId']);
			$balance = $dealer->outstandingBalance+$request->input('grandValue')-$prevBalance;
			$dealer->outstandingBalance = $balance;
			$dealer->save();
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

	public function selectDealer($dealerName)
	{
		clock($dealerName);
		$dealer = Contact::where('name', 'like', '%'.$dealerName.'%')->where('type','dealer')->get();
		$return = array(
			'data' => $dealer
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

	public function printdebitNote($id, $copy)
	{
		$debitNote = DebitNote::with('dealer', 'product')->find($id);

		$amountInWords = $this->amountToWords($debitNote['grandValue']);
		$debitNote['amountInWords'] = $amountInWords;

		$profileSettings = ProfileSetting::find(1);
		$debitNote['profile'] = $profileSettings;

		$debitNoteSettings = DebitNoteSetting::find(1);
		$debitNote['debitNote'] = $debitNoteSettings;

		$debitNote['copy'] = $copy;

		$debitNote = (object) $debitNote;
		if($copy=='DC'){	
			$pdf = PDF::loadView('backend.debitNoteTemplates.DC', $debitNote);
			return $pdf->stream($debitNote['serialPrefix'].$debitNote['serialNumber'].'_'.ucfirst($copy).'.pdf');
		} else {
			$pdf = PDF::loadView('backend.debitNoteTemplates.template1', $debitNote);
			return $pdf->stream($debitNote['serialPrefix'].$debitNote['serialNumber'].'_'.ucfirst($copy).'.pdf');
		}

	}
	public function changeDebitNoteStatus(Request $request)
	{
		// dd($request->all());
		$debitNote = DebitNote::find($request->id);
		// dd($debitNote);
		$debitNote->debitNoteStatus = $request->debitNoteStatus;
		$debitNote->save();
		toast('Status changed Successfully!','success','top-right')->autoclose(3500);
		return Redirect::to('debitNotes');
	}

	public function payDebitNoteBalance(Request $request)
	{
		$debitNote = DebitNote::find($request->id);
		$debitNotePaymentData['debit_note_id'] =  $request->id;
		$debitNotePaymentData['paymentDate'] =  $request->paymentDate;
		$debitNotePaymentData['amount'] =  $request->debitNotePayment;
		$debitNotePaymentData['balance'] =  $debitNote->pendingBalance - $request->debitNotePayment;
		$debitNotePaymentData['user_id'] =  auth()->user()->id;
		$debitNotePaymentData['account_id'] =  $request->account_id;
		$debitNotePaymentData['description'] =  $request->description;
		$debitNotePaymentData['method'] =  $request->method;
		$debitNotepayment = DebitNotePayment::create($debitNotePaymentData);
		
		if($debitNotePaymentData['balance']==0)
			$debitNote->debitNoteStatus = 'paid';
		else
			$debitNote->debitNoteStatus = 'partial';
		$debitNote->amountRecieved = $debitNote->amountRecieved+$request->debitNotePayment;
		$debitNote->pendingBalance = $debitNotePaymentData['balance'];
		$debitNote->save();

		$accounts = Account::find($request->account_id);
		$accounts->balance = $accounts->balance+$request->debitNotePayment;
		$accounts->save();

		$transaction['payerid'] = $debitNote->dealer->dealerId;
		$transaction['payeeid'] = $request->account_id;
		$transaction['account'] = $accounts->accountName;
		$transaction['type'] 	= 'Payment';
		$transaction['amount'] = $request->debitNotePayment;
		$transaction['description'] = $request->description;
		$transaction['date'] = $request->paymentDate;
		$transaction['cr'] = $request->debitNotePayment;
		$transaction['bal'] = $accounts->balance;
		$transfer = Transaction::create($transaction);
		
		$contact = Contact::find($debitNote->dealer->dealerId);
		$balance = $contact->outstandingBalance - $request->debitNotePayment;

		$contact->outstandingBalance = $balance;
		$contact->save();

		toast('Payment has been done successfully!','success','top-right')->autoclose(3500);
		return Redirect::to('debitNotes');
	}
}
