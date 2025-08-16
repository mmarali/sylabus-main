<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Effect extends Model
{
    protected $fillable = [
        'syllabus_version_id',
        'number',
        'method',
        'grade_below_50',
        'grade_50_59',
        'grade_60_74',
        'grade_75_100',
    ];

    public function syllabusVersion()
    {
        return $this->belongsTo(SyllabusVersion::class);
    }
}
