<?php

namespace App\Helpers;

use Stichoza\GoogleTranslate\GoogleTranslate;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class TranslationHelper {
    public static function translate($text) {
        // User ki current language session se uthayen
        $targetLang = Session::get('locale', 'en');

        // Agar English hai, to translate na karein
        if ($targetLang == 'en') {
            return $text;
        }

        // Cache use karein taake har baar API hit na ho (Speed ke liye)
        $cacheKey = 'trans_' . $targetLang . '_' . md5($text);
        
        return Cache::remember($cacheKey, 86400, function () use ($text, $targetLang) {
            try {
                $tr = new GoogleTranslate();
                $tr->setSource('en');
                $tr->setTarget($targetLang);
                return $tr->translate($text);
            } catch (\Exception $e) {
                return $text; // Agar koi error aaye to original text return karein
            }
        });
    }
}