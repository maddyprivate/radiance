@extends('layouts.backend')

@section('content')

<section>
	<div class="container-fluid" id="app">
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header d-flex align-items-center row no-gutters">
						<div class="col-6">
							<h3 class="h4">@lang('laryl-expenses.heading.new')</h3>
						</div>
						<div class="col-6 text-right">
							<a href="{{ route('Expenses.expenses.index')  }}" class="bttn-plain">
								@lang('laryl-expenses.buttons.back-to-expenses')
							</a>
						</div>
					</div>
					<div class="card-body">
						<div class="container">

							<div class="row">
								<div class="col-md-12 mx-auto">
									<form id="newExpenseForm" method="POST" action="{{ route('Expenses.expenses.store') }}">
										@csrf
										<div class="form-group row">
											<div class="col-md-3">
												<div class="row">
													<label for="serialNumber" class="col-md-12 col-form-label">@lang('laryl-expenses.form.label.expenseSerial')</label>

													<div class="col-4 mr-auto pr-0">
														<input type="text" id="serialPrefix" class="form-control " name="serialPrefix" value={{ $expense->serialPrefix }} readonly>
													</div>
							
													<div class="col-8 ml-auto">
														<input id="serialNumber" type="text" class="form-control " name="serialNumber" value="{{ $expense->serialNumber }}" readonly>
													</div>
				
													@if ($errors->has('serialNumber'))
														<span class="col-md-12 form-error-message">
															<small for="serialNumber">{{ $errors->first('serialNumber') }}</small>
														</span>
													@endif
												</div>
											</div>
											<div class="col-sm-6 col-md-3">
												<div class="row">
													<label for="date" class="col-md-12 col-form-label">@lang('laryl-expenses.form.label.date')</label>
							
													<div class="col-md-12">
														<div id="date" data-name="date" class="bfh-datepicker" data-input="form-control" data-min="01-01-2000" data-max="today"  data-format="y-m-d" data-date="today">
														</div>
													</div>
				
													@if ($errors->has('date'))
														<span class="col-md-12 form-error-message">
															<small for="date">{{ $errors->first('date') }}</small>
														</span>
													@endif
												</div>
											</div>
											<div class="col-sm-6">
												<div class="row">
													<label for="account_id" class="col-md-12 col-form-label">@lang('laryl-expenses.form.label.account_id')</label>
							
													<div class="col-md-12">
														<select id="account_id" name="account_id" class="form-control ">
															<option value="">Select Account</option>
															@foreach($accounts as $key=>$value)
																<option value="{{$value->id}}">
																	{{$value->accountName}}
																</option>
															@endforeach
														</select>
													</div>
				
													@if ($errors->has('account_id'))
														<span class="col-md-12 form-error-message">
															<small for="account_id">{{ $errors->first('account_id') }}</small>
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
															<label for="amount" class="col-auto col-form-label">@lang('laryl-expenses.form.label.amount')</label>
					
															<div class="col-md-12">
																<input id="amount" type="text" class="form-control digit-812" name="amount" value="{{ old('amount') }}" autofocus>
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
													<label for="description" class="col-md-12 col-form-label">@lang('laryl-expenses.form.label.description')</label>

													<div class="col-md-12">
														<input id="description" type="text" class="form-control	" name="description" value="{{ old('description') }}" maxlength="15" >
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
											<div class="col-md-4">
												<div class="row">
													<div class="col-md-12">
														<div class="row">
															<label for="chequeNo" class="col-auto col-form-label">@lang('laryl-expenses.form.label.chequeNo')</label>

															<div class="col-md-12">
																<input id="chequeNo" type="text" class="form-control digit-8" name="chequeNo" value="{{ old('chequeNo') }}" autofocus>
															</div>

															@if ($errors->has('chequeNo'))
															<span class="col-md-12 form-error-message">
																<small for="chequeNo">{{ $errors->first('chequeNo') }}</small>
															</span>
															@endif
														</div>
													</div>
												</div>
											</div>
											<div class="col-md-4 ">
												<div class="row">
													<label for="ref" class="col-md-12 col-form-label">@lang('laryl-expenses.form.label.ref')</label>

													<div class="col-md-12">
														<input id="ref" type="text" class="form-control" name="ref" value="{{ old('ref') }}" maxlength="15" >
													</div>

													@if ($errors->has('ref'))
													<span class="col-md-12 form-error-message">
														<small for="ref">{{ $errors->first('ref') }}</small>
													</span>
													@endif
												</div>												
											</div>
											<div class="col-md-4 ">
												<div class="row">
													<label for="person" class="col-md-12 col-form-label">@lang('laryl-expenses.form.label.person')</label>

													<div class="col-md-12">
														<input id="person" type="text" class="form-control" name="person" value="{{ old('person') }}" maxlength="15" >
													</div>

													@if ($errors->has('person'))
													<span class="col-md-12 form-error-message">
														<small for="person">{{ $errors->first('person') }}</small>
													</span>
													@endif
												</div>												
											</div>
										</div>								
										<div class="form-group row mt-5 mb-0">
											<div class="col-auto ml-auto my-auto">
												<button type="submit" class="btn btn-success  ml-auto">
													@lang('laryl-expenses.buttons.save-expense')
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
	window.expense_product_serial = 1;
	window.workingRowIndex = 0;

	window.tableScrollable = $(".table-body-scrollable");
	window.tableFixed = $('.table-fixed');

	$(function() {

		autosize($('textarea.autosize'));

	});


</script>

<!-- <script src="{{ asset('js/new-expense.js') }}"></script> -->
@endsection