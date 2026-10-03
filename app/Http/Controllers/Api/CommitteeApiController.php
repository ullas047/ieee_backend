<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommitteeResource;
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

        return response()->json(
            $members->map(
                fn (Committee $member) => (new CommitteeResource($member))->resolve()
            )
        );
    }

    public function show($id)
    {
        $member = Committee::findOrFail($id);

        return response()->json((new CommitteeResource($member))->resolve());
    }
}
