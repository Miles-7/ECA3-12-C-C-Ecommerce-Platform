<?php


//

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// array of the languages that I will support 
$supported_langs = ['en', 'af', 'xh', 'zu'];



// I make sure that a language is selected by fetching it from url, then check if it is in the array of supported languages
if (isset($_GET['lang']) && in_array($_GET['lang'], $supported_langs)) {
    $_SESSION['lang'] = $_GET['lang'];
}

$current_lang = $_SESSION['lang'] ?? 'en';

$lang_file = __DIR__ . '/../../lang/' . $current_lang . '.json';
$translations = json_decode(file_get_contents($lang_file), true) ?? [];

function t(string $key): string
{
    global $translations;

    $parts = explode('.', $key);
    $value = $translations;

    foreach ($parts as $part) {
        if (!isset($value[$part])) {
            return $key;
        }
        $value = $value[$part];
    }

    return is_string($value) ? $value : $key;
}
