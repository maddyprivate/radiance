<?php

namespace App\Http\Controllers\Backend;

use App\Purchase;
use App\PurchaseDealer;
use App\PurchaseProduct;
use App\PurchaseSetting;
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

class PurchasesController extends Controller
{
	public function __construct(Request $request)
	{
		$request->route()->setParameter('page-heading', 'Purchases');		
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$purchases = Purchase::paginate(10);

		return view('backend.purchases.purchases_list', compact('purchases'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$purchaseSettings = PurchaseSetting::find(1);

		$purchase['serialPrefix'] = $purchaseSettings['serialPrefix'];

		// Finding the purchases with set prefix
		$purchasesCreated = Purchase::where('serialPrefix', $purchaseSettings['serialPrefix'])->get();
		// $purchasesCreatedCount = Purchase::count('serialPrefix', $purchaseSettings['serialPrefix']);
		$purchasesCreatedCount = $purchasesCreated->count();

		if($purchasesCreatedCount) {

			// Assuming the last user serial is the the one which is set in settings
			$serialNumberLastUsed = $purchaseSettings['serialNumberStart'];

			// Finding the greatest number under used serials with the prefix from settings
			foreach($purchasesCreated as $purchaseCreated) {
				if($purchaseCreated['serialNumber'] > $serialNumberLastUsed) {
					$serialNumberLastUsed = $purchaseCreated['serialNumber'];
				}
			}

			$purchase['serialNumber'] = str_pad(intval($serialNumberLastUsed) + 1, strlen($purchaseSettings['serialNumberStart']), '0', STR_PAD_LEFT);

		} else {

			$purchase['serialNumber'] = $purchaseSettings['serialNumberStart'];

		}

		$profileSettings = ProfileSetting::find(1);

		$purchase['placeOfOrigin'] = $profileSettings['placeOfOrigin'];
		$purchase['businessName'] = $profileSettings['businessName'];

		$purchase = (object) $purchase;
		clock($purchase);
		return view('backend.purchases.create_purchase', compact('purchase'));
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
			// 'dealer.mobile' => 'Dealer Mobile',
			'purchaseProducts.*.description' => 'purchase product description',
		 );
		
		$rules = array(
			'placeOfSupply'				=> 'required',
			'dealer.name'				=> 'required',
			// 'dealer.mobile'			=> 'required|regex:/\+91[[:space:]]\d{10}/',
			'purchaseProducts.*.description'	=> 'required',
		);

		$validator = Validator::make($request->all(), $rules);
		$validator->setAttributeNames($attributeNames);

		if ($validator->fails()) {

			return Response::json(array(
				'status' => 0,
				'errors' => $validator->errors()
			), 400);

		} else {
			$purchaseData = $request->except('dealer', 'purchaseProducts', '_token','dealerId');
			$purchaseDealerData = $request->input('dealer');
			$purchaseProductsData = $request->input('purchaseProducts');

			$purchase = Purchase::updateOrCreate(['serialPrefix' => $request->input('serialPrefix'), 'serialNumber' => $request->input('serialNumber')], $purchaseData);
			$purchase->save();

			$purchaseDealer = PurchaseDealer::updateOrCreate(['purchase_id' => $purchase['id']], $purchaseDealerData);
			$purchase->dealer()->save($purchaseDealer);

			foreach($purchaseProductsData as $purchaseProduct){
				$purchaseProduct = PurchaseProduct::updateOrCreate(['purchase_id' => $purchase['id'], 'purchaseSerial' => $purchaseProduct['purchaseSerial']], $purchaseProduct);
				$purchase->product()->save($purchaseProduct);

				$purchaseProductIds[] = $purchaseProduct['purchaseSerial'];
			}

			$deleteMissingProducts = PurchaseProduct::where('purchase_id', $purchase['id'])
						->whereNotIn('purchaseSerial', $purchaseProductIds)
						->delete();
			$dealer = Contact::find($purchaseDealerData['dealerId']);
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
		$purchase = Purchase::with('dealer', 'product')->find($id);

		$amountInWords = $this->amountToWords($purchase['grandValue']);
		$purchase['amountInWords'] = $amountInWords;

		$profileSettings = ProfileSetting::find(1);
		$purchase['profile'] = $profileSettings;

		$purchaseSettings = PurchaseSetting::find(1);
		$purchase['purchase'] = $purchaseSettings;

		$purchase = (object) $purchase;

		clock($purchase);

		return view('backend.purchases.view_purchase', compact('purchase'));
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
		$purchase = Purchase::with('dealer', 'product')->find($id);

		$profileSettings = ProfileSetting::find(1);
		$purchase['profile'] = $profileSettings;

		$purchaseSettings = PurchaseSetting::find(1);
		$purchase['purchase'] = $purchaseSettings;

		$purchase = (object) $purchase;

		clock($purchase);

		return view('backend.purchases.edit_purchase', compact('purchase'));
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
			'purchaseProducts.*.description' => 'purchase product description',
		 );
		
		$rules = array(
			'placeOfSupply'				=> 'required',
			'dealer.name'				=> 'required',
			'dealer.mobile'			=> 'required|regex:/\+91[[:space:]]\d{10}/',
			'purchaseProducts.*.description'	=> 'required',
		);

		$validator = Validator::make($request->all(), $rules);
		$validator->setAttributeNames($attributeNames);

		if ($validator->fails()) {

			return Response::json(array(
				'status' => 0,
				'errors' => $validator->errors()
			), 400);

		} else {

			$purchaseData = $request->except('dealer', 'purchaseProducts', '_token', '_method','dealerId');
			$purchaseDealerData = $request->input('dealer');
			$purchaseProductsData = $request->input('purchaseProducts');

			$purchase = Purchase::with('dealer')->find($id);
			$prevBalance = $purchase->grandValue;
			Purchase::whereId($id)->update($purchaseData);

			$purchase->dealer->update($purchaseDealerData);

			foreach($purchaseProductsData as $purchaseProduct){
				$purchase->product()->where('purchaseSerial', $purchaseProduct['purchaseSerial'])->updateOrCreate(['purchase_id' => $purchase['id'], 'purchaseSerial' => $purchaseProduct['purchaseSerial']], $purchaseProduct);

				$purchaseProductIds[] = $purchaseProduct['purchaseSerial'];
			}

			$deleteMissingProducts = PurchaseProduct::where('purchase_id', $purchase['id'])
						->whereNotIn('purchaseSerial', $purchaseProductIds)
						->delete();
						
			$dealer = Contact::find($purchaseDealerData['dealerId']);
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

	public function printpurchase($id, $copy)
	{
		$purchase = Purchase::with('dealer', 'product')->find($id);

		$amountInWords = $this->amountToWords($purchase['grandValue']);
		$purchase['amountInWords'] = $amountInWords;

		$profileSettings = ProfileSetting::find(1);
		$purchase['profile'] = $profileSettings;

		$purchaseSettings = PurchaseSetting::find(1);
		$purchase['purchase'] = $purchaseSettings;

		$purchase['copy'] = $copy;

		$purchase = (object) $purchase;
		if($copy=='DC'){	
			$pdf = PDF::loadView('backend.purchaseTemplates.DC', $purchase);
			return $pdf->stream($purchase['serialPrefix'].$purchase['serialNumber'].'_'.ucfirst($copy).'.pdf');
		} else {
			$pdf = PDF::loadView('backend.purchaseTemplates.template1', $purchase);
			return $pdf->stream($purchase['serialPrefix'].$purchase['serialNumber'].'_'.ucfirst($copy).'.pdf');
		}

	}
	public function changePurchaseStatus(Request $request)
	{
		// dd($request->all());
		$purchase = Purchase::find($request->id);
		// dd($purchase);
		$purchase->purchaseStatus = $request->purchaseStatus;
		$purchase->save();
		toast('Status changed Successfully!','success','top-right')->autoclose(3500);
		return Redirect::to('purchases');
	}

}
