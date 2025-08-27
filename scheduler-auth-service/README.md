# 🛡️ User Authentication & Profile Management API

This project provides a **robust API** for managing user authentication and profile information. It simplifies tasks like registration, login, email verification, password recovery, and profile management.



## Features

- 🔐 Secure **user registration** and **login**  
- 📧 **Email verification** & **password recovery**  
- 🧑‍💼 Flexible **profile management** (social accounts, workplace, interests)  
- 🗝️ Token-based **authentication** for protected routes  
- ⚡ Easy integration for modern applications  


Test Credentials for Demo:

Mail: user regitration mail.

Password: 123456

Verification Code: 123456

Authentication:
Include a Bearer token in headers for protected routes:

Authorization: Bearer <your_token>

📝 API Endpoints
1️⃣ User Registration

POST /api/v1/users/register
Creates a new user and sends a verification code.

Payload (example):

{
  "first_name": "Test",
  "last_name": "User",
  "email": "test@example.com",
  "password": "123456",
  "password_confirmation": "123456"
}

2️⃣ Email Verification

POST /api/v1/users/verify
Verifies the user’s email using a code sent after registration.

Payload (example):

{
  "code": "123456",
  "email": "test@example.com"
}

3️⃣ User Login

POST /api/v1/users/login
Authenticates the user and returns an access token.

Payload (example):

{
  "email": "test@example.com",
  "password": "123456"
}

4️⃣ Forgot Password

POST /api/v1/auth/forgot-password
Sends a password reset token to the user’s email.

Payload (example):

{
  "email": "test@example.com"
}

5️⃣ Reset Password

POST /api/v1/auth/reset-password
Sets a new password using a valid reset token.

Payload (example):

{
  "email": "test@example.com",
  "token": "123456",
  "password": "123456",
  "password_confirmation": "123456"
}

6️⃣ Add/Update Social Accounts

POST /api/v1/users/info/social-accounts
Adds or updates the user’s social media profiles. (Auth required)

Payload (example):

[
  { "title": "facebook", "pages": ["page1_url", "page2_url"] },
  { "title": "linkedin", "pages": ["profile_url"] }
]

7️⃣ Add/Update Workplace Information

POST /api/v1/users/info/work-place
Adds or updates professional details. (Auth required)

Payload (example):

{
  "organization": "Example Corp",
  "organization_size": "51-200",
  "is_agency": false,
  "country": "United States",
  "time_zone": "New York (UTC -04:00)"
}

8️⃣ Add/Update Interests

POST /api/v1/users/info/interests
Adds or updates the user’s professional or personal interests. (Auth required)

Payload (example):

{
  "interest_type": "Professional Development",
  "interests": ["API Design", "Software Architecture", "Project Management"]
}
