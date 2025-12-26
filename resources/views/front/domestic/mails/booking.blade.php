<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flight Booking Confirmation</title>
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
            /* Adjusted padding for a more spacious header */
            background: #f3f3f3;
            border-bottom: 1px solid #e0e0e0;
            text-align: center;
        }

        .email-header img {
            height: 60px;
            /* Increased the logo size */
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

        /* New, smaller, and more elegant download button */
        .download-button {
            display: inline-block;
            padding: 8px 18px;
            background-color: #5bba45;
            color: #fff !important;
            /* Ensure white text */
            text-decoration: none;
            font-weight: bold;
            margin-top: 20px;
            text-align: center;
            font-size: 14px;
            transition: background-color 0.3s ease, transform 0.3s ease;
            border-radius: 5px;
            /* Rounded corners for a smooth button */
        }

        .download-button:hover {
            background-color: #4a9d3a;
            transform: translateY(-3px);
            /* Slightly lifted effect on hover */
        }

        .email-footer {
            padding: 10px 0;
            /* Reduced padding */
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
        <!-- Header -->
        <div class="email-header">
            <img src="https://flightsgyani.com/frontend/images/logo.png" alt="Flights Gyani">
        </div>
        <!-- Body -->
        <div class="email-body">
            @if ($for == 'user')
                <p>Dear {{ $flightBooking->emergency_contact_fullname ?? 'Customer' }},</p>

                <p>You ticket has been issued for
                    {{ $flightBooking->flight_type == 'O' ? 'One way' : 'Two way' }},
                    {{ $flightBooking->sector_from }}-{{ $flightBooking->sector_to }},
                    Adult: {{ $flightBooking->adult_count ?? 0 }}
                    {{ $flightBooking->child_count ? 'Child: ' . $flightBooking->child_count : '' }},
                    DEP: {{ $flightBooking->departure_date }}.
                </p>
            @else
                @if ($status != 'failed')
                    <p>Hello Admin,</p>
                    <p>A customer has successfully booked a flight. Please review the booking details.</p>
                    <p>Ticket Details:
                        {{ $flightBooking->flight_type == 'O' ? 'One way' : 'Two way' }},
                        {{ $flightBooking->sector_from }}-{{ $flightBooking->sector_to }},
                        Adult: {{ $flightBooking->adult_count ?? 0 }}
                        {{ $flightBooking->child_count ? 'Child: ' . $flightBooking->child_count : '' }},
                        DEP: {{ $flightBooking->departure_date }}.
                    </p>
                    <p>Phone: {{ $flightBooking->emergency_contact_phone }}</p>
                    <p>Email: {{ $flightBooking->emergency_contact_email }}</p>
                @else
                    <p>Hello Admin,</p>
                    <p>A customer has tried to book a flight. Please review the booking details.</p>
                    <p>Ticket Details:
                        {{ $flightBooking->flight_type == 'O' ? 'One way' : 'Two way' }},
                        {{ $flightBooking->sector_from }}-{{ $flightBooking->sector_to }},
                        Adult: {{ $flightBooking->adult_count ?? 0 }}
                        {{ $flightBooking->child_count ? 'Child: ' . $flightBooking->child_count : '' }},
                        DEP: {{ $flightBooking->departure_date }}.
                    </p>
                    <p>Phone: {{ $flightBooking->emergency_contact_phone }}</p>
                    <p>Email: {{ $flightBooking->emergency_contact_email }}</p>
                @endif
            @endif

            <p>Booking Code: {{ $flightBooking->booking_code ?? '' }}</p>
            <p>Please click the link below to download ticket:</p>
            <a class="download-button"
                href="{{ route('domesticflights.ticket.download', $flightBooking->booking_code) }}">Download Ticket</a>
        </div>
        <!-- Footer -->
        <div class="email-footer">
            <p>For more details, visit: <a href="https://www.flightsgyani.com" target="_blank">www.flightsgyani.com</a>
            </p>
            <p>Contact us: <a href="mailto:info@flightsgyani.com">info@flightsgyani.com</a></p>
        </div>
    </div>
</body>

</html>
