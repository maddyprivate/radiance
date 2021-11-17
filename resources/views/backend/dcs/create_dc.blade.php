@extends('layouts.backend')

@section('header')
<link rel="stylesheet" href="{{ asset('css/dc-table.css') }}">
@endsection
@section('content')

<section>
	<div class="container-fluid" id="app">
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header d-flex align-items-center row no-gutters">
						<div class="col-6">
							<h3 class="h4">@lang('laryl-dcs.heading.new')</h3>
						</div>
						<div class="col-6 text-right">
							<a href="{{ route('Dcs.dcs.index')  }}" class="bttn-plain">
								@lang('laryl-dcs.buttons.back-to-dcs')
							</a>
						</div>
						<div class="col-12">
							<h6 class="t-cap">{{ $dc->businessName }}, <span id="placeoforigin">{{ $dc->placeOfOrigin }}</span></h6>
						</div>
					</div>
					<div class="card-body">
						<div class="container">

							<div class="row">
								<div class="col-md-12 mx-auto">

							<form id="newDcForm" method="POST" action="{{ route('Dcs.dcs.store') }}">
								@csrf
						
								<div class="form-group row">
									<div class="col-md-3">
										<div class="row">
											<label for="serialNumber" class="col-md-12 col-form-label">@lang('laryl-dcs.form.label.dcSerial')</label>
											<div class="col-md-12">
												<input type="text" id="serialPrefix" class="form-control t-cap" name="serialPrefix" value={{ $dc->serialPrefix }} readonly>
											</div>
										</div>
									</div>
									<div class="col-md-3">
										<label for="serialNumber" class="col-md-12 col-form-label"><br></label>
										<div class="row">
											<input id="serialNumber" type="text" class="form-control t-cap" name="serialNumber" value="{{ $dc->serialNumber }}" readonly>
										</div>
									</div>
									<div class="col-md-3">
										<div class="row">
											<label for="issueDate" class="col-md-12 col-form-label">@lang('laryl-dcs.form.label.issueDate')</label>
					
											<div class="col-md-12">
												<div id="date" data-name="issueDate" class="bfh-datepicker" data-input="form-control" data-min="01-01-2000" data-max="today"  data-format="y-m-d" data-date="today">
												</div>
											</div>
		
											@if ($errors->has('issueDate'))
												<span class="col-md-12 form-error-message">
													<small for="issueDate">{{ $errors->first('issueDate') }}</small>
												</span>
											@endif
										</div>
									</div>
									<div class="col-md-3">
										<div class="row">
											<label for="placeOfSupply" class="col-md-12 col-form-label">@lang('laryl-dcs.form.label.placeOfSupply')</label>
					
											<div class="col-md-12">
												<select id="placeOfSupply" name="placeOfSupply" class="form-control bfh-states" data-country="India" data-state="{{ old('placeOfSupply') }}"></select>
											</div>
		
											@if ($errors->has('placeOfSupply'))
												<span class="col-md-12 form-error-message">
													<small for="placeOfSupply">{{ $errors->first('placeOfSupply') }}</small>
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
													<label for="customerName" class="col-auto col-form-label">@lang('laryl-dcs.form.label.customerName')</label>
			
													<div class="col-md-12">
														<input id="customerName" type="text" class="form-control t-cap" name="customer[name]" value="{{ old('customer.name') }}" autofocus>
													</div>
				
													@if ($errors->has('customer.name'))
														<span class="col-md-12 form-error-message">
															<small for="customer.name">{{ $errors->first('customer.name') }}</small>
														</span>
													@endif
													<input type="hidden" name="customer[customerId]" id="customerId" >
												</div>
											</div>
											<div class="col-sm-6 col-md-6">
												<div class="row">
													<label for="customerGstin" class="col-md-12 col-form-label">@lang('laryl-dcs.form.label.customerGstin')</label>
		
													<div class="col-md-12">
														<input id="customerGstin" type="text" class="form-control t-up" name="customer[gstin]" value="{{ old('customer.gstin') }}" maxlength="15" >
													</div>
				
													@if ($errors->has('customer.gstin'))
														<span class="col-md-12 form-error-message">
															<small for="customer.gstin">{{ $errors->first('customer.gstin') }}</small>
														</span>
													@endif
												</div>												
											</div>
											<div class="col-sm-6 col-md-6">
												<div class="row">
													<label for="customerMobile" class="col-md-12 col-form-label">@lang('laryl-dcs.form.label.customerMobile')</label>
		
													<div class="col-md-12">
														<input id="customerMobile" type="text" class="form-control t-up bfh-phone" data-country="India" name="customer[mobile]" value="{{ old('customer.mobile') }}" >
													</div>
				
													@if ($errors->has('customer.mobile'))
														<span class="col-md-12 form-error-message">
															<small for="customer.mobile">{{ $errors->first('customer.mobile') }}</small>
														</span>
													@endif
												</div>												
											</div>
										</div>
									</div>

									<div class="col-md-6">
										<div class="row">
											<div class="col-sm-6 col-md-6">
												<div class="row">
													<label for="billingAddress" class="col-auto col-form-label">@lang('laryl-dcs.form.label.billingAddress')</label>

													<span id="billingaddress_edit" class="col-auto align-self-center ml-auto"><a data-remodal-target="editBillingAddress" href="javascript:;">Edit</a></span>
			
													<div class="col-md-12">
														<textarea id="billingAddress" rows=4 class="form-control autosize t-cap" name="customer[billingAddress]" value="{{ old('billingAddress') }}" readonly></textarea>
													</div>
				
													@if ($errors->has('billingAddress'))
														<span class="col-md-12 form-error-message">
															<small for="billingAddress">{{ $errors->first('billingAddress') }}</small>
														</span>
													@endif
												</div>
											</div>
											<div class="col-sm-6 col-md-6">
												<div class="row">
													<label for="shippingAddress" class="col-auto col-form-label">@lang('laryl-dcs.form.label.shippingAddress')</label>

													<span id="editShippingAddress" class="d-none col-auto align-self-center ml-auto"><a data-remodal-target="editShippingAddress" href="javascript:;">Edit</a></span>
			
													<div class="col-md-12">
														<textarea id="shippingAddress" rows=4 class="form-control autosize t-cap" name="customer[shippingAddress]" value="{{ old('shippingAddress') }}" readonly></textarea>
													</div>
				
													@if ($errors->has('shippingAddress'))
														<span class="col-md-12 form-error-message">
															<small for="shippingAddress">{{ $errors->first('shippingAddress') }}</small>
														</span>
													@endif
												</div>
											</div>
											<div class="col-auto ml-auto mt-3 form-group">
												<div class="pure-checkbox">
													<input name="customer[sameAsBilling]" type="text" value="off" hidden>
													<input class="newinv_form_event" id="sameAsBilling" name="customer[sameAsBilling]" type="checkbox" checked="checked">
													<label for="sameAsBilling">Same as Billing Address</label>
												</div>										
											</div>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-12">
										<div class="dc-products-table">
											<div class="table-body-scrollable">
												<div class="table-responsive dc-products-list-table">
													<table id="table" class="table text-center">
														<thead>
															<tr>
																<th>#</th>
																<th>Product Description</th>
																<th>Qty</th>
																<th>Unit</th>
																<th >DC Date</th>
																<th>Vehicle No.</th>
																<th>DC No.</th>
															</tr>
														</thead>
														<tbody id="product-tbody">

															<tr class="dc-totals-row-scrollable">
																<td colspan="7" class=""><a href="javascript:;" id="add-empty-row-button">+ Add another line</a></td>
															</tr>
														</tbody>
													</table>
												</div>
											</div>

											
										</div>
									</div>
								</div>						
								<div class="form-group row mt-5 mb-0">
									<div class="col-auto ml-auto my-auto">
										<button type="submit" class="btn btn-success  ml-auto">
											@lang('laryl-dcs.buttons.save-dc')
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

<div class="remodal" data-remodal-id="editBillingAddress" aria-labelledby="modalTitle" aria-describedby="modalDesc" data-remodal-options="hashTracking: false, closeOnOutsideClick: false">
	<button data-remodal-action="close" class="remodal-close" aria-label="Close"></button>
	<div>
		<h2 id="modalTitle">Edit Billing Address</h2>
		<form id="edit_billingaddress_form">
			<div class="row">
				<div class="col-12 form-group mx-auto">
					<textarea name="editBillingAddress" id="editBillingAddress" type="text" class="form-control" style="height: 180px;" value="{{ old('billingAddress') }}"></textarea>
					<small for="editBillingAddress" class="validate-text" style="display: none;">Error Text.</small>
				</div>
				<div class="form-group col-auto ml-auto">
					<button type="reset" data-remodal-action="cancel" class="btn btn-danger ml-auto">Close</button>
					<button type="submit" class="btn btn-success">OK</button>
				</div>
			</div>
		</form>			
	</div>
</div>

<div class="remodal" data-remodal-id="editShippingAddress" aria-labelledby="modalTitle" aria-describedby="modalDesc" data-remodal-options="hashTracking: false, closeOnOutsideClick: false">
	<button data-remodal-action="close" class="remodal-close" aria-label="Close"></button>
	<div>
		<h2 id="modalTitle">Edit Shipping Address</h2>
		<form id="edit_shippingaddress_form">
			<div class="row">
				<div class="col-12 form-group mx-auto">
					<textarea name="editShippingAddress" id="editShippingAddress" type="text" class="form-control" style="height: 180px;" value="{{ old('shippingAddress') }}"></textarea>
					<small for="editShippingAddress" class="validate-text" style="display: none;">Error Text.</small>
				</div>
				<div class="form-group col-auto ml-auto">
					<button type="reset" data-remodal-action="cancel" class="btn btn-danger ml-auto">Close</button>
					<button type="submit" class="btn btn-success">OK</button>
				</div>
			</div>
		</form>
	</div>
</div>

<div class="remodal" data-remodal-id="selectProductModal" aria-labelledby="modalTitle" aria-describedby="modalDesc" data-remodal-options="hashTracking: false, closeOnOutsideClick: false">
	<button data-remodal-action="close" class="remodal-close" aria-label="Close"></button>
	<div>
		<h2 id="modalTitle">Search Product</h2>
		<form id="selectProduct_form">
			<div class="form-group row align-items-center">
				<label class="col-sm-3 col-form-label">Product Description</label>
				<div class="col-sm-9">
					<input name="ProductDescription" id="searchProductDescription" type="text" placeholder="Product's Description" class="form-control" autofocus>
				</div>
			</div>
			<div class="form-group row">
				<div class="col-auto ml-auto" style="text-align: left;">
					<button type="reset" data-remodal-action="cancel" class="btn btn-danger ml-auto">Close</button>
				</div>
			</div>	
		</form>			
	</div>
</div>

<script>
	window.dc_product_serial = 1;
	window.workingRowIndex = 0;

	window.tableScrollable = $(".table-body-scrollable");
	window.tableFixed = $('.table-fixed');

	$(function() {
		
		add_empty_productrow();

		autosize($('textarea.autosize'));

		//Declaring select customer remodal as JS obj. Used when closing the modal after customer selection
		var remodal_options = {
			hashTracking: false, closeOnOutsideClick: false,
		};

		window.selectProductModal = $('[data-remodal-id=selectProductModal]').remodal(remodal_options);

	});


</script>

<script src="{{ asset('js/new-dc.js') }}"></script>

<script>
	$('#newDcForm').on('submit', function(e){

		$('.input-error').removeClass('input-error');

		$.ajaxSetup({
			header:$('meta[name="_token"]').attr('content')
		});

		e.preventDefault();

		var formdata = $(this).serializeArray();
		var posturl = $(this).attr('action');

		$.ajax({
			type	:"POST",
			url		: posturl,
			data	: formdata,
			dataType: 'json',
			success: function(response){

				swal_message("Dc Saved.", "success");
				
			},
			error: function(response){

				var responseText = JSON.parse(response['responseText']);
				var responseErrors = responseText['errors'];

				$.each( responseErrors, function( key, value ) {
					var splitKey = key.split(".");
					console.log(splitKey);
					if((splitKey.length) > 1) {
						$('[name="'+splitKey[0]+'['+splitKey[1]+']'+'"]').addClass('input-error');
					} else {
						$('[name="'+splitKey[0]+'"]').addClass('input-error');
					}
				});

				swal_message("Error in Submission. Re-Submit", "error");

			}
		})
	});

	function swal_message(message_set, type_set, toast_set="true") {
		swal({
				title: message_set,
				type: type_set,
				toast:	toast_set,
				showConfirmButton:false,
				showCloseButton: true,
				timer: 3000,
				grow: false,
				position: 'top-right',
			});
	}
</script>

@endsection