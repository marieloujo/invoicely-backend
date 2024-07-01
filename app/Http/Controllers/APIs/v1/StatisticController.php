<?php

namespace App\Http\Controllers\APIs\v1;

use App\Http\Controllers\Controller;
use App\Models\Facture;
use App\Traits\JsonResponseTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StatisticController extends Controller
{

    use JsonResponseTrait;

    function __invoke()
    {
        $data = Facture::where('user_id', Auth::id())
            ->select(
                DB::raw('COUNT(factures.id) as total_invoices'),
                DB::raw('SUM(CASE WHEN factures.status THEN 1 ELSE 0 END) as total_paid_invoices'),
                DB::raw('SUM(CASE WHEN factures.status THEN 0 ELSE 1 END) as total_unpaid_invoices'),
                DB::raw('SUM(facture_items.total_amount_excl) as total_amount'),
                DB::raw('SUM(CASE WHEN factures.status THEN facture_items.total_amount_excl ELSE 0 END) as total_paid_amount'),
                DB::raw('SUM(CASE WHEN factures.status THEN 0 ELSE facture_items.total_amount_excl END) as total_unpaid_amount')
            )
            ->join('facture_items', 'factures.id', '=', 'facture_items.facture_id')
            ->first();

        return $this->success(response: $data);
    }

}
