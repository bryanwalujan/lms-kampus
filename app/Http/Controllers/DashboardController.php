<?php
// app/Http/Controllers/DashboardController.php - ✅ FIXED

namespace App\Http\Controllers;

use App\Models\ClassModel;
use App\Models\Attendance;
use App\Models\Location;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    // ✅ PUBLIC METHOD - Dipanggil dari /dashboard
    public function index()
    {
        $user = Auth::user();
        
        // Redirect berdasarkan role
        return match($user->role) {
            'admin' => $this->adminDashboard(),
            'dosen' => $this->dosenDashboard(),
            'mahasiswa' => $this->mahasiswaDashboard(),
            default => view('dashboard', compact('user'))
        };
    }

    // ✅ PUBLIC METHOD - Dipanggil dari /admin/dashboard
   public function adminDashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_classes' => ClassModel::count(), // ✅ FIXED
            'total_locations' => Location::where('is_active', true)->count(),
            'today_attendances' => 0, // Phase 8
        ];

        // Recent activities
        $recentActivities = collect([
            (object)[
                'title' => '🚀 Sistem LMS Lokasi Aktif', 
                'description' => 'Platform LMS berbasis GPS siap digunakan', 
                'created_at' => now()
            ],
            (object)[
                'title' => '📍 ' . $stats['total_locations'] . ' Lokasi Tersedia', 
                'description' => 'Lokasi pembelajaran GPS telah dikonfigurasi', 
                'created_at' => now()->subHour()
            ],
            (object)[
                'title' => '👥 ' . $stats['total_users'] . ' Users Terdaftar', 
                'description' => 'Total admin, dosen, dan mahasiswa', 
                'created_at' => now()->subHours(2)
            ],
        ]);

        return view('admin.dashboard', compact('stats', 'recentActivities'));
    }

    // ✅ PUBLIC METHOD - Dipanggil dari /dosen/dashboard
    public function dosenDashboard()
    {
        $classes = Auth::user()
                     ->classesAsDosen()
                     ->withCount('members')
                     ->with('location')
                     ->get();

        $todayAttendances = Attendance::whereHas('schedule.class.dosen', fn($q) => $q->where('dosen_id', Auth::id()))
                                     ->whereDate('checkin_time', today())
                                     ->count();

        $stats = [
            'total_classes' => $classes->count(),
            'total_students' => $classes->sum('members_count'),
            'today_attendances' => $todayAttendances,
        ];

        return view('dosen.dashboard', compact('classes', 'stats'));
    }

    // ✅ PUBLIC METHOD - Dipanggil dari /mahasiswa/dashboard
    public function mahasiswaDashboard()
    {
        $classes = Auth::user()->classMemberships()
                             ->with(['class' => fn($q) => $q->with('location')])
                             ->active()
                             ->get();

        $todayAttendance = Attendance::whereHas('schedule.class.members', fn($q) => $q->where('user_id', Auth::id()))
                                    ->whereDate('checkin_time', today())
                                    ->first();

        $stats = [
            'total_classes' => $classes->count(),
            'today_attendance' => $todayAttendance,
        ];

        return view('mahasiswa.dashboard', compact('classes', 'stats', 'todayAttendance'));
    }
}