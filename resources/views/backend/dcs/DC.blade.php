<!doctype html>
<html lang="en">
<head>
	<title>DC {{$serialPrefix.$serialNumber}} {{ucfirst($copy)}}</title>
	<link href="{{ asset('/css/dcTemplate/template1.css') }}" rel="stylesheet">
</head>
<body class="template_2">
	<htmlpageheader name="dcHeader">
		<div id="top_header">
			@if($dcStatus === 'quote')
				Quotation
			@else
				<img src="{{asset('img/RadianceLogo.jpg')}}" height="12%" />
			@endif
		</div>
	</htmlpageheader>
	<htmlpagefooter name="dcFooter">
		Page {PAGENO} of {nbpg}
	</htmlpagefooter>
	<div>
	    <table class="intro_info no_border">
	        <tbody>			
				<tr class="dc_for_row no_border">
					@if($dcStatus != 'quote')
						@if($copy === 'original')
							<td class="dc_for" colspan="4" ><img src="{{asset('img/invoice/Original.png')}}" height="50px" /></td>
						@elseif($copy === 'DC')
							<td class="dc_for" colspan="4"><img src="{{asset('img/invoice/DC.png')}}" height="50px" /></td>
						@elseif($copy === 'triplicate')
							<td class="dc_for" colspan="4"><img src="{{asset('img/invoice/Triplicate.png')}}" height="50px" /></td>
						@endif
					@else
						<td class="dc_for" colspan="2"><img src="{{asset('img/invoice/Blank.png')}}" height="50px" /></td>
					@endif
				</tr>
				<tr class="dc_for_row no_border " >
					<td style="text-align: center; padding-bottom:0px;padding-top:15px;" colspan="4">{{$profile['address']}}</td>
				</tr>
				<tr class="dc_for_row no_border ">
					<td style="text-align: center;padding-bottom:10px;" colspan="4">Contact on: +91 99218 90622 Or Mail on: tukaramnagargoje@gmail.com</td>
				</tr>
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
									<td><span class="t-up">{{$profile['gstin']}}</span><br /><span class="t-cap">{{$profile['placeOfOrigin']}}</span> (Source State)<br /><span class="t-up">{{$profile['panNumber']}}</span><br /></td>
								</tr>
							</tbody>
						</table>
	                </td>
	                <td colspan="2">
	                    <div>
	                        <table class="no_border no_row_border">
	                            <tbody>
	                                <tr class="triple_details">
	                                    <td>Challan No</td>
	                                    <td>:</td>
	                                    <td><b>{{$serialPrefix.$serialNumber}}</b></td>
	                                </tr>
	                                <tr>
	                                    <td>Delivery Date</td>
	                                    <td>:</td>
	                                    <td>{{$issueDate}}</td>
	                                </tr>
	                                <tr>
	                                    <td>Place Of Supply</td>
	                                    <td>:</td>
	                                    <td><b>{{$placeOfSupply}}</b></td>
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
									<td colspan="3"><b>{{$customer['name']}}<br />{{$customer['billingAddress']}}<br /></b></td>
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
	                <th>Sr.No.</th>
	                <th>DC No.</th>
	                <th>DC Date</th>
	                <th>Description</th>
	                <th>Qty</th>
	                <th>Unit</th>
	                <th>Vehicle No.</th>
	            </tr>
	        </thead>
	        <tbody>
				@foreach($product as $prod)
					<tr class="product_row">
						<td>{{$prod['dcSerial']}}</td>
						<td>{{$prod['dcNo']}}</td>
						<td>{{$prod['dcDate']}}</td>
						<td>{{$prod['description']}}</td>
						<td>{{$prod['quantity']}}</td>
						<td>{{$prod['unit']}}</td>
						<td>{{$prod['vehicleNo']}}</td>
					</tr> 
				@endforeach
				@php
				if(count($product)>8)  $height = 200;
				if(count($product)==8) $height = 220;
				if(count($product)==7) $height = 240;
				if(count($product)==6) $height = 260;
				if(count($product)==5) $height = 280;
				if(count($product)==4) $height = 300;
				if(count($product)==3) $height = 320;
				if(count($product)==2) $height = 340;
				if(count($product)==1) $height = 360;
				if(count($product)<1) $height = 360;
				@endphp
	            <tr class="product_row">
	            	<td height="{{$height}}px"></td>
	            	<td></td>
	            	<td></td>
	            	<td></td>
	            	<td></td>
	            	<td></td>
	            	<td></td>
	            </tr>
	            <tr class="">
	            	<td height="40px" colspan="2" class="v_bottom">
	            		Reciever's Sign
	            	</td>
	            	<td colspan="3" class="v_bottom">
	            		Common Seal
	            	</td>
	            	<td colspan="2">
	            		<table class="sign no_border no_row_border">
							<tbody >
	            				<tr>
									<td style="padding-bottom: 10%;">For {{ $profile['businessName'] }}</td>
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