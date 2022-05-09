@ECHO OFF
setlocal DISABLEDELAYEDEXPANSION
SET BIN_TARGET=%~dp0/../latte/latte/bin/latte-lint
php "%BIN_TARGET%" %*
