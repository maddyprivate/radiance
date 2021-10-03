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
							<table class="table" id="purchaseTable">
								<thead>
									<tr>
										<th> @lang('laryl-purchases.table.#') </th>
										<th> @lang('laryl-purchases.table.issueDate') </th>
										<!-- <th> @lang('laryl-purchases.table.dueDate') </th> -->
										<th> @lang('laryl-purchases.table.customer') </th>
										<th> @lang('laryl-purchases.table.purchaseStatus') </th>
										<th> @lang('laryl-purchases.table.grandValue') </th>
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
												<!-- <td class="t-up">{{date('d/m/Y', strtotime($purchase['dueDate']))}}</td> -->
												<td class="t-up">{{$purchase['customer']['name']}}</td>
												<td class="t-up">{{$purchase['purchaseStatus']}}</td>
												<td class="t-cap">Rs. {{$purchase['grandValue']}}</td>
												<td>

														<a class="btn btn-sm btn-success mb-2 mb-sm-0" href="{{ route('Purchases.purchases.show', $purchase['id'])  }}" data-toggle="tooltip" title="@lang('laryl.tooltips.show')">
															@lang('laryl.buttons.show')
														</a>

														<a class="btn btn-sm btn-warning mb-2 mb-sm-0" href="{{ route('Purchases.purchases.edit', $purchase['id'])  }}" data-toggle="tooltip" title="@lang('laryl.tooltips.edit')">
															@lang('laryl.buttons.edit')
														</a>
														<a class="btn btn-sm btn-primary mb-2 mb-sm-0" data-remodal-target="purchaseStatusChange" href="javascript:;"  title="@lang('laryl.tooltips.payment')" onclick="$('#purchaseStatusChange').val('{{$purchase['purchaseStatus']}}');$('#id').val('{{$purchase['id']}}');">
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
								<a href="{{url('purchases')}}" class="btn btn-sm btn-primary"> List Page wise</a>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
</section>
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