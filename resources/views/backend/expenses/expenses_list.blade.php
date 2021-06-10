@extends('layouts.backend')

@section('content')

<section>
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header d-flex align-items-center">
						<div class="col-6">
							<h3 class="h4">@lang('laryl-expenses.heading.list')</h3>
						</div>
						<div class="col-6 text-right">
							<a href="{{ route('Expenses.expenses.create')  }}" class="bttn-plain">
								<i class="fas fa-file-expense"></i>&emsp;@lang('laryl-expenses.buttons.create-new')
							</a>
						</div>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table">
								<thead>
									<tr>
										<th> @lang('laryl-expenses.table.#') </th>
										<th> @lang('laryl-expenses.table.date') </th>
										<th> @lang('laryl-expenses.table.amount') </th>
										<th> @lang('laryl-expenses.table.account_id') </th>
										<th> @lang('laryl-expenses.table.description') </th>
										<th> @lang('laryl-expenses.table.chequeNo') </th>
										<th> @lang('laryl-expenses.table.ref') </th>
										<th> @lang('laryl-expenses.table.person') </th>
									</tr>
								</thead>
								<tbody>
									@php
										$expense_array = $expenses->toArray();
										$i = $expense_array['from'];
									@endphp

									@if(count($expenses) > 0)

										@foreach($expenses as $key => $expense)
											<tr>
												<th class="scope-row">{{$key+1}}</th>
												<td class="t-cap">{{$expense['date']}}</td>
												<td class="t-up">Rs. {{$expense['amount']}}</td>
												<td class="t-up">{{$expense['accounts']['accountName']}}</td>
												<td class="t-cap">{{$expense['description']}}</td>
												<td class="t-cap">{{$expense['chequeNo']}}</td>
												<td class="t-cap">{{$expense['ref']}}</td>
												<td class="t-cap">{{$expense['person']}}</td>
												<!-- <td>

														<a class="btn btn-sm btn-success mb-2 mb-sm-0" href="{{ route('Expenses.expenses.show', $expense['id'])  }}" data-toggle="tooltip" title="@lang('laryl.tooltips.show')">
															@lang('laryl.buttons.show')
														</a>

														<a class="btn btn-sm btn-warning mb-2 mb-sm-0" href="{{ route('Expenses.expenses.edit', $expense['id'])  }}" data-toggle="tooltip" title="@lang('laryl.tooltips.edit')">
															@lang('laryl.buttons.edit')
														</a>

												</td> -->
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

						<div class="row">
							<div class="col d-none d-sm-block">
								{{ $expenses->render() }}
							</div>

							<div class="col d-sm-none">
								{{ $expenses->links('pagination::simple-bootstrap-4') }}
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection