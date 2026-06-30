<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Committee;


class CommitteeApiController extends Controller
{
    public function years()
    {
        return Committee::select('year')
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year');
    }

    public function byYear($year)
    {
        $members = Committee::where('year', $year)
            ->orderBy('committee_type')
            ->get();

        return response()->json($members);
    }

    public function show($id)
    {
        $member = Committee::findOrFail($id);

        return response()->json($member);
    }
}