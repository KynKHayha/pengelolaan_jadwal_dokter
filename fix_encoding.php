<?php
// Fix encoding issues in blade files caused by PowerShell UTF-8 BOM write
$dir = __DIR__ . '/resources/views';
$count = 0;

function fixFile($path) {
    global $count;
    $content = file_get_contents($path);
    
    // Check if there are garbled characters (UTF-8 misread as Latin-1)
    // The garbled â€" is the UTF-8 bytes for — (em dash: E2 80 94) read as Latin-1
    // PowerShell double-encoded: UTF-8 string stored as Windows-1252
    
    $replacements = [
        "\xc3\xa2\xc2\x80\xc2\x94" => '&ndash;',  // â€" -> –
        "\xc3\xa2\xc2\x80\xc2\x93" => '&ndash;',  // â€" variant
        "\xc3\xa2\xc2\x80\xc2\x99" => "'",         // â€™ -> '
        "\xc3\xa2\xc2\x80\xc2\x98" => "'",         // â€˜ -> '
        "\xc3\xa2\xc2\x80\xc2\x9c" => '"',         // â€œ -> "
        "\xc3\xa2\xc2\x80\xc2\x9d" => '"',         // â€ -> "
        'â€"'  => '–',
        'â€™'  => "'",
        'â€˜'  => "'",
        'â€œ'  => '"',
        'â€'   => '"',
        'â€¦'  => '...',
    ];
    
    $fixed = str_replace(array_keys($replacements), array_values($replacements), $content);
    
    if ($fixed !== $content) {
        file_put_contents($path, $fixed);
        $count++;
        echo "Fixed: $path\n";
    }
}

$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
foreach ($iterator as $file) {
    if ($file->getExtension() === 'php') {
        fixFile($file->getPathname());
    }
}

echo "\nDone! Fixed $count files.\n";
