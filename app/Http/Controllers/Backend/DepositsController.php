<?php

namespace App\Http\Controllers\Backend;

use App\Transaction;
use App\Account;
use App\Deposit;
use App\Contact;
use Validator;
use Response;
use Redirect;
use View;
use PDF;

use Illuminate\Http\Request;
use App\Http\Controllers\AceController\Controller;

class DepositsController extends Controller
{
	public function __construct(Request $request)
	{
		$request->route()->setParameter('page-heading', 'Deposits');		
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$deposits = Deposit::paginate(10);

		return view('backend.deposits.deposits_list', compact('deposits'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$accounts = Account::get();
		return view('backend.deposits.create_deposit', compact('accounts'));
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
			'date'				=> 'required',
			'account_id'		=> 'required',
			'amount'			=> 'required',
			/*'description'		=> 'required',
			'chequeNo'			=> 'required',
			'ref'				=> 'required',
			'person'			=> 'required',*/
		);

		$validator = Validator::make($request->all(), $rules);
		if ($validator->fails()) {

			toast('Rectify errors and re-submit!','error','top-right')->autoclose(3500);

            return Redirect::to('deposits/create')
                ->withErrors($validator)
                ->withInput($request->input());

		} else {

			$depositData = $request->all();

			$deposit = Deposit::create($depositData);
			$deposit->save();

			$account = Account::find($request->account_id);
			$account->balance = $account->balance+$request->amount;
			$account->save();

			$transferData['payeeid'] = $request->account_id;
			$transferData['account'] = $deposit->accounts->accountName;
            $transferData['type'] = 'Deposit';
            $transferData['amount'] = $request->amount;
            $transferData['description'] = $request->description;
            $transferData['date'] = $request->date;
            $transferData['cr'] = $request->amount;
            $transferData['bal'] = $deposit->accounts->balance;
            
            $transfer = Transaction::create($transferData);
			toast('Deposit Created Successfully!','success','top-right')->autoclose(3500);
            return Redirect::to('deposits/');
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
		$deposit = Deposit::with('customer', 'product')->find($id);

		$amountInWords = $this->amountToWords($deposit['grandValue']);
		$deposit['amountInWords'] = $amountInWords;

		$profileSettings = ProfileSetting::find(1);
		$deposit['profile'] = $profileSettings;

		$depositSettings = DepositSetting::find(1);
		$deposit['deposit'] = $depositSettings;

		$deposit = (object) $deposit;

		clock($deposit);

		return view('backend.deposits.view_deposit', compact('deposit'));
	}

	public function amountToWords($number){

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
		$accounts = Account::get();
		$deposit = Deposit::with('accounts')->find($id);

/*		$profileSettings = ProfileSetting::find(1);
		$deposit['profile'] = $profileSettings;

		$depositSettings = DepositSetting::find(1);
		$deposit['deposit'] = $depositSettings;*/

		$deposit = (object) $deposit;

		clock($deposit);

		return view('backend.deposits.edit_deposit', compact('deposit','accounts'));
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
		clock($request->all());

		$rules = array(
			'date'				=> 'required',
			'account_id'		=> 'required',
			'amount'			=> 'required',
			/*'description'		=> 'required',
			'chequeNo'			=> 'required',
			'ref'				=> 'required',
			'person'			=> 'required',*/
		);

		$validator = Validator::make($request->all(), $rules);
		if ($validator->fails()) {

			toast('Rectify errors and re-submit!','error','top-right')->autoclose(3500);

            return Redirect::to('deposits/create')
                ->withErrors($validator)
                ->withInput($request->input());

		} else {
			$depositData = $request->except('_token', '_method');
			$deposit = Deposit::find($id);
			$preAmount = $deposit->amount;
			$curAmount = $request->amount;
			$prevAccountId = $deposit->account_id;
			$curAccountId = $request->account_id;
			if($prevAccountId==$curAccountId){
				$prevAccount = Account::find($prevAccountId);
				$prevAccount->balance = $prevAccount->balance-$preAmount+$curAmount;
				$prevAccount->save();
			} else{
				$curAccount = Account::find($curAccountId);
				$curAccount->balance = $curAccount->balance+$curAmount;
				$curAccount->save();

				$prevAccount = Account::find($prevAccountId);
				$prevAccount->balance = $prevAccount->balance-$preAmount;
				$prevAccount->save();
			}
			Deposit::whereId($id)->update($depositData);


			$transactionData['payeeid'] = $request->account_id;
			$transactionData['account'] = $deposit->accounts->accountName;
            // $transactionData['type'] = 'Deposit';
            // $transactionData['typeId'] = $deposit->id;
            $transactionData['amount'] = $request->amount;
            $transactionData['description'] = $request->description;
            $transactionData['date'] = $request->date;
            $transactionData['cr'] = $request->amount;
            $transactionData['bal'] = $deposit->accounts->balance;
            $transaction = Transaction::where('typeId',$id)->where('type','Deposit')->update($transactionData);
            
			toast('Deposit updated Successfully!','success','top-right')->autoclose(3500);
            return Redirect::to('deposits/');

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

	public function printdeposit($id, $copy)
	{
		$deposit = Deposit::with('customer', 'product')->find($id);

		$amountInWords = $this->amountToWords($deposit['grandValue']);
		$deposit['amountInWords'] = $amountInWords;

		$profileSettings = ProfileSetting::find(1);
		$deposit['profile'] = $profileSettings;

		$depositSettings = DepositSetting::find(1);
		$deposit['deposit'] = $depositSettings;

		$deposit['copy'] = $copy;

		$deposit = (object) $deposit;

		$pdf = PDF::loadView('backend.depositTemplates.template1', $deposit);
		return $pdf->stream($deposit['serialPrefix'].$deposit['serialNumber'].'_'.ucfirst($copy).'.pdf');

	}

}
