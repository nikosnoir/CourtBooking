# Complete Render Deployment Guide

## 🚀 Step-by-Step Deployment to Render

### Prerequisites
- GitHub account
- Render account (free at render.com)
- Your Court Booking project ready

## Step 1: Prepare GitHub Repository

1. **Create GitHub Repository**:
   - Go to github.com and create new repository
   - Name: `court-booking-app`
   - Make it public
   - Don't initialize with README (we have one)

2. **Push Your Code to GitHub**:
   ```bash
   git init
   git add .
   git commit -m "Initial commit for Render deployment"
   git branch -M main
   git remote add origin https://github.com/YOUR_USERNAME/court-booking-app.git
   git push -u origin main
   ```

## Step 2: Set Up Database on Render

1. **Go to Render Dashboard**: https://dashboard.render.com
2. **Create PostgreSQL Database**:
   - Click "New" → "PostgreSQL"
   - Name: `court-booking-db`
   - Region: Choose closest to you
   - Plan: Free tier
   - Click "Create Database"

3. **Note Database Details**:
   - External Database URL (starts with postgres://)
   - Internal Database URL
   - Host, Port, Database Name, Username, Password

4. **Import Your Data**:
   - Use a PostgreSQL client or pgAdmin
   - Convert your MySQL data to PostgreSQL format
   - Or start fresh and register new users

## Step 3: Deploy Web Service

1. **Create Web Service**:
   - Click "New" → "Web Service"
   - Connect your GitHub repository
   - Select `court-booking-app` repository

2. **Configure Service**:
   - **Name**: `court-booking-app`
   - **Environment**: `Docker` or `Node`
   - **Build Command**: `chmod +x build.sh && ./build.sh`
   - **Start Command**: `chmod +x start.sh && ./start.sh`
   - **Auto-Deploy**: Yes

## Step 4: Environment Variables

Add these environment variables in Render dashboard:

```
DATABASE_URL=postgresql://username:password@host:port/database
DB_HOST=your_postgres_host
DB_NAME=your_database_name  
DB_USER=your_database_user
DB_PASSWORD=your_database_password
DB_PORT=5432
NODE_ENV=production
```

## Step 5: Test Your Deployment

After deployment completes:
1. **Visit your app**: https://your-app-name.onrender.com
2. **Test registration**: Create a new account
3. **Test booking**: Make a court booking
4. **Test admin**: Create admin user

## Database Schema for PostgreSQL

Since Render uses PostgreSQL, convert your MySQL schema:

```sql
-- Users table (PostgreSQL version)
CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    role VARCHAR(20) DEFAULT 'student',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Courts table
CREATE TABLE courts (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100),
    location VARCHAR(255),
    type VARCHAR(50),
    status VARCHAR(20) DEFAULT 'active'
);

-- Bookings table
CREATE TABLE bookings (
    id SERIAL PRIMARY KEY,
    user_id INTEGER REFERENCES users(id),
    court_id INTEGER REFERENCES courts(id),
    booking_date DATE,
    booking_time TIME,
    status VARCHAR(20) DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

## Troubleshooting

- **Build fails**: Check build logs, ensure all dependencies in package.json
- **Database connection**: Verify DATABASE_URL format
- **Port issues**: Render automatically assigns ports
- **File permissions**: Make sure shell scripts are executable

## Cost Estimates

- **Database**: Free tier (limited storage)
- **Web Service**: Free tier (limited hours)
- **Upgrade**: $7/month for always-on service

Your app will be live at: `https://your-app-name.onrender.com`
- **Type**: Web Service
- **Environment**: Docker
- **Build Command**: `chmod +x build.sh && ./build.sh`
- **Start Command**: `chmod +x start.sh && ./start.sh`
- **Port**: 8080

## Environment Variables Required:
```
DB_HOST=your_mysql_host
DB_NAME=uitm_booking
DB_USER=your_mysql_user
DB_PASSWORD=your_mysql_password
DB_PORT=3306
NODE_PORT=3000
```

## Database Setup
1. Create a MySQL database on Render or external provider
2. Import your database schema
3. Update environment variables

## Post-Deployment Steps
1. Test the PHP application at your-app.onrender.com
2. Test the Node.js API at your-app.onrender.com:3000
3. Configure any necessary redirects or proxy rules

## Troubleshooting
- Check logs in Render dashboard
- Ensure all file permissions are correct
- Verify database connectivity
