<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agent Registration</title>
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

        .credentials-container {
            margin: 20px 0;
            padding: 10px;
            background-color: #f9f9f9;
            border: 1px solid #e0e0e0;
            border-radius: 5px;
        }

        .credentials-container p {
            margin: 5px 0;
            font-weight: bold;
            color: #333;
        }

        .note {
            font-style: italic;
            color: #c1272f;
            margin-top: 20px;
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
            <p>Dear {{ $user['name'] ?? '' }},</p>
            @if ($user['agentAccountStatus'] ?? null)
                @if ($user['agentAccountStatus'] == 'Pending')
                    Your account is currently in the Pending status and is awaiting further approval. You will receive
                    another notification once your account is fully approved.
                @elseif ($user['agentAccountStatus'] == 'Active')
                    Congratulations! Your account has been successfully Activated, and you can now log in to the portal
                    using the provided your credentials.
                @elseif ($user['agentAccountStatus'] == 'Suspended')
                    Please note that your account has been Suspended. If you have any questions or believe this is an
                    error, kindly reach out to us for clarification or support.
                @endif
            @else
                <p>You have been successfully registered as an agent on our portal. Below are your login credentials:
                </p>
                <div class="credentials-container">
                    <p>Email: {{ $user['email'] ?? '' }}</p>
                    <p>Password: {{ $user['password'] ?? '' }}</p>
                </div>
                <p>You can log in to the portal using the link below:</p>
                <a class="verify-button" href="{{ route('agent.login') }}" target="_blank">Log In to Portal</a>
                @if ($user['agent_register'] ?? null)
                    <p class="note">Please note: Your account is awaiting admin approval. You will be notified once
                        your
                        account is approved and ready for login.</p>
                @endif
            @endif
        </div>
        <div class="email-footer">
            <p>For any questions, visit: <a href="https://www.flightsgyani.com" target="_blank">www.flightsgyani.com</a>
            </p>
            <p>Contact us: <a href="mailto:info@flightsgyani.com">info@flightsgyani.com</a></p>
        </div>
    </div>
</body>

</html>
