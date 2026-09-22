# Sync widget changes into the standalone widget-repo + mirror landing/presentation into the main repo.
# Run:  powershell -ExecutionPolicy Bypass -File scripts\sync-widget-repo.ps1
$ErrorActionPreference = 'Stop'
$root = Split-Path -Parent $PSScriptRoot
$wr   = Join-Path $root 'widget-repo'

if (-not (Test-Path -LiteralPath (Join-Path $wr '.git'))) {
    Write-Host 'widget-repo: .git not found - init and add remote first.' -ForegroundColor Yellow
    exit 1
}

# 1) Canonical widget/admin sources -> widget-repo
foreach ($m in @('widget', 'admin')) {
    $s = Join-Path $root $m
    $d = Join-Path $wr   $m
    if (Test-Path -LiteralPath $s) {
        if (Test-Path -LiteralPath $d) { Remove-Item -LiteralPath $d -Recurse -Force }
        Copy-Item -LiteralPath $s -Destination $d -Recurse -Force
    }
}

# server: sources only (no personal config.json, no data/)
$sd = Join-Path $wr 'server'
foreach ($f in @('server.js', 'config.example.json')) {
    $src = Join-Path $root "server\$f"
    if (Test-Path -LiteralPath $src) { Copy-Item -LiteralPath $src -Destination (Join-Path $sd $f) -Force }
}
$sl = Join-Path $root 'server\lib'
if (Test-Path -LiteralPath $sl) {
    if (Test-Path -LiteralPath (Join-Path $sd 'lib')) { Remove-Item -LiteralPath (Join-Path $sd 'lib') -Recurse -Force }
    Copy-Item -LiteralPath $sl -Destination (Join-Path $sd 'lib') -Recurse -Force
}

# 2) landing / presentation from widget-repo -> main repo
foreach ($d in @('landing', 'presentation')) {
    $s = Join-Path $wr $d
    $t = Join-Path $root $d
    if (Test-Path -LiteralPath $s) {
        if (Test-Path -LiteralPath $t) { Remove-Item -LiteralPath $t -Recurse -Force }
        Copy-Item -LiteralPath $s -Destination $t -Recurse -Force
    }
}

# 3) Commit + push widget-repo
Push-Location $wr
try {
    git add -A
    $changed = git status --porcelain
    if ($changed) {
        git commit -m "sync: widget/server/admin + landing/presentation/docs" | Out-Null
        git push | Out-Null
        Write-Host 'widget-repo: committed and pushed.' -ForegroundColor Green
    } else {
        Write-Host 'widget-repo: nothing to commit.' -ForegroundColor DarkGray
    }
} finally {
    Pop-Location
}

Write-Host ''
Write-Host ('Also commit and push the main repo: ' + $root) -ForegroundColor Cyan