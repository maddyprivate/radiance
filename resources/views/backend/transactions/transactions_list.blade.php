@extends('layouts.backend')
@section('content')
<section>
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header d-flex align-items-center">
						<div class="col-6">
							<h3 class="h4">@lang('laryl-transactions.heading.list')</h3>
						</div>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table" id="transTable">
								<thead>
									<tr>
										<th> @lang('laryl-transactions.table.#') </th>
										<th> @lang('laryl-transactions.table.date') </th>
										<th> @lang('laryl-transactions.table.account') </th>
										<th> @lang('laryl-transactions.table.type') </th>
										<th> @lang('laryl-transactions.table.amount') </th>
										<th> @lang('laryl-transactions.table.description') </th>
										<th> @lang('laryl-transactions.table.dr') </th>
										<th> @lang('laryl-transactions.table.cr') </th>
										<th> @lang('laryl-transactions.table.balance') </th>
									</tr>
								</thead>
								<tbody>
									@php
										$transaction_array = $transactions->toArray();
									@endphp
									@if(count($transactions) > 0)
										@foreach($transactions as $key => $transaction)
											<tr>
												<th class="scope-row">{{$key+1}}</th>
												<td class="t-cap">{{$transaction['date']}}</td>
												<td class="t-up">{{$transaction['account']}}</td>
												<td class="t-up">{{$transaction['type']}}</td>
												<td class="t-up">Rs. {{$transaction['amount']}}</td>
												<td class="t-cap">{{$transaction['description']}}</td>
												<td class="t-cap">{{$transaction['dr']}}</td>
												<td class="t-cap">{{$transaction['cr']}}</td>
												<td class="t-cap">{{$transaction['bal']}}</td>
											</tr>
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
								{{ $transactions->render() }}
							</div>
							<div class="col d-sm-none">
								{{ $transactions->links('pagination::simple-bootstrap-4') }}
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection
@section('footer')
	<script type="text/javascript">
		$(document).ready(function() {
		    $('#transTable').DataTable({
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
		    });
		} );
	</script>
@endsection