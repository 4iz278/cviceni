@ECHO OFF
setlocal DISABLEDELAYEDEXPANSION
SET BIN_TARGET=%~dp0/../nette/neon/bin/neon-lint
php "%BIN_TARGET%" %*
