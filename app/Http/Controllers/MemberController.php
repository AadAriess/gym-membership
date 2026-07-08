<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Membership;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::with('membership')->get();
        return view('members.index', compact('members'));
    }

    public function show(Member $member)
    {
        $member->load(['membership', 'invoices.payments']);

        $monthsPaid = $member->invoices()->where('status', 'paid')->count();

        $totalPaidAmount = $member->invoices()->where('status', 'paid')->sum('total_amount');

        return view('members.show', compact('member', 'monthsPaid', 'totalPaidAmount'));
    }

    public function create()
    {
        $memberships = Membership::all();
        return view('members.create', compact('memberships'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'membership_id' => 'required|exists:memberships,id',
            'join_date' => 'required|date',
        ]);

        Member::create($validated);
        return redirect()->route('members.index')->with('success', 'Member berhasil ditambahkan.');
    }

    public function edit(Member $member)
    {
        $memberships = Membership::all();
        return view('members.edit', compact('member', 'memberships'));
    }

    public function update(Request $request, Member $member)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'membership_id' => 'required|exists:memberships,id',
            'join_date' => 'required|date',
            'status' => 'required|in:active,suspended',
        ]);

        $member->update($validated);
        return redirect()->route('members.index')->with('success', 'Data member berhasil diperbarui.');
    }

    public function destroy(Member $member)
    {
        $member->delete();
        return redirect()->route('members.index')->with('success', 'Member berhasil dihapus.');
    }
}
