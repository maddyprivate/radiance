@extends('layouts.backend')

@section('content')

<section>
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header d-flex align-items-center">
						<div class="col-6">
							<h3 class="h4">@lang('laryl-contacts.heading.list')</h3>
						</div>
						<div class="col-6 text-right">
							<a href="{{ route('Contacts.contacts.create')  }}" class="bttn-plain">
								<i class="fa fa-user-plus"></i>&emsp;@lang('laryl-contacts.buttons.create-new')
							</a>
						</div>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table">
								<thead>
									<tr>
										<th> @lang('laryl-contacts.table.serial') </th>
										<th> @lang('laryl-contacts.table.name') </th>
										<th> @lang('laryl-contacts.table.pan') </th>
										<th> @lang('laryl-contacts.table.mobile') </th>
										<th> @lang('laryl-contacts.table.state') </th>
										<th> @lang('laryl-contacts.table.gstin') </th>
										<th> @lang('laryl-contacts.table.outstandingBal') </th>
										<th> @lang('laryl-contacts.table.options') </th>
									</tr>
								</thead>
								<tbody>
									@php
										$contact_array = $contacts->toArray();
										$i = $contact_array['from'];
									@endphp

									@if(count($contacts) > 0)

										@foreach($contacts as $contact)
											<tr>
												<th class="scope-row">{{$i}}</th>
												<td class="t-cap">{{$contact['name']}}</td>
												<td class="t-up">{{$contact['pan']}}</td>
												<td class="t-up">{{$contact['mobile']}}</td>
												<td class="t-cap">{{$contact['state']}}</td>
												<td class="t-up">{{$contact['gstin']}}</td>
												<td class="t-up">{{$contact['outstandingBalance']}}</td>
												<td>

														<a class="btn btn-sm btn-success mb-2 mb-sm-0" href="{{ route('Contacts.contacts.show', $contact['id'])  }}" data-toggle="tooltip" title="@lang('laryl.tooltips.show')">
															@lang('laryl.buttons.show')
														</a>

														<a class="btn btn-sm btn-warning mb-2 mb-sm-0" href="{{ route('Contacts.contacts.edit', $contact['id'])  }}" data-toggle="tooltip" title="@lang('laryl.tooltips.edit')">
															@lang('laryl.buttons.edit')
														</a>
														
														<a class="btn btn-sm btn-primary mb-2 mb-sm-0" data-remodal-target="outstandingPayment" href="javascript:;"  title="@lang('laryl.tooltips.payment')" onclick="$('#outstandingBalance').val('{{$contact['outstandingBalance']}}');$('#id').val('{{$contact['id']}}');">
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

						<div class="row">
							<div class="col d-none d-sm-block">
								{{ $contacts->render() }}
							</div>

							<div class="col d-sm-none">
								{{ $contacts->links('pagination::simple-bootstrap-4') }}
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<div class="remodal" data-remodal-id="outstandingPayment" aria-labelledby="modalTitle" aria-describedby="modalDesc" data-remodal-options="hashTracking: false, closeOnOutsideClick: false">
	<button data-remodal-action="close" class="remodal-close" aria-label="Close"></button>
	<div>
		<h2 id="modalTitle">Outstanding Payemnt</h2>
		<form id="outstandingPayment_form" method="post" action="{{url('payOutstandingBalance')}}">
			@csrf
			<div class="form-group row align-items-center">
				<label class="col-sm-5 col-form-label">Outstanding Balance</label>
				<div class="col-sm-7">
					<input name="id" id="id" type="hidden" class="form-control" >
					<input name="outstandingBalance" id="outstandingBalance" type="text" class="form-control" readonly="">
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
				<label for="description" class="col-md-5 col-form-label">@lang('laryl-deposits.form.label.description')</label>

				<div class="col-md-7">
					<input id="description" type="text" class="form-control	" name="description" value="{{ old('description') }}" maxlength="15" >
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
					<input name="outstandingPayment" id="outstandingPayment" type="text" class="form-control">
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
@endsection