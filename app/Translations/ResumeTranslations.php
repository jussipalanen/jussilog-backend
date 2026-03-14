<?php

declare(strict_types=1);

namespace App\Translations;

class ResumeTranslations
{
    private const SUPPORTED = ['en', 'fi'];

    public const SKILL_CATEGORIES = [
        'programming_languages',
        'scripting_languages',
        'markup_languages',
        'query_languages',
        'frontend_technologies',
        'backend_technologies',
        'full_stack_development',
        'frameworks',
        'libraries',
        'ui_ux_design',
        'responsive_design',
        'mobile_development',
        'desktop_development',
        'game_development',
        'embedded_systems',
        'databases',
        'database_design',
        'database_administration',
        'orm_data_access',
        'api_development',
        'web_services',
        'graphql',
        'microservices',
        'event_driven_architecture',
        'devops',
        'cloud_platforms',
        'serverless',
        'containerization',
        'ci_cd',
        'infrastructure_as_code',
        'configuration_management',
        'version_control',
        'testing_qa',
        'test_automation',
        'security',
        'authentication_authorization',
        'networking',
        'performance_optimization',
        'architecture_design_patterns',
        'system_design',
        'distributed_systems',
        'data_engineering',
        'big_data',
        'machine_learning_ai',
        'monitoring_logging',
        'development_tools',
        'operating_systems',
        'project_management',
        'agile_methodologies',
        'soft_skills',
        'other',
    ];

    public const SKILL_PROFICIENCIES = [
        'beginner',
        'basic',
        'intermediate',
        'advanced',
        'expert',
    ];

    public const LANGUAGE_PROFICIENCIES = [
        'native_bilingual',
        'full_professional',
        'professional_working',
        'limited_working',
        'elementary',
    ];

    public const SPOKEN_LANGUAGES = [
        'af', 'sq', 'ar', 'hy', 'az',
        'be', 'bn', 'bs', 'bg',
        'ca', 'zh', 'hr', 'cs',
        'da', 'nl',
        'en', 'et',
        'fi', 'fr',
        'ka', 'de', 'el',
        'he', 'hi', 'hu',
        'is', 'id', 'it',
        'ja',
        'kk', 'ko',
        'lv', 'lt',
        'mk', 'ms', 'mt',
        'no',
        'fa', 'pl', 'pt',
        'ro', 'ru',
        'sr', 'sk', 'sl', 'es', 'sv',
        'th', 'tr',
        'uk', 'ur',
        'vi',
        'cy',
        'other',
    ];

    public static function get(string $lang): array
    {
        $locale = in_array($lang, self::SUPPORTED, true) ? $lang : 'en';

        return include base_path("lang/{$locale}/resume.php");
    }

    /** @return array<int, array{value: string, label: string}> */
    public static function skillCategories(string $lang): array
    {
        $t = self::get($lang);

        return array_values(array_map(
            fn ($v) => ['value' => $v, 'label' => $t['skill_category_' . $v] ?? $v],
            self::SKILL_CATEGORIES,
        ));
    }

    /** @return array<int, array{value: string, label: string}> */
    public static function skillProficiencies(string $lang): array
    {
        $t = self::get($lang);

        return array_values(array_map(
            fn ($v) => ['value' => $v, 'label' => $t['skill_proficiency_' . $v] ?? $v],
            self::SKILL_PROFICIENCIES,
        ));
    }

    /** @return array<int, array{value: string, label: string}> */
    public static function languageProficiencies(string $lang): array
    {
        $t = self::get($lang);

        return array_values(array_map(
            fn ($v) => ['value' => $v, 'label' => $t['proficiency_' . $v] ?? $v],
            self::LANGUAGE_PROFICIENCIES,
        ));
    }

    /** @return array<int, array{value: string, label: string}> */
    public static function spokenLanguages(string $lang): array
    {
        $t = self::get($lang);

        return array_values(array_map(
            fn ($v) => ['value' => $v, 'label' => $t['spoken_language_' . $v] ?? $v],
            self::SPOKEN_LANGUAGES,
        ));
    }

    /** @return array<int, array{value: string, label: string}> */
    public static function themes(array $themes, string $lang): array
    {
        $t = self::get($lang);

        return array_values(array_map(
            fn ($v) => ['value' => $v, 'label' => $t['theme_' . $v] ?? $v],
            $themes,
        ));
    }

    /** @return array<int, array{value: string, label: string}> */
    public static function templates(array $templates, string $lang): array
    {
        $t = self::get($lang);

        return array_values(array_map(
            fn ($v) => ['value' => $v, 'label' => $t['template_' . $v] ?? $v],
            $templates,
        ));
    }

    /** @return array<int, array{value: string, label: string}> */
    public static function languages(array $languages, string $lang): array
    {
        $t = self::get($lang);

        return array_values(array_map(
            fn ($value) => ['value' => $value, 'label' => $t['language_' . $value] ?? $value],
            array_keys($languages),
        ));
    }
}
