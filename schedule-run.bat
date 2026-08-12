@echo off
cd /d D:\OSPanel\home\pos-client
"D:\OSPanel\modules\PHP-8.2\PHP\php.exe" artisan schedule:run >> storage\logs\schedule.log 2>&1
