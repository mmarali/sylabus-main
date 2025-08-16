<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SyllabusVersion extends Model
{
    protected $fillable = [
        'course_id',
        'version_number',
        'dark_mode',
        'unit',
        'major',
        'profile',
        'specialty',
        'module_type',
        'ects',
        'year_semester',
        'coordinator',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function requirements()
    {
        return $this->hasMany(Requirement::class);
    }

    public function goals()
    {
        return $this->hasMany(Goal::class);
    }

    public function teachingForms()
    {
        return $this->hasMany(TeachingForm::class);
    }

    public function teachingMethods()
    {
        return $this->hasMany(TeachingMethod::class);
    }

    public function outcomes()
    {
        return $this->hasMany(Outcome::class);
    }

    public function contents()
    {
        return $this->hasMany(Content::class);
    }

    public function effects()
    {
        return $this->hasMany(Effect::class);
    }

    public function workloads()
    {
        return $this->hasMany(Workload::class);
    }

    public function literatures()
    {
        return $this->hasMany(Literature::class);
    }
}
