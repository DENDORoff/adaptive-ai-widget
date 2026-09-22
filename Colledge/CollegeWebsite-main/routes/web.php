<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\ThrottleFormSubmissions;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\Api\SiteAdminController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\AchievementsController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\StateSymbolsController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AppealController;
use App\Http\Controllers\InfoBoardController;
use App\Http\Controllers\VacancyController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ExpertiseController;
use App\Http\Controllers\GosCorruptionController;
use App\Http\Controllers\CollegeDocumentController;
use App\Http\Controllers\AnticorruptionDocumentController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\CuratorController;
use App\Http\Controllers\Api\PortalVisitsController;
use App\Http\Controllers\NormativeDocumentsController;
use App\Http\Controllers\UnionEducationController;
use App\Http\Controllers\LaborProtectionController;
use App\Http\Controllers\YouthApiController;
use App\Http\Controllers\YouthMovementController;
use App\Http\Controllers\CouncilController;
use App\Http\Controllers\CouncilDocumentController;
use App\Http\Controllers\BugReportController;
use App\Http\Controllers\SitemapController;

// Маршрут для перенаправления на страницу входа Filament
Route::get('/login', function () {
    return redirect('/admin/login');
})->name('login');

// SEO Routes
Route::get('/sitemap.xml', [SitemapController::class, 'sitemap'])->name('sitemap.xml');
Route::get('/robots.txt', [SitemapController::class, 'robots'])->name('robots.txt');

Route::get('/', [HomeController::class, 'index'])
    ->middleware('cache.response:30')
    ->name('home');

Route::get('/locale/{locale}', [LocaleController::class, 'switch'])
    ->name('locale.switch');

Route::get('/news', [NewsController::class, 'index'])
    ->middleware('cache.response:15')
    ->name('news.index');
Route::get('/news/{slug}', [NewsController::class, 'show'])->name('news.show');

Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

Route::get('/staff', [StaffController::class, 'index'])->name('staff.index');

Route::get('/questions', [QuestionController::class, 'index'])->name('questions.index');
Route::post('/questions', [QuestionController::class, 'store'])
    ->middleware([ThrottleFormSubmissions::class . ':5,60', 'spam.protection'])
    ->name('questions.store');

Route::get('/about', [AboutController::class, 'about'])->name('about');
Route::get('/timeline/{slug}', [AboutController::class, 'show'])->name('timeline.event');
Route::get('/api/timeline', [AboutController::class, 'getTimelineEvents'])->name('api.timeline');

Route::get('/applicants', [PageController::class, 'applicants'])->name('applicants');
Route::get('/students', [PageController::class, 'students'])->name('students');
Route::get('/collaborations', [PageController::class, 'collaborations'])->name('collaborations');
Route::get('/anti-corruption', [PageController::class, 'antiCorruption'])->name('anti-corruption');
Route::get('/government-services', [PageController::class, 'governmentServices'])->name('government-services');
Route::get('/trade-union', [PageController::class, 'tradeUnion'])->name('trade-union');

Route::get('/youth-movement', [YouthMovementController::class, 'index'])->name('youth-movement');

Route::get('/sovet', [CouncilController::class, 'index'])->name('sovet');

Route::prefix('councils/documents')->group(function () {
    Route::get('/{id}/view', [CouncilDocumentController::class, 'view'])
        ->name('council.document.view');
    Route::get('/{id}/download', [CouncilDocumentController::class, 'download'])
        ->name('council.document.download');
});

Route::post('/consultation/request', [ConsultationController::class, 'store'])
    ->middleware([ThrottleFormSubmissions::class . ':3,30', 'spam.protection'])
    ->name('consultation.store');

Route::get('/achievements', [AchievementsController::class, 'index'])->name('achievements.index');

Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/search/live', [SearchController::class, 'live'])->name('search.live');

Route::get('/state-symbols', [StateSymbolsController::class, 'index'])->name('state-symbols.index');

Route::get('/contacts', [ContactController::class, 'index'])->name('contacts.index');

Route::get('/library', [LibraryController::class, 'index'])->name('library.index');

Route::get('/curators', [CuratorController::class, 'index'])->name('curators.index');
Route::get('/curators/{id}', [CuratorController::class, 'show'])->name('curators.show');
Route::get('/api/curators/filter', [CuratorController::class, 'filter'])->name('curators.filter');

Route::post('/appeals', [AppealController::class, 'store'])
    ->middleware([ThrottleFormSubmissions::class . ':10,60', 'spam.protection'])
    ->name('appeals.store');

Route::post('/bug-report', [BugReportController::class, 'store'])
    ->middleware([ThrottleFormSubmissions::class . ':5,30', 'spam.protection'])
    ->name('bug-report.store');

Route::get('/infoboard', [InfoBoardController::class, 'index'])->name('infoboard.index');

Route::get('/vacancies', [VacancyController::class, 'index'])->name('vacancies.index');
Route::get('/vacancies/{slug}', [VacancyController::class, 'show'])->name('vacancies.show');

Route::get('/api/search', [SearchController::class, 'live'])->name('search.api');
Route::get('/api/staff/{id}', [StaffController::class, 'show'])->name('staff.show');

Route::post('/api/chat/session', [ChatController::class, 'getSession'])->name('chat.session');
Route::post('/api/chat/messages', [ChatController::class, 'getMessages'])->name('chat.messages');
Route::post('/api/chat/send', [ChatController::class, 'sendMessage'])
    ->middleware(ThrottleFormSubmissions::class . ':10,5')
    ->middleware('spam.protection')
    ->name('chat.send');

Route::prefix('expertise')->name('expertise.')->group(function () {
    Route::get('/', [ExpertiseController::class, 'index'])->name('index');
});

Route::get('/goscorruption', [GosCorruptionController::class, 'index'])->name('goscorruption.index');

Route::get('/documents/college/{type}', [CollegeDocumentController::class, 'show'])
    ->name('college-documents.show')
    ->where('type', 'charter|license|rules');

Route::get('/anticorruption/document/{slug}', [AnticorruptionDocumentController::class, 'show'])
    ->name('anticorruption.show');

Route::get('/anticorruption/documents', [AnticorruptionDocumentController::class, 'allDocuments'])->name('anticorruption.documents');

Route::prefix('portal-visits')->group(function () {
    Route::get('/monthly-chart', [PortalVisitsController::class, 'getMonthlyChart']);
    Route::get('/last-12-months-chart', [PortalVisitsController::class, 'getLast12MonthsChart']);
    Route::get('/today', [PortalVisitsController::class, 'getToday']);
    Route::get('/current-month', [PortalVisitsController::class, 'getCurrentMonth']);
    Route::get('/recent/{days}', [PortalVisitsController::class, 'getRecentDays']);
    Route::get('/all', [PortalVisitsController::class, 'getAll']);
});

Route::prefix('api/dashboard')->middleware('api')->group(function () {
    Route::get('/data', [DashboardController::class, 'index'])->name('dashboard.data');
    Route::get('/category/{category}', [DashboardController::class, 'category'])->name('dashboard.category');
    Route::get('/key/{key}', [DashboardController::class, 'getByKey'])->name('dashboard.key');
    Route::post('/refresh/{key}', [DashboardController::class, 'refresh'])->name('dashboard.refresh')->middleware('auth:sanctum');
    Route::get('/summary', [DashboardController::class, 'summary'])->name('dashboard.summary');
    Route::get('/tab/{tab}', [DashboardController::class, 'tabData'])->name('dashboard.tab');
});

Route::prefix('dashboard')->group(function () {
    Route::get('/data', [DashboardController::class, 'getAllData'])->name('dashboard.getAllData');
    Route::get('/category/{category}', [DashboardController::class, 'getByCategory'])->name('dashboard.getByCategory');
    Route::get('/key/{key}', [DashboardController::class, 'getByKeyApi'])->name('dashboard.getByKey');
});

Route::get('/normative-documents', [NormativeDocumentsController::class, 'index'])
    ->name('normative-documents');

Route::get('/normative-documents/download/{document}', [NormativeDocumentsController::class, 'download'])
    ->name('normative-documents.download')
    ->where('document', '[a-z-]+');

Route::get('/normative-documents/preview/{document}', [NormativeDocumentsController::class, 'preview'])
    ->name('normative-documents.preview')
    ->where('document', '[a-z-]+');

Route::get('/union-education', [UnionEducationController::class, 'index'])
    ->name('union-education');

Route::get('/union-education/download/{document}', [UnionEducationController::class, 'download'])
    ->name('union-education.download')
    ->where('document', '[a-z-]+');

Route::get('/union-education/preview/{document}', [UnionEducationController::class, 'preview'])
    ->name('union-education.preview')
    ->where('document', '[a-z-]+');

Route::get('/labor-protection', [LaborProtectionController::class, 'index'])
    ->name('labor-protection');

Route::get('/labor-protection/download/{document}', [LaborProtectionController::class, 'download'])
    ->name('labor-protection.download')
    ->where('document', '[a-z-]+');

Route::get('/labor-protection/preview/{document}', [LaborProtectionController::class, 'preview'])
    ->name('labor-protection.preview')
    ->where('document', '[a-z-]+');

Route::middleware('api')->group(function () {
    Route::prefix('youth')->group(function () {
        Route::get('/events/calendar', [YouthApiController::class, 'getCalendarEvents']);
        Route::get('/events/{id}', [YouthApiController::class, 'getEvent']);
        Route::get('/clubs/{id}', [YouthApiController::class, 'getClub']);
    });
});

Route::post('/api/site/online/ping', [SiteAdminController::class, 'onlinePing']);

Route::middleware(['api', 'site.token'])->prefix('api/site')->group(function () {
    Route::get('/overview', [SiteAdminController::class, 'overview']);
    Route::get('/online', [SiteAdminController::class, 'online']);
    Route::get('/news', [SiteAdminController::class, 'newsList']);
    Route::get('/news/{id}', [SiteAdminController::class, 'newsShow']);
    Route::post('/news', [SiteAdminController::class, 'newsStore']);
    Route::put('/news/{id}', [SiteAdminController::class, 'newsUpdate']);
    Route::delete('/news/{id}', [SiteAdminController::class, 'newsDelete']);
    Route::get('/sections', [SiteAdminController::class, 'sections']);
    Route::get('/sections/{id}', [SiteAdminController::class, 'sectionShow']);
    Route::put('/sections/{id}', [SiteAdminController::class, 'sectionUpdate']);
    Route::post('/cache/clear', [SiteAdminController::class, 'cacheClear']);
});

Route::get('/test-speed', function () {
    return response()->json([
        'status' => 'ok',
        'message' => 'Server is responding',
        'timestamp' => now()
    ]);
});