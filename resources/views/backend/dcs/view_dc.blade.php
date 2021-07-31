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
								<h3 class="h4">@lang('laryl-dcs.heading.show', ['dc'=> $dc->serialPrefix.$dc->serialNumber] )</h3>
							</div>
							<div class="col-12 col-sm-6 text-sm-right mt-3 mt-md-0">
								<span class="mb-2 my-md-0"><h5>Print Dc :</h5></span>
								<br class="d-none d-sm-inlineblock" />
								<a target='_blank' href="{{ route('PrintDc', [$dc->id, 'DC'])  }}" class="bttn-plain mx-3">
									<i class="fas fa-shipping-fast"></i>
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
									{{ $dc->profile['businessName'] }}.<br />
									{{$dc->profile['address']}}<br />
									<br />
									GSTIN : <span class="t-up">{{$dc->profile['gstin']}}</span> <br />
									State : <span class="t-cap">{{$dc->profile['placeOfOrigin']}}</span> <br />
									PAN : <span class="t-up">{{$dc->profile['panNumber']}}</span> <br />
								</div>
								<div class="col-md-4 my-3 my-md-0">
									Dc No : {{$dc->serialPrefix.$dc->serialNumber}} <br />
									Dc Date : {{$dc->issueDate}} <br />
									Reference No : <br />
									Place Of Supply : {{$dc->placeOfSupply}} <br />
									Due Date : {{$dc->dueDate}} <br />
									<br />
									Transporter Name :<br />
									GR/RW/AWB No. :<br />
									GR/RW/AWB Date :<br />
									Vehicle No. :<br />
									Weight :<br />
								</div>
								<div class="col-md-4 my-3 my-md-0">
									Bill To :<br />
									{{$dc->customer['name']}}<br />
									{{$dc->customer['billingAddress']}}<br />
									Customer GSTIN : {{$dc->customer['gstin']}}<br />
									<br />
									Ship To :<br />
									{{$dc->customer['name']}}<br />
									{{$dc->customer['shippingAddress']}}<br />
									Customer Mobile : {{$dc->customer['mobile']}}<br />
								</div>
							</div>
							<div class="row">
								<div class="col-12 my-5">
									<table class="table-responsive">
										<thead>
											<tr class="pricing_thr">
												<th>S. No.</th>
												<th>Description</th>
												<th>Qty. Unit</th>
												<th>DC No.</th>
												<th>DC Date</th>
												<th>Vehicle no.</th>
											</tr>
										</thead>
										<tbody>
											@foreach($dc->product as $prod)
												<tr class="product_row">
													<td>{{$prod['dcSerial']}}</td>
													<td>{{$prod['description']}}</td>
													<td>{{$prod['quantity']}} {{$prod['unit']}}</td>
													<td>{{$prod['dcNo']}}</td>
													<td>{{$prod['dcDate']}}</td>
													<td>{{$prod['vehicleNo']}}</td>
												</tr> 
											@endforeach									
										</tbody>
									</table>
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