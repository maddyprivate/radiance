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
						<div class="col-6 text-right">
							<a href="{{ route('Settings.account.create')  }}" class="bttn-plain">
								<i class="fas fa-file-account"></i>&emsp;@lang('laryl-accounts.buttons.create-new')
							</a>
						</div>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table">
								<thead>
									<tr>
										<th> @lang('laryl-accounts.table.#') </th>
										<th> @lang('laryl-accounts.table.accountName') </th>
										<th> @lang('laryl-accounts.table.bankName') </th>
										<th> @lang('laryl-accounts.table.balance') </th>
										<th> @lang('laryl-accounts.table.accountNumber') </th>
										<th> @lang('laryl-accounts.table.ifscode') </th>
										<th> @lang('laryl-accounts.table.address') </th>
										<th> @lang('laryl-accounts.table.branch') </th>
										<th> @lang('laryl-accounts.table.description') </th>
										<!-- <th> @lang('laryl-accounts.table.action') </th> -->
									</tr>
								</thead>
								<tbody>
									@php
										$account_array = $accounts->toArray();
									@endphp

									@if(count($accounts) > 0)

										@foreach($accounts as $key=>$account)
											<tr>
												<th class="scope-row">{{$key+1}}</th>
												<td class="t-cap">{{$account['accountName']}}</td>
												<td class="t-cap">{{$account['bankName']}}</td>
												<td class="t-cap">{{$account['balance']}}</td>
												<td class="t-up">{{$account['accountNo']}}</td>
												<td class="t-up">{{$account['ifscCode']}}</td>
												<td class="t-cap">{{$account['address']}}</td>
												<td class="t-cap">{{$account['branch']}}</td>
												<td class="t-cap">{{$account['description']}}</td>
												<!-- <td>
													<a class="btn btn-sm btn-success mb-2 mb-sm-0" href="{{ route('Settings.account.show', $account['id'])  }}" data-toggle="tooltip" title="@lang('laryl.tooltips.show')">
														@lang('laryl.buttons.show')
													</a>

													<a class="btn btn-sm btn-warning mb-2 mb-sm-0" href="{{ route('Settings.account.edit', $account['id'])  }}" data-toggle="tooltip" title="@lang('laryl.tooltips.edit')">
														@lang('laryl.buttons.edit')
													</a>

												</td> -->
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