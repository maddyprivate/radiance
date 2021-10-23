@extends('layouts.backend')

@section('content')

<section>
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header d-flex align-items-center">
						<div class="col-6">
							<h3 class="h4">@lang('laryl-debitNotes.heading.list')</h3>
						</div>
						<div class="col-6 text-right">
							<a href="{{ route('DebitNotes.debitNotes.create')  }}" class="bttn-plain">
								<i class="fas fa-file-debitNote"></i>&emsp;@lang('laryl-debitNotes.buttons.create-new')
							</a>
						</div>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table" id="debitNoteTable">
								<thead>
									<tr>
										<th> @lang('laryl-debitNotes.table.#') </th>
										<th> @lang('laryl-debitNotes.table.debitNoteNo') </th>
										<th> @lang('laryl-debitNotes.table.issueDate') </th>
										<th> @lang('laryl-debitNotes.table.dealer') </th>
										<th> @lang('laryl-debitNotes.table.debitNoteStatus') </th>
										<th> @lang('laryl-debitNotes.table.grandValue') </th>
										<th> @lang('laryl-debitNotes.table.pendingBalance') </th>
										<th> @lang('laryl-debitNotes.table.options') </th>
									</tr>
								</thead>
								<tbody>
									@php
										$debitNote_array = $debitNotes->toArray();
										$i = $debitNote_array['from'];
									@endphp

									@if(count($debitNotes) > 0)

										@foreach($debitNotes as $debitNote)
											<tr>
												<th class="scope-row">{{$i}}</th>
												<td class="t-up">{{$debitNote['serialPrefix']}}{{$debitNote['serialNumber']}}</td>
												<td class="t-cap">{{date('d/m/Y', strtotime($debitNote['issueDate']))}}</td>
												<td class="t-up">{{$debitNote['dealer']['name']}}</td>
												<td class="t-up">{{$debitNote['debitNoteStatus']}}</td>
												<td class="t-cap">Rs. {{$debitNote['grandValue']}}</td>
												<td class="t-cap">Rs. {{$debitNote['pendingBalance']}}</td>
												<td>

														<a class="btn btn-sm btn-success mb-2 mb-sm-0" href="{{ route('DebitNotes.debitNotes.show', $debitNote['id'])  }}" data-toggle="tooltip" title="@lang('laryl.tooltips.show')">
															@lang('laryl.buttons.show')
														</a>

														<a class="btn btn-sm btn-warning mb-2 mb-sm-0" href="{{ route('DebitNotes.debitNotes.edit', $debitNote['id'])  }}" data-toggle="tooltip" title="@lang('laryl.tooltips.edit')">
															@lang('laryl.buttons.edit')
														</a>
														<!-- <a class="btn btn-sm btn-primary mb-2 mb-sm-0 cls_debitNotePayment_btn" data-remodal-target="debitNotePayment" href="javascript:;" data-pendingBalance="{{$debitNote['pendingBalance']}}" data-debitNoteNumber="{{$debitNote['serialPrefix']}}{{$debitNote['serialNumber']}}" data-id="{{$debitNote['id']}}" title="@lang('laryl.tooltips.payment')" >
															@lang('laryl.buttons.payment')
														</a> -->
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
							<div class="col-md-10">
								<div class="col d-none d-sm-block">
									{{ $debitNotes->render() }}
								</div>

								<div class="col d-sm-none">
									{{ $debitNotes->links('pagination::simple-bootstrap-4') }}
								</div>
							</div>
							<div class="col-md-2">
								<a href="{{url('view-all-debitNotes')}}" class="btn btn-sm btn-primary"> View All</a>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<div class="remodal" data-remodal-id="debitNotePayment" aria-labelledby="modalTitle" aria-describedby="modalDesc" data-remodal-options="hashTracking: false, closeOnOutsideClick: false">
	<button data-remodal-action="close" class="remodal-close" aria-label="Close"></button>
	<div>
		<h2 id="modalTitle">DebitNote Payment : <span id="debitNoteNumber"></span></h2>
		<form id="debitNotePayment_form" method="post" action="{{url('payDebitNoteBalance')}}" onsubmit="return checkPaymentAmount()">
			@csrf
			<div class="form-group row align-items-center">
				<label class="col-sm-5 col-form-label">DebitNote Balance</label>
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
					<input name="debitNotePayment" id="debitNotePayment" type="text" class="form-control">
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
<div class="remodal" data-remodal-id="debitNoteStatusChange" aria-labelledby="modalTitle" aria-describedby="modalDesc" data-remodal-options="hashTracking: false, closeOnOutsideClick: false">
	<button data-remodal-action="close" class="remodal-close" aria-label="Close"></button>
	<div>
		<form id="debitNoteStatusChange_form" method="post" action="{{url('changeDebitNoteStatus')}}" >
			@csrf
			<div class="form-group row align-items-center">
				<label for="debitNoteStatus" class="col-md-5 col-form-label">Change to @lang('laryl-debitNotes.form.label.debitNoteStatus')</label>
				<div class="col-sm-7">
					<div class="col-md-12">
						<select id="debitNoteStatus" name="debitNoteStatus" class="form-control">
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
	function checkPaymentAmount() { 
			var pendingBalance = $('#pendingBalance').val();
			var debitNotePayment = $('#debitNotePayment').val();
			console.log(pendingBalance,debitNotePayment,debitNotePayment > pendingBalance,pendingBalance > debitNotePayment);
			if(parseFloat(debitNotePayment) > parseFloat(pendingBalance)){
				alert('Your payment exceed pending balance, Please enter valid amount.');
				return false;
			}
			return true;
		}
	$(document).ready(function() {
		$('#debitNoteTable').DataTable( {
			dom: 'Bfrtip',
			paging: false,
			info: false,
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
		$('.cls_debitNotePayment_btn').on('click', function(e){
			var pendingBalance = $(this).attr('data-pendingBalance');
			var id = $(this).attr('data-id');
			var debitNoteNumber = $(this).attr('data-debitNoteNumber');
			// alert(pendingBalance);
			$('#pendingBalance').val(pendingBalance);
			$('#debitNotePayment').val(pendingBalance);
			$('#debitNoteNumber').html(debitNoteNumber);
			$('#id').val(id);
		});
		
	} );
</script>
@endsection