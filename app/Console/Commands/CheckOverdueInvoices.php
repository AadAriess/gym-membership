<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Invoice;
use App\Models\Member;
use Carbon\Carbon;

class CheckOverdueInvoices extends Command
{
    protected $signature = 'billing:check-overdue';
    protected $description = 'Suspend members who have unpaid invoices pas the due date';
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::now()->toDateString();

        $overdueMemberIds = Invoice::where('status', 'unpaid')
            ->where('due_date', '<=', $today)
            ->pluck('member_id')
            ->unique();

        if ($overdueMemberIds->isEmpty()) {
            $this->info('No member has no pay today.');
            return Command::SUCCESS;
        }

        $updated = Member::whereIn('id', $overdueMemberIds)
            ->where('status', 'active')
            ->update(['status' => 'suspended']);

        $this->info("Succes suspended {$updated} member has late paid.");
        return Command::SUCCESS;
    }
}
