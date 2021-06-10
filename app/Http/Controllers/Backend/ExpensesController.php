<?php
namespace App\Http\Controllers\Backend;

use App\Account;
use App\Expense;
use App\Transaction;
use App\ExpenseSetting;
use App\Contact;
use Validator;
use Response;
use Redirect;
use View;
use PDF;

use Illuminate\Http\Request;
use App\Http\Controllers\AceController\Controller;

class ExpensesController extends Controller
{
	public function __construct(Request $request)
	{
		$request->route()->setParameter('page-heading', 'Expenses');		
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$expenses = Expense::paginate(10);

		return view('backend.expenses.expenses_list', compact('expenses'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$expenseSettings = ExpenseSetting::find(1);
		$accounts = Account::get();

		$expense['serialPrefix'] = $expenseSettings['serialPrefix'];
		
		// Finding the expenses with set prefix
		$expensesCreated = Expense::where('serialPrefix', $expenseSettings['serialPrefix'])->get();
		// $expensesCreatedCount = Expense::count('serialPrefix', $expenseSettings['serialPrefix']);
		$expensesCreatedCount = $expensesCreated->count();

		if($expensesCreatedCount) {

			// Assuming the last user serial is the the one which is set in settings
			$serialNumberLastUsed = $expenseSettings['serialNumberStart'];

			// Finding the greatest number under used serials with the prefix from settings
			foreach($expensesCreated as $expenseCreated) {
				if($expenseCreated['serialNumber'] > $serialNumberLastUsed) {
					$serialNumberLastUsed = $expenseCreated['serialNumber'];
				}
			}

			$expense['serialNumber'] = str_pad(intval($serialNumberLastUsed) + 1, strlen($expenseSettings['serialNumberStart']), '0', STR_PAD_LEFT);

		} else {

			$expense['serialNumber'] = $expenseSettings['serialNumberStart'];

		}

		$expense = (object) $expense;
		clock($expense);
		return view('backend.expenses.create_expense', compact('expense','accounts'));
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
			'description'		=> 'required',
			// 'chequeNo'			=> 'required',
			// 'ref'				=> 'required',
			// 'person'			=> 'required',
		);

		$validator = Validator::make($request->all(), $rules);
		if ($validator->fails()) {

			toast('Rectify errors and re-submit!','error','top-right')->autoclose(3500);

            return Redirect::to('expenses/create')
                ->withErrors($validator)
                ->withInput($request->input());

		} else {

			$expenseData = $request->all();

			$expense = Expense::updateOrCreate(['serialPrefix' => $request->input('serialPrefix'), 'serialNumber' => $request->input('serialNumber')], $expenseData);
			$expense->save();
			
			$account = Account::find($request->account_id);
			$account->balance = $account->balance-$request->amount;
			$account->save();

			$transferData['payerid'] = $request->account_id;
			$transferData['account'] = $expense->accounts->accountName;
            $transferData['type'] = 'Expense';
            $transferData['amount'] = $request->amount;
            $transferData['description'] = $request->description;
            $transferData['date'] = $request->date;
            $transferData['dr'] = $request->amount;
            $transferData['bal'] = $expense->accounts->balance;
            $transfer = Transaction::create($transferData);
			toast('Expense Created Successfully!','success','top-right')->autoclose(3500);
            return Redirect::to('expenses/');
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
		$expense = Expense::with('customer', 'product')->find($id);

		$amountInWords = $this->amountToWords($expense['grandValue']);
		$expense['amountInWords'] = $amountInWords;

		$profileSettings = ProfileSetting::find(1);
		$expense['profile'] = $profileSettings;

		$expenseSettings = ExpenseSetting::find(1);
		$expense['expense'] = $expenseSettings;

		$expense = (object) $expense;

		clock($expense);

		return view('backend.expenses.view_expense', compact('expense'));
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
		$expense = Expense::with('customer', 'product')->find($id);

		$profileSettings = ProfileSetting::find(1);
		$expense['profile'] = $profileSettings;

		$expenseSettings = ExpenseSetting::find(1);
		$expense['expense'] = $expenseSettings;

		$expense = (object) $expense;

		clock($expense);

		return view('backend.expenses.edit_expense', compact('expense'));
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
			'expenseProducts.*.description' => 'expense product description',
		 );
		
		$rules = array(
			'placeOfSupply'				=> 'required',
			'customer.name'				=> 'required',
			'customer.mobile'			=> 'required|regex:/\+91[[:space:]]\d{10}/',
			'expenseProducts.*.description'	=> 'required',
		);

		$validator = Validator::make($request->all(), $rules);
		$validator->setAttributeNames($attributeNames);

		if ($validator->fails()) {

			return Response::json(array(
				'status' => 0,
				'errors' => $validator->errors()
			), 400);

		} else {

			$expenseData = $request->except('customer', 'expenseProducts', '_token', '_method');
			$expenseCustomerData = $request->input('customer');
			$expenseProductsData = $request->input('expenseProducts');

			$expense = Expense::with('customer')->find($id);

			Expense::whereId($id)->update($expenseData);

			$expense->customer->update($expenseCustomerData);

			foreach($expenseProductsData as $expenseProduct){
				$expense->product()->where('expenseSerial', $expenseProduct['expenseSerial'])->updateOrCreate(['expense_id' => $expense['id'], 'expenseSerial' => $expenseProduct['expenseSerial']], $expenseProduct);

				$expenseProductIds[] = $expenseProduct['expenseSerial'];
			}

			$deleteMissingProducts = ExpenseProduct::where('expense_id', $expense['id'])
						->whereNotIn('expenseSerial', $expenseProductIds)
						->delete();

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

	public function printexpense($id, $copy)
	{
		$expense = Expense::with('customer', 'product')->find($id);

		$amountInWords = $this->amountToWords($expense['grandValue']);
		$expense['amountInWords'] = $amountInWords;

		$profileSettings = ProfileSetting::find(1);
		$expense['profile'] = $profileSettings;

		$expenseSettings = ExpenseSetting::find(1);
		$expense['expense'] = $expenseSettings;

		$expense['copy'] = $copy;

		$expense = (object) $expense;

		$pdf = PDF::loadView('backend.expenseTemplates.template1', $expense);
		return $pdf->stream($expense['serialPrefix'].$expense['serialNumber'].'_'.ucfirst($copy).'.pdf');

	}

}
