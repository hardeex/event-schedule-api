<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Reset Your Password - Event Schedule</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f0f8ff;
      padding: 20px;
      margin: 0;
      line-height: 1.6;
    }
    
    .email-container {
      max-width: 600px;
      margin: auto;
      background-color: #ffffff;
      border-radius: 12px;
      padding: 40px;
      box-shadow: 0 4px 16px rgba(59, 130, 246, 0.1);
      border-top: 4px solid #2563eb;
    }
    
    .header {
      text-align: center;
      margin-bottom: 30px;
    }
    
    .company-name {
      font-size: 28px;
      font-weight: 700;
      color: #1e40af;
      margin: 0;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
    }
    
    .wave-icon {
      font-size: 32px;
    }
    
    .tagline {
      font-size: 14px;
      color: #6b7280;
      margin: 5px 0 0 0;
    }
    
    .main-title {
      font-size: 24px;
      font-weight: 700;
      color: #1e40af;
      margin-bottom: 20px;
      border-bottom: 2px solid #dbeafe;
      padding-bottom: 10px;
    }
    
    .greeting {
      font-size: 16px;
      color: #374151;
      margin-bottom: 20px;
    }
    
    .main-text {
      font-size: 16px;
      color: #374151;
      margin-bottom: 30px;
      line-height: 1.6;
    }
    
    .button-container {
      text-align: center;
      margin: 40px 0;
    }
    
    .reset-button {
      display: inline-block;
      background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
      color: white;
      padding: 16px 32px;
      border-radius: 8px;
      text-decoration: none;
      font-weight: 600;
      font-size: 16px;
      box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
      transition: all 0.3s ease;
    }
    
    .reset-button:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 16px rgba(37, 99, 235, 0.4);
    }
    
    .security-notice {
      background-color: #eff6ff;
      border-left: 4px solid #3b82f6;
      padding: 20px;
      margin: 30px 0;
      border-radius: 0 8px 8px 0;
    }
    
    .security-title {
      margin: 0;
      font-size: 14px;
      color: #1e40af;
      font-weight: 500;
    }
    
    .security-text {
      margin: 10px 0 0 0;
      font-size: 14px;
      color: #374151;
      line-height: 1.5;
    }
    
    .expiry-notice {
      margin-top: 30px;
      font-size: 14px;
      color: #6b7280;
      line-height: 1.5;
    }
    
    .footer {
      margin-top: 40px;
      padding-top: 30px;
      border-top: 1px solid #e5e7eb;
      text-align: center;
    }
    
    .support-text {
      font-size: 14px;
      color: #6b7280;
      margin: 0;
    }
    
    .support-link {
      color: #2563eb;
      text-decoration: none;
    }
    
    .support-link:hover {
      text-decoration: underline;
    }
    
    .copyright {
      font-size: 12px;
      color: #9ca3af;
      margin: 10px 0 0 0;
    }
  </style>
</head>
<body>

  <div class="email-container">

  
    <div class="header">
      <h1 class="company-name">
      
        Event Schedule 
      </h1>
     
    </div>

    <h2 class="main-title">
      Reset Your Password
    </h2>

    <p class="greeting">
      Hello {{ $user->name }},
    </p>

    <p class="main-text">
      You recently requested to reset your password for your Event Scheduler. Click the button below to create a new password and continue planning your next adventure.
    </p>

    <div class="button-container">
      <a href="{{ $url }}" class="reset-button">
        Reset Password
      </a>
    </div>

    <div class="security-notice">
      <p class="security-title">
        Security Notice
      </p>
      <p class="security-text">
        If you did not request a password reset, please ignore this email. Your account remains secure.
      </p>
    </div>

    <p class="expiry-notice">
      This password reset link will expire in 60 minutes for your security.
    </p>

   
  </div>
</body>
</html>