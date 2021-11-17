@extends('layouts.backend')

@section('content')

<section>
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header d-flex align-items-center">
						<div class="col-6">
							<h3 class="h4">@lang('laryl-purchases.heading.list')</h3>
						</div>
						<div class="col-6 text-right">
							<a href="{{ route('Purchases.purchases.create')  }}" class="bttn-plain">
								<i class="fas fa-file-purchase"></i>&emsp;@lang('laryl-purchases.buttons.create-new')
							</a>
						</div>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<div class="table-responsive">
							<table class="table" id="purchaseTable">
								<thead>
									<tr>
										<th> @lang('laryl-purchases.table.#') </th>
										<th> @lang('laryl-purchases.table.issueDate') </th>
										<th> @lang('laryl-purchases.table.billNo') </th>
										<th> @lang('laryl-purchases.table.dealer') </th>
										<th> @lang('laryl-purchases.table.purchaseStatus') </th>
										<th> @lang('laryl-purchases.table.grandValue') </th>
										<th> @lang('laryl-invoices.table.pendingBalance') </th>
										<th> @lang('laryl-purchases.table.options') </th>
									</tr>
								</thead>
								<tbody>
									@php
										$purchase_array = $purchases->toArray();
										$i = 1;
									@endphp

									@if(count($purchases) > 0)

										@foreach($purchases as $purchase)
											<tr>
												<th class="scope-row">{{$i}}</th>
												<td class="t-cap">{{date('d/m/Y', strtotime($purchase['issueDate']))}}</td>
												<td class="t-up">{{$purchase['billNo']}}</td>
												<td class="t-up">{{$purchase['dealer']['name']}}</td>
												<td class="t-up">{{$purchase['purchaseStatus']}}</td>
												<td class="t-cap">Rs. {{$purchase['grandValue']}}</td>
												<td class="t-cap">Rs. {{$purchase['pendingBalance']}}</td>
												<td>

														<a class="btn btn-sm btn-success mb-2 mb-sm-0" href="{{ route('Purchases.purchases.show', $purchase['id'])  }}" data-toggle="tooltip" title="@lang('laryl.tooltips.show')">
															@lang('laryl.buttons.show')
														</a>

														<a class="btn btn-sm btn-warning mb-2 mb-sm-0" href="{{ route('Purchases.purchases.edit', $purchase['id'])  }}" data-toggle="tooltip" title="@lang('laryl.tooltips.edit')">
															@lang('laryl.buttons.edit')
														</a>
														<!-- <a class="btn btn-sm btn-primary mb-2 mb-sm-0" data-remodal-target="purchaseStatusChange" href="javascript:;"  title="@lang('laryl.tooltips.payment')" onclick="$('#purchaseStatusChange').val('{{$purchase['purchaseStatus']}}');$('#id').val('{{$purchase['id']}}');">
															@lang('laryl.buttons.payment')
														</a> -->
														<a class="btn btn-sm btn-primary mb-2 mb-sm-0 cls_purchasePayment_btn" data-remodal-target="purchasePayment" href="javascript:;" data-pendingBalance="{{$purchase['pendingBalance']}}" data-purchaseNumber="{{$purchase['serialPrefix']}}{{$purchase['serialNumber']}}" data-id="{{$purchase['id']}}" title="@lang('laryl.tooltips.payment')" >
															@lang('laryl.buttons.payment')
														</a>
												</td>
											</tr>

											@php $i++; @endphp
											
										@endforeach
										
									@else 
										
										<tr class="text-center">
											<td colspan="7">@lang('laryl.messages.no-records')</td>
										</tr>

									@endif
								</tbody>
							</table>
							
						{{-- table responsive --}}
						</div> 
						</div> 

						<div class="row mt-2">
							<div class="col-md-2">
								<a href="{{url('purchases')}}" class="btn btn-sm btn-primary"> List Page wise</a>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<div class="remodal" data-remodal-id="purchasePayment" aria-labelledby="modalTitle" aria-describedby="modalDesc" data-remodal-options="hashTracking: false, closeOnOutsideClick: false">
	<button data-remodal-action="close" class="remodal-close" aria-label="Close"></button>
	<div>
		<h2 id="modalTitle">Purchase Payment : <span id="purchaseNumber"></span></h2>
		<form id="purchasePayment_form" method="post" action="{{url('payPurchaseBalance')}}" onsubmit="return checkPaymentAmount()">
			@csrf
			<div class="form-group row align-items-center">
				<label class="col-sm-5 col-form-label">Purchase Balance</label>
				<div class="col-sm-7">
					<input name="id" id="id" type="hidden" class="form-control" >
					<input name="pendingBalance" id="pendingBalance" type="text" class="form-control" readonly="">
				</div>
			</div>
			<div class="form-group row align-items-center">
				<label for="account_id" class="col-md-5 col-form-label">@lang('laryl-deposits.form.label.account_id')</label>

				<div class="col-md-7">
					<select id="account_id" name="account_id" class="form-control ">
						<option value="">Select Account</option>
						@foreach($accounts as $key=>$value)
						<option value="{{$value->id}}">
							{{$value->accountName}}
						</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="form-group row align-items-center">
				<label class="col-sm-5 col-form-label">Payment Date</label>
				<div class="col-sm-7">
					<div id="paymentDate" data-name="paymentDate" class="bfh-datepicker" data-input="form-control" data-min="01-01-2000" data-max="today"  data-format="y-m-d" data-date="today">
					</div>
				</div>
			</div>
			<div class="form-group row align-items-center">
				<label for="description" class="col-md-5 col-form-label">@lang('laryl-deposits.form.label.description')</label>

				<div class="col-md-7">
					<textarea id="description" type="text" class="form-control	" name="description"></textarea>
				</div>
			</div>
			<div class="form-group row align-items-center">
				<label for="method" class="col-md-5 col-auto col-form-label">@lang('laryl-transfers.form.label.method')</label>

				<div class="col-md-7">
					<input id="method" type="text" class="form-control" name="method" value="{{ old('method') }}" autofocus>
				</div>
			</div>
			<div class="form-group row align-items-center">
				<label class="col-sm-5 col-form-label">Payment</label>
				<div class="col-sm-7">
					<input name="purchasePayment" id="purchasePayment" type="text" class="form-control">
				</div>
			</div>
			<div class="form-group row">
				<div class="col-auto ml-auto" style="text-align: left;">
					<button type="submit" class="btn btn-success">Pay</button>
					<button type="reset" data-remodal-action="cancel" class="btn btn-danger ml-auto">Close</button>
				</div>
			</div>
		</form>			
	</div>
</div>
<div class="remodal" data-remodal-id="purchaseStatusChange" aria-labelledby="modalTitle" aria-describedby="modalDesc" data-remodal-options="hashTracking: false, closeOnOutsideClick: false">
	<button data-remodal-action="close" class="remodal-close" aria-label="Close"></button>
	<div>
		<form id="purchaseStatusChange_form" method="post" action="{{url('changeInvoiceStatus')}}">
			@csrf
			<div class="form-group row align-items-center">
				<label for="purchaseStatus" class="col-md-5 col-form-label">Change to @lang('laryl-purchases.form.label.purchaseStatus')</label>
				<div class="col-sm-7">
					<div class="col-md-12">
						<select id="purchaseStatus" name="purchaseStatus" class="form-control">
							<option value="unpaid">Unpaid</option>
							<option value="partial">Partial</option>
							<option value="paid">Paid</option>
						</select>
						<input name="id" id="id" type="hidden" class="form-control" >
					</div>
				</div>
			</div>
			<div class="form-group row">
				<div class="col-auto ml-auto" style="text-align: left;">
					<button type="submit" class="btn btn-success">Change Status</button>
					<button type="reset" data-remodal-action="cancel" class="btn btn-danger ml-auto">Close</button>
				</div>
			</div>
		</form>			
	</div>
</div>
@endsection
@section('footer')
<script type="text/javascript">
	$(document).ready(function() {
		$('#purchaseTable').DataTable( {
			info: false,
			dom: 'Bfrtip',
			paging: false,
			buttons: [
			'copyHtml5',
			'excelHtml5',
			'csvHtml5',
			'pdfHtml5'
			]
		} );
	} );
</script>
@endsection