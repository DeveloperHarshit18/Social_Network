# Social Network Application

A modern PHP-based social network application with user authentication, posts, comments, and likes functionality.

## Features

- 🔐 **User Authentication**: Sign up, login, and logout
- 📝 **Post Creation**: Create text posts with optional image uploads
- ❤️ **Like System**: Like and unlike posts
- 💬 **Comments**: Add comments to posts
- 👤 **User Profiles**: Profile management with profile pictures
- 📱 **Responsive Design**: Mobile-friendly interface
- 🎨 **Modern UI**: Clean and intuitive user interface

## Technologies Used

- **Backend**: PHP 7.4+
- **Database**: MySQL
- **Frontend**: HTML5, CSS3, JavaScript (ES6+)
- **Icons**: Font Awesome
- **Architecture**: MVC-like structure

## Installation

### Prerequisites

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Web server (Apache/Nginx) or PHP built-in server

### Setup Instructions

1. **Clone the repository**
   ```bash
   git clone https://github.com/YOUR_USERNAME/social-network.git
   cd social-network
   ```

2. **Database Setup**
   - Create a MySQL database named `social_network`
   - Import the `database.sql` file to create tables
   - Update database credentials in `classes/Database.php`

3. **Configure Database**
   ```php
   // In classes/Database.php
   private $host = 'localhost';
   private $db_name = 'social_network';
   private $username = 'your_username';
   private $password = 'your_password';
   ```

4. **Start the Server**
   ```bash
   # Using PHP built-in server
   php -S localhost:8000
   
   # Or use XAMPP/WAMP and place in htdocs folder
   ```

5. **Access the Application**
   - Open your browser and go to `http://localhost:8000`
   - Sign up for a new account
   - Start using the social network!

## Project Structure

```
social-network/
├── ajax/                 # AJAX endpoints
│   ├── signup_process.php
│   ├── login_process.php
│   ├── create_post.php
│   └── ...
├── classes/              # Core classes
│   ├── Database.php
│   ├── User.php
│   └── Post.php
├── css/                  # Stylesheets
│   └── style.css
├── js/                   # JavaScript files
│   ├── main.js
│   └── auth.js
├── uploads/              # File uploads
│   ├── profiles/
│   └── posts/
├── index.php             # Main feed page
├── signup.php            # Registration page
├── login.php             # Login page
├── profile.php           # User profile page
└── database.sql          # Database schema
```

## Usage

### User Registration
1. Go to the signup page
2. Fill in your details (name, email, password, date of birth)
3. Optionally upload a profile picture
4. Click "Sign Up"

### Creating Posts
1. Log in to your account
2. Write your post in the textarea
3. Optionally add an image
4. Click "Post"

### Interacting with Posts
- **Like**: Click the heart icon to like/unlike posts
- **Comment**: Click the comment icon to add comments
- **View Profile**: Click on user names to view profiles

## Security Features

- Password hashing using PHP's `password_hash()`
- SQL injection prevention with prepared statements
- XSS protection with `htmlspecialchars()`
- File upload validation
- Session-based authentication

## Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## License

This project is open source and available under the [MIT License](LICENSE).

## Contact

If you have any questions or suggestions, please feel free to open an issue or contact the maintainers.

---

**Happy Coding! 🚀**