<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Literature extends Model
{
    protected $fillable = ['syllabus_version_id', 'name', 'type'];

    public function syllabusVersion()
    {
        return $this->belongsTo(SyllabusVersion::class);
    }
}
