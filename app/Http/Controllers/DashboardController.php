<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contract;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = $request->user();
        $ownerId = $user?->id ?? $user?->user_id ?? null;

        $q      = $request->query('q');
        $status = $request->query('status'); // status_name e.g. 'draft','sent','pending','signed'

        $contracts = Contract::query()
            ->with('status')                 // contract_status(status_name)
            ->when($ownerId, fn($qq)=>$qq->where('user_id',$ownerId))
            ->when($q, function ($qq) use ($q) {
                $qq->where(function ($w) use ($q) {
                    $w->where('recipient_name', 'like', "%{$q}%")
                      ->orWhere('recipient_email', 'like', "%{$q}%");
                });
            })
            ->when($status, function ($qq) use ($status) {
                $qq->whereHas('status', fn($s)=>$s->where('status_name',$status));
            })
            ->orderByRaw('COALESCE(sent_date, NOW()) DESC')
            ->orderByDesc('contract_id')
            ->paginate(10)
            ->through(fn($c)=>[
                'contract_id'     => $c->contract_id,
                'recipient_name'  => $c->recipient_name,
                'recipient_email' => $c->recipient_email,
                'status'          => $c->status?->status_name ?? '—',
                'sent_date'       => optional($c->sent_date)->toDateTimeString(),
                'signed_date'     => optional($c->signed_date)->toDateTimeString(),
            ])
            ->withQueryString();

        return Inertia::render('Dashboard', [
            'contracts' => $contracts,
            'filters'   => ['q'=>$q,'status'=>$status],
        ]);
    }
}