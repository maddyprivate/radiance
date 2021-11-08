@extends('layouts.backend')

@section('content')

<section>
	<div class="container-fluid" id="app">
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header d-flex align-items-center row no-gutters">
						<div class="col-6">
							<h3 class="h4">@lang('laryl-transfers.heading.new')</h3>
						</div>
						<div class="col-6 text-right">
							<a href="{{ route('Transfers.transfers.index')  }}" class="bttn-plain">
								@lang('laryl-transfers.buttons.back-to-transfers')
							</a>
						</div>
					</div>
					<div class="card-body">
						<div class="container">
							<div class="row">
								<div class="col-md-12 mx-auto">
									<form id="editTransferForm" method="POST" action="{{ route('Transfers.transfers.update',$transfer->id) }}">
										@method('PUT')
										@csrf
										<div class="form-group row">
											<div class="col-sm-4">
												<div class="row">
													<label for="date" class="col-md-12 col-form-label">@lang('laryl-transfers.form.label.date')</label>
							
													<div class="col-md-12">
														<div id="date" data-name="date" class="bfh-datepicker" data-input="form-control" data-min="01-01-2000" data-max="today"  data-format="y-m-d" data-date="{{ old('date') ? old('date') : $transfer->date }}">
														</div>
													</div>
				
													@if ($errors->has('date'))
														<span class="col-md-12 form-error-message">
															<small for="date">{{ $errors->first('date') }}</small>
														</span>
													@endif
												</div>
											</div>
											<div class="col-sm-4">
												<div class="row">
													<label for="fromAccountId" class="col-md-12 col-form-label">@lang('laryl-transfers.form.label.fromAccountId')</label>
							
													<div class="col-md-12">
														<select id="fromAccountId" name="fromAccountId" class="form-control ">
															<option value="">Select Account</option>
															@foreach($accounts as $key=>$value)
																<option {{ ( $transfer['fromAccountId'] == $value->id ) ? 'selected' : '' }} value="{{$value->id}}">
																	{{$value->accountName}}
																</option>
															@endforeach
														</select>
													</div>
				
													@if ($errors->has('fromAccountId'))
														<span class="col-md-12 form-error-message">
															<small for="fromAccountId">{{ $errors->first('fromAccountId') }}</small>
														</span>
													@endif
												</div>
											</div>
											<div class="col-sm-4">
												<div class="row">
													<label for="toAccount" class="col-md-12 col-form-label">@lang('laryl-transfers.form.label.toAccountId')</label>
							
													<div class="col-md-12">
														<input type="text" id="toAccount" name="toAccount" class="form-control " value="{{ old('toAccount') ? old('toAccount') : $transfer->toAccount }}" />
														<!-- <select id="toAccountId" name="toAccountId" class="form-control ">
															<option value="">Select Account</option>
															@foreach($accounts as $key=>$value)
																<option value="{{$value->id}}">
																	{{$value->accountName}}
																</option>
															@endforeach
														</select> -->
													</div>
				
													@if ($errors->has('toAccountId'))
														<span class="col-md-12 form-error-message">
															<small for="toAccountId">{{ $errors->first('toAccountId') }}</small>
														</span>
													@endif
												</div>
											</div>
										</div>
										<div class="form-group row">
											<div class="col-md-6">
												<div class="row">
													<div class="col-md-12">
														<div class="row">
															<label for="amount" class="col-auto col-form-label">@lang('laryl-transfers.form.label.amount')</label>
					
															<div class="col-md-12">
																<input id="amount" type="text" class="form-control digit-812" name="amount" value="{{ old('amount') ? old('amount') : $transfer->amount }}" autofocus>
															</div>
						
															@if ($errors->has('amount'))
																<span class="col-md-12 form-error-message">
																	<small for="amount">{{ $errors->first('amount') }}</small>
																</span>
															@endif
														</div>
													</div>
												</div>
											</div>
											<div class="col-sm-6 ">
												<div class="row">
													<label for="description" class="col-md-12 col-form-label">@lang('laryl-transfers.form.label.description')</label>

													<div class="col-md-12">
														<input id="description" type="text" class="form-control	" name="description" value="{{ old('description') ? old('description') : $transfer->description }}" maxlength="15" >
													</div>

													@if ($errors->has('description'))
													<span class="col-md-12 form-error-message">
														<small for="description">{{ $errors->first('description') }}</small>
													</span>
													@endif
												</div>												
											</div>
										</div>		
										<div class="form-group row">
											<div class="col-md-6">
												<div class="row">
													<div class="col-md-12">
														<div class="row">
															<label for="method" class="col-auto col-form-label">@lang('laryl-transfers.form.label.method')</label>

															<div class="col-md-12">
																<input id="method" type="text" class="form-control" name="method" value="{{ old('method') ? old('method') : $transfer->method }}" autofocus>
															</div>

															@if ($errors->has('method'))
															<span class="col-md-12 form-error-message">
																<small for="method">{{ $errors->first('method') }}</small>
															</span>
															@endif
														</div>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="row">
													<label for="ref" class="col-md-12 col-form-label">@lang('laryl-transfers.form.label.ref')</label>

													<div class="col-md-12">
														<input id="ref" type="text" class="form-control" name="ref" value="{{ old('ref') ? old('ref') : $transfer->ref }}" maxlength="15" >
													</div>

													@if ($errors->has('ref'))
													<span class="col-md-12 form-error-message">
														<small for="ref">{{ $errors->first('ref') }}</small>
													</span>
													@endif
												</div>												
											</div>
										</div>								
										<div class="form-group row mt-5 mb-0">
											<div class="col-auto ml-auto my-auto">
												<button type="submit" class="btn btn-success  ml-auto">
													@lang('laryl-transfers.buttons.save-transfer')
												</button>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<script>
	window.transfer_product_serial = 1;
	window.workingRowIndex = 0;

	window.tableScrollable = $(".table-body-scrollable");
	window.tableFixed = $('.table-fixed');

	$(function() {

		autosize($('textarea.autosize'));

	});


</script>

<!-- <script src="{{ asset('js/new-transfer.js') }}"></script> -->
@endsection