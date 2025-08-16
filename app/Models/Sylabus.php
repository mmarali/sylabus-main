<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Sylabus extends Model
{
    protected $table = 'syllabuses';

    protected $fillable = [
        'university_id',
        'subject_name',
        'description',
        'learning_goals',
        'learning_outcomes',
        'prerequisites',
        'literature',
        'assessment_methods',
        'hours',
        'semester',
        'history',
    ];

    protected $casts = [
        'history' => 'array',
    ];

    public function university()
    {
        return $this->belongsTo(University::class);
    }
}
