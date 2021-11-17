@extends('layouts.backend')

@section('content')

<section>
	<div class="container-fluid" id="app">
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header d-flex align-items-center row no-gutters">
						<div class="col-6">
							<h3 class="h4">@lang('laryl-accounts.heading.new')</h3>
						</div>
						<div class="col-6 text-right">
							<a href="{{ route('Settings.account.index')  }}" class="bttn-plain">
								@lang('laryl-accounts.buttons.back-to-accounts')
							</a>
						</div>
						<div class="col-12">
							<h6 class="t-cap">, <span id="placeoforigin"></span></h6>
						</div>
					</div>
					<div class="card-body">
						<div class="container">
							<div class="row">
								<div class="col-md-12 mx-auto">
									<form id="newAcountForm" method="POST" action="{{ route('Settings.account.store') }}">
										@csrf
										<div class="form-group row">
											<div class="col-md-4">
												<div class="form-group row">
													<label for="accountName" class="col-md-12 col-form-label">@lang('laryl-accounts.form.label.accountName')</label>
										
													<div class="col-md-12">
														<input id="accountName" type="text" class="form-control t-cap" name="accountName" value="{{ old('accountName') }}" autofocus>
													</div>

													@if ($errors->has('accountName'))
				                                        <span class="col-md-12 form-error-message">
				                                            <small for="accountName">{{ $errors->first('accountName') }}</small>
				                                        </span>
													@endif
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group row">
													<label for="bankName" class="col-md-12 col-form-label">@lang('laryl-accounts.form.label.bankName')</label>
										
													<div class="col-md-12">
														<input id="bankName" type="text" class="form-control t-cap" name="bankName" value="{{ old('bankName') }}" autofocus>
													</div>

													@if ($errors->has('bankName'))
				                                        <span class="col-md-12 form-error-message">
				                                            <small for="bankName">{{ $errors->first('bankName') }}</small>
				                                        </span>
													@endif
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group row">
													<label for="accountNo" class="col-md-12 col-form-label">@lang('laryl-accounts.form.label.accountNo')</label>
													<div class="col-md-12">
														<input id="accountNo" type="text" class="form-control  integer" name="accountNo" value="{{ old('accountNo') }}" autofocus>
													</div>
													@if ($errors->has('accountNo'))
														<span class="col-md-12 form-error-message">
															<small for="accountNo">{{ $errors->first('accountNo') }}</small>
														</span>
													@endif
												</div>
											</div>
										</div>

										<div class="form-group row">
											<div class="col-md-4">
												<div class="form-group row">
													<label for="balance" class="col-md-12 col-form-label">@lang('laryl-accounts.form.label.balance')</label>
													
													<div class="col-md-12">
														<input id="balance" type="text" class="form-control digit-8" name="balance" value="{{ old('balance') }}">
													</div>
				
													@if ($errors->has('balance'))
														<span class="col-md-12 form-error-message">
															<small for="balance">{{ $errors->first('balance') }}</small>
														</span>
													@endif
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group row">
													<label for="ifscCode" class="col-md-12 col-form-label">@lang('laryl-accounts.form.label.ifscCode')</label>
													
													<div class="col-md-12">
														<input id="ifscCode" type="text" class="form-control" name="ifscCode" value="{{ old('ifscCode') }}">
													</div>
				
													@if ($errors->has('ifscCode'))
														<span class="col-md-12 form-error-message">
															<small for="ifscCode">{{ $errors->first('ifscCode') }}</small>
														</span>
													@endif
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group row">
													<label for="branch" class="col-md-12 col-form-label">@lang('laryl-accounts.form.label.branch')</label>
													
													<div class="col-md-12">
														<input id="branch" type="text" class="form-control t-cap" name="branch" value="{{ old('branch') }}">
													</div>
				
													@if ($errors->has('branch'))
														<span class="col-md-12 form-error-message">
															<small for="branch">{{ $errors->first('branch') }}</small>
														</span>
													@endif
												</div>
											</div>
										</div>

										<div class="form-group row">
											<div class="col-md-6">
												<div class="form-group row">
													<label for="address" class="col-md-12 col-form-label">@lang('laryl-accounts.form.label.address')</label>
													
													<div class="col-md-12">
														<textarea id="address" type="text" class="form-control " name="address" >{{ old('address') }}</textarea>
													</div>
				
													@if ($errors->has('address'))
														<span class="col-md-12 form-error-message">
															<small for="address">{{ $errors->first('address') }}</small>
														</span>
													@endif
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group row">
													<label for="description" class="col-md-12 col-form-label">@lang('laryl-accounts.form.label.description')</label>
													
													<div class="col-md-12">
														<textarea id="description" type="text" class="form-control " name="description" >{{ old('description') }}</textarea>
													</div>
				
													@if ($errors->has('description'))
														<span class="col-md-12 form-error-message">
															<small for="description">{{ $errors->first('description') }}</small>
														</span>
													@endif
												</div>
											</div>
										</div>
										<div class="form-group row mb-0">
											<div class="col-auto ml-auto">
												<button type="submit" class="btn btn-success  ml-auto">
													@lang('laryl-accounts.buttons.save-account')
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
@if ($errors->any())
 <script>
	@foreach ($errors->getMessages() as $key => $message)
		$("#{{$key}}.form-control").addClass("form-error-field");
	@endforeach
 </script>
@endif
@endsection