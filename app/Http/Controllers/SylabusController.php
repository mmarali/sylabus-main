<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Course;
use App\Models\Effect;
use App\Models\Goal;
use App\Models\Literature;
use App\Models\Outcome;
use App\Models\Requirement;
use App\Models\Sylabus;
use App\Models\SyllabusVersion;
use App\Models\TeachingForm;
use App\Models\TeachingMethod;
use App\Models\University;
use App\Models\Workload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class SylabusController extends Controller
{
    public function index()
    {
        $syllabuses = Course::with([
            'currentVersion' => function ($query) {
                $query->with([
                    'requirements',
                    'goals',
                    'teachingForms',
                    'teachingMethods',
                    'outcomes',
                    'contents',
                    'effects',
                    'workloads',
                    'literatures',
                ]);
            }
        ])->get()->map(function ($course) {
            return [
                'id' => $course->id,
                'code' => $course->code,
                'name' => $course->name,
                'unit' => $course->currentVersion?->unit,
                'major' => $course->currentVersion?->major,
                'ects' => $course->currentVersion?->ects,
                'coordinator' => $course->currentVersion?->coordinator,
                'version_number' => $course->currentVersion?->version_number,
                'created_at' => $course->currentVersion?->created_at->format('d.m.Y H:i'),
            ];
        });

        return Inertia::render('Sylabus/Index', [
            'syllabuses' => $syllabuses,
        ]);
    }

    public function show($courseId)
    {
        $course = Course::with([
            'currentVersion' => function ($query) {
                $query->with([
                    'requirements',
                    'goals',
                    'teachingForms',
                    'teachingMethods',
                    'outcomes',
                    'contents',
                    'effects',
                    'workloads',
                    'literatures',
                ]);
            }
        ])->findOrFail($courseId);

        return Inertia::render('Sylabus/Show', [
            'course' => $course,
            'version' => $course->currentVersion,
        ]);
    }

    public function create()
    {
        return Inertia::render('Sylabus/Create');
    }

    public function store(Request $request)
    {
        // Validate the incoming JSON data
        $data = $request->validate([
            'code' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'darkMode' => 'required|boolean',
            'unit' => 'required|string|max:255',
            'major' => 'required|string|max:255',
            'profile' => 'required|string|max:255',
            'specialty' => 'required|string|max:255',
            'moduleType' => 'required|string|max:255',
            'ects' => 'required|integer|min:1',
            'yearSemester' => 'required|string|max:10',
            'coordinator' => 'required|string|max:255',
            'requirementsList' => 'required|array',
            'requirementsList.*' => 'string|max:255',
            'goalsList' => 'required|array',
            'goalsList.*' => 'string|max:255',
            'teachingForms' => 'required|array',
            'teachingForms.*.type' => 'required|string|max:255',
            'teachingForms.*.hours' => 'required|integer|min:0',
            'teachingForms.*.mode' => 'required|string|max:255',
            'teachingMethods' => 'required|array',
            'teachingMethods.*.type' => 'required|string|max:255',
            'teachingMethods.*.name' => 'required|string|max:255',
            'outcomes' => 'required|array',
            'outcomes.*.number' => 'required|string|max:50',
            'outcomes.*.type' => 'required|string|max:255',
            'outcomes.*.description' => 'required|string',
            'outcomes.*.reference' => 'nullable|string|max:255',
            'content' => 'required|array',
            'content.*.number' => 'required|string|max:50',
            'content.*.type' => 'required|string|max:255',
            'content.*.topic' => 'required|string|max:255',
            'content.*.effect' => 'required|string',
            'effects' => 'required|array',
            'effects.*.number' => 'required|string|max:50',
            'effects.*.method' => 'required|string|max:255',
            'effects.*.gradeBelow50' => 'required|string|max:255',
            'effects.*.grade50_59' => 'required|string|max:255',
            'effects.*.grade60_74' => 'required|string|max:255',
            'effects.*.grade75_100' => 'required|string|max:255',
            'workload' => 'required|array',
            'workload.*.type' => 'required|string|max:255',
            'workload.*.hours' => 'required|integer|min:0',
            'literature' => 'required|array',
            'literature.*.name' => 'required|string|max:255',
            'literature.*.type' => 'required|string|max:255',
        ]);

        // Use a database transaction to ensure atomicity
        $version = DB::transaction(function () use ($data) {
            // Find or create the course
            $course = Course::firstOrCreate(
                ['code' => $data['code']],
                ['name' => $data['name']]
            );

            // Get the next version number for this course
            $latestVersion = SyllabusVersion::where('course_id', $course->id)
                ->max('version_number') ?? 0;

            // Create a new syllabus version
            $version = SyllabusVersion::create([
                'course_id' => $course->id,
                'version_number' => $latestVersion + 1,
                'dark_mode' => $data['darkMode'],
                'unit' => $data['unit'],
                'major' => $data['major'],
                'profile' => $data['profile'],
                'specialty' => $data['specialty'],
                'module_type' => $data['moduleType'],
                'ects' => $data['ects'],
                'year_semester' => $data['yearSemester'],
                'coordinator' => $data['coordinator'],
            ]);

            // Save requirements
            foreach ($data['requirementsList'] as $req) {
                Requirement::create([
                    'syllabus_version_id' => $version->id,
                    'requirement' => $req,
                ]);
            }

            // Save goals
            foreach ($data['goalsList'] as $goal) {
                Goal::create([
                    'syllabus_version_id' => $version->id,
                    'goal' => $goal,
                ]);
            }

            // Save teaching forms
            foreach ($data['teachingForms'] as $form) {
                TeachingForm::create([
                    'syllabus_version_id' => $version->id,
                    'type' => $form['type'],
                    'hours' => $form['hours'],
                    'mode' => $form['mode'],
                ]);
            }

            // Save teaching methods
            foreach ($data['teachingMethods'] as $method) {
                TeachingMethod::create([
                    'syllabus_version_id' => $version->id,
                    'type' => $method['type'],
                    'name' => $method['name'],
                ]);
            }

            // Save outcomes
            foreach ($data['outcomes'] as $outcome) {
                Outcome::create([
                    'syllabus_version_id' => $version->id,
                    'number' => $outcome['number'],
                    'type' => $outcome['type'],
                    'description' => $outcome['description'],
                    'reference' => $outcome['reference'],
                ]);
            }

            // Save content
            foreach ($data['content'] as $content) {
                Content::create([
                    'syllabus_version_id' => $version->id,
                    'number' => $content['number'],
                    'type' => $content['type'],
                    'topic' => $content['topic'],
                    'effect' => $content['effect'],
                ]);
            }

            // Save effects
            foreach ($data['effects'] as $effect) {
                Effect::create([
                    'syllabus_version_id' => $version->id,
                    'number' => $effect['number'],
                    'method' => $effect['method'],
                    'grade_below_50' => $effect['gradeBelow50'],
                    'grade_50_59' => $effect['grade50_59'],
                    'grade_60_74' => $effect['grade60_74'],
                    'grade_75_100' => $effect['grade75_100'],
                ]);
            }

            // Save workload
            foreach ($data['workload'] as $workload) {
                Workload::create([
                    'syllabus_version_id' => $version->id,
                    'type' => $workload['type'],
                    'hours' => $workload['hours'],
                ]);
            }

            // Save literature
            foreach ($data['literature'] as $literature) {
                Literature::create([
                    'syllabus_version_id' => $version->id,
                    'name' => $literature['name'],
                    'type' => $literature['type'],
                ]);
            }

            // Update the course's current version
            $course->update(['current_version_id' => $version->id]);

            return $version;
        });

        // Return response for Inertia.js
        return inertia('Syllabus/Show', [
            'course' => $version->course->load([
                'currentVersion',
                'currentVersion.requirements',
                'currentVersion.goals',
                'currentVersion.teachingForms',
                'currentVersion.teachingMethods',
                'currentVersion.outcomes',
                'currentVersion.contents',
                'currentVersion.effects',
                'currentVersion.workloads',
                'currentVersion.literatures'
            ]),
            'message' => 'Syllabus version created successfully',
        ]);
    }

    public function history($courseId)
    {
        $course = Course::with([
            'syllabusVersions' => function ($query) {
                $query->orderBy('version_number', 'desc')->with([
                    'requirements',
                    'goals',
                    'teachingForms',
                    'teachingMethods',
                    'outcomes',
                    'contents',
                    'effects',
                    'workloads',
                    'literatures',
                ]);
            }
        ])->findOrFail($courseId);

        $versions = $course->syllabusVersions->map(function ($version) {
            return [
                'id' => $version->id,
                'version_number' => $version->version_number,
                'unit' => $version->unit,
                'major' => $version->major,
                'ects' => $version->ects,
                'coordinator' => $version->coordinator,
                'created_at' => $version->created_at->format('d.m.Y H:i'),
            ];
        });

        return Inertia::render('Sylabus/History', [
            'course' => [
                'id' => $course->id,
                'code' => $course->code,
                'name' => $course->name,
            ],
            'versions' => $versions,
        ]);
    }

    public function showVersion($courseId, $versionNumber)
    {
        $version = SyllabusVersion::where('course_id', $courseId)
            ->where('version_number', $versionNumber)
            ->with([
                'course',
                'requirements',
                'goals',
                'teachingForms',
                'teachingMethods',
                'outcomes',
                'contents',
                'effects',
                'workloads',
                'literatures',
            ])
            ->firstOrFail();

        return Inertia::render('Sylabus/Show', [
            'course' => $version->course,
            'version' => $version,
        ]);
    }

    public function diff($courseId, $versionNumber)
    {
        $currentVersion = SyllabusVersion::where('course_id', $courseId)
            ->where('version_number', $versionNumber)
            ->with([
                'requirements',
                'goals',
                'teachingForms',
                'teachingMethods',
                'outcomes',
                'contents',
                'effects',
                'workloads',
                'literatures',
            ])
            ->firstOrFail();

        $previousVersion = SyllabusVersion::where('course_id', $courseId)
            ->where('version_number', $versionNumber - 1)
            ->with([
                'requirements',
                'goals',
                'teachingForms',
                'teachingMethods',
                'outcomes',
                'contents',
                'effects',
                'workloads',
                'literatures',
            ])
            ->first();

        if (!$previousVersion) {
            return Inertia::render('Syllabus/Diff', [
                'course' => $currentVersion->course,
                'currentVersion' => $currentVersion,
                'previousVersion' => null,
                'differences' => [],
                'message' => 'Brak poprzedniej wersji do porównania.',
            ]);
        }

        // Calculate differences for main fields
        $mainFields = [
            'unit',
            'major',
            'profile',
            'specialty',
            'module_type',
            'ects',
            'year_semester',
            'coordinator',
            'dark_mode',
        ];

        $differences = [];
        foreach ($mainFields as $field) {
            if ($currentVersion->$field !== $previousVersion->$field) {
                $differences[$field] = [
                    'previous' => $previousVersion->$field,
                    'current' => $currentVersion->$field,
                ];
            }
        }

        $relatedFields = [
            'requirements' => 'requirement',
            'goals' => 'goal',
            'teachingForms' => ['type', 'hours', 'mode'],
            'teachingMethods' => ['type', 'name'],
            'outcomes' => ['number', 'type', 'description', 'reference'],
            'contents' => ['number', 'type', 'topic', 'effect'],
            'effects' => ['number', 'method', 'grade_below_50', 'grade_50_59', 'grade_60_74', 'grade_75_100'],
            'workloads' => ['type', 'hours'],
            'literatures' => ['name', 'type'],
        ];

        foreach ($relatedFields as $relation => $fields) {
            $currentItems = $currentVersion->$relation->pluck(is_array($fields) ? $fields : $fields)->toArray();
            $previousItems = $previousVersion->$relation->pluck(is_array($fields) ? $fields : $fields)->toArray();

            $added = array_diff(array_map('serialize', $currentItems), array_map('serialize', $previousItems));
            $removed = array_diff(array_map('serialize', $previousItems), array_map('serialize', $currentItems));

            if ($added || $removed) {
                $differences[$relation] = [
                    'added' => array_map('unserialize', $added),
                    'removed' => array_map('unserialize', $removed),
                ];
            }
        }
        return Inertia::render('Sylabus/Diff', [
            'course' => $currentVersion->course,
            'currentVersion' => $currentVersion,
            'previousVersion' => $previousVersion,
            'differences' => $differences,
        ]);
    }
}
