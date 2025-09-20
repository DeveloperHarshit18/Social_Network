# Docker Setup for Social Network

This guide explains how to run the Social Network application using Docker.

## Prerequisites

- Docker Desktop installed on your system
- Docker Compose (included with Docker Desktop)

## Quick Start

### 1. Clone the Repository
```bash
git clone https://github.com/YOUR_USERNAME/social-network.git
cd social-network
```

### 2. Run with Docker Compose
```bash
# Development environment
docker-compose up -d

# Or for production
docker-compose -f docker-compose.prod.yml up -d
```

### 3. Access the Application
- **Social Network**: http://localhost:8080
- **phpMyAdmin**: http://localhost:8081 (development only)
- **Database**: localhost:3306

## Services

### Web Application (Port 8080)
- PHP 8.1 with Apache
- All application files mounted as volumes
- Auto-reloads on file changes

### MySQL Database (Port 3306)
- MySQL 8.0
- Database: `social_network`
- User: `social_user`
- Password: `social_password`
- Root Password: `rootpassword`

### phpMyAdmin (Port 8081 - Development Only)
- Web-based MySQL administration
- Username: `social_user`
- Password: `social_password`

## Docker Commands

### Basic Commands
```bash
# Start all services
docker-compose up -d

# Stop all services
docker-compose down

# View logs
docker-compose logs -f

# Rebuild containers
docker-compose up --build -d

# Remove everything (including volumes)
docker-compose down -v
```

### Database Commands
```bash
# Access MySQL shell
docker-compose exec db mysql -u social_user -p social_network

# Backup database
docker-compose exec db mysqldump -u social_user -p social_network > backup.sql

# Restore database
docker-compose exec -T db mysql -u social_user -p social_network < backup.sql
```

### Application Commands
```bash
# Access application container
docker-compose exec web bash

# View application logs
docker-compose logs web

# Restart application
docker-compose restart web
```

## Environment Variables

### Development (.env)
```env
MYSQL_ROOT_PASSWORD=rootpassword
MYSQL_DATABASE=social_network
MYSQL_USER=social_user
MYSQL_PASSWORD=social_password
```

### Production
Create a `.env` file with your production credentials:
```env
MYSQL_ROOT_PASSWORD=your_secure_root_password
MYSQL_DATABASE=social_network
MYSQL_USER=your_db_user
MYSQL_PASSWORD=your_secure_password
```

## File Structure

```
social-network/
├── Dockerfile                 # PHP application container
├── docker-compose.yml        # Development environment
├── docker-compose.prod.yml   # Production environment
├── .dockerignore            # Files to exclude from Docker build
├── database.sql             # Database schema
└── uploads/                 # File uploads (mounted as volume)
    ├── profiles/
    └── posts/
```

## Troubleshooting

### Common Issues

1. **Port Already in Use**
   ```bash
   # Change ports in docker-compose.yml
   ports:
     - "8081:80"  # Change 8080 to 8081
   ```

2. **Database Connection Issues**
   ```bash
   # Check if database is running
   docker-compose ps
   
   # View database logs
   docker-compose logs db
   ```

3. **Permission Issues**
   ```bash
   # Fix upload directory permissions
   docker-compose exec web chown -R www-data:www-data /var/www/html/uploads
   ```

4. **Container Won't Start**
   ```bash
   # Rebuild containers
   docker-compose down
   docker-compose up --build -d
   ```

### Reset Everything
```bash
# Stop and remove all containers, networks, and volumes
docker-compose down -v
docker system prune -a
```

## Production Deployment

### 1. Set Environment Variables
```bash
cp env.example .env
# Edit .env with production values
```

### 2. Deploy
```bash
docker-compose -f docker-compose.prod.yml up -d
```

### 3. Security Considerations
- Change default passwords
- Use SSL certificates
- Configure firewall rules
- Regular database backups
- Monitor container logs

## Development Workflow

1. **Make changes** to your code
2. **Files are automatically synced** (volume mount)
3. **Refresh browser** to see changes
4. **Database persists** between container restarts

## Backup and Restore

### Backup
```bash
# Backup database
docker-compose exec db mysqldump -u social_user -p social_network > backup.sql

# Backup uploads
tar -czf uploads_backup.tar.gz uploads/
```

### Restore
```bash
# Restore database
docker-compose exec -T db mysql -u social_user -p social_network < backup.sql

# Restore uploads
tar -xzf uploads_backup.tar.gz
```

## Monitoring

### View Logs
```bash
# All services
docker-compose logs -f

# Specific service
docker-compose logs -f web
docker-compose logs -f db
```

### Container Status
```bash
# Running containers
docker-compose ps

# Resource usage
docker stats
```

---

**Happy Dockerizing! 🐳**
