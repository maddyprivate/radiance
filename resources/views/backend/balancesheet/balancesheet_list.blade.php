@extends('layouts.backend')
@section('content')
<section>
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header d-flex align-items-center">
						<div class="col-6">
							<h3 class="h4">@lang('laryl-accounts.heading.list')</h3>
						</div>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th> @lang('laryl-accounts.table.account') </th>
										<th> @lang('laryl-accounts.table.balance') </th>
									</tr>
								</thead>
								<tbody>
									@php
										$transaction_array = $balancesheet->toArray();
									@endphp
									@if(count($balancesheet) > 0)
										@foreach($balancesheet as $key => $transaction)
											<tr>
												<td class="t-up">{{$transaction['accountName']}}</td>
												<td class="t-cap">{{$transaction['balance']}}</td>
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
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection