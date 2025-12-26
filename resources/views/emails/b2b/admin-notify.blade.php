<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agent Registration Notification</title>
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

        .agent-details-container {
            margin: 20px 0;
            padding: 10px;
            background-color: #f9f9f9;
            border: 1px solid #e0e0e0;
            border-radius: 5px;
        }

        .agent-details-container p {
            margin: 5px 0;
            font-weight: bold;
            color: #333;
        }

        .action-btn {
            background-color: #5bba45;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
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
            <p>Dear Admin,</p>
            <p>We would like to inform you that a new agent has successfully registered on your portal. Please review
                the details below and verify the account:</p>
            <div class="agent-details-container">
                <p>Name: {{ $user['name'] ?? '' }}</p>
                <p>Email: {{ $user['email'] ?? '' }}</p>
                <p>Registration Status: Pending Admin Approval</p>
            </div>
            <p>To verify and approve the agent's account, click the link below:</p>
            <a class="action-btn" href="{{ route('v2.admin.agents.edit', $user['user_id']) }}" target="_blank">Verify
                Agent</a>
        </div>
    </div>
</body>

</html>
