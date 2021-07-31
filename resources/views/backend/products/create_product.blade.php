@extends('layouts.backend')

@section('content')

<section>
	<div class="container-fluid" id="app">
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header d-flex align-items-center">
						<div class="col-6">
							<h3 class="h4">@lang('laryl-products.heading.new')</h3>
						</div>
						<div class="col-6 text-right">
							<a href="{{ route('Products.products.index')  }}" class="bttn-plain">
								@lang('laryl-products.buttons.back-to-products')
							</a>
						</div>
					</div>
					<div class="card-body">
						<div class="container">
							<div class="row">
								<div class="col-md-12 mx-auto">
									<form method="POST" action="{{ route('Products.products.store') }}">
										@csrf
										<div class="form-group row">
											<div class="col-md-6">
												<div class="form-group row">
													<label for="description" class="col-md-12 col-form-label">@lang('laryl-products.form.label.description')</label>
										
													<div class="col-md-12">
														<input id="description" type="text" class="form-control t-cap" name="description" value="{{ old('description') }}" autofocus>
													</div>

													@if ($errors->has('description'))
				                                        <span class="col-md-12 form-error-message">
				                                            <small for="description">{{ $errors->first('description') }}</small>
				                                        </span>
													@endif
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group row">
													<label for="type" class="col-md-12 col-form-label">@lang('laryl-products.form.label.type')</label>
										
													<div class="col-md-12">
														<select id="type" class="form-control" name="type" value="{{ old('type') }}">
															<option value="goods">Goods</option>
															<option value="service">Service</option>
														</select>
													</div>

													@if ($errors->has('type'))
														<span class="col-md-12 form-error-message">
															<small for="type">{{ $errors->first('type') }}</small>
														</span>
													@endif
												</div>
											</div>
										</div>

										<div class="form-group row">
											<div class="col-md-6">
												<div class="form-group row">
													<label for="hsn" class="col-md-12 col-form-label">@lang('laryl-products.form.label.hsn')</label>
													
													<div class="col-md-12">
														<input id="hsn" type="text" class="form-control digit-8" name="hsn" value="{{ old('hsn') }}">
													</div>
				
													@if ($errors->has('hsn'))
														<span class="col-md-12 form-error-message">
															<small for="hsn">{{ $errors->first('hsn') }}</small>
														</span>
													@endif
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group row">
													<label for="sku" class="col-md-12 col-form-label">@lang('laryl-products.form.label.sku')</label>
													
													<div class="col-md-12">
														<input id="sku" type="text" class="form-control t-cap" name="sku" value="{{ old('sku') }}">
													</div>
				
													@if ($errors->has('sku'))
														<span class="col-md-12 form-error-message">
															<small for="sku">{{ $errors->first('sku') }}</small>
														</span>
													@endif
												</div>
											</div>
										</div>
										<div class="form-group row">
											<div class="col-md-6">
												<div class="form-group row">
													<label for="taxRate" class="col-md-12 col-form-label">@lang('laryl-products.form.label.taxRate')</label>
													
													<div class="col-md-12">
														<select name="taxRate" id="taxRate" class="form-control" value="{{ old('taxRate') }}">
															<option value="0">0 %</option>
															<option value="0.1">0.1 %</option>
															<option value="0.25">0.25 %</option>
															<option value="3">3.00 %</option>
															<option value="5">5.00 %</option>
															<option value="12">12.00 %</option>
															<option value="18">18.00 %</option>
															<option value="28">28.00 %</option>
														</select>
													</div>
				
													@if ($errors->has('taxRate'))
														<span class="col-md-12 form-error-message">
															<small for="taxRate">{{ $errors->first('taxRate') }}</small>
														</span>
													@endif
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group row">
													<label for="cessValue" class="col-md-12 col-form-label">@lang('laryl-products.form.label.cessValue')</label>
													
													<div class="col-md-12">
														<input id="cessValue" type="text" class="form-control numeric-p2d2" name="cessValue" value="{{ old('cessValue', '0.00') }}">
													</div>
				
													@if ($errors->has('cessValue'))
														<span class="col-md-12 form-error-message">
															<small for="cessValue">{{ $errors->first('cessValue') }}</small>
														</span>
													@endif
												</div>
											</div>
										</div>
										<div class="form-group row">
											<div class="col-md-6">
												<div class="form-group row">
													<label for="saleValue" class="col-md-12 col-form-label">@lang('laryl-products.form.label.saleValue')</label>
													
													<div class="col-md-12">
														<input id="saleValue" type="text" class="form-control numeric-p8d2" name="saleValue" value="{{ old('saleValue', '0.00') }}">
													</div>

													@if ($errors->has('saleValue'))
														<span class="col-md-12 form-error-message">
															<small for="saleValue">{{ $errors->first('saleValue') }}</small>
														</span>
													@endif
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group row">
													<label for="discountRate" class="col-md-12 col-form-label">@lang('laryl-products.form.label.discountRate')</label>
													
													<div class="col-md-12">
														<input id="discountRate" type="text" class="form-control numeric-p2d2" name="discountRate" value="{{ old('discountRate', '0.00') }}">
													</div>

													@if ($errors->has('discountRate'))
														<span class="col-md-12 form-error-message">
															<small for="discountRate">{{ $errors->first('discountRate') }}</small>
														</span>
													@endif
												</div>
											</div>
										</div>
										<div class="form-group row">
											<div class="col-md-6">
												<div class="form-group row">
													<label for="unit" class="col-md-12 col-form-label">@lang('laryl-products.form.label.unit')</label>
													
													<div class="col-md-12">
															<select id="unit" name="unit" class="form-control">
																<option value="NOS">NOS</option>
																<option value="BGS">Bags</option>
																<option value="Brass">Brass</option>
																<option value="BTL">Bottles</option>
																<option value="CAN">Cans</option>
																<option value="KG">Kilograms</option>
																<option value="LTR">liter</option>
																<option value="MTR">Meter</option>
																<option value="CH">Chhota Hatti</option>
															</select>
													</div>

													@if ($errors->has('unit'))
														<span class="col-md-12 form-error-message">
															<small for="unit">{{ $errors->first('unit') }}</small>
														</span>
													@endif
												</div>
											</div>
										</div>

										<div class="form-group row mb-0">
											<div class="col-auto ml-auto">
												<button type="submit" class="btn btn-success  ml-auto">
													@lang('laryl-products.buttons.save-product')
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