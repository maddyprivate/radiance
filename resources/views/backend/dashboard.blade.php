@extends('layouts.backend')

@section('content')

<section class="pb-0">
    <div class="container">
        <div class="col-md-12">
            <div class="row">
                <div class="col-lg-3">
                    <div class="widget style1 lazur-bg info-tile info-tile-alt tile-teal">
                        <div class="row">
                            <div class="col-xs-2">
                                <i class="fa fa-plus fa-2x"></i>
                            </div>
                            <div class="col-xs-10 text-right">
                                <span> Income Today </span>
                                <h3 class="font-bold amount">Rs. {{$todaysIncome}}</h3>
                                <a href="{{url('deposits/create')}}" class="btn btn-success btn-xs">Add Deposit</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="widget style1 red-bg info-tile info-tile-alt tile-danger">
                        <div class="row">
                            <div class="col-xs-2">
                                <i class="fa fa-minus fa-2x"></i>
                            </div>
                            <div class="col-xs-10 text-right">
                                <span> Expense Today </span>
                                <h3 class="font-bold amount">Rs.{{$todaysExpense}}</h3>
                                <a href="{{url('expenses/create')}}" class="btn btn-warning btn-xs">Add Expense</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="widget style1 lazur-bg info-tile info-tile-alt tile-teal">
                        <div class="row">
                            <div class="col-xs-2">
                                <i class="fa fa-plus fa-2x"></i>
                            </div>
                            <div class="col-xs-10 text-right">
                                <span> Income This Month </span>
                                <h3 class="font-bold amount">Rs.{{$monthlyIncome}}</h3>
                                <a href="{{url('deposits/create')}}" class="btn btn-success btn-xs">Add Deposit</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="widget style1 red-bg info-tile info-tile-alt tile-danger">
                        <div class="row">
                            <div class="col-xs-2">
                                <i class="fa fa-minus fa-2x"></i>
                            </div>
                            <div class="col-xs-10 text-right">
                                <span> Expense This Month </span>
                                <h3 class="font-bold amount">Rs.{{$monthlyExpense}}</h3>
                                <a href="{{url('expenses/create')}}" class="btn btn-warning btn-xs">Add Expense</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Welcome {{auth()->user()->name}}!</div>

                    <div class="card-body">
                        @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                        @endif

                        You are logged in!
                        <br />

                    </div>
                </div>
            </div>
        </div> -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <div class="col-6">
                            <h3 class="h4">@lang('laryl-invoices.heading.list')</h3>
                        </div>
                        <div class="col-6 text-right">
                            <a href="{{ route('Invoices.invoices.create')  }}" class="bttn-plain">
                                <i class="fas fa-file-invoice"></i>&emsp;@lang('laryl-invoices.buttons.create-new')
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th> @lang('laryl-invoices.table.#') </th>
                                        <th> @lang('laryl-invoices.table.issueDate') </th>
                                        <!-- <th> @lang('laryl-invoices.table.dueDate') </th> -->
                                        <th> @lang('laryl-invoices.table.invoiceStatus') </th>
                                        <th> @lang('laryl-invoices.table.grandValue') </th>
                                        <th> @lang('laryl-invoices.table.options') </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $invoice_array = $invoices->toArray();
                                    $i = $invoice_array['from'];
                                    @endphp

                                    @if(count($invoices) > 0)

                                    @foreach($invoices as $invoice)
                                    <tr>
                                        <th class="scope-row">{{$i}}</th>
                                        <td class="t-cap">{{date('d/m/Y',strtotime($invoice['issueDate']))}}</td>
                                        <!-- <td class="t-up">{{$invoice['dueDate']}}</td> -->
                                        <td class="t-up">{{$invoice['invoiceStatus']}}</td>
                                        <td class="t-cap">Rs. {{$invoice['grandValue']}}</td>
                                        <td>

                                            <a class="btn btn-sm btn-success mb-2 mb-sm-0" href="{{ route('Invoices.invoices.show', $invoice['id'])  }}" data-toggle="tooltip" title="@lang('laryl.tooltips.show')">
                                                @lang('laryl.buttons.show')
                                            </a>

                                            <a class="btn btn-sm btn-warning mb-2 mb-sm-0" href="{{ route('Invoices.invoices.edit', $invoice['id'])  }}" data-toggle="tooltip" title="@lang('laryl.tooltips.edit')">
                                                @lang('laryl.buttons.edit')
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

                        <div class="row">
                            <div class="col d-none d-sm-block">
                                {{ $invoices->render() }}
                            </div>

                            <div class="col d-sm-none">
                                {{ $invoices->links('pagination::simple-bootstrap-4') }}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
