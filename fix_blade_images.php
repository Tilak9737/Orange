<?php
$dir = new RecursiveIteratorIterator(new RecursiveDirectoryIterator('resources/views'));
foreach ($dir as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        $content = file_get_contents($file->getPathname());
        $content = preg_replace('/Storage::url\((.*?)\)/', '(\Illuminate\Support\Str::startsWith($1, [\'http://\', \'https://\']) ? $1 : Storage::url($1))', $content);
        file_put_contents($file->getPathname(), $content);
    }
}
echo "Done replacing Storage::url\n";
