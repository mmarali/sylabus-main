<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeachingMethod extends Model
{
    protected $fillable = ['syllabus_version_id', 'type', 'name'];

    public function syllabusVersion()
    {
        return $this->belongsTo(SyllabusVersion::class);
    }
}
