<?php
// app/Http/Controllers/Admin/LocationController.php - ✅ FIXED COUNTS
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminController; // ✅ EXTEND ADMINCONTROLLER
use App\Models\Location;
use App\Models\ClassModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class LocationController extends AdminController // ✅ FIXED
{
    public function index(Request $request)
    {
        $query = Location::withCount('classes') // ✅ withCount works
                        ->when($request->filled('search'), function($q, $search) {
                            $q->where(function($subQ) use ($search) {
                                $subQ->where('name', 'like', "%{$search}%")
                                     ->orWhere('address', 'like', "%{$search}%");
                            });
                        })
                        ->when($request->filled('status'), function($q, $status) {
                            $q->where('is_active', $status === '1');
                        })
                        ->when($request->filled('type'), function($q, $type) {
                            $q->where('type', $type);
                        })
                        ->orderBy('is_active', 'desc')
                        ->orderBy('created_at', 'desc');

        $locations = $query->paginate(15);

        // ✅ FIXED: Calculate total classes manually
        $totalClasses = ClassModel::whereHas('location')->count();

        return view('admin.locations.index', compact('locations', 'totalClasses'));
    }

    public function create()
    {
        return view('admin.locations.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [ // ✅ MANUAL VALIDATION
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'radius' => 'required|numeric|min:5|max:1000',
            'type' => 'required|in:campus,lab,field,library,other',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        $data = $request->all();

        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('locations', 'public');
        }

        // Generate QR Code
        $qrData = [
            'id' => Str::uuid(),
            'location_id' => 0, // Will be updated after create
            'name' => $data['name'],
            'lat' => $data['latitude'],
            'lng' => $data['longitude'],
        ];
        $qrPath = 'qr-codes/' . Str::uuid() . '.png';
        QrCode::size(300)->generate(json_encode($qrData), storage_path('app/public/' . $qrPath));
        $data['qr_code'] = $qrPath;

        $location = Location::create($data);

        // Update QR with real location ID
        $qrData['location_id'] = $location->id;
        QrCode::size(300)->generate(json_encode($qrData), storage_path('app/public/' . $qrPath));

        return redirect()->route('admin.locations.index')
                       ->with('success', '✅ Lokasi "' . $data['name'] . '" berhasil dibuat!');
    }

    public function show(Location $location)
    {
        $location->load(['classes.dosen', 'schedules']);
        return view('admin.locations.show', compact('location'));
    }

    public function edit(Location $location)
    {
        return view('admin.locations.edit', compact('location'));
    }

    public function update(Request $request, Location $location)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'radius' => 'required|numeric|min:5|max:1000',
            'type' => 'required|in:campus,lab,field,library,other',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        $data = $request->all();

        // Handle image upload
        if ($request->hasFile('image')) {
            if ($location->image) {
                Storage::disk('public')->delete($location->image);
            }
            $data['image'] = $request->file('image')->store('locations', 'public');
        }

        // Regenerate QR Code
        $qrData = [
            'id' => Str::uuid(),
            'location_id' => $location->id,
            'name' => $data['name'],
            'lat' => $data['latitude'],
            'lng' => $data['longitude'],
        ];
        $qrPath = 'qr-codes/' . Str::uuid() . '.png';
        QrCode::size(300)->generate(json_encode($qrData), storage_path('app/public/' . $qrPath));
        $data['qr_code'] = $qrPath;

        $location->update($data);

        return redirect()->route('admin.locations.index')
                       ->with('success', '✅ Lokasi berhasil diupdate!');
    }

    public function destroy(Location $location)
    {
        // Delete image & QR
        if ($location->image) {
            Storage::disk('public')->delete($location->image);
        }
        if ($location->qr_code) {
            Storage::disk('public')->delete($location->qr_code);
        }

        $location->delete();

        return redirect()->route('admin.locations.index')
                       ->with('success', '✅ Lokasi berhasil dihapus!');
    }

    public function toggleStatus(Request $request, Location $location)
    {
        $location->update(['is_active' => !$location->is_active]);
        
        return response()->json([
            'success' => true,
            'is_active' => $location->is_active,
        ]);
    }
}