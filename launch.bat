@echo off
echo Starting UiTM Court Booking System with Laragon...

echo Installing Node.js dependencies...
npm install

echo Checking if Laragon is running...
echo Please make sure Laragon is started (Apache + MySQL)

echo Starting Node.js server on port 3000...
start "Node Server" npm start

echo.
echo =====================================
echo Court Booking System is starting...
echo =====================================
echo PHP Application: http://localhost/CourtBooking/
echo Node.js API: http://localhost:3000
echo =====================================
echo.
echo Make sure:
echo 1. Laragon is running (Apache + MySQL started)
echo 2. Project is in C:\laragon\www\CourtBooking\
echo 3. Database 'uitm_booking' is created
echo =====================================
echo.
echo Press any key to stop all servers...
pause

echo Stopping servers...
taskkill /f /im php.exe 2>nul
taskkill /f /im node.exe 2>nul
echo All servers stopped.
