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
										<th> @lang('laryl-debitNotes.table.issueDate') </th>
										<!-- <th> @lang('laryl-debitNotes.table.dueDate') </th> -->
										<th> @lang('laryl-debitNotes.table.dealer') </th>
										<th> @lang('laryl-debitNotes.table.debitNoteStatus') </th>
										<th> @lang('laryl-debitNotes.table.grandValue') </th>
										<th> @lang('laryl-debitNotes.table.options') </th>
									</tr>
								</thead>
								<tbody>
									@php
										$debitNote_array = $debitNotes->toArray();
										$i = 1;
									@endphp

									@if(count($debitNotes) > 0)

										@foreach($debitNotes as $debitNote)
											<tr>
												<th class="scope-row">{{$i}}</th>
												<td class="t-cap">{{date('d/m/Y', strtotime($debitNote['issueDate']))}}</td>
												<!-- <td class="t-up">{{date('d/m/Y', strtotime($debitNote['dueDate']))}}</td> -->
												<td class="t-up">{{$debitNote['dealer']['name']}}</td>
												<td class="t-up">{{$debitNote['debitNoteStatus']}}</td>
												<td class="t-cap">Rs. {{$debitNote['grandValue']}}</td>
												<td>

														<a class="btn btn-sm btn-success mb-2 mb-sm-0" href="{{ route('DebitNotes.debitNotes.show', $debitNote['id'])  }}" data-toggle="tooltip" title="@lang('laryl.tooltips.show')">
															@lang('laryl.buttons.show')
														</a>

														<a class="btn btn-sm btn-warning mb-2 mb-sm-0" href="{{ route('DebitNotes.debitNotes.edit', $debitNote['id'])  }}" data-toggle="tooltip" title="@lang('laryl.tooltips.edit')">
															@lang('laryl.buttons.edit')
														</a>
														<a class="btn btn-sm btn-primary mb-2 mb-sm-0" data-remodal-target="debitNoteStatusChange" href="javascript:;"  title="@lang('laryl.tooltips.payment')" onclick="$('#debitNoteStatusChange').val('{{$debitNote['debitNoteStatus']}}');$('#id').val('{{$debitNote['id']}}');">
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
								<a href="{{url('debitNotes')}}" class="btn btn-sm btn-primary"> List Page wise</a>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<div class="remodal" data-remodal-id="debitNoteStatusChange" aria-labelledby="modalTitle" aria-describedby="modalDesc" data-remodal-options="hashTracking: false, closeOnOutsideClick: false">
	<button data-remodal-action="close" class="remodal-close" aria-label="Close"></button>
	<div>
		<form id="debitNoteStatusChange_form" method="post" action="{{url('changeInvoiceStatus')}}">
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
	$(document).ready(function() {
		$('#debitNoteTable').DataTable( {
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
	} );
</script>
@endsection