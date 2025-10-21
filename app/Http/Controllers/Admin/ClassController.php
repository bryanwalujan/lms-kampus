<?php
// app/Http/Controllers/Admin/ClassController.php - ✅ FIXED: NO CONSTRUCTOR
namespace App\Http\Controllers\Admin;

use App\Models\ClassModel;
use App\Models\Location;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ClassController extends AdminController // ✅ NO CONSTRUCTOR
{
    public function index(Request $request)
    {
        $query = ClassModel::with(['location', 'dosen'])
                          ->withCount(['members as members_count']);

        // Search
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('code', 'like', "%{$request->search}%");
            });
        }

        // Filters
        if ($request->filled('location_id')) {
            $query->where('location_id', $request->location_id);
        }

        if ($request->filled('dosen_id')) {
            $query->where('dosen_id', $request->dosen_id);
        }

        $classes = $query->latest()->paginate(15);

        return view('admin.classes.index', compact('classes'));
    }

    public function create()
    {
        $locations = Location::where('is_active', true)->orderBy('name')->get();
        $dosens = User::role('dosen')->orderBy('name')->get();
        
        return view('admin.classes.create', compact('locations', 'dosens'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:20|unique:classes,code',
            'description' => 'nullable|string|max:1000',
            'location_id' => 'required|exists:locations,id',
            'dosen_id' => 'required|exists:users,id',
            'max_students' => 'required|integer|min:1|max:1000',
            'status' => 'required|in:active,draft,finished,cancelled',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        ClassModel::create([
            'name' => $request->name,
            'code' => strtoupper($request->code),
            'description' => $request->description,
            'location_id' => $request->location_id,
            'dosen_id' => $request->dosen_id,
            'max_students' => $request->max_students,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.classes.index')
                       ->with('success', '✅ Kelas "' . $request->name . '" berhasil dibuat!');
    }

    public function show(ClassModel $class)
    {
        $class->load(['location', 'dosen', 'members.user.profile']);
        return view('admin.classes.show', compact('class'));
    }

    public function edit(ClassModel $class)
    {
        $locations = Location::where('is_active', true)->orderBy('name')->get();
        $dosens = User::role('dosen')->orderBy('name')->get();
        
        return view('admin.classes.edit', compact('class', 'locations', 'dosens'));
    }

    public function update(Request $request, ClassModel $class)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:20|unique:classes,code,' . $class->id,
            'description' => 'nullable|string|max:1000',
            'location_id' => 'required|exists:locations,id',
            'dosen_id' => 'required|exists:users,id',
            'max_students' => 'required|integer|min:1|max:1000',
            'status' => 'required|in:active,draft,finished,cancelled',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        $class->update([
            'name' => $request->name,
            'code' => strtoupper($request->code),
            'description' => $request->description,
            'location_id' => $request->location_id,
            'dosen_id' => $request->dosen_id,
            'max_students' => $request->max_students,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.classes.index')
                       ->with('success', '✅ Kelas berhasil diperbarui!');
    }

    public function destroy(ClassModel $class)
    {
        if ($class->members()->count() > 0) {
            return redirect()->back()
                           ->with('error', '❌ Kelas tidak bisa dihapus karena masih ada anggota!');
        }

        $class->delete();

        return redirect()->route('admin.classes.index')
                       ->with('success', '✅ Kelas berhasil dihapus!');
    }
}