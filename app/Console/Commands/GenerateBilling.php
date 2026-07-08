<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Member;
use App\Models\Invoice;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class GenerateBilling extends Command
{
    protected $signature = 'billing:generate';
    protected $description = 'Generate monthly invoices for all active gym members';
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now();
        $currentMonth = $now->month;
        $currentYear = $now->year;

        $activeMembers = Member::where('status', 'active')
            ->whereNotExists(function ($query) use ($currentMonth, $currentYear) {
                $query->select(DB::raw(1))
                    ->from('invoices')
                    ->whereColumn('invoices.member_id', 'members.id')
                    ->where('invoices.billing_month', $currentMonth)
                    ->where('invoices.billing_year', $currentYear);
            })->with('membership')->get();

        if ($activeMembers->isEmpty()) {
            $this->info('All member billing active already process.');
            return Command::SUCCESS;
        }

        $count = 0;
        foreach ($activeMembers as $member) {
            DB::transaction(function () use ($member, $currentMonth, $currentYear, $now, &$count) {
                $basePrice = $member->membership->monthly_price;
                $tax = $basePrice * 0.11; // 11% tax terpisah
                $total = $basePrice + $tax;

                $invoiceNumber = $this->generateInvoiceNumber($currentYear, $currentMonth);

                Invoice::create([
                    'member_id' => $member->id,
                    'invoice_number' => $invoiceNumber,
                    'billing_month' => $currentMonth,
                    'billing_year' => $currentYear,
                    'base_price' => $basePrice,
                    'tax' => $tax,
                    'total_amount' => $total,
                    'status' => 'unpaid',
                    'due_date' => $now->copy()->addDays(3)->toDateString(),
                ]);

                $count++;
            });
        }

        $this->info("Success create {$count} new invoice.");
        return Command::SUCCESS;
    }

    private function generateInvoiceNumber($year, $month)
    {
        $formattedMonth = str_pad($month, 2, '0', STR_PAD_LEFT);

        $lastInvoice = Invoice::where('billing_year', $year)
            ->where('billing_month', $month)
            ->orderBy('id', 'desc')
            ->first();

        $nextNumber = $lastInvoice ? ((int) substr($lastInvoice->invoice_number, -5)) + 1 : 1;
        $formattedNumber = str_pad($nextNumber, 5, '0', STR_PAD_LEFT);

        return "INV/{$year}/{$formattedMonth}/{$formattedNumber}";
    }
}
