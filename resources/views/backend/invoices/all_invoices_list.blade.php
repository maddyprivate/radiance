@extends('layouts.backend')

@section('content')

<section>
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header d-flex align-items-center">
						<div class="col-6">
							<h3 class="h4">@lang('laryl-invoices.heading.list')</h3>
						</div>
						<div class="col-6 text-right">
							<a href="{{ route('Invoices.invoices.create')  }}" class="bttn-plain">
								<i class="fas fa-file-invoice"></i>&emsp;@lang('laryl-invoices.buttons.create-new')
							</a>
						</div>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table" id="invoiceTable">
								<thead>
									<tr>
										<th> @lang('laryl-invoices.table.#') </th>
										<th> @lang('laryl-invoices.table.invoiceNo') </th>
										<th> @lang('laryl-invoices.table.issueDate') </th>
										<th> @lang('laryl-invoices.table.customer') </th>
										<th> @lang('laryl-invoices.table.invoiceStatus') </th>
										<th> @lang('laryl-invoices.table.grandValue') </th>
										<th> @lang('laryl-invoices.table.pendingBalance') </th>
										<th> @lang('laryl-invoices.table.options') </th>
									</tr>
								</thead>
								<tbody>
									@php
										$invoice_array = $invoices->toArray();
										$i = 1;
									@endphp

									@if(count($invoices) > 0)

										@foreach($invoices as $invoice)
											<tr>
												<th class="scope-row">{{$i}}</th>
												<td class="t-up">{{$invoice['serialPrefix']}}{{$invoice['serialNumber']}}</td>
												<td class="t-cap">{{date('d/m/Y', strtotime($invoice['issueDate']))}}</td>
												<td class="t-up">{{$invoice['customer']['name']}}</td>
												<td class="t-up">{{$invoice['invoiceStatus']}}</td>
												<td class="t-cap">Rs. {{$invoice['grandValue']}}</td>
												<td class="t-cap">Rs. {{$invoice['pendingBalance']}}</td>
												<td>

														<a class="btn btn-sm btn-success mb-2 mb-sm-0" href="{{ route('Invoices.invoices.show', $invoice['id'])  }}" data-toggle="tooltip" title="@lang('laryl.tooltips.show')">
															@lang('laryl.buttons.show')
														</a>

														<a class="btn btn-sm btn-warning mb-2 mb-sm-0" href="{{ route('Invoices.invoices.edit', $invoice['id'])  }}" data-toggle="tooltip" title="@lang('laryl.tooltips.edit')">
															@lang('laryl.buttons.edit')
														</a>
														<a class="btn btn-sm btn-primary mb-2 mb-sm-0 cls_invoicePayment_btn" data-remodal-target="invoicePayment" href="javascript:;" data-pendingBalance="{{$invoice['pendingBalance']}}" data-invoiceNumber="{{$invoice['serialPrefix']}}{{$invoice['serialNumber']}}" data-id="{{$invoice['id']}}" title="@lang('laryl.tooltips.payment')" >
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

						<div class="row mt-2">
							<div class="col-md-2">
								<a href="{{url('invoices')}}" class="btn btn-sm btn-primary"> List Page wise</a>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<div class="remodal" data-remodal-id="invoicePayment" aria-labelledby="modalTitle" aria-describedby="modalDesc" data-remodal-options="hashTracking: false, closeOnOutsideClick: false">
	<button data-remodal-action="close" class="remodal-close" aria-label="Close"></button>
	<div>
		<h2 id="modalTitle">Invoice Payment : <span id="invoiceNumber"></span></h2>
		<form id="invoicePayment_form" method="post" action="{{url('payInvoiceBalance')}}" onsubmit="return checkPaymentAmount()">
			@csrf
			<div class="form-group row align-items-center">
				<label class="col-sm-5 col-form-label">Invoice Balance</label>
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
					<input name="invoicePayment" id="invoicePayment" type="text" class="form-control">
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
<div class="remodal" data-remodal-id="invoiceStatusChange" aria-labelledby="modalTitle" aria-describedby="modalDesc" data-remodal-options="hashTracking: false, closeOnOutsideClick: false">
	<button data-remodal-action="close" class="remodal-close" aria-label="Close"></button>
	<div>
		<form id="invoiceStatusChange_form" method="post" action="{{url('changeInvoiceStatus')}}">
			@csrf
			<div class="form-group row align-items-center">
				<label for="invoiceStatus" class="col-md-5 col-form-label">Change to @lang('laryl-invoices.form.label.invoiceStatus')</label>
				<div class="col-sm-7">
					<div class="col-md-12">
						<select id="invoiceStatus" name="invoiceStatus" class="form-control">
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
		$('#invoiceTable').DataTable( {
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
		/*$('#transTable').DataTable({
			initComplete: function () {
				this.api().columns().every( function () {
					var column = this;
					var select = $('<select><option value=""></option></select>')
					.appendTo( $(column.footer()).empty() )
					.on( 'change', function () {
						var val = $.fn.dataTable.util.escapeRegex(
							$(this).val()
							);
						
						column
						.search( val ? '^'+val+'$' : '', true, false )
						.draw();
					} );
					
					column.data().unique().sort().each( function ( d, j ) {
						select.append( '<option value="'+d+'">'+d+'</option>' )
					} );
				} );
			}
		});*/
	} );
</script>
@endsection