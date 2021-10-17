
	var scrollableContent =  "";
	
	function setScrollableContent(i){
		var tDate = moment(new Date()).format("YYYY-MM-DD")
		scrollableContent = "<tr class=\"product-details-row-scrollable\" row-index=\"\"> <td class=\"product-detail-cell\" id=\"creditNoteSerial\"> <input type=\"text\" class=\"table-cell-input text-center\" id=\"creditNoteSerial\" name=\"creditNoteProducts["+i+"][creditNoteSerial]\" value=\"\" readonly> </td> <td class=\"product-detail-cell\" id=\"description\"> <input type=\"text\" class=\"table-cell-input\" id=\"description\" name=\"creditNoteProducts["+i+"][description]\" value=\"\"><a href=\"javascript:;\" id=\"search_product\"><i class=\"fa fa-search\"></i></a> </td> <td class=\"product-detail-cell\" id=\"hsn\"> <input type=\"text\" class=\"table-cell-input\" id=\"hsn\" name=\"creditNoteProducts["+i+"][hsn]\" value=\"\"> </td> <td class=\"product-detail-cell\" id=\"quantity\"> <input type=\"text\" class=\"table-cell-input\" id=\"quantity\" name=\"creditNoteProducts["+i+"][quantity]\" value=\"1\"> </td> <td class=\"product-detail-cell\" id=\"unit\"> <select id=\"unit\" name=\"creditNoteProducts["+i+"][unit]\" class=\"table-cell-input\"> <option value=\"NOS\">NOS</option><option value=\"BGS\">Bags</option><option value=\"Brass\">Brass</option><option value=\"BTL\">Bottles</option><option value=\"CAN\">Cans</option><option value=\"KG\">Kilograms</option><option value=\"LTR\">liter</option><option value=\"MTR\">Meter</option><option value=\"CH\">Chhota Hatti</option></select> </td> <td class=\"product-detail-cell\" id=\"saleValue\"> <input type=\"text\" class=\"table-cell-input\" id=\"saleValue\" name=\"creditNoteProducts["+i+"][saleValue]\" value=\"\"> </td> <td class=\"product-detail-cell\" id=\"discountRate\" value=\"0.00\"> <input type=\"text\" class=\"table-cell-input\" id=\"discountRate\" name=\"creditNoteProducts["+i+"][discountRate]\" value=\"0.00\"> </td> <td class=\"product-detail-cell d-none\" id=\"discountValue\"> <input type=\"text\" class=\"table-cell-input\" id=\"discountValue\" name=\"creditNoteProducts["+i+"][discountValue]\" value=\"0.00\"> </td> <td class=\"product-detail-cell readonly-cell\" id=\"taxableValue\"> <input type=\"text\" class=\"table-cell-input\" id=\"taxableValue\" name=\"creditNoteProducts["+i+"][taxableValue]\" value=\"0.00\" readonly> </td> <td class=\"product-detail-cell\" id=\"taxRate\"> <select name=\"creditNoteProducts["+i+"][taxRate]\" id=\"taxRate\" class=\"table-cell-input\" > <option value=\"0.00\">0 %</option> <option value=\"0.10\">0.10 %</option> <option value=\"0.25\">0.25 %</option> <option value=\"3.00\">3.00 %</option> <option value=\"5.00\">5.00 %</option> <option value=\"12.00\">12.00 %</option> <option value=\"18.00\">18.00 %</option> <option value=\"28.00\">28.00 %</option> </select> </td> <td class=\"product-detail-cell readonly-cell\" id=\"cgstValue\"> <input type=\"text\" class=\"table-cell-input\" id=\"cgstValue\" name=\"creditNoteProducts["+i+"][cgstValue]\" value=\"0.00\" readonly> <input type=\"text\" class=\"table-cell-input \" id=\"cgstRate\" name=\"creditNoteProducts["+i+"][cgstRate]\" value=\"0\" readonly> </td> <td class=\"product-detail-cell readonly-cell\" id=\"sgstValue\"> <input type=\"text\" class=\"table-cell-input\" id=\"sgstValue\" name=\"creditNoteProducts["+i+"][sgstValue]\" value=\"0.00\" readonly> <input type=\"text\" class=\"table-cell-input \" id=\"sgstRate\" name=\"creditNoteProducts["+i+"][sgstRate]\" value=\"0\" readonly> </td></tr> ";
	}

	var fixedContent =  "";
	
	function setFixedContent(i){
		fixedContent = "<tr class=\"product-details-row-fixed\"> <td class=\"product-detail-cell readonly-cell\" id=\"grossvalue\" rowspan=\"1\"> <input type=\"text\" class=\"table-cell-input\" id=\"grossvalue\" name=\"creditNoteProducts["+i+"][grossvalue]\" value=\"0.00\" readonly> </td> <td class=\"delete-row-cell\" colspan=\"1\" rowspan=\"1\"> <a href=\"javascript:;\" class=\"delete-row-link\"><svg xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\" viewBox=\"0 0 16 16\"><g fill=\"none\" fill-rule=\"evenodd\"><path fill=\"#FFF\" d=\"M5.308 5.348l5.384 5.304\"></path><path stroke=\"#FF4949\" stroke-linecap=\"round\" d=\"M5.308 5.348l5.384 5.304\"></path><path fill=\"#FFF\" d=\"M10.692 5.348l-5.384 5.304\"></path><path stroke=\"#FF4949\" stroke-linecap=\"round\" d=\"M10.692 5.348l-5.384 5.304M15 8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z\"></path></g></svg></a> </td> </tr>";
	}
	
	// Below 3 functions - used to change and copy text in between billing and shipping address based on checkbox state
	//Enabling edit on shipping address on checkbox toggle
	$('input#sameAsBilling').on('change', function(e){
		$('span#editShippingAddress').toggleClass('d-none');
		$('textarea#shippingAddress').val($('textarea#billingAddress').val()).change(); //copying value of billing address to shipping address
		$('textarea#editShippingAddress').val($('textarea#billingAddress').val()).change(); //copying value of billing address to edit shipping address
	});

	//Edit billing address form submit	
	$('#edit_billingaddress_form').unbind('submit').bind('submit', function(e){
		e.preventDefault();
		//Copy edit textarea to main textarea
		$('textarea#billingAddress').val($('textarea#editBillingAddress').val()).change();
		//if shipping address same as billing address
		if($('input#sameAsBilling[type=checkbox]').prop('checked')) {
			//Copy edit textarea to shippping address (both edit and main areas) too
			$('textarea#shippingAddress').val($('textarea#editBillingAddress').val()).change();
			$('textarea#editShippingAddress').val($('textarea#editBillingAddress').val());
		}
		//close modal
		$('[data-remodal-id="editBillingAddress"]').remodal().close();
		autosize.update($('textarea#billingAddress'));
		autosize.update($('textarea#shippingAddress'));
	});

	//Edit shipping address form submit
	$('#edit_shippingaddress_form').unbind('submit').bind('submit', function(e){
		e.preventDefault();
		//copy edit textarea value to main textarea
		$('textarea#shippingAddress').val($('textarea#editShippingAddress').val()).change();
		//close remodal
		$('[data-remodal-id="editShippingAddress"]').remodal().close();
		autosize.update($('textarea#billingAddress'));
		autosize.update($('textarea#shippingAddress'));
	});

	//************************************************************************************** */

	//Customer selection - Autocomplte
	$("input#customerName").autocomplete({

		valueKey:'name',
		titleKey:'name',
		dropdownWidth:'auto',
		appendMethod:'replace',
		source:[
			function( q,add ){

				if( q !== "") {
					$.ajax({
						url: baseURL+"/creditNotes/select_customer/"+encodeURIComponent(q),
						dataType : 'json',
						success: function(resp){
							add(resp.data);
						}
					});

				}
			},
		],

	}).on('selected.xdsoft', function(e, datum){ //on select of a customer in the select a customer modal

		//fill in the customer details on page
		$('input#customerId').val(datum.id);
		$('input#customerGstin').val(datum.gstin);
		$('input#customerMobile').val(datum.mobile);
		$('select#placeOfSupply').attr('data-state', datum.state);
		$('select#placeOfSupply').val(datum.state).change();
		$('textarea#billingAddress').val($.grep([datum.address, datum.city, datum.state, datum.pincode], Boolean).join('\n'));
		$('textarea#editBillingAddress').val($('textarea#billingAddress').val());
		$('textarea#shippingAddress').val($.grep([datum.address, datum.city, datum.state, datum.pincode], Boolean).join('\n'));
		$('textarea#editShippingAddress').val($('textarea#shippingAddress').val());
		//resize the text areas after value upadtion
		autosize.update($('textarea#billingAddress'));
		autosize.update($('textarea#shippingAddress'));

	});	

	//************************************************************************************** */
	//************************************************************************************** */
	//*********************     Product selection - Autocomplete     *********************** */
	//**************     on select of a creditNote product in selct product modal     ********* */
	//************************************************************************************** */
	//************************************************************************************** */


	tableScrollable.on('click', 'a#search_product', function(e){
		e.preventDefault();
		selectProductModal.open();
		workingRowIndex = $(this).parents('tr.product-details-row-scrollable').attr('row-index');
	});

	$("input#searchProductDescription").autocomplete({

		valueKey:'description',
		titleKey:'description',
		dropdownWidth:'auto',
		appendMethod:'replace',
		source:[
			function( q,add ){

				if( q !== "") {
					$.ajax({
						url: baseURL+"/creditNotes/select_product/"+encodeURIComponent(q),
						dataType : 'json',
						success: function(resp){
							add(resp.data);
						}
					});
				}
			},
		],

	}).on('selected.xdsoft', function(e, datum){ 

		$.each( datum, function( key, value ) {
			var tableRow = $('.table-body-scrollable .table-responsive table tbody tr[row-index='+workingRowIndex+']');
			var rowCell = tableRow.children('td#'+key);
			var cellInput = rowCell.children('.table-cell-input');
			cellInput.val(value);
		});
		$('#selectProduct_form')[0].reset();
		new_product_added(workingRowIndex);
		selectProductModal.close();
	});

	//************************************************************************************** */
	//************************************************************************************** */
	//**************     Horizontal Scroll Activation De-Activation     ******************** */
	//************************************************************************************** */
	//************************************************************************************** */

	$('.table-responsive').scroll(function() {
		var scrollbarWidth = $(this).get(0).scrollWidth - $(this).width();
		var currentPosition = $(this).scrollLeft();
		if((currentPosition + 30) >= scrollbarWidth){
			$('.table-body-fixed').removeClass('table-shadow');
		} else {
			$('.table-body-fixed').addClass('table-shadow');
		}
	});

	//************************************************************************************** */
	//************************************************************************************** */
	//**************     Products Table Row Operations Manipulations     ******************* */
	//************************************************************************************** */
	//************************************************************************************** */

	function add_empty_productrow() {

		setAutocompleteOff();

		setScrollableContent(creditNote_product_serial);

		setFixedContent(creditNote_product_serial);

		$(".table-body-scrollable table tbody .creditNote-totals-row-scrollable").before(scrollableContent);
		$(".table-body-fixed table tbody .creditNote-totals-row-fixed").before(fixedContent);
		$('.table-body-scrollable table tbody tr.product-details-row-scrollable:last').attr('row-index', creditNote_product_serial);
		$('.table-body-fixed table tbody tr.product-details-row-fixed:last').attr('row-index', creditNote_product_serial);
		$('input#creditNoteSerial:last').val(creditNote_product_serial);
		// $("#eventregion_table").on('click','.bfh-datepicker',function() {
		/*$('#product-tbody').find('.bfh-datepicker').each(function () {
			var $datepicker;
			$datepicker = $(this);
			$datepicker.bfhdatepicker($datepicker.data());
		});*/
		setRowHeight();

		creditNote_product_serial++;
	}

	function delete_productrow(row_id) {
		$('tr.product-details-row-scrollable[row-index='+row_id+']').remove();
		$('tr.product-details-row-fixed[row-index='+row_id+']').remove();
	}

	function renumber_productrow() {
		$('tr.product-details-row-scrollable').each(function(i, obj) {
			$(this).attr('row-index', i+1);
		});

		$('tr.product-details-row-fixed').each(function(i, obj) {
			$(this).attr('row-index', i+1);
		});

		$('input#creditNoteSerial').each(function(i, obj) {
			$(this).val(i+1);
			creditNote_product_serial = i+2;
		});
	}

	$('#add-empty-row-button').on('click', function(e){
		e.preventDefault();
		add_empty_productrow()
	})

	tableFixed.on('click', 'a.delete-row-link', function(e){
		e.preventDefault();

		var rowId = $(this).parents('tr.product-details-row-fixed').attr('row-index');
		delete_productrow(rowId);

		creditNote_product_serial = 1; // Since renumbering wont happen after deleting all rows in previous step, assinging value manually
		renumber_productrow();
		setTotalsRow();
		finalRoundingoff();
	});

	//************************************************************************************** */
	//************************************************************************************** */
	//**************************     Change Events     ************************************* */
	//************************************************************************************** */
	//************************************************************************************** */

	//	Change Event for Discount Type change on table
	// Setting Discount percent or value based on heding radio button change
	// Applies to all product rows
	$('input[type=radio][name=discountType]').on('change', function() {
		var activeDiscountMode = $(this).val();
		var percentElem = tableScrollable.find('td#discountRate');
		var valueElem = tableScrollable.find('td#discountValue');
		if(activeDiscountMode === 'discountRate') {
			percentElem.removeClass('d-none');
			percentElem.find('input.table-cell-input').val('0.00').change();
			valueElem.children('input.table-cell-input').val('');
			valueElem.addClass('d-none');
		} else {
			percentElem.children('input.table-cell-input').val('');
			percentElem.addClass('d-none');
			valueElem.removeClass('d-none');
			valueElem.find('input.table-cell-input').val('0.00').change();
		}
	});

	// Change event for input fields of the table
	tableScrollable.on('keyup update change paste', '.table-cell-input', function(e){
		setProductTotal($(this));
	});

	// Change event for select fields of the table
	tableScrollable.on('change update', 'select#taxRate', function(e){
		setTaxRatesAndValues($(this));
	});

	// CHange event for Place of supply select box change
	$('select#placeOfSupply').on('change update', function(e){

		$('tr.product-details-row-scrollable').each(function(i, obj) {
			var actionElement = $(this).find('.table-cell-input#description');
			setProductTotal(actionElement);
		});

	});
	
	// Change event for CESS rate & CESS Value interupdation
	/*tableScrollable.on('change keyup update paste', 'input#cessValue, input#cessRate', function(e){
		var workingDetailsRow = $(this).parents('tr.product-details-row-scrollable');
		var cessValue = workingDetailsRow.find('input#cessValue').val();
		var cessRate = workingDetailsRow.find('input#cessRate').val();
		var taxableValue = workingDetailsRow.find('.table-cell-input#taxableValue').val();
		var changingCessId = $(this).attr('id');
		if(changingCessId === 'cessRate') {
			cessValue = ((taxableValue / 100) * cessRate).toFixed(2);
			workingDetailsRow.find('input#cessValue').val(cessValue)
		} else {
			cessRate = ((100 / taxableValue) * cessValue).toFixed(2);
			workingDetailsRow.find('input#cessRate').val(cessRate);
		}
	});*/

	$('input#roundOffState[type=checkbox]').on('change', function(e){
		finalRoundingoff();
	});

	$('input#amountRecieved').on('change', function(e){
		setCreditNoteStatus($(this).val());
	});
	$('select#creditNoteStatus').on('change', function(e){
		setAmountRecieved($(this).val());
	});

	//************************************************************************************** */
	//************************************************************************************** */
	//**************************     JQUERY Function to      ******************************* */
	//******************** and active hori scrolling in the products table ***************** */
	//************************************************************************************** */
	//************************************************************************************** */


	jQuery(function ($) {
		$.fn.hScroll = function (amount) {
			amount = amount || 120;
			$(this).bind("DOMMouseScroll mousewheel", function (event) {
				var oEvent = event.originalEvent, 
					direction = oEvent.detail ? oEvent.detail * -amount : oEvent.wheelDelta, 
					position = $(this).scrollLeft();
				position += direction > 0 ? -amount : amount;
				$(this).scrollLeft(position);
				event.preventDefault();
			})
		};
	});

	$(document).ready(function(){
		// Making Products Table Scroll Horizontal
		$('.creditNote-products-list-table').hScroll(30);
	});

	//************************************************************************************** */
	//************************************************************************************** */
	//**************************     Functions      **************************************** */
	//************************************************************************************** */
	//************************************************************************************** */


	function new_product_added(workingRowIndex) {

		// trigger a cess value change to re-calculate cess value change
		tableScrollable.find('tr[row-index='+workingRowIndex+'] input#cessValue').change();

		//Making the description cell and HSN cell readonly after selecting product
		tableScrollable.find('tr[row-index='+workingRowIndex+'] input#description').attr('readonly', 'readonly');
		tableScrollable.find('tr[row-index='+workingRowIndex+'] input#hsn').attr('readonly', 'readonly');
		tableScrollable.find('tr[row-index='+workingRowIndex+'] input#description').parent('td.product-detail-cell').addClass('readonly-cell');
		tableScrollable.find('tr[row-index='+workingRowIndex+'] input#hsn').parent('td.product-detail-cell').addClass('readonly-cell');

		// set actionElement as the description cell of the row in which a product has been selected
		var actionElement = tableScrollable.find('tr[row-index='+workingRowIndex+'] input#description');

		//calling main total calculating function
		setProductTotal(actionElement);

	}

	function setRowHeight() {
		$('tr.product-details-row-scrollable').each(function(i, obj) {
			var sourceElement = $(this).find('td#creditNoteSerial');
			var sourceHeight = sourceElement.outerHeight( true );			
			var rowIndex  = $(this).attr('row-index');
			var destinyElement = tableFixed.find('tr.product-details-row-fixed[row-index='+rowIndex+'] td#grossvalue');
			destinyElement.css('height', sourceHeight);

			var sourceHeader = tableScrollable.find('table thead th');
			var sourceHeaderHeight = sourceHeader.outerHeight( true );
			var targetHeaderElement = tableFixed.find('table thead th');
			targetHeaderElement.css('height', sourceHeaderHeight);
		});
	}

	function setProductTotal(actionElement) {

		var workingDetailsRow = actionElement.parents('tr.product-details-row-scrollable');
		workingRowIndex = actionElement.parents('tr.product-details-row-scrollable').attr('row-index');
		var workingTotalRow = tableFixed.find('tr.product-details-row-fixed[row-index='+workingRowIndex+']');

		var saleValue = workingDetailsRow.find('.table-cell-input#saleValue').val();
		var discountValue = workingDetailsRow.find('.table-cell-input#discountValue').val();
		var discountRate = workingDetailsRow.find('.table-cell-input#discountRate').val();
		var quantity = workingDetailsRow.find('.table-cell-input#quantity').val();
		var taxRate = workingDetailsRow.find('.table-cell-input#taxRate').val();

		var activeDiscountMode = $('input[type=radio][name=discountType]:checked').val();

		if(activeDiscountMode === 'discountrate') {
			var discountAmount = (saleValue / 100) * discountRate ;
		} else {
			var discountAmount = discountValue;
		}

		var taxableValue = ((saleValue - discountAmount) * quantity ).toFixed(2);
		workingDetailsRow.find('.table-cell-input#taxableValue').val(taxableValue);

		setTaxRatesAndValues(actionElement);

		// var cessValue = workingDetailsRow.find('input#cessValue').val();

		var grossValue = (((taxableValue / 100) * taxRate) + parseFloat(taxableValue)/* + parseFloat(cessValue * quantity)*/);
		workingTotalRow.find('.table-cell-input#grossvalue').val((grossValue).toFixed(2));

		setTotalsRow();

		finalRoundingoff();
	}

	function setTaxRatesAndValues(actionElement) {

		var workingDetailsRow = actionElement.parents('tr.product-details-row-scrollable');

		var taxableValue = workingDetailsRow.find('.table-cell-input#taxableValue').val();
		var taxRate = workingDetailsRow.find('.table-cell-input#taxRate').val();

		var placeOfOrigin = $('span#placeoforigin').html();
		var placeOfSupply = $('select#placeOfSupply').val();
		
		if(placeOfSupply.length > 1) {

			if(placeOfSupply.toUpperCase() === placeOfOrigin.toUpperCase()) {

				var halfTaxrate = (taxRate / 2).toFixed(2);
				var taxvalue = (halfTaxrate * (taxableValue/100)).toFixed(2);

				workingDetailsRow.find('.table-cell-input#cgstRate').val(halfTaxrate);
				workingDetailsRow.find('.table-cell-input#cgstValue').val(taxvalue);
				workingDetailsRow.find('.table-cell-input#sgstRate').val(halfTaxrate);
				workingDetailsRow.find('.table-cell-input#sgstValue').val(taxvalue);

				workingDetailsRow.find('.table-cell-input#igstRate').val('0.00');
				workingDetailsRow.find('.table-cell-input#igstValue').val('0.00');
			
			} else {

				var taxvalue = (taxRate * (taxableValue/100)).toFixed(2);
				taxRate = (taxRate * 1).toFixed(2);


				workingDetailsRow.find('.table-cell-input#igstRate').val(taxRate);
				workingDetailsRow.find('.table-cell-input#igstValue').val(taxvalue);

				workingDetailsRow.find('.table-cell-input#cgstRate').val('0.00');
				workingDetailsRow.find('.table-cell-input#cgstValue').val('0.00');
				workingDetailsRow.find('.table-cell-input#sgstRate').val('0.00');
				workingDetailsRow.find('.table-cell-input#sgstValue').val('0.00');

			}
		
		} else {

			var taxvalue = (taxRate * (taxableValue/100)).toFixed(2);
			taxRate = (taxRate * 1).toFixed(2);

			workingDetailsRow.find('.table-cell-input#igstRate').val(taxRate);
			workingDetailsRow.find('.table-cell-input#igstValue').val(taxvalue);

			workingDetailsRow.find('.table-cell-input#cgstRate').val('0');
			workingDetailsRow.find('.table-cell-input#cgstValue').val('0');
			workingDetailsRow.find('.table-cell-input#sgstRate').val('0');
			workingDetailsRow.find('.table-cell-input#sgstValue').val('0');
			
		}
	}

	function setTotalsRow() {
		var totalsRow = $('.creditNote-totals-row-scrollable');

		var totalTaxableValue = 0;
		var totalIgstValue = 0;
		var totalCgstValue = 0;
		var totalSgstValue = 0;
		var totalCessValue = 0;
		var netValue = 0;

		$('tr.product-details-row-scrollable').each(function(i, obj) {

			totalTaxableValue += parseFloat($(this).find('.table-cell-input#taxableValue').val());
			totalIgstValue += parseFloat($(this).find('.table-cell-input#igstValue').val());
			totalCgstValue += parseFloat($(this).find('.table-cell-input#cgstValue').val());
			totalSgstValue += parseFloat($(this).find('.table-cell-input#sgstValue').val());
			totalCessValue += parseFloat($(this).find('.table-cell-input#cessValue').val());

			netValue += parseFloat($('.product-details-row-fixed[row-index='+(i+1)+']').find('.table-cell-input#grossvalue').val());

		});

		totalsRow.find('.table-cell-total#taxableValue').val((totalTaxableValue).toFixed(2));
		totalsRow.find('.table-cell-total#igstValue').val((totalIgstValue).toFixed(2));
		totalsRow.find('.table-cell-total#cgstValue').val((totalCgstValue).toFixed(2));
		totalsRow.find('.table-cell-total#sgstValue').val((totalSgstValue).toFixed(2));
		totalsRow.find('.table-cell-total#cessValue').val((totalCessValue).toFixed(2));

		var otherCharges = parseFloat($("#otherCharges").val());
		netValue = netValue+otherCharges;
		$('.table-cell-total#netValue').val((netValue).toFixed(2));

	}

	function finalRoundingoff(){
		// vsr otherCharges = $("#otherCharges").val();
		var  netValue = $('.table-cell-total#netValue').val();

		if($('input#roundOffState[type=checkbox]').prop('checked')){
			var rounded_total = Math.round(netValue);
		} else {
			var rounded_total = netValue;
		}

		$('#grandValue').val((parseFloat(rounded_total)).toFixed(2));
		$('#roundOffValue').val((rounded_total - netValue).toFixed(2));
	}

	function setCreditNoteStatus(amountRecieved) {

		amountRecievedFloat = parseFloat(amountRecieved).toFixed(2);
		$('input#amountRecieved').val(amountRecievedFloat);

		amountRecieved = parseFloat(amountRecieved);
		grandValue = parseFloat($('input#grandValue').val());

		$('select#creditNoteStatus').children('option[selected]').removeAttr('selected');

		if(amountRecieved < 1){
			$('select#creditNoteStatus').val("unpaid").change();
		}else if(amountRecieved < grandValue){
			$('select#creditNoteStatus').val("partial").change();
		}else if(amountRecieved === grandValue){
			$('select#creditNoteStatus').val("paid").change();
		}else if(amountRecieved > grandValue){
			$('select#creditNoteStatus').val("paid").change();
		}
		// if(amountRecieved < 1){
		// 	$('select#creditNoteStatus').children('option[value="unpaid"]').attr('selected', 'selected');
		// }else if(amountRecieved < $('input#grandValue').val()){
		// 	$('select#creditNoteStatus').children('option[value="partial"]').attr('selected', 'selected');
		// }else if(amountRecieved === $('input#amountRecieved').val()){
		// 	$('select#creditNoteStatus').children('option[value="paid"]').attr('selected', 'selected');
		// }
	}

	function setAmountRecieved(selectOption) {
		if(selectOption != 'quote') {
			$('input#amountRecieved').removeAttr('readonly');
		} else {
			$('input#amountRecieved').val('0.00');
			$('input#amountRecieved').attr('readonly', 'readonly');
		}
	}