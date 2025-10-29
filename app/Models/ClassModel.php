<?php
// app/Models/ClassModel.php - ✅ FIXED TABLE NAME
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassModel extends Model
{
    use HasFactory;

    // ✅ FIXED: SET TABLE NAME
    protected $table = 'classes';

    protected $fillable = [
        'name',
        'code',
        'description',
        'location_id',
        'dosen_id',
        'max_students',
        'status',
    ];

    protected $casts = [
        'max_students' => 'integer',
        'status' => 'string',
    ];

    // Relationships
    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function dosen()
    {
        return $this->belongsTo(User::class, 'dosen_id');
    }

    public function members()
    {
        return $this->hasMany(ClassMember::class, 'class_id');
    }

    // Accessors
    public function getMembersCountAttribute()
    {
        return $this->members()->where('status', 'active')->count();
    }

    public function getCapacityPercentageAttribute()
    {
        if ($this->max_students == 0) return 0;
        return round(($this->members_count / $this->max_students) * 100);
    }

    public function isFull()
    {
        return $this->members_count >= $this->max_students;
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}