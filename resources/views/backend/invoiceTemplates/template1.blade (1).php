<!doctype html>
<html lang="en">

<head>
	<title>Invoice {{$serialPrefix.$serialNumber}} {{ucfirst($copy)}}</title>
	<link href="{{ asset('/css/invoiceTemplate/template1.css') }}" rel="stylesheet">
</head>

<body class="template_2">

<htmlpageheader name="invoiceHeader">
	<div id="top_header">
		@if($invoiceStatus === 'quote')
			Quotation
		@else
			<img src="{{asset('img/RadianceLogo.jpg')}}" height="12%" />
		@endif
	</div>
</htmlpageheader>

<htmlpagefooter name="invoiceFooter">
	Page {PAGENO} of {nbpg}
</htmlpagefooter>

<div >
   
    <table class="intro_info no_border">
        <tbody>			
			<tr class="invoice_for_row no_border">
				@if($invoiceStatus != 'quote')
					@if($copy === 'original')
						<td class="invoice_for" colspan="4" ><img src="{{asset('img/invoice/Original.png')}}" height="50px" /></td>
					@elseif($copy === 'duplicate')
						<td class="invoice_for" colspan="4"><img src="{{asset('img/invoice/Duplicate.png')}}" height="50px" /></td>
					@elseif($copy === 'triplicate')
						<td class="invoice_for" colspan="4"><img src="{{asset('img/invoice/Triplicate.png')}}" height="50px" /></td>
					@endif
				@else
					<td class="invoice_for" colspan="2"><img src="{{asset('img/invoice/Blank.png')}}" height="50px" /></td>
				@endif
			</tr>
			<tr class="invoice_for_row no_border " ><td style="text-align: center; padding-bottom:3px;padding-top:20px;" colspan="4">Royal Empress Building, Near Aryan Suzuki Showroom,Baner,Pune, 411045</td></tr>
			<tr class="invoice_for_row no_border "><td style="text-align: center;padding-bottom:25px;" colspan="4">Contact on: +91 90282 94344 Or Mail on: info@radiancelpg.in</td></tr>
            <tr>
                <td rowspan="2" style="width:40%;">
					@if($profile['logoPath'] != null)
						<img src="{{asset('storage/swiftbilling/'.$profile['logoPath'])}}" height="100px" />
					@else
						{{-- <img src="{{asset('storage/swiftbilling/defaultLogo.png')}}" max-height="100px" /> --}}
					@endif
					<table class="no_border no_row_border">
						<tbody>
							<tr>
								<td colspan="2">From</td>
							</tr>
							<tr>
								<td colspan="2"><b>{{ $profile['businessName'] }}</b></td>
							</tr>
							<tr>
								<td colspan="2">{{$profile['address']}}</td>
							</tr>
							<tr>
								<td>GSTIN<br />State<br />PAN<br /><br /></td>
								<td><span class="t-up">{{$customer['gstin']}}</span><br /><span class="t-cap">{{$profile['placeOfOrigin']}}</span> (Source State)<br /><span class="t-up">{{$profile['panNumber']}}</span><br /></td>
							</tr>
						</tbody>
					</table>
                </td>
                <td colspan="2">
                    <div>
                        <table class="no_border no_row_border">
                            <tbody>
                                <tr class="triple_details">
                                    <td>Invoice No</td>
                                    <td>:</td>
                                    <td>{{$serialPrefix.$serialNumber}}</td>
                                </tr>
                                <tr>
                                    <td>Invoice Date</td>
                                    <td>:</td>
                                    <td>{{$issueDate}}</td>
                                </tr>
                                <tr>
                                    <td>Place Of Supply</td>
                                    <td>:</td>
                                    <td>{{$placeOfSupply}}</td>
                                </tr>
                                <tr>
                                    <td>Due Date</td>
                                    <td>:</td>
                                    <td>{{$dueDate}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </td>
            </tr>
            <!-- <tr>
                <td>
                    <div>
                        <table class=<img src="{{asset('img/RadianceLogo.jpg')}}" height="70px" />"no_border no_row_border">
                            <tbody>
								<tr class="triple_details">
									<td>Transporter Name</td>
									<td>:</td>
									<td></td>
								</tr>
								<tr>
									<td>GR/RW/AWB No.</td>
									<td>:</td>
									<td></td>
								</tr>
								<tr>
									<td>GR/RW/AWB Date<br /></td>
									<td>:</td>
									<td></td>
								</tr>
								<tr>
									<td>Vehicle No.</td>
									<td>:</td>
									<td></td>
								</tr>
								<tr>
									<td>Weight</td>
									<td>:</td>
									<td></td>
								</tr>
							</tbody>
                        </table>
                    </div>
                </td>
            </tr> -->
            <tr>
				<td style="width: 30%">
					<table class="no_border no_row_border">
						<tbody>
							<tr>
								<td>Bill To :</td>
							</tr>
							<tr>
								<td colspan="3">{{$customer['name']}}<br />{{$customer['billingAddress']}}<br /></td>
							</tr>
							<tr class="">
								<td>GSTIN:</td>
								<td><span class="t-up">{{$customer['gstin']}}</span></td>
							</tr>
						</tbody>
					</table>
				</td>
				<td class="v_top">
					<table class="no_border no_row_border">
						<tbody>
							<tr>
								<td>Ship To :</td>
							</tr>
							<tr>
								<td colspan="3">{{$customer['name']}}<br />{{$customer['shippingAddress']}}<br /></td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
        </tbody>
    </table>
       
    <table class="pricing_table">
        <thead>
            <tr class="pricing_thr">
                <th>S. No.</th>
                <th>Description</th>
                <th>HSN/SAC</th>
                <th>Qty. Unit</th>
                <th>Rate /Unit<br />&#8377;</th>
				<th>Disc.<br/ >
					@if ($discountType === 'discountrate')
						%
					@else
						Rs.
					@endif
				</th>
                <th>Taxable Value</th>
                <!-- <th class="igst">IGST<br />&#8377;(%)</th> -->
                <th class="cgst">CGST<br />&#8377;(%)</th>
                <th class="sgst">SGST<br />&#8377;(%)</th>
                <!-- <th class="cess">CESS<br />&#8377;(%)</th> -->
                <th>Total Amount<br />&#8377;</th>
            </tr>
        </thead>
        <tbody>
			@foreach($product as $prod)
				<tr class="product_row">
					<td>{{$prod['invoiceSerial']}}</td>
					<td>{{$prod['description']}}</td>
					<td>{{$prod['hsn']}}</td>
					<td>{{$prod['quantity']}} {{$prod['unit']}}</td>
					<td>{{$prod['saleValue']}}</td>
					<td>@if ($discountType === 'discountrate')
							{{$prod['discountRate']}}</td>
						@else
							{{$prod['discountValue']}}</td>
						@endif
					<td>{{$prod['taxableValue']}}</td>
					<!-- <td>{{$prod['igstValue']}}<br />({{$prod['igstRate']}})</td> -->
					<td>{{$prod['cgstValue']}}<br />({{$prod['cgstRate']}})</td>
					<td>{{$prod['sgstValue']}}<br />({{$prod['sgstRate']}})</td>
					<!-- <td>{{$prod['cessValue']}}<br />({{$prod['cessRate']}})</td> -->
					<td>{{$prod['grossValue']}}</td>
				</tr> 
			@endforeach
			<tr><td colspan="10";height="10px"></td></tr>
            
            <tr class="total_row">
                <td colspan="6">Total</td>
                <td>{{$totalTaxableValue}}</td>
                <!-- <td>{{$totalIgstValue}}</td> -->
                <td>{{$totalCgstValue}}</td>
                <td>{{$totalSgstValue}}</td>
                <!-- <td>{{$totalCessValue}}</td> -->
                <td>{{$netValue}}</td>
            </tr>
            <tr class="bank_details_row">
				<td colspan="7" rowspan="3">
					<table class="bank_details no_border no_row_border">
						<tbody>
							<tr>
								<td class="bank_details_heading" colspan="2">Bank Details</td>
							</tr>
							<tr>
								<td class="bank_details_cell1">
									<table class="no_border no_row_border ">
										<tbody>
											<tr class="triple_details">
												<td>Account No.</td>
												<td>:</td>
												<td class="bank_account">{{$profile['bankAccount']}}</td>
											</tr>
											<tr>
												<td>Bank Name</td>
												<td>:</td>
												<td class="bank_name">{{$profile['bankName']}}</td>
											</tr>
										</tbody>
									</table>
								</td>
								<td class="bank_details_cell2">
									<table class="no_border no_row_border">
										<tbody>
											<tr class="triple_details">
												<td>IFSC Code</td>
												<td>:</td>
												<td class="bank_ifsc">{{$profile['bankIfsc']}}</td>
											</tr>
											<tr>
												<td>Branch</td>
												<td>:</td>
												<td class="bank_branch">{{$profile['bankBranch']}}</td>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
						</tbody>
					</table>
				</td>
				<td class="total total_taxable" colspan="2">Taxable Amount &#8377;</td>
				<td class="total_val total_taxable_val">{{$totalTaxableValue}}</td>
			</tr>
			<tr class="total_tax_row">
				<td class="total total_tax" colspan="2">Total Taxes &#8377;</td>
				<td class="total_val total_tax_val">{{$totalIgstValue + $totalCgstValue + $totalSgstValue + $totalCessValue}}
			</tr>
			<tr class="total_round_off_row">
				<td class="total total_round_off" colspan="2">Rounding Off &#8377;</td>
				<td class="total_val total_round_off_val">{{$roundOffValue}}</td>
			</tr>
			<tr class="amount_in_words_row">
				<td class="amount_in_words" colspan="2">Total Amount (in words) </td>
				<td class="amount_in_words_val" colspan="5"><b>{{$amountInWords}}</b></td>
				<td class="net_amount" colspan="2">Net Amount &#8377;</td>
				<td class="net_amount_val" colspan="1"><b>{{$grandValue}}</b></td>
			</tr>
        </tbody>
    </table>
    
    <table class="notes_table">
        <tbody>
			<tr>
				<td>
					<table class="no_border no_row_border">
						<tbody><!-- 
							<tr>
								<td class="notes_heading">Notes</td>
							</tr> -->
							<tr>
								<td class="notes_content"><ol type="1">
									{!!nl2br($invoice['invoiceNotes'])!!}
								</ol></td>
							</tr>
							<tr>
								<td class="tc_heading">Terms &amp; Conditions</td>
							</tr>
							<tr>
								<td class="tc_content">
									<ol type="1">
									<li>All disputes will be subject to the juridiction of courts of Pune.</li>
									<li>Title and rish in the goods will be pass to the buyerat the plant/Terminal gate.</li>
									<li>Acceptance of the invoice by the driver or representative of the buyer is the conclusive proof of delivery of goods to the buyer.</li>
									<li>Interest @24% Per annum will be charged if the payment is not made within the due date.</li>
									<li>Goods once sold cannot be returned or replaced.</li>
									<li>LPG supplied under 2.5% CGST & 2.5% SGST/ 5% IGST for supply to household domestic customers. For Commercial customers its 9% CGST & 9%SGST/18%IGST only and itshallbe the responsibility of Distributor to Ensure the same.</li>
									</ol>
								</td>
							</tr>
						</tbody>
					</table>
				</td>
				<td class=" ">
					
					<table class="sign no_border no_row_border">
						<tbody >
							<tr>
								<td style="padding-bottom: 18%;">For {{ $profile['businessName'] }}</td>
							</tr>
							<tr>
								<td class="sign_signline">_____________________________</td>
							</tr>
							<tr>
								<td class="sign_designation">Authorized Signatory</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
		</tbody>
    </table>
    
</div>
	
</body>

</html>