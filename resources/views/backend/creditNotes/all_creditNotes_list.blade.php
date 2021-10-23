@extends('layouts.backend')

@section('content')

<section>
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header d-flex align-items-center">
						<div class="col-6">
							<h3 class="h4">@lang('laryl-creditNotes.heading.list')</h3>
						</div>
						<div class="col-6 text-right">
							<a href="{{ route('CreditNotes.creditNotes.create')  }}" class="bttn-plain">
								<i class="fas fa-file-creditNote"></i>&emsp;@lang('laryl-creditNotes.buttons.create-new')
							</a>
						</div>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table" id="creditNoteTable">
								<thead>
									<tr>
										<th> @lang('laryl-creditNotes.table.#') </th>
										<th> @lang('laryl-creditNotes.table.issueDate') </th>
										<!-- <th> @lang('laryl-creditNotes.table.dueDate') </th> -->
										<th> @lang('laryl-creditNotes.table.customer') </th>
										<th> @lang('laryl-creditNotes.table.creditNoteStatus') </th>
										<th> @lang('laryl-creditNotes.table.grandValue') </th>
										<th> @lang('laryl-creditNotes.table.options') </th>
									</tr>
								</thead>
								<tbody>
									@php
										$creditNote_array = $creditNotes->toArray();
										$i = 1;
									@endphp

									@if(count($creditNotes) > 0)

										@foreach($creditNotes as $creditNote)
											<tr>
												<th class="scope-row">{{$i}}</th>
												<td class="t-cap">{{date('d/m/Y', strtotime($creditNote['issueDate']))}}</td>
												<!-- <td class="t-up">{{date('d/m/Y', strtotime($creditNote['dueDate']))}}</td> -->
												<td class="t-up">{{$creditNote['customer']['name']}}</td>
												<td class="t-up">{{$creditNote['creditNoteStatus']}}</td>
												<td class="t-cap">Rs. {{$creditNote['grandValue']}}</td>
												<td>

														<a class="btn btn-sm btn-success mb-2 mb-sm-0" href="{{ route('CreditNotes.creditNotes.show', $creditNote['id'])  }}" data-toggle="tooltip" title="@lang('laryl.tooltips.show')">
															@lang('laryl.buttons.show')
														</a>

														<a class="btn btn-sm btn-warning mb-2 mb-sm-0" href="{{ route('CreditNotes.creditNotes.edit', $creditNote['id'])  }}" data-toggle="tooltip" title="@lang('laryl.tooltips.edit')">
															@lang('laryl.buttons.edit')
														</a>
														<a class="btn btn-sm btn-primary mb-2 mb-sm-0" data-remodal-target="creditNoteStatusChange" href="javascript:;"  title="@lang('laryl.tooltips.payment')" onclick="$('#creditNoteStatusChange').val('{{$creditNote['creditNoteStatus']}}');$('#id').val('{{$creditNote['id']}}');">
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
								<a href="{{url('creditNotes')}}" class="btn btn-sm btn-primary"> List Page wise</a>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<div class="remodal" data-remodal-id="creditNoteStatusChange" aria-labelledby="modalTitle" aria-describedby="modalDesc" data-remodal-options="hashTracking: false, closeOnOutsideClick: false">
	<button data-remodal-action="close" class="remodal-close" aria-label="Close"></button>
	<div>
		<form id="creditNoteStatusChange_form" method="post" action="{{url('changeCreditNoteStatus')}}">
			@csrf
			<div class="form-group row align-items-center">
				<label for="creditNoteStatus" class="col-md-5 col-form-label">Change to @lang('laryl-creditNotes.form.label.creditNoteStatus')</label>
				<div class="col-sm-7">
					<div class="col-md-12">
						<select id="creditNoteStatus" name="creditNoteStatus" class="form-control">
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
		$('#creditNoteTable').DataTable( {
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