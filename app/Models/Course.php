<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['code', 'name', 'current_version_id'];

    public function syllabusVersions()
    {
        return $this->hasMany(SyllabusVersion::class);
    }

    public function currentVersion()
    {
        return $this->belongsTo(SyllabusVersion::class, 'current_version_id');
    }
}
