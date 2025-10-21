<?php
// app/Models/Material.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Material extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'file_path', 'file_type', 'thumbnail',
        'class_id', 'uploaded_by', 'location_id', 'order', 'type',
        'is_required', 'is_active', 'views', 'downloads'
    ];

    protected $casts = [
        'is_required' => 'boolean',
        'is_active' => 'boolean',
    ];

    protected $appends = ['file_url', 'thumbnail_url', 'is_video'];

    public function class()
    {
        return $this->belongsTo(ClassModel::class);
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function locationMaterials()
    {
        return $this->hasMany(LocationMaterial::class);
    }

    public function getFileUrlAttribute()
    {
        if ($this->file_path && Storage::disk('public')->exists($this->file_path)) {
            return Storage::url($this->file_path);
        }
        return null;
    }

    public function getThumbnailUrlAttribute()
    {
        if ($this->thumbnail && Storage::disk('public')->exists($this->thumbnail)) {
            return Storage::url($this->thumbnail);
        }
        return $this->getDefaultThumbnail();
    }

    public function getIsVideoAttribute()
    {
        return in_array($this->file_type, ['mp4', 'avi', 'mov', 'wmv']);
    }

    private function getDefaultThumbnail()
    {
        return match($this->type) {
            'video' => asset('images/video-thumb.jpg'),
            'document' => asset('images/pdf-thumb.jpg'),
            'image' => asset('images/image-thumb.jpg'),
            default => asset('images/file-thumb.jpg')
        };
    }

    public function incrementView()
    {
        $this->increment('views');
    }

    public function incrementDownload()
    {
        $this->increment('downloads');
    }
}