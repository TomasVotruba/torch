<?php

declare(strict_types=1);

// this is needed, to avoid same-named function override,
// that was added to scoper 18.x https://github.com/humbug/php-scoper/pull/706/files


// @see https://chat.openai.com/share/7a22f30a-e73b-41ff-82cb-22441bebaf24

if (isset($argv[1])) {
    $filename = $argv[1];

    if (file_exists($filename)) {
        // Read the content from the file
        $content = file_get_contents($filename);

        // Define the regex pattern and replacement
        $pattern = '/if\s*!\s*function_exists\s*\([^)]*\)\s*{[^}]*}/s';
        $replacement = '$1// $0';

        // Perform the replacement
        $modifiedContent = preg_replace($pattern, $replacement, $content);

        // Save the modified content back to the file
        file_put_contents($filename, $modifiedContent);

        echo "Processing completed successfully.\n";
    } else {
        echo "File not found: $filename\n";
    }
} else {
    echo "Usage: php escape-twig-functions.php <filename>\n";
}
