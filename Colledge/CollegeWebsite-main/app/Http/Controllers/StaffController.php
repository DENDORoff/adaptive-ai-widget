<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class StaffController extends Controller
{
    public function index(Request $request)
    {
        try {

            $director = Staff::where('is_leadership', true)
                ->orderBy('order')
                ->first();


            $leadership = Staff::where('is_leadership', true)
                ->when($director, fn($q) => $q->where('id', '!=', $director->id))
                ->orderBy('order')
                ->get();


            $department = $request->get('department');
            $search = $request->get('search');
            $sort = $request->get('sort', 'order_asc');


            $teachersQuery = Staff::where('is_leadership', false);


            if ($department) {
                $teachersQuery->where('department', $department);
            }


            if ($search && strlen(trim($search)) >= 2) {
                $searchTerm = trim($search);
                $teachersQuery->where(function($q) use ($searchTerm) {

                    $q->orWhereRaw("
                        CASE 
                            WHEN is_multilang = true THEN 
                                COALESCE(NULLIF((full_name::json->>'ru')::text, ''), full_name::text)
                            ELSE 
                                full_name::text
                        END ILIKE ?
                    ", ['%' . $searchTerm . '%']);
                    

                    $q->orWhereRaw("
                        CASE 
                            WHEN is_multilang = true THEN 
                                COALESCE(NULLIF((position::json->>'ru')::text, ''), position::text)
                            ELSE 
                                position::text
                        END ILIKE ?
                    ", ['%' . $searchTerm . '%']);
                    

                    $q->orWhere('department', 'ilike', '%' . $searchTerm . '%');
                    

                    $q->orWhereRaw("
                        CASE 
                            WHEN is_multilang = true THEN 
                                COALESCE(NULLIF((specialty::json->>'ru')::text, ''), specialty::text)
                            ELSE 
                                specialty::text
                        END ILIKE ?
                    ", ['%' . $searchTerm . '%']);
                    

                    $q->orWhereRaw("
                        CASE 
                            WHEN is_multilang = true THEN 
                                COALESCE(NULLIF((teaching_subjects::json->>'ru')::text, ''), teaching_subjects::text)
                            ELSE 
                                teaching_subjects::text
                        END ILIKE ?
                    ", ['%' . $searchTerm . '%']);
                });
            }


            switch ($sort) {
                case 'name_asc':
                    $teachersQuery->orderByRaw("
                        CASE 
                            WHEN is_multilang = true THEN 
                                COALESCE(NULLIF((full_name::json->>'ru')::text, ''), full_name::text)
                            ELSE 
                                full_name::text
                        END ASC
                    ");
                    break;
                    
                case 'name_desc':
                    $teachersQuery->orderByRaw("
                        CASE 
                            WHEN is_multilang = true THEN 
                                COALESCE(NULLIF((full_name::json->>'ru')::text, ''), full_name::text)
                            ELSE 
                                full_name::text
                        END DESC
                    ");
                    break;
                    
                case 'experience_asc':

                    $teachersQuery->orderByRaw("
                        CASE 
                            WHEN is_multilang = true THEN 
                                COALESCE(
                                    NULLIF(
                                        REGEXP_REPLACE(
                                            COALESCE(NULLIF((work_experience_pedagogical::json->>'ru')::text, ''), ''),
                                            '[^0-9]', '', 'g'
                                        ),
                                        ''
                                    )::integer,
                                    0
                                )
                            ELSE 
                                COALESCE(
                                    NULLIF(
                                        REGEXP_REPLACE(work_experience_pedagogical::text, '[^0-9]', '', 'g'),
                                        ''
                                    )::integer,
                                    0
                                )
                        END ASC
                    ");
                    break;
                    
                case 'experience_desc':
                    $teachersQuery->orderByRaw("
                        CASE 
                            WHEN is_multilang = true THEN 
                                COALESCE(
                                    NULLIF(
                                        REGEXP_REPLACE(
                                            COALESCE(NULLIF((work_experience_pedagogical::json->>'ru')::text, ''), ''),
                                            '[^0-9]', '', 'g'
                                        ),
                                        ''
                                    )::integer,
                                    0
                                )
                            ELSE 
                                COALESCE(
                                    NULLIF(
                                        REGEXP_REPLACE(work_experience_pedagogical::text, '[^0-9]', '', 'g'),
                                        ''
                                    )::integer,
                                    0
                                )
                        END DESC
                    ");
                    break;
                    
                case 'department_asc':
                    $teachersQuery->orderBy('department', 'asc');
                    break;
                    
                case 'department_desc':
                    $teachersQuery->orderBy('department', 'desc');
                    break;
                    
                case 'order_asc':
                default:
                    $teachersQuery->orderBy('order', 'asc');
                    break;
            }


            $teachers = $teachersQuery->paginate(20)->withQueryString();


            $departments = Staff::whereNotNull('department')
                ->where('department', '!=', '')
                ->distinct()
                ->pluck('department')
                ->filter()
                ->sort()
                ->values();


            $categories = Staff::all()
                ->map(function($staff) {
                    return $staff->category;
                })
                ->filter(function($category) {
                    return !empty($category) && trim($category) !== '';
                })
                ->unique()
                ->sort()
                ->values()
                ->toArray();

            return view('staff.index', compact(
                'director', 
                'leadership', 
                'teachers', 
                'departments', 
                'categories',
                'department', 
                'search', 
                'sort'
            ));

        } catch (\Exception $e) {
            Log::error('Staff index error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);
            

            return view('staff.index', [
                'director' => null,
                'leadership' => collect(),
                'teachers' => collect(),
                'departments' => [],
                'categories' => [],
                'department' => null,
                'search' => null,
                'sort' => 'order_asc'
            ]);
        }
    }

    public function show($id)
    {
        try {
            $staff = Staff::findOrFail($id);
            

            $photoUrl = $this->getStaffPhotoUrl($staff->photo, $staff->id);
            

            $currentLocale = app()->getLocale();
            $translatedData = $staff->getForLanguage($currentLocale);
            
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $staff->id,
                    'full_name' => $translatedData['full_name'] ?? $staff->full_name,
                    'position' => $translatedData['position'] ?? $staff->position,
                    'department' => $staff->department ?? null,
                    'email' => $staff->email ?? null,
                    'phone' => $staff->phone ?? null,
                    'photo' => $photoUrl,
                    'photo_path' => $staff->photo, 
                    'bio' => $translatedData['bio'] ?? $staff->bio ?? null,
                    'education' => $translatedData['education'] ?? $staff->education ?? null,
                    'specialty' => $translatedData['specialty'] ?? $staff->specialty ?? null,
                    'diploma_specialty' => $translatedData['diploma_specialty'] ?? $staff->diploma_specialty ?? null,
                    'diploma_qualification' => $translatedData['diploma_qualification'] ?? $staff->diploma_qualification ?? null,
                    'teaching_subjects' => $translatedData['teaching_subjects'] ?? $staff->teaching_subjects ?? null,
                    'work_experience_total' => $translatedData['work_experience_total'] ?? $staff->work_experience_total ?? null,
                    'work_experience_pedagogical' => $translatedData['work_experience_pedagogical'] ?? $staff->work_experience_pedagogical ?? null,
                    'category' => $translatedData['category'] ?? $staff->category ?? null,
                    'awards' => $translatedData['awards'] ?? $staff->awards ?? null,
                    'professional_development' => $translatedData['professional_development'] ?? $staff->professional_development ?? null,
                    'is_leadership' => $staff->is_leadership,
                    'order' => $staff->order,
                    'created_at' => $staff->created_at,
                    'updated_at' => $staff->updated_at,
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Staff show error', [
                'staff_id' => $id,
                'error' => $e->getMessage()
            ]);
            return response()->json([
                'success' => false,
                'error' => 'Сотрудник не найден'
            ], 404);
        }
    }

    private function getStaffPhotoUrl($photoPath, $staffId = null)
    {
        if (!$photoPath) {
            return asset('images/default-avatar.jpg');
        }

        $possiblePaths = [];
        

        if (str_starts_with($photoPath, 'http')) {
            return $photoPath;
        }
        

        if (str_starts_with($photoPath, 'staff/')) {
            $possiblePaths[] = asset('uploads/' . $photoPath);
            $possiblePaths[] = asset('storage/' . $photoPath);
            $possiblePaths[] = url($photoPath);
        } 
        elseif (str_starts_with($photoPath, 'storage/')) {
            $possiblePaths[] = asset($photoPath);
            $possiblePaths[] = url(str_replace('storage/', '', $photoPath));
        }
        elseif (str_starts_with($photoPath, 'public/')) {
            $possiblePaths[] = asset(str_replace('public/', '', $photoPath));
        }
        else {
            $possiblePaths[] = asset('uploads/staff/' . $photoPath);
            $possiblePaths[] = asset('storage/staff/' . $photoPath);
            $possiblePaths[] = asset('staff/' . $photoPath);
            $possiblePaths[] = asset('images/staff/' . $photoPath);
        }


        foreach ($possiblePaths as $url) {
            try {
                $parsedUrl = parse_url($url);
                if (isset($parsedUrl['path'])) {
                    $fullPath = public_path($parsedUrl['path']);
                    
                    if (file_exists($fullPath)) {
                        Log::info('Staff photo found', [
                            'staff_id' => $staffId,
                            'path' => $photoPath,
                            'url' => $url,
                            'full_path' => $fullPath
                        ]);
                        return $url;
                    }
                }
                

                $headers = @get_headers($url);
                if ($headers && strpos($headers[0], '200')) {
                    Log::info('Staff photo found via HTTP', [
                        'staff_id' => $staffId,
                        'path' => $photoPath,
                        'url' => $url
                    ]);
                    return $url;
                }
            } catch (\Exception $e) {
                
            }
        }

        Log::warning('Staff photo not found, using default', [
            'staff_id' => $staffId,
            'original_path' => $photoPath,
            'possible_paths' => $possiblePaths
        ]);

        return asset('images/default-avatar.jpg');
    }

    public function search(Request $request)
    {
        try {
            $query = $request->input('q', '');
            
            if (strlen($query) < 2) {
                return response()->json([]);
            }

            $staff = Staff::where(function($q) use ($query) {

                    $q->orWhereRaw("
                        CASE 
                            WHEN is_multilang = true THEN 
                                COALESCE(NULLIF((full_name::json->>'ru')::text, ''), full_name::text)
                            ELSE 
                                full_name::text
                        END ILIKE ?
                    ", ['%' . $query . '%']);
                    

                    $q->orWhereRaw("
                        CASE 
                            WHEN is_multilang = true THEN 
                                COALESCE(NULLIF((position::json->>'ru')::text, ''), position::text)
                            ELSE 
                                position::text
                        END ILIKE ?
                    ", ['%' . $query . '%']);
                    

                    $q->orWhere('department', 'ilike', '%' . $query . '%');
                })
                ->orderByRaw("
                    CASE 
                        WHEN is_multilang = true THEN 
                            COALESCE(NULLIF((full_name::json->>'ru')::text, ''), full_name::text)
                        ELSE 
                            full_name::text
                    END ASC
                ")
                ->limit(10)
                ->get()
                ->map(function($item) {
                    $photoUrl = $this->getStaffPhotoUrl($item->photo, $item->id);
                    
                    return [
                        'id' => $item->id,
                        'full_name' => $item->full_name,
                        'position' => $item->position,
                        'department' => $item->department,
                        'photo' => $photoUrl,
                        'is_leadership' => $item->is_leadership,
                    ];
                });

            return response()->json($staff);

        } catch (\Exception $e) {
            Log::error('Staff search API error: ' . $e->getMessage());
            
            return response()->json([
                'error' => 'Ошибка поиска'
            ], 500);
        }
    }

    public function checkPhotos()
    {
        try {
            $staffWithPhotos = Staff::whereNotNull('photo')
                ->where('photo', '!=', '')
                ->get(['id', 'full_name', 'photo']);
            
            $results = [];
            
            foreach ($staffWithPhotos as $staff) {
                $url = $this->getStaffPhotoUrl($staff->photo, $staff->id);
                $results[] = [
                    'id' => $staff->id,
                    'name' => $staff->full_name,
                    'original_path' => $staff->photo,
                    'final_url' => $url,
                    'is_default' => strpos($url, 'default-avatar') !== false,
                ];
            }
            
            return response()->json([
                'total' => $staffWithPhotos->count(),
                'results' => $results,
                'public_path' => public_path(),
                'storage_path' => storage_path(),
                'app_url' => config('app.url'),
            ]);
            
        } catch (\Exception $e) {
            Log::error('Check photos error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function stats()
    {
        try {
            $stats = [
                'total' => Staff::count(),
                'leadership' => Staff::where('is_leadership', true)->count(),
                'teachers' => Staff::where('is_leadership', false)->count(),
                'with_photos' => Staff::whereNotNull('photo')->where('photo', '!=', '')->count(),
                'by_department' => Staff::selectRaw('department, COUNT(*) as count')
                    ->whereNotNull('department')
                    ->where('department', '!=', '')
                    ->groupBy('department')
                    ->orderBy('count', 'desc')
                    ->get()
                    ->pluck('count', 'department')
                    ->toArray(),
                'by_category' => Staff::all()
                    ->groupBy(function($staff) {
                        return $staff->category;
                    })
                    ->map(function($group) {
                        return $group->count();
                    })
                    ->filter(function($count, $category) {
                        return !empty($category);
                    })
                    ->sortDesc()
                    ->toArray(),
            ];

            return response()->json([
                'success' => true,
                'stats' => $stats
            ]);

        } catch (\Exception $e) {
            Log::error('Staff stats error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'error' => 'Ошибка получения статистики'
            ], 500);
        }
    }
}