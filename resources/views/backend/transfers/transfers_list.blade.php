@extends('layouts.backend')

@section('content')

<section>
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header d-flex align-items-center">
						<div class="col-6">
							<h3 class="h4">@lang('laryl-transfers.heading.list')</h3>
						</div>
						<div class="col-6 text-right">
							<a href="{{ route('Transfers.transfers.create')  }}" class="bttn-plain">
								<i class="fas fa-file-transfer"></i>&emsp;@lang('laryl-transfers.buttons.create-new')
							</a>
						</div>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table">
								<thead>
									<tr>
										<th> @lang('laryl-transfers.table.#') </th>
										<th> @lang('laryl-transfers.table.date') </th>
										<th> @lang('laryl-transfers.table.fromAccountId') </th>
										<th> @lang('laryl-transfers.table.toAccountId') </th>
										<th> @lang('laryl-transfers.table.amount') </th>
										<th> @lang('laryl-transfers.table.description') </th>
										<th> @lang('laryl-transfers.table.method') </th>
										<th> @lang('laryl-transfers.table.ref') </th>
										<th> @lang('laryl-transfers.table.options') </th>
									</tr>
								</thead>
								<tbody>
									@php
										$transfer_array = $transfers->toArray();
									@endphp

									@if(count($transfers) > 0)

										@foreach($transfers as $key => $transfer)
											<tr>
												<th class="scope-row">{{$key+1}}</th>
												<td class="t-cap">{{dmyDate($transfer['date'])}}</td>
												<td class="t-cap">{{$transfer['fromaccounts']['accountName']}}</td>
												<td class="t-cap">{{$transfer['toAccount']}}</td>
												<!-- <td class="t-cap">{{$transfer['toaccounts']['accountName']}}</td> -->
												<td class="t-cap">Rs. {{$transfer['amount']}}</td>
												<td class="t-cap">{{$transfer['description']}}</td>
												<td class="t-cap">{{$transfer['method']}}</td>
												<td class="t-cap">{{$transfer['ref']}}</td>
												<td>

														<a class="btn btn-sm btn-warning mb-2 mb-sm-0" href="{{ route('Transfers.transfers.edit', $transfer['id'])  }}" data-toggle="tooltip" title="@lang('laryl.tooltips.edit')">
															@lang('laryl.buttons.edit')
														</a>

												</td>
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
								{{ $transfers->render() }}
							</div>

							<div class="col d-sm-none">
								{{ $transfers->links('pagination::simple-bootstrap-4') }}
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection