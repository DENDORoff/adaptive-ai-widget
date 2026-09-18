<?php
// app/Http/Controllers/TranslationTestController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DeepLDynamicTranslator;

class TranslationTestController extends Controller
{
    protected $translator;
    
    public function __construct(DeepLDynamicTranslator $translator)
    {
        $this->translator = $translator;
    }
    
    public function show()
    {
        return view('test-translation', [
            'translator' => $this->translator,
            'isAvailable' => $this->translator->isAvailable(),
            'currentLang' => app()->getLocale(),
            'supportedLangs' => ['ru', 'en', 'kk'],
            'usage' => $this->translator->getUsage(),
        ]);
    }
    
    public function translateAjax(Request $request)
    {
        $request->validate([
            'text' => 'required|string|max:1000',
            'lang' => 'required|string|in:en,kk',
        ]);
        
        $translated = $this->translator->translate($request->text, $request->lang);
        
        return response()->json([
            'success' => true,
            'original' => $request->text,
            'translated' => $translated,
            'lang' => $request->lang,
        ]);
    }
}