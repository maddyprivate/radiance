<?php

namespace App\Http\Controllers\Backend;

use App\Invoice;
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
        $invoices = Invoice::paginate(10);
        return view('backend.dashboard', compact('invoices'));
    }
}
