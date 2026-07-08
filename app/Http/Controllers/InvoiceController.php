<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Support\Facades\Artisan;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with('member')->orderBy('created_at', 'desc')->get();
        return view('invoices.index', compact('invoices'));
    }

    public function triggerGenerate()
    {
        Artisan::call('billing:generate');
        $output = Artisan::output();
        return redirect()->back()->with('success', 'Billing Log: ' . $output);
    }

    public function triggerMassSuspend()
    {
        Artisan::call('billing:check-overdue');
        $output = Artisan::output();

        return redirect()->back()->with('success', 'Suspended Engine Log: ' . $output);
    }
}
