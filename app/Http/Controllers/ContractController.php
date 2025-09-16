<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\ContractField;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ContractController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Contracts/Create', [
            'availableFields' => ContractField::all()->toArray(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validate the incoming data
        $validated = $request->validate([
            'recipient_name' => 'required|string|max:255',
            'recipient_email' => 'required|email|max:255',
            'parts' => 'required|array',
        ]);

        // 2. Create the Contract record, manually adding the user's ID
        $contract = Contract::create([
            'recipient_name' => $validated['recipient_name'],
            'recipient_email' => $validated['recipient_email'],
            'status_id' => 1, // Assuming '1' is the ID for 'Draft' status
            'user_id' => $request->user()->id, // We are now explicitly setting the user ID
        ]);

        // dd($contract);

        // Note: Logic to save the contract version and field values will go here next.

        // 3. Redirect back to the dashboard
        return redirect()->route('dashboard')->with('success', 'Contract saved as a draft.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Contract $contract)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contract $contract)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contract $contract)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contract $contract)
    {
        //
    }
}
