<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeachingForm extends Model
{
    protected $fillable = ['syllabus_version_id', 'type', 'hours', 'mode'];

    public function syllabusVersion()
    {
        return $this->belongsTo(SyllabusVersion::class);
    }
}
