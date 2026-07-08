<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PaymentController extends Controller
{
    public function store($invoiceId)
    {
        $invoice = Invoice::findOrFail($invoiceId);

        if ($invoice->status === 'paid') {
            return redirect()->back()->with('error', 'Invoice sudah lunas sebelumnya.');
        }

        DB::transaction(function () use ($invoice) {
            Payment::create([
                'invoice_id' => $invoice->id,
                'amount_paid' => $invoice->total_amount,
                'payment_date' => Carbon::now()->toDateString(),
            ]);

            $invoice->update(['status' => 'paid']);

            $member = $invoice->member;
            if ($member->status === 'suspended') {
                $member->update(['status' => 'active']);
            }
        });

        return redirect()->back()->with('success', 'Pembayaran berhasil diverifikasi.');
    }
}
