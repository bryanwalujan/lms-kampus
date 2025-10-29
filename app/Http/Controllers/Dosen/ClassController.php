<?php
// app/Http/Controllers/Dosen/ClassController.php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\Location;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ClassController extends Controller
{
    public function index()
    {
        $classes = auth()->user()
                       ->classesAsDosen()
                       ->withCount('members')
                       ->with('location')
                       ->paginate(10);
        
        return view('dosen.classes.index', compact('classes'));
    }

    public function create()
    {
        $locations = Location::where('is_active', true)->get();
        
        return view('dosen.classes.create', compact('locations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location_id' => 'required|exists:locations,id',
            'max_students' => 'required|integer|min:1|max:1000',
        ]);

        // Generate unique code
        $code = $this->generateClassCode($request->name);

        ClassModel::create([
            'name' => $request->name,
            'code' => $code,
            'description' => $request->description,
            'location_id' => $request->location_id,
            'dosen_id' => auth()->id(),
            'max_students' => $request->max_students,
            'status' => 'draft',
        ]);

        return redirect()->route('dosen.classes.index')
                       ->with('success', 'Kelas berhasil dibuat!');
    }

    private function generateClassCode($name)
    {
        $prefix = Str::upper(Str::substr($name, 0, 3));
        $year = now()->format('y');
        $number = \App\Models\ClassModel::whereYear('created_at', now()->year)->count() + 1;
        
        return "{$prefix}-{$year}-" . str_pad($number, 3, '0', STR_PAD_LEFT);
    }

    public function show(ClassModel $class)
    {
        if ($class->dosen_id !== auth()->id()) {
            abort(403);
        }

        $class->load(['location', 'members.user', 'schedules', 'materials']);
        return view('dosen.classes.show', compact('class'));
    }

    // Update & Delete methods sama seperti Admin
}