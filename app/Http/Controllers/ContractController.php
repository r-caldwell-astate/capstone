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
        $validated = $request->validate([
            'recipient_name' => 'required|string|max:255',
            'recipient_email' => 'required|email|max:255',
            'parts' => 'present|array', // present allows an empty array of parts
        ]);

        // Create the main Contract record
        $contract = $request->user()->contracts()->create([
            'recipient_name' => $validated['recipient_name'],
            'recipient_email' => $validated['recipient_email'],
            'status_id' => 1, // 1 is the ID for 'Draft' status
        ]);

        // full contract content
        $fullContent = '';
        foreach ($validated['parts'] as $part) {
            // check if the 'type' key exists
            if (isset($part['type']) && $part['type'] === 'text') {
                // text block
                $fullContent .= $part['content'] . "\n\n";
            } else {
                // field block
                $fullContent .= '{{' . $part['field_name'] . '}}' . "\n\n";
            }
        }

        $version = $contract->versions()->create([
            'version_number' => 1,
            'content' => trim($fullContent),
            'created_date' => now(),
        ]);

        foreach ($validated['parts'] as $part) {
            if (isset($part['field_id'])) {
                $contract->fieldValues()->create([
                    'version_id' => $version->version_id,
                    'field_id' => $part['field_id'],
                    'field_value' => null, 
                ]);
            }
        }

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
        $contract->load(['versions', 'fieldValues.field']);

        return Inertia::render('Contracts/Create', [
            'availableFields' => ContractField::all(),
            'contract' => $contract,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contract $contract)
    {
        $validated = $request->validate([
            'recipient_name' => 'required|string|max:255',
            'recipient_email' => 'required|email|max:255',
            'parts' => 'present|array',
        ]);

        $contract->update([
            'recipient_name' => $validated['recipient_name'],
            'recipient_email' => $validated['recipient_email'],
        ]);

        $contract->fieldValues()->delete();
        $contract->versions()->delete();

        $fullContent = '';

        // Check for 'content' key to identify text blocks
        foreach ($validated['parts'] as $part) {
            if (isset($part['content'])) {
                $fullContent .= $part['content'] . "\n\n";
            } else {
                $fullContent .= '{{' . $part['field_name'] . '}}' . "\n\n";
            }
        }

        $version = $contract->versions()->create([
            'version_number' => $contract->versions()->count() + 1,
            'content' => trim($fullContent),
            'created_date' => now(),
        ]);

        // Check for 'field_id' key to identify field blocks
        foreach ($validated['parts'] as $part) {
            if (isset($part['field_id'])) {
                $contract->fieldValues()->create([
                    'version_id' => $version->version_id,
                    'field_id' => $part['field_id'],
                    'field_value' => null,
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
