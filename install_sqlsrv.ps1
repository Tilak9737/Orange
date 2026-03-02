$exePath = "$env:TEMP\sqlsrv_win.exe"
$extractDir = "$env:TEMP\sqlsrv_dlls"
New-Item -ItemType Directory -Force -Path $extractDir
$process = Start-Process -FilePath $exePath -ArgumentList "/Q /x:$extractDir" -Wait -PassThru
if ($process.ExitCode -eq 0) {
    Write-Host "Extraction successful"
    Copy-Item "$extractDir\SQLSRV512\php_pdo_sqlsrv_83_ts_x64.dll" -Destination "C:\php-8.3.4\ext\" -Force
    Copy-Item "$extractDir\SQLSRV512\php_sqlsrv_83_ts_x64.dll" -Destination "C:\php-8.3.4\ext\" -Force
    
    $ini = 'C:\php-8.3.4\php.ini'
    $content = Get-Content $ini -Raw
    if ($content -notmatch 'extension=pdo_sqlsrv') {
        $content += "`nextension=pdo_sqlsrv`n"
    }
    if ($content -notmatch 'extension=sqlsrv') {
        $content += "extension=sqlsrv`n"
    }
    Set-Content $ini $content
    Write-Host "Extensions added to php.ini"
}
else {
    Write-Host "Extraction failed with code $($process.ExitCode)"
}
