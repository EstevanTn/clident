@echo off
Title ZendFramework install component
echo Ingrese nombre de paquete de zend framework
set /p nombre=
set comando=php composer.phar require zendframework/%nombre%
%comando%
pause