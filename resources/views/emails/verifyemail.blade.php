<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
        }

        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .email-header {
            padding: 20px 0;
            background: #f3f3f3;
            border-bottom: 1px solid #e0e0e0;
            text-align: center;
        }

        .email-header img {
            height: 60px;
            margin-bottom: 10px;
        }

        .email-body {
            padding: 20px;
        }

        .email-body h2 {
            color: #5bba45;
            margin-top: 0;
        }

        .email-body p {
            margin: 10px 0;
        }

        .verify-button {
            display: inline-block;
            padding: 8px 18px;
            background-color: #5bba45;
            color: #fff !important;
            text-decoration: none;
            font-weight: bold;
            margin-top: 20px;
            text-align: center;
            font-size: 14px;
            transition: background-color 0.3s ease, transform 0.3s ease;
            border-radius: 5px;
        }

        .verify-button:hover {
            background-color: #4a9d3a;
            transform: translateY(-3px);
        }

        .email-footer {
            padding: 10px 0;
            text-align: center;
            background: #f3f3f3;
            font-size: 14px;
            color: #555;
        }

        .email-footer a {
            color: #5bba45;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="email-header">
            <img src="https://flightsgyani.com/frontend/images/logo.png" alt="Flights Gyani">
        </div>
        <div class="email-body">
            <p>Dear {{ $name }},</p>
            <p>Thank you for registering with us. Please click the link below to verify your email address.</p>
            <a href="{{ $verification_url }}" class="verify-button">Verify Email Address</a>
        </div>
        <div class="email-footer">
            <p>For any questions, visit: <a href="https://www.flightsgyani.com" target="_blank">www.flightsgyani.com</a>
            </p>
            <p>Contact us: <a href="mailto:info@flightsgyani.com">info@flightsgyani.com</a></p>
        </div>
    </div>
</body>

</html>
