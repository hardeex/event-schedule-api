<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Email </title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #0ea5e9 0%, #1e40af 100%);
            min-height: 100vh;
            line-height: 1.6;
        }
        
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-top: 40px;
            margin-bottom: 40px;
        }
        
        .header {
            background: linear-gradient(135deg, #0ea5e9 0%, #1e40af 100%);
            padding: 40px 30px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="2" fill="white" opacity="0.1"/><circle cx="20" cy="20" r="1" fill="white" opacity="0.15"/><circle cx="80" cy="30" r="1.5" fill="white" opacity="0.1"/><circle cx="30" cy="80" r="1" fill="white" opacity="0.2"/><circle cx="70" cy="70" r="1" fill="white" opacity="0.1"/></svg>');
            animation: float 20s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }
        
        .logo {
            background: rgba(255, 255, 255, 0.2);
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.3);
            position: relative;
            z-index: 1;
        }
        
        .logo::before {
            content: '✈️';
            font-size: 32px;
            animation: plane 3s ease-in-out infinite;
        }
        
        @keyframes plane {
            0%, 100% { transform: translateX(0px); }
            50% { transform: translateX(5px); }
        }
        
        .header h1 {
            color: white;
            margin: 0;
            font-size: 28px;
            font-weight: 700;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
            position: relative;
            z-index: 1;
        }
        
        .header p {
            color: rgba(255, 255, 255, 0.9);
            margin: 10px 0 0;
            font-size: 16px;
            position: relative;
            z-index: 1;
        }
        
        .content {
            padding: 40px 30px;
            background: white;
        }
        
        .welcome-message {
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 30px;
            border-left: 5px solid #0ea5e9;
        }
        
        .welcome-message h2 {
            color: #1e40af;
            margin: 0 0 15px 0;
            font-size: 24px;
            font-weight: 600;
        }
        
        .welcome-message p {
            color: #374151;
            margin: 0;
            font-size: 16px;
        }
        
        .user-name {
            color: #0ea5e9;
            font-weight: 600;
        }
        
        .verification-section {
            text-align: center;
            margin: 40px 0;
        }
        
        .verification-section p {
            color: #4b5563;
            margin-bottom: 30px;
            font-size: 16px;
        }
        
        .verify-button {
            display: inline-block;
            padding: 18px 40px;
            background: linear-gradient(135deg, #0ea5e9 0%, #1e40af 100%);
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            font-size: 16px;
            text-align: center;
            transition: all 0.3s ease;
            box-shadow: 0 10px 30px rgba(14, 165, 233, 0.4);
            border: none;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }
        
        .verify-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s;
        }
        
        .verify-button:hover::before {
            left: 100%;
        }
        
        .verify-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 35px rgba(14, 165, 233, 0.5);
        }
        
        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin: 40px 0;
        }
        
        .feature {
            background: #f8fafc;
            padding: 25px;
            border-radius: 12px;
            text-align: center;
            border: 1px solid #e2e8f0;
            transition: transform 0.3s ease;
        }
        
        .feature:hover {
            transform: translateY(-5px);
        }
        
        .feature-icon {
            font-size: 32px;
            margin-bottom: 15px;
        }
        
        .feature h3 {
            color: #1e40af;
            margin: 0 0 10px 0;
            font-size: 16px;
            font-weight: 600;
        }
        
        .feature p {
            color: #64748b;
            margin: 0;
            font-size: 14px;
        }
        
        .footer {
            background: #f8fafc;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #e2e8f0;
        }
        
        .footer p {
            color: #64748b;
            margin: 0 0 15px 0;
            font-size: 14px;
        }
        
        .footer .company-name {
            color: #1e40af;
            font-weight: 600;
            font-size: 16px;
        }
        
        .security-note {
            background: #fef3c7;
            border: 1px solid #fbbf24;
            border-radius: 8px;
            padding: 15px;
            margin: 30px 0;
            font-size: 14px;
            color: #92400e;
        }
        
        .security-note strong {
            color: #78350f;
        }
        
        @media (max-width: 600px) {
            .email-container {
                margin: 20px 10px;
                border-radius: 15px;
            }
            
            .header, .content, .footer {
                padding: 25px 20px;
            }
            
            .header h1 {
                font-size: 24px;
            }
            
            .welcome-message {
                padding: 20px;
            }
            
            .verify-button {
                padding: 15px 30px;
                font-size: 15px;
            }
            
            .features {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <div class="logo"></div>
            <h1>Event Schedule API</h1>
           
        </div>
        
        <div class="content">
            <div class="welcome-message">
                <h2>Hello <span class="user-name">{{ $user->name }}!</span>! </h2>
             
            </div>
            
            <div class="verification-section">
              
                <p>Kindly, verify your email to have access to our exclusive offers</p>
                
                <a href="{{ $url }}" class="verify-button">
                  
                </a>
            </div>
            
  
            
            <div class="security-note">
                <strong>Security Note:</strong> This verification link will expire in 24 hours. If you didn't create an account with Event Schedule, please ignore this email and no action is required.
            </div>
        </div>
        
        
    </div>
</body>
</html>