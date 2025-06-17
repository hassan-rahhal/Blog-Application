# BitCast Blog Application

BitCast is a modern, responsive, and secure blog web application designed to provide a seamless user experience for creating, reading, and engaging (Like & comment) with blog posts. Built with PHP, MySQL, and Bootstrap, BitCast emphasizes security, usability, and real-time interactivity.

## Features

- **User Authentication**  
  - Secure registration and login with email and username.  
  - Passwords are hashed using PHP’s `password_hash()` function with the `BCRYPT` algorithm for enhanced security.

- **Post Management**  
  - Users can create, view, and read blog posts with rich content, titles, and timestamps.  
  - Posts display author details and publication date.

- **Like System**  
  - Logged-in users can like or unlike posts dynamically.  
  - Real-time like count updates without page refresh using AJAX / Fetch API.
  - Like counts displayed for posts to track popularity and engagement.

- **Comment and Reply System**  
  - Users can add comments to blog posts.  
  - Nested replies allow users to respond directly to comments, facilitating threaded discussions.  

- **Responsive Design**  
  - Fully responsive layout using Bootstrap to ensure accessibility across all devices.

- **Input Validation and Error Handling**  
  - Comprehensive server-side validation including email format, password strength, and required fields.  
  - User-friendly error messages for registration, login, and form submissions.

- **Session Management**  
  - Secure handling of user sessions for login state persistence.

## Technology Stack

- **Backend:** PHP (with PDO for secure and parameterized database queries)  
- **Database:** MySQL  
- **Frontend:** HTML5, CSS3, Bootstrap 3, JavaScript (Fetch API and AJAX)  
- **Security:** Password hashing with PHP `password_hash()` (BCRYPT algorithm)  
- **Libraries:** jQuery, Bootstrap JS  