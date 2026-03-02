$ini = 'C:\php-8.3.4\php.ini'
$content = Get-Content $ini -Raw
$exts = @('fileinfo','mbstring','openssl','pdo_sqlite','tokenizer','xml','ctype','bcmath','curl','zip','intl','gd','dom','soap')
foreach ($ext in $exts) {
    $content = $content -replace (';extension=' + $ext + "`r"), ('extension=' + $ext + "`r")
    $content = $content -replace (';extension=' + $ext + "`n"), ('extension=' + $ext + "`n")
}
Set-Content $ini $content
Write-Host "Done enabling extensions"
php -m
