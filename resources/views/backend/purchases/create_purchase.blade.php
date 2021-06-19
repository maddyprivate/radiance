@extends('layouts.backend')
@section('header')
<link rel="stylesheet" href="{{ asset('css/purchase-table.css') }}">
@endsection
@section('content')

<section>
	<div class="container-fluid" id="app">
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header d-flex align-items-center row no-gutters">
						<div class="col-6">
							<h3 class="h4">@lang('laryl-purchases.heading.new')</h3>
						</div>
						<div class="col-6 text-right">
							<a href="{{ route('Purchases.purchases.index')  }}" class="bttn-plain">
								@lang('laryl-purchases.buttons.back-to-purchases')
							</a>
						</div>
						<div class="col-12">
							<h6 class="t-cap">{{ $purchase->businessName }}, <span id="placeoforigin">{{ $purchase->placeOfOrigin }}</span></h6>
						</div>
					</div>
					<div class="card-body">
						<div class="container">

							<div class="row">
								<div class="col-md-12 mx-auto">

							<form id="newInvoiceForm" method="POST" action="{{ route('Purchases.purchases.store') }}">
								@csrf
						
								<div class="form-group row">
									<div class="col-md-3">
										<div class="row">
											<label for="serialNumber" class="col-md-12 col-form-label">@lang('laryl-purchases.form.label.purchaseSerial')</label>

											<div class="col-7 mr-auto pr-0">
												<input type="text" id="serialPrefix" class="form-control t-cap" name="serialPrefix" value="{{ $purchase->serialPrefix }} "readonly>
											</div>
					
											<div class="col-5 ml-auto">
												<input id="serialNumber" type="text" class="form-control t-cap" name="serialNumber" value="{{ $purchase->serialNumber }}" readonly>
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
											<label for="issueDate" class="col-md-12 col-form-label">@lang('laryl-purchases.form.label.issueDate')</label>
					
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
									<div class="col-sm-6 col-md-3">
										<div class="row">
											<label for="dueDate" class="col-md-12 col-form-label">@lang('laryl-purchases.form.label.dueDate')</label>
					
											<div class="col-md-12">
												<div id="duedate" data-name="dueDate" class="bfh-datepicker" data-min="01-01-2000" data-format="y-m-d" data-date="today">
												</div>
											</div>
		
											@if ($errors->has('dueDate'))
												<span class="col-md-12 form-error-message">
													<small for="dueDate">{{ $errors->first('dueDate') }}</small>
												</span>
											@endif
										</div>
									</div>
									<div class="col-sm-6 col-md-3">
										<div class="row">
											<label for="placeOfSupply" class="col-md-12 col-form-label">@lang('laryl-purchases.form.label.placeOfSupply')</label>
					
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
													<label for="dealerName" class="col-auto col-form-label">@lang('laryl-purchases.form.label.dealerName')</label>
			
													<div class="col-md-12">
														<input id="dealerName" type="text" class="form-control t-cap" name="dealer[name]" value="{{ old('dealer.name') }}" autofocus>
													</div>
				
													@if ($errors->has('dealer.name'))
														<span class="col-md-12 form-error-message">
															<small for="dealer.name">{{ $errors->first('dealer.name') }}</small>
														</span>
													@endif
													<input type="hidden" name="dealer[dealerId]" id="dealerId" >
												</div>
											</div>
											<div class="col-sm-6 col-md-6">
												<div class="row">
													<label for="dealerGstin" class="col-md-12 col-form-label">@lang('laryl-purchases.form.label.dealerGstin')</label>
		
													<div class="col-md-12">
														<input id="dealerGstin" type="text" class="form-control t-up" name="dealer[gstin]" value="{{ old('dealer.gstin') }}" maxlength="15" >
													</div>
				
													@if ($errors->has('dealer.gstin'))
														<span class="col-md-12 form-error-message">
															<small for="dealer.gstin">{{ $errors->first('dealer.gstin') }}</small>
														</span>
													@endif
												</div>												
											</div>
											<div class="col-sm-6 col-md-6">
												<div class="row">
													<label for="dealerMobile" class="col-md-12 col-form-label">@lang('laryl-purchases.form.label.dealerMobile')</label>
		
													<div class="col-md-12">
														<input id="dealerMobile" type="text" class="form-control t-up bfh-phone" data-country="India" name="dealer[mobile]" value="{{ old('dealer.mobile') }}" >
													</div>
				
													@if ($errors->has('dealer.mobile'))
														<span class="col-md-12 form-error-message">
															<small for="dealer.mobile">{{ $errors->first('dealer.mobile') }}</small>
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
													<label for="billingAddress" class="col-auto col-form-label">@lang('laryl-purchases.form.label.billingAddress')</label>

													<span id="billingaddress_edit" class="col-auto align-self-center ml-auto"><a data-remodal-target="editBillingAddress" href="javascript:;">Edit</a></span>
			
													<div class="col-md-12">
														<textarea id="billingAddress" rows=4 class="form-control autosize t-cap" name="dealer[billingAddress]" value="{{ old('billingAddress') }}" readonly></textarea>
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
													<label for="shippingAddress" class="col-auto col-form-label">@lang('laryl-purchases.form.label.shippingAddress')</label>

													<span id="editShippingAddress" class="d-none col-auto align-self-center ml-auto"><a data-remodal-target="editShippingAddress" href="javascript:;">Edit</a></span>
			
													<div class="col-md-12">
														<textarea id="shippingAddress" rows=4 class="form-control autosize t-cap" name="dealer[shippingAddress]" value="{{ old('shippingAddress') }}" readonly></textarea>
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
													<input name="dealer[sameAsBilling]" type="text" value="off" hidden>
													<input class="newinv_form_event" id="sameAsBilling" name="dealer[sameAsBilling]" type="checkbox" checked="checked">
													<label for="sameAsBilling">Same as Billing Address</label>
												</div>										
											</div>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-12">
										<div class="purchase-products-table">
											<div class="table-body-scrollable">
												<div class="table-responsive purchase-products-list-table">
													<table id="table" class="table text-center">
														<thead>
															<tr>
																<th rowspan=2>#</th>
																<th rowspan=2>Product Description</th>
																<th rowspan=2>HSN / SAC</th>
																<th rowspan=2>Qty</th>
																<th rowspan=2>Unit</th>
																<th rowspan=2>Rate<br>/ Unit</th>
																<th rowspan=1>Discount</th>
																<th rowspan=1 colspan=2>Taxable</th>
																<th rowspan=1 colspan=2>Values</th>
															</tr>
															<tr>
																<th rowspan=1>
																	<div class="row no-gutters">
																		<div class="col-6">
																			<label for="discountType">%</label>
																		</div>
																		<div class="col-6">
																			<label for="discountType">Rs.</label>
																		</div>
																	</div>
																	<div class="row no-gutters">
																		<div class="col-6">
																			<input type="radio" value="discountrate" id="discount_percent" name="discountType" checked>
																		</div>
																		<div class="col-6">
																			<input type="radio" value="discountvalue" id="discount_value" name="discountType">
																		</div>
																	</div>
																</th>
																<th rowspan=1>Value</th>
																<th rowspan=1>Rate</th>
																<th rowspan=1>CGST</th>
																<th rowspan=1>SGST</th>
															</tr>
														</thead>
														<tbody id="product-tbody">

															<tr class="purchase-totals-row-scrollable">
																<td colspan="5" class=""><a href="javascript:;" id="add-empty-row-button">+ Add another line</a></td>
																<td colspan="2" class="">Total Inv. Val</td>
																<td class="purchase-total-cell readonly-cell" id="taxableValue">
																	<input type="text" 	class="table-cell-total" id="taxableValue" name="totalTaxablevalue" value="0.00" readonly>
																</td>
																<td colspan="1" class=""></td>
																<td class="purchase-total-cell readonly-cell" id="totalCgstValue">
																	<input type="text" 	class="table-cell-total" id="cgstValue" name="totalCgstvalue" value="0.00" readonly>
																</td>
																<td class="purchase-total-cell readonly-cell" id="sgstValue">
																	<input type="text" 	class="table-cell-total" id="sgstValue" name="totalSgstvalue" value="0.00" readonly>
																</td>	
															</tr>
														</tbody>
													</table>
												</div>
											</div>

											<div class="table-body-fixed table-shadow">
												<div class="table-fixed">
													<table id="table" class="table">
														<thead>
															<tr>
																<th rowspan=2 data-field="total_amount">
																	<div class="th-inner text-right">Total<br>Amount</div>
																</th>
															</tr>
														</thead>
														<tbody>
															<tr class="purchase-totals-row-fixed">
																<td class="purchase-total-cell readonly-cell" id="netValue">
																	<input type="text" 	class="table-cell-total" id="netValue" name="netValue" value="0.00" readonly>
																</td>
															</tr>
														</tbody>
													</table>
												</div>
											</div>
										</div>
									</div>
								</div>

								<div class="form-group row">
									<div class="col-12 text-right" style="max-width: calc(100% - 160px);">
										
										<div class="pure-checkbox">
											<input name="roundOffState" type="text" value="off" hidden>
											<input class="" id="roundOffState" name="roundOffState" type="checkbox" checked="checked">
											<label for="roundOffState">Round Off : </label>
										</div>
									</div>
									<div class="col-auto m-0 p-0">
										<input class="roundOffValue" type="text" id="roundOffValue" name="roundOffValue" value="0.00" readonly>
									</div>
								</div>

								<div class="form-group row">
									<div class="col-12 text-right" style="max-width: calc(100% - 160px);">
										<label for="grandValue">Net Total : </label>
									</div>
									<div class="col-auto m-0 p-0">
										<input class="grandValue" type="text" id="grandValue" name="grandValue" value="0.00" readonly>
									</div>
								</div>

								<div class="form-group row">
									<div class="col-12 text-right my-auto" style="max-width: calc(100% - 160px);">
										<label for="amountRecieved">Amount Recieved : </label>
									</div>
									<div class="col-auto m-0 p-0" style="max-width: 108px;">
										<input class="form-control numeric-p8d2" type="text" id="amountRecieved" name="amountRecieved" value=0.00 readonly>
									</div>
								</div>
								
								<div class="form-group row mt-5 mb-0">
									<div class="col-12 col-md-4 mb-3 mb-md-0">
										<div class="row">
											<label for="otherCharges" class="col-auto col-form-label">@lang('laryl-purchases.form.label.otherCharges')</label>

											<div class="col-md-12">
												<input id="otherCharges" type="text" class="form-control digit-8" name="otherCharges" value="{{ old('otherCharges') ?? 0}}" autofocus onblur="setTotalsRow();finalRoundingoff();">
											</div>

											@if ($errors->has('otherCharges'))
												<span class="col-md-12 form-error-message">
													<small for="otherCharges">{{ $errors->first('otherCharges') }}</small>
												</span>
											@endif
										</div>
									</div>
									<div class="col-auto ml-auto my-auto">
										<button type="submit" class="btn btn-success  ml-auto">
											@lang('laryl-purchases.buttons.save-purchase')
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
	window.purchase_product_serial = 1;
	window.workingRowIndex = 0;

	window.tableScrollable = $(".table-body-scrollable");
	window.tableFixed = $('.table-fixed');

	$(function() {
		
		add_empty_productrow();

		autosize($('textarea.autosize'));

		//Declaring select dealer remodal as JS obj. Used when closing the modal after dealer selection
		var remodal_options = {
			hashTracking: false, closeOnOutsideClick: false,
		};

		window.selectProductModal = $('[data-remodal-id=selectProductModal]').remodal(remodal_options);

	});


</script>

<script src="{{ asset('js/new-purchase.js') }}"></script>

<script>
	$('#newInvoiceForm').on('submit', function(e){

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

				swal_message("Invoice Saved.", "success");
				
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