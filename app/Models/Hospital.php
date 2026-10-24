<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Hospital extends Model
{
    use SoftDeletes;

    protected $table = 'hospitals';
    protected $fillable = [
        'name',
        'photo',
        'about',
        'address',
        'city',
        'post_code',
        'phone'
    ];

    public function doctors()
    {
        return $this->hasMany(Doctor::class);
    }

    // relation many to many used belongsToMany to relation pivot table
    public function specialists()
    {
        return $this->belongsToMany(Specialist::class, 'hospital_specialists');
    }
    public function getPhotoAttribute(string $value)
    {
        if (!$value) {
            return null;
        }

        return url(Storage::url($value));
    }
}
