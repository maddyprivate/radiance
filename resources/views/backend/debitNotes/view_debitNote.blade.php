@extends('layouts.backend')

@section('content')

<section>
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header d-flex container-fluid">
						<div class="row  align-items-center" style="width: 100%;">
							<div class="col-12 col-sm-6">
								<h3 class="h4">@lang('laryl-debitNotes.heading.show', ['debitNote'=> $debitNote->serialPrefix.$debitNote->serialNumber] )</h3>
							</div>
							<div class="col-12 col-sm-6 text-sm-right mt-3 mt-md-0">
								<span class="mb-2 my-md-0"><h5>Print DebitNote :</h5></span>
								<br class="d-none d-sm-inlineblock" />
								<a target='_blank' href="{{ route('PrintDebitNote', [$debitNote->id, 'original'])  }}" class="bttn-plain mx-3">
									<i class="fas fa-shopping-cart"></i>
								</a>
								<a target='_blank' href="{{ route('PrintDebitNote', [$debitNote->id, 'DC'])  }}" class="bttn-plain mx-3">
									<i class="fas fa-shipping-fast"></i>
								</a>
								<a target='_blank' href="{{ route('PrintDebitNote', [$debitNote->id, 'triplicate'])  }}" class="bttn-plain mx-3">
									<i class="fas fa-industry"></i>
								</a>
							</div>
						</div>
					</div>
					<div class="card-body">
						
						<div class="container">
							<div class="row">
								<div class="col-md-4 my-3 my-md-0">
									From : <br />
									<br />
									{{ $debitNote->profile['businessName'] }}.<br />
									{{$debitNote->profile['address']}}<br />
									<br />
									GSTIN : <span class="t-up">{{$debitNote->profile['gstin']}}</span> <br />
									State : <span class="t-cap">{{$debitNote->profile['placeOfOrigin']}}</span> <br />
									PAN : <span class="t-up">{{$debitNote->profile['panNumber']}}</span> <br />
								</div>
								<div class="col-md-4 my-3 my-md-0">
									DebitNote No : {{$debitNote->serialPrefix.$debitNote->serialNumber}} <br />
									DebitNote Date : {{dmyDate($debitNote->issueDate)}} <br />
									Reference No : <br />
									Place Of Supply : {{$debitNote->placeOfSupply}} <br />
									<!-- Due Date : {{$debitNote->dueDate}} <br /> -->
									<br />
									Transporter Name :<br />
									GR/RW/AWB No. :<br />
									GR/RW/AWB Date :<br />
									Vehicle No. :<br />
									Weight :<br />
								</div>
								<div class="col-md-4 my-3 my-md-0">
									Bill To :<br />
									{{$debitNote->dealer['name']}}<br />
									{{$debitNote->dealer['billingAddress']}}<br />
									Customer GSTIN : {{$debitNote->dealer['gstin']}}<br />
									<br />
									Ship To :<br />
									{{$debitNote->dealer['name']}}<br />
									{{$debitNote->dealer['shippingAddress']}}<br />
									Customer Mobile : {{$debitNote->dealer['mobile']}}<br />
								</div>
							</div>
							<div class="row">
								<div class="col-12 my-5">
									<table class="table-responsive">
										<thead>
											<tr class="pricing_thr">
												<th>S. No.</th>
												<th>Description</th>
												<th>HSN/SAC</th>
												<th>Qty. Unit</th>
												<th>Rate /Unit<br />&#8377;</th>
												<th>Disc.<br/ >
													@if ($debitNote->discountType === 'discountrate')
														%
													@else
														Rs.
													@endif
												</th>
												<th>Taxable Value</th>
												<th class="igst">IGST<br />&#8377;(%)</th>
												<th class="cgst">CGST<br />&#8377;(%)</th>
												<th class="sgst">SGST<br />&#8377;(%)</th>
												<th class="cess">CESS<br />&#8377;(%)</th>
												<th>Total Amount<br />&#8377;</th>
											</tr>
										</thead>
										<tbody>
											@foreach($debitNote->product as $prod)
												<tr class="product_row">
													<td>{{$prod['invoiceSerial']}}</td>
													<td>{{$prod['description']}}</td>
													<td>{{$prod['hsn']}}</td>
													<td>{{$prod['quantity']}} {{$prod['unit']}}</td>
													<td>{{$prod['saleValue']}}</td>
													<td>@if ($debitNote->discountType === 'discountrate')
															{{$prod['discountRate']}}</td>
														@else
															{{$prod['discountValue']}}</td>
														@endif
													<td>{{$prod['taxableValue']}}</td>
													<td>{{$prod['igstValue']}}<br />({{$prod['igstRate']}})</td>
													<td>{{$prod['cgstValue']}}<br />({{$prod['cgstRate']}})</td>
													<td>{{$prod['sgstValue']}}<br />({{$prod['sgstRate']}})</td>
													<td>{{$prod['cessValue']}}<br />({{$prod['cessRate']}})</td>
													<td>{{$prod['grossValue']}}</td>
												</tr> 
											@endforeach
											
											<tr class="total_row">
												<td colspan="6">Total</td>
												<td>{{$debitNote->totalTaxableValue}}</td>
												<td>{{$debitNote->totalIgstValue}}</td>
												<td>{{$debitNote->totalCgstValue}}</td>
												<td>{{$debitNote->totalSgstValue}}</td>
												<td>{{$debitNote->totalCessValue}}</td>
												<td>{{$debitNote->netValue}}</td>
											</tr>											
										</tbody>
									</table>
								</div>

								<div class="col-md-4 my-3">
									Bank Details<br />
									<br />
									Account No. : {{$debitNote->profile['bankAccount']}}<br />
									Bank Name : {{$debitNote->profile['bankName']}}<br />
									IFSC Code : {{$debitNote->profile['bankIfsc']}}<br />
									Branch : {{$debitNote->profile['bankBranch']}}<br />
								</div>
								<div class="col-md-4 my-3">
										Totals<br />
										<br />
										Taxable Amount : &#8377;.{{$debitNote->totalTaxableValue}}<br />
										Total Taxes : &#8377;.{{$debitNote->totalIgstValue + $debitNote->totalCgstValue + $debitNote->totalSgstValue + $debitNote->totalCessValue}}<br />
										Rounding Off : &#8377;.{{$debitNote->roundOffValue}}<br />
										Net Amount : &#8377;.{{$debitNote->grandValue}}<br />
								</div>
								<div class="col-12 my-3">
									Total Amount (in words) : {{$debitNote->amountInWords}}<br />
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
</section>

@endsection