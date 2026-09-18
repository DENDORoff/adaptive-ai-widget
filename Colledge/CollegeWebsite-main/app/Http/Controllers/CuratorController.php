<?php

namespace App\Http\Controllers;

use App\Models\Curator;
use Illuminate\Http\Request;

class CuratorController extends Controller
{

    private function extractCourseFromGroupName(string $groupName): int
    {
        if (strpos($groupName, '{"ru":"') === 0) {
            try {
                $data = json_decode($groupName, true);
                $groupName = $data['ru'] ?? $groupName;
            } catch (\Exception $e) {

            }
        }
        
        if (preg_match('/-(\d{2,3})/', $groupName, $matches)) {
            $numbers = $matches[1];

            if (strlen($numbers) >= 2) {
                $firstDigit = substr($numbers, 0, 1);
                return (int) $firstDigit;
            }
        }
        

        if (preg_match('/(\d{2,3})/', $groupName, $matches)) {
            $numbers = $matches[1];
            if (strlen($numbers) >= 2) {
                $firstDigit = substr($numbers, 0, 1);
                return (int) $firstDigit;
            }
        }
        

        return 1;
    }
    

    public function index()
    {
        try {

            $curators = Curator::active()
                ->ordered()
                ->get()
                ->map(function ($curator) {

                    $parsedCourse = $this->extractCourseFromGroupName($curator->group_name);
                    
                    return [
                        'id' => $curator->id,
                        'curator_name' => $curator->curator_name,
                        'curator_position' => $curator->curator_position,
                        'curator_email' => $curator->curator_email,
                        'curator_phone' => $curator->curator_phone,
                        'curator_photo' => $curator->curator_photo,
                        'group_name' => $curator->group_name,
                        'specialty' => $curator->specialty,
                        'course' => $parsedCourse, 
                        'students_count' => $curator->students_count,
                        'room_number' => $curator->room_number,
                        'consultation_schedule' => $curator->consultation_schedule,
                        'additional_info' => $curator->additional_info,
                        'order' => $curator->order,
                        'is_active' => $curator->is_active,
                        'is_multilang' => $curator->is_multilang,
                    ];
                });


            $curatorsByCourse = $curators->groupBy('course');


            $specialties = Curator::active()
                ->get()
                ->pluck('specialty')
                ->filter()
                ->unique()
                ->sort()
                ->values()
                ->toArray();


            $courses = $curators->pluck('course')
                ->unique()
                ->sort()
                ->values()
                ->toArray();

            \Log::info('CuratorController: Found ' . count($curators) . ' curators');
            \Log::info('CuratorController: Courses: ' . json_encode($courses));
            \Log::info('CuratorController: Specialties: ' . json_encode($specialties));

            return view('pages.curators.index', compact('curators', 'curatorsByCourse', 'specialties', 'courses'));

        } catch (\Exception $e) {
            \Log::error('CuratorController index error: ' . $e->getMessage());
            \Log::error('CuratorController trace: ' . $e->getTraceAsString());
            
            return view('pages.curators.index', [
                'curators' => collect(),
                'curatorsByCourse' => collect(),
                'specialties' => [],
                'courses' => [],
            ]);
        }
    }


    public function show($id)
    {
        $curator = Curator::active()
            ->findOrFail($id);

        return view('pages.curators.show', compact('curator'));
    }


    public function filter(Request $request)
    {
        $query = Curator::active();


        if ($request->filled('course')) {
            $query->where('course', $request->course);
        }


        if ($request->filled('specialty')) {
            $query->where(function($q) use ($request) {
                $q->where('specialty', 'ilike', '%' . $request->specialty . '%');
            });
        }


        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('curator_name', 'ilike', '%' . $search . '%')
                  ->orWhere('group_name', 'ilike', '%' . $search . '%');
            });
        }

        $curators = $query->ordered()->get()
            ->map(function($curator) {

                $parsedCourse = $this->extractCourseFromGroupName($curator->group_name);
                
                return [
                    'curator' => $curator,
                    'parsed_course' => $parsedCourse,
                ];
            });


        if ($request->filled('course')) {
            $requestedCourse = (int) $request->course;
            $curators = $curators->filter(function($item) use ($requestedCourse) {
                return $item['parsed_course'] == $requestedCourse;
            });
        }

        return response()->json([
            'curators' => $curators->map(function($item) {
                $curator = $item['curator'];
                $photoUrl = $curator->curator_photo 
                    ? asset('uploads/' . $curator->curator_photo)
                    : null;
                
                return [
                    'id' => $curator->id,
                    'group_name' => $curator->group_name,
                    'specialty' => $curator->specialty,
                    'course' => $item['parsed_course'], 
                    'students_count' => $curator->students_count,
                    'room_number' => $curator->room_number,
                    'consultation_schedule' => $curator->consultation_schedule,
                    'curator_name' => $curator->curator_name,
                    'curator_position' => $curator->curator_position,
                    'curator_email' => $curator->curator_email,
                    'curator_phone' => $curator->curator_phone,
                    'curator_photo' => $photoUrl,
                ];
            })
        ]);
    }
}