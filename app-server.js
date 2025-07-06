const express = require('express');
const path = require('path');
const fs = require('fs');
const app = express();
const PORT = process.env.PORT || 8080;

// Serve static files
app.use(express.static(__dirname));

// Simple route to serve index page
app.get('/', (req, res) => {
    res.send(`
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>UiTM Court Booking</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 20px;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
                min-height: 100vh;
            }
            .container {
                max-width: 800px;
                margin: 0 auto;
                text-align: center;
                padding: 50px 20px;
            }
            .header {
                background: rgba(255,255,255,0.1);
                padding: 30px;
                border-radius: 15px;
                backdrop-filter: blur(10px);
                margin-bottom: 30px;
            }
            .btn {
                display: inline-block;
                background: #ff6b6b;
                color: white;
                padding: 15px 30px;
                text-decoration: none;
                border-radius: 8px;
                margin: 10px;
                font-weight: bold;
                transition: all 0.3s ease;
            }
            .btn:hover {
                background: #ff5252;
                transform: translateY(-2px);
            }
            .status {
                background: rgba(255,255,255,0.1);
                padding: 20px;
                border-radius: 10px;
                margin: 20px 0;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h1>🏀 UiTM Court Booking System</h1>
                <p>Welcome to the Court Booking Application</p>
            </div>
            
            <div class="status">
                <h3>✅ System Status</h3>
                <p>✅ Node.js Server: Running on port ${PORT}</p>
                <p>✅ API Server: Running on port 3000</p>
                <p>⚠️ PHP Server: Not available (PHP not installed)</p>
            </div>

            <div>
                <h3>Quick Actions</h3>
                <a href="/api/test" class="btn">Test API</a>
                <a href="/files" class="btn">View Files</a>
                <a href="http://localhost:3000" class="btn">Node.js API</a>
            </div>
            
            <div style="margin-top: 40px;">
                <h3>📝 Next Steps to Complete Setup:</h3>
                <ol style="text-align: left; max-width: 600px; margin: 0 auto;">
                    <li>Install XAMPP or PHP to run the full application</li>
                    <li>Set up MySQL database</li>
                    <li>Import database schema</li>
                    <li>Configure database connection</li>
                </ol>
            </div>
        </div>
    </body>
    </html>
    `);
});

// API test endpoint
app.get('/api/test', (req, res) => {
    res.json({
        status: 'success',
        message: 'Node.js server is working!',
        timestamp: new Date().toISOString(),
        nodePort: PORT,
        apiPort: 3000
    });
});

// List project files
app.get('/files', (req, res) => {
    const files = fs.readdirSync(__dirname).filter(file => 
        file.endsWith('.php') || file.endsWith('.html') || file.endsWith('.js') || file.endsWith('.css')
    );
    
    res.json({
        message: 'Project files found',
        files: files,
        note: 'Install PHP/XAMPP to run .php files'
    });
});

app.listen(PORT, () => {
    console.log(`
    ╔══════════════════════════════════════╗
    ║        Court Booking System          ║
    ║               Started!               ║
    ╠══════════════════════════════════════╣
    ║  Web App: http://localhost:${PORT}     ║
    ║  API:     http://localhost:3000      ║
    ╚══════════════════════════════════════╝
    `);
});
