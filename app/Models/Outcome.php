<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Outcome extends Model
{
    protected $fillable = ['syllabus_version_id', 'number', 'type', 'description', 'reference'];

    public function syllabusVersion()
    {
        return $this->belongsTo(SyllabusVersion::class);
    }
}
