<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VisitorController extends Controller
{
    /**
     * Track a site visit.
     *
     * @group Visitors
     */
    public function track(Request $request): JsonResponse
    {
        $ip = $request->ip();

        Visitor::create(['ip_address' => $ip]);

        return response()->json(['tracked' => true]);
    }

    /**
     * Count unique visitors for today.
     *
     * @group Visitors
     * @authenticated
     */
    public function today(): JsonResponse
    {
        $count = Visitor::whereDate('created_at', today())
            ->distinct('ip_address')
            ->count('ip_address');

        return response()->json(['visitors' => $count]);
    }

    /**
     * Count unique visitors of all time.
     *
     * @group Visitors
     * @authenticated
     */
    public function total(): JsonResponse
    {
        $count = Visitor::distinct('ip_address')
            ->count('ip_address');

        return response()->json(['visitors' => $count]);
    }
}
