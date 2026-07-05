<?php

namespace App\Http\Controllers;

use App\Models\Committee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CommitteeController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $selectedYear = $request->year ?? date('Y');
        $selectedCommittee = $request->committee_type;

        $query = Committee::query();

        // Year filter
        if ($selectedYear) {
            $query->where('year', $selectedYear);
        }

        // Committee filter
        if ($selectedCommittee && $selectedCommittee != 'all') {
            $query->where('committee_type', $selectedCommittee);
        }

        $committees = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $years = Committee::select('year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        $committeeTypes = Committee::select('committee_type')
            ->distinct()
            ->orderBy('committee_type')
            ->pluck('committee_type');

        return view('admin.committees.index', compact(
            'committees',
            'years',
            'committeeTypes'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.committees.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'year' => 'required|digits:4',
            'committee_type' => 'required',
            'name' => 'required',
            'club_position' => 'required',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')
                ->store('committee', 'public');
        }

        Committee::create([
            'year' => $request->year,
            'committee_type' => $request->committee_type,
            'name' => $request->name,
            'image' => $imagePath,
            'club_position' => $request->club_position,
            'varsity_position' => $request->varsity_position,
            'facebook_link' => $request->facebook_link,
            'linkedin_link' => $request->linkedin_link,
        ]);

        return redirect()
            ->route('committees.index')
            ->with('success', 'Committee member added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Committee $committee)
    {
        return view('admin.committees.show', compact('committee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Committee $committee)
    {
        return view('admin.committees.edit', compact('committee'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Committee $committee)
    {
        $request->validate([
            'year' => 'required|digits:4',
            'committee_type' => 'required',
            'name' => 'required',
            'club_position' => 'required',
        ]);

        if ($request->hasFile('image')) {

            if (
                $committee->image &&
                Storage::disk('public')->exists($committee->image)
            ) {

                Storage::disk('public')->delete($committee->image);
            }

            $committee->image = $request->file('image')
                ->store('committee', 'public');
        }
        $committee->year = $request->year;

        $committee->committee_type = $request->committee_type;
        $committee->name = $request->name;
        $committee->club_position = $request->club_position;
        $committee->varsity_position = $request->varsity_position;
        $committee->facebook_link = $request->facebook_link;
        $committee->linkedin_link = $request->linkedin_link;

        $committee->save();

        return redirect()
            ->route('committees.index')
            ->with('success', 'Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Committee $committee)
    {
        if (
            $committee->image &&
            Storage::disk('public')->exists($committee->image)
        ) {
            Storage::disk('public')->delete($committee->image);
        }

        $committee->delete();

        return back()->with('success', 'Deleted successfully');
    }
}
