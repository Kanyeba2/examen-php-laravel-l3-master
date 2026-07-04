@echo off
cd /d C:\xampp\htdocs\examen-php-laravel-l3-master

if not exist C:\xampp\htdocs\examen-php-laravel-l3-master\storage\router.php (
	echo Erreur: storage\router.php introuvable.
	exit /b 1
)

C:\php84\php.exe artisan optimize:clear

start "Laravel Local 8000" cmd /k "cd /d C:\xampp\htdocs\examen-php-laravel-l3-master && C:\php84\php.exe -S 127.0.0.1:8000 C:\xampp\htdocs\examen-php-laravel-l3-master\storage\router.php"

echo Serveur demarre dans une nouvelle fenetre: http://127.0.0.1:8000
