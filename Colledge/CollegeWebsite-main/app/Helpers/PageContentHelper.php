<?php

use App\Models\PageSection;

if (!function_exists('page_content')) {

    function page_content(string $pageKey, string $sectionKey, string $contentKey, $default = null)
    {
        return PageSection::getValue($pageKey, $sectionKey, $contentKey, $default);
    }
}

if (!function_exists('page_section')) {

    function page_section(string $pageKey, string $sectionKey)
    {
        return PageSection::getSection($pageKey, $sectionKey);
    }
}

if (!function_exists('page_image')) {

    function page_image(string $pageKey, string $sectionKey, string $imageKey, ?string $default = null)
    {
        $section = PageSection::getSection($pageKey, $sectionKey);
        return $section ? $section->getImage($imageKey) : $default;
    }
}