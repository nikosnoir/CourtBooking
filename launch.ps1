# UiTM Court Booking System Launcher
Write-Host "Starting UiTM Court Booking System..." -ForegroundColor Green

# Check if Node.js is installed
try {
    $nodeVersion = node --version
    Write-Host "Node.js version: $nodeVersion" -ForegroundColor Yellow
} catch {
    Write-Host "Error: Node.js is not installed. Please install Node.js first." -ForegroundColor Red
    exit 1
}

# Check if PHP is installed
try {
    $phpVersion = php --version
    Write-Host "PHP is available" -ForegroundColor Yellow
} catch {
    Write-Host "Error: PHP is not installed. Please install PHP first." -ForegroundColor Red
    exit 1
}

# Install Node.js dependencies
Write-Host "Installing Node.js dependencies..." -ForegroundColor Cyan
npm install

if ($LASTEXITCODE -ne 0) {
    Write-Host "Error installing dependencies. Please check your internet connection." -ForegroundColor Red
    exit 1
}

# Start PHP server
Write-Host "Starting PHP server on port 8080..." -ForegroundColor Cyan
Start-Process powershell -ArgumentList "-NoExit", "-Command", "php -S localhost:8080"

# Wait a moment
Start-Sleep -Seconds 2

# Start Node.js server
Write-Host "Starting Node.js server on port 3000..." -ForegroundColor Cyan
Start-Process powershell -ArgumentList "-NoExit", "-Command", "npm start"

Write-Host ""
Write-Host "=====================================" -ForegroundColor Green
Write-Host "Court Booking System is starting..." -ForegroundColor Green
Write-Host "=====================================" -ForegroundColor Green
Write-Host "PHP Application: http://localhost:8080" -ForegroundColor White
Write-Host "Node.js API: http://localhost:3000" -ForegroundColor White
Write-Host "=====================================" -ForegroundColor Green
Write-Host ""
Write-Host "Press any key to stop all servers..." -ForegroundColor Yellow
$null = $Host.UI.RawUI.ReadKey("NoEcho,IncludeKeyDown")

Write-Host "Stopping servers..." -ForegroundColor Red
Get-Process -Name "php" -ErrorAction SilentlyContinue | Stop-Process -Force
Get-Process -Name "node" -ErrorAction SilentlyContinue | Stop-Process -Force
Write-Host "All servers stopped." -ForegroundColor Green
