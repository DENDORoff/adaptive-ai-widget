<?php

namespace App\Services;

use Illuminate\Support\Str;


class SpamDetectionService
{

    private const SPAM_KEYWORDS = [
        'casino', 'poker', 'xxx', 'viagra', 'cialis', 'phentermine',
        'click here', 'buy now', 'order now', 'limited time',
        'get rich', 'work from home', 'make money fast',
        'free money', 'easy money', 'win cash', 'lottery',
        'nigger', 'fuck', 'shit', 
    ];


    private const SQL_PATTERNS = [
        '/(\b(union|select|insert|update|delete|drop|create|alter|exec|script)\b)/i',
        '/(-{2}|\/\*|\*\/|;)/i', 
        '/(%27|\')/i', 
    ];


    private const XSS_PATTERNS = [
        '/<script[^>]*>.*?<\/script>/i',
        '/javascript:/i',
        '/on\w+\s*=/i', 
        '/<iframe[^>]*>/i',
        '/<embed[^>]*>/i',
        '/<object[^>]*>/i',
    ];

    /**
     * Проверить текст на спам и вредоносный контент
     * 
     * @param string $text Текст для проверки
     * @return array ['is_spam' => bool, 'type' => string, 'details' => string]
     */
    public static function detectSpam(string $text): array
    {
        $text = trim($text);


        if (empty($text)) {
            return ['is_spam' => false, 'type' => null, 'details' => null];
        }


        if (self::containsXss($text)) {
            return [
                'is_spam' => true,
                'type' => 'xss_attempt',
                'details' => 'Обнаружена попытка XSS attack'
            ];
        }


        if (self::containsSpamKeywords($text)) {
            return [
                'is_spam' => true,
                'type' => 'spam_keywords',
                'details' => 'Текст содержит признаки спама'
            ];
        }


        if (self::hasExcessiveSymbols($text)) {
            return [
                'is_spam' => true,
                'type' => 'excessive_symbols',
                'details' => 'Текст содержит чрезмерное количество одинаковых символов'
            ];
        }


        if (self::hasObfuscatedUnicode($text)) {
            return [
                'is_spam' => true,
                'type' => 'obfuscated_unicode',
                'details' => 'Текст содержит подозрительные Unicode символы'
            ];
        }


        if (self::hasMultipleUrls($text)) {
            return [
                'is_spam' => true,
                'type' => 'multiple_urls',
                'details' => 'Текст содержит подозрительное количество URL адресов'
            ];
        }

        return ['is_spam' => false, 'type' => null, 'details' => null];
    }


    private static function containsSqlInjection(string $text): bool
    {
        foreach (self::SQL_PATTERNS as $pattern) {
            if (preg_match($pattern, $text)) {
                return true;
            }
        }
        return false;
    }


    private static function containsXss(string $text): bool
    {
        foreach (self::XSS_PATTERNS as $pattern) {
            if (preg_match($pattern, $text)) {
                return true;
            }
        }
        return false;
    }


    private static function containsSpamKeywords(string $text): bool
    {
        $lowerText = mb_strtolower($text);
        
        foreach (self::SPAM_KEYWORDS as $keyword) {
            if (strpos($lowerText, $keyword) !== false) {
                return true;
            }
        }
        
        return false;
    }


    private static function hasExcessiveSymbols(string $text): bool
    {

        if (preg_match('/(.)\1{5,}/', $text)) {
            return true;
        }


        $specialCharCount = preg_match_all('/[!@#$%^&*()_\-+=\[\]{};:\'",.<>?\\/\\|`~]/', $text);
        $totalLength = mb_strlen($text);
        

        if ($specialCharCount > ($totalLength * 0.3)) {
            return true;
        }

        return false;
    }


    private static function hasObfuscatedUnicode(string $text): bool
    {

        if (preg_match('/\xE2\x80\xAE|\xE2\x80\x8B|\xE2\x80\x8C|\xE2\x80\x8D|\xEF\xBB\xBF/u', $text)) {
            return true;
        }
        

        if (preg_match('/[\p{Mn}]{5,}/u', $text)) {
            return true;
        }
        
        return false;
    }


    private static function hasMultipleUrls(string $text): bool
    {
        $urlPattern = '/(https?:\/\/|www\.)[^\s]+/i';
        $matches = [];
        preg_match_all($urlPattern, $text, $matches);
        

        return count($matches[0]) > 2;
    }


    public static function isValidEmail(string $email): bool
    {

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }


        if (preg_match('/[<>"\'%;()&+]/', $email)) {
            return false;
        }


        if (strlen($email) > 254) {
            return false;
        }

        return true;
    }

 
    public static function isValidPhone(string $phone): bool
    {

        $cleaned = preg_replace('/[^\d+]/', '', $phone);


        if (strlen($cleaned) < 10) {
            return false;
        }


        if (strlen($cleaned) > 15) {
            return false;
        }

        return true;
    }


    public static function sanitize(string $text): string
    {

        $text = strip_tags($text);


        $text = preg_replace('/[\x00-\x08\x0B-\x0C\x0E-\x1F\x7F]/u', '', $text);


        $text = preg_replace('/\s+/', ' ', $text);

        return trim($text);
    }
}
