<?php

namespace App\Http\Controllers\Backend;

use App\Invoice;
use App\Transaction;
use App\InvoicePayment;
use Illuminate\Http\Request;
use App\Http\Controllers\AceController\Controller;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {

        $request->route()->setParameter('page-heading', 'Dashboard');

        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $request->user()->authorizeRoles(['user', 'admin']);
        $currentDate = date('Y-m-d');
        $todaysIncome = Transaction::where('date',$currentDate)->whereIn('type',['Income','Deposit'])->sum('amount');
        $todaysExpense = Transaction::where('date',$currentDate)->whereIn('type',['Expense'])->sum('amount');
        $monthlyIncome = Transaction::whereMonth('date', date('m'))->whereIn('type',['Income','Deposit'])->sum('amount');
        $monthlyExpense = Transaction::whereMonth('date', date('m'))->whereIn('type',['Expense'])->sum('amount');
        // dd($todaysIncome);
        // $todaysTotal = InvoicePayment::where('issueDate',$currentDate)->sum('amount');
        $invoices = Invoice::paginate(10);
        return view('backend.dashboard', compact('invoices','todaysIncome','todaysExpense','monthlyIncome','monthlyExpense'));
    }
}
