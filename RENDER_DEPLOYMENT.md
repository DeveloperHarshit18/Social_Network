# Render Deployment Guide

This guide explains how to deploy the Social Network application on Render.

## Prerequisites

- GitHub repository with the code
- Render account (free tier available)

## Step-by-Step Deployment

### 1. Prepare Your Repository

Make sure your repository has all the necessary files:
- `composer.json`
- `render.yaml`
- `database_postgresql.sql`
- `init_database.php`
- `.htaccess`
- `public/index.php`

### 2. Create Database on Render

1. **Go to Render Dashboard**
2. **Click "New +"**
3. **Select "PostgreSQL"**
4. **Configure:**
   - Name: `social-network-db`
   - Database: `social_network`
   - User: `social_user`
   - Password: `your_secure_password`
   - Plan: Free

### 3. Deploy Web Service

1. **Go to Render Dashboard**
2. **Click "New +"**
3. **Select "Web Service"**
4. **Connect your GitHub repository**
5. **Configure:**
   - Name: `social-network`
   - Environment: `PHP`
   - Build Command: `composer install`
   - Start Command: `php -S 0.0.0.0:$PORT`
   - Health Check Path: `/index.php`

### 4. Set Environment Variables

In your web service settings, add these environment variables:

```
DB_HOST=your_postgres_host
DB_NAME=social_network
DB_USER=social_user
DB_PASS=your_secure_password
```

### 5. Initialize Database

After deployment, run the database initialization:

1. **Go to your web service**
2. **Click "Shell"**
3. **Run:** `php init_database.php`

### 6. Test Your Application

- **Visit your Render URL**
- **Try signing up** with a new account
- **Test login/logout functionality**
- **Create posts and test features**

## Troubleshooting

### Common Issues

1. **Database Connection Failed**
   - Check environment variables
   - Verify database is running
   - Check connection string format

2. **Login/Signup Not Working**
   - Ensure database tables are created
   - Check PHP error logs
   - Verify session configuration

3. **File Upload Issues**
   - Check upload directory permissions
   - Verify file size limits
   - Check PHP upload settings

### Debug Steps

1. **Check Logs:**
   ```bash
   # In Render shell
   tail -f /var/log/php_errors.log
   ```

2. **Test Database Connection:**
   ```php
   // Create test_db.php
   <?php
   require_once 'classes/Database.php';
   $db = new Database();
   $conn = $db->getConnection();
   if ($conn) {
       echo "Database connected!";
   } else {
       echo "Connection failed!";
   }
   ?>
   ```

3. **Check Environment Variables:**
   ```php
   // Create test_env.php
   <?php
   echo "DB_HOST: " . ($_ENV['DB_HOST'] ?? 'Not set') . "\n";
   echo "DB_NAME: " . ($_ENV['DB_NAME'] ?? 'Not set') . "\n";
   echo "DB_USER: " . ($_ENV['DB_USER'] ?? 'Not set') . "\n";
   ?>
   ```

## Environment Variables Reference

| Variable | Description | Example |
|----------|-------------|---------|
| `DB_HOST` | Database host | `dpg-xxxxx-a.oregon-postgres.render.com` |
| `DB_NAME` | Database name | `social_network` |
| `DB_USER` | Database user | `social_user` |
| `DB_PASS` | Database password | `your_secure_password` |

## File Structure for Render

```
social-network/
├── public/
│   └── index.php          # Entry point
├── classes/
│   └── Database.php       # Database connection
├── ajax/                  # API endpoints
├── css/                   # Stylesheets
├── js/                    # JavaScript
├── uploads/               # File uploads
├── composer.json          # PHP dependencies
├── render.yaml           # Render configuration
├── database_postgresql.sql # Database schema
├── init_database.php     # Database initialization
└── .htaccess             # URL rewriting
```

## Performance Optimization

1. **Enable Gzip Compression**
2. **Use CDN for static assets**
3. **Optimize database queries**
4. **Implement caching**

## Security Considerations

1. **Use HTTPS** (Render provides this automatically)
2. **Set secure session configuration**
3. **Validate all inputs**
4. **Use prepared statements**
5. **Implement rate limiting**

## Monitoring

1. **Check Render logs regularly**
2. **Monitor database performance**
3. **Set up error alerts**
4. **Track user metrics**

---

**Your Social Network should now be live on Render! 🚀**
