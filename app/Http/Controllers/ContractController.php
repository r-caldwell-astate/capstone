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
        // Validate the incoming data
        $validated = $request->validate([
            'recipient_name' => 'required|string|max:255',
            'recipient_email' => 'required|email|max:255',
            'parts' => 'present|array', // 'present' allows an empty array of parts
        ]);

        // Create the main Contract record
        $contract = $request->user()->contracts()->create([
            'recipient_name' => $validated['recipient_name'],
            'recipient_email' => $validated['recipient_email'],
            'status_id' => 1, // Assuming '1' is the ID for 'Draft' status
        ]);

        // Reconstruct the full contract content for the version
        $fullContent = '';
        foreach ($validated['parts'] as $part) {
            // check if the 'type' key exists.
            if (isset($part['type']) && $part['type'] === 'text') {
                // text block.
                $fullContent .= $part['content'] . "\n\n";
            } else {
                // field block.
                $fullContent .= '{{' . $part['field_name'] . '}}' . "\n\n";
            }
        }

        // Create the first ContractVersion linked to this contract
        $version = $contract->versions()->create([
            'version_number' => 1,
            'content' => trim($fullContent),
            'created_date' => now(), // current date/time
        ]);

        // Loop through the parts again to save the specific field values
        foreach ($validated['parts'] as $part) {
            // Check if it's a field (and not a text block)
            if (isset($part['field_id'])) {
                $contract->fieldValues()->create([
                    'version_id' => $version->version_id,
                    'field_id' => $part['field_id'],
                    'field_value' => null, // The value is null because it's a draft
                ]);
            }
        }

        // Redirect back to the dashboard with a success message
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
        // Load the relationships for the edit view
        $contract->load(['versions', 'fieldValues.field']);

        return Inertia::render('Contracts/Create', [
            'availableFields' => ContractField::all(),
            'contract' => $contract, // Pass the existing contract data to the component
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contract $contract)
    {
        // Validate the incoming data
        $validated = $request->validate([
            'recipient_name' => 'required|string|max:255',
            'recipient_email' => 'required|email|max:255',
            'parts' => 'present|array',
        ]);

        // Update the main contract details
        $contract->update([
            'recipient_name' => $validated['recipient_name'],
            'recipient_email' => $validated['recipient_email'],
        ]);

        // Delete old records
        $contract->fieldValues()->delete();
        $contract->versions()->delete();


        $fullContent = '';
        foreach ($validated['parts'] as $part) {
            // Check if the part has a 'content' key to identify it as a text block
            if (isset($part['content'])) {
                $fullContent .= $part['content'] . "\n\n";
            } else {
                // Otherwise, it's a field block
                $fullContent .= '{{' . $part['field_name'] . '}}' . "\n\n";
            }
        }

        $version = $contract->versions()->create([
            'version_number' => $contract->versions()->count() + 1, // version number increment
            'content' => trim($fullContent),
            'created_date' => now(),
        ]);

        foreach ($validated['parts'] as $part) {
            // Check if the part has a 'field_id' key to identify it as a field
            if (isset($part['field_id'])) {
                $contract->fieldValues()->create([
                    'version_id' => $version->version_id,
                    'field_id' => $part['field_id'],
                    'field_value' => null, // null for drafts
                ]);
            }
        }

        return redirect()->route('dashboard')->with('success', 'Contract draft updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contract $contract)
    {
        //
    }
}
