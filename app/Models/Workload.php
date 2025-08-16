<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Workload extends Model
{
    protected $fillable = ['syllabus_version_id', 'type', 'hours'];

    public function syllabusVersion()
    {
        return $this->belongsTo(SyllabusVersion::class);
    }
}
