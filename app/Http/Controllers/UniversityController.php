<?php

namespace App\Http\Controllers;

use App\Models\University;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UniversityController extends Controller
{
    public function index()
    {
        return Inertia::render('Universities/Index', [
            'universities' => University::all()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'nullable|string|max:255',
        ]);

        University::create($request->all());

        return redirect()->back();
    }

    public function destroy(University $university)
    {
        $university->delete();
        return redirect()->back();
    }
}
