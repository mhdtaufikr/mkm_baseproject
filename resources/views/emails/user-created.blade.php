<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Request Access for {{ $appName }}</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            color: #1a1a1a;
            background: #f7f9fc;
        }

        .wrapper {
            max-width: 720px;
            margin: 0 auto;
            padding: 24px;
            background: #fff;
        }

        .header {
            border-bottom: 2px solid #0d6efd;
            margin-bottom: 16px;
        }

        .header h2 {
            margin: 0 0 6px;
            color: #0d6efd;
        }

        .meta {
            font-size: 13px;
            color: #555;
        }

        .section-title {
            margin: 22px 0 8px;
            font-weight: 700;
            color: #0d6efd;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #e5e7eb;
            padding: 8px 10px;
            vertical-align: top;
        }

        th {
            background: #f3f4f6;
            text-align: left;
            width: 220px;
        }

        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #6b7280;
        }

        .btn {
            display: inline-block;
            background: #0d6efd;
            color: #fff;
            text-decoration: none;
            padding: 10px 14px;
            border-radius: 6px;
            font-weight: 600;
        }
    </style>
</head>

<body>
    <div class="wrapper">

        <div class="header">
            <h2>{{ $appName }} – Account Created</h2>
            <div class="meta">
                This is an automatic notification from {{ $appName }}
            </div>
        </div>

        <p>Hello <strong>{{ $user->name }}</strong>,</p>

        <p>
            Your account has been successfully created in
            <strong>{{ $appName }}</strong>.
        </p>

        <div class="section-title">Account Information</div>
        <table>
            <tr>
                <th>Full Name</th>
                <td>{{ $user->name }}</td>
            </tr>
            <tr>
                <th>Username</th>
                <td>{{ $user->username }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $user->email }}</td>
            </tr>
        </table>

        <div class="section-title">Login Information</div>
        <table>
            <tr>
                <th>Temporary Password</th>
                <td><strong>{{ $hashPassword }}</strong></td>
            </tr>
            <tr>
                <th>Login URL</th>
                <td>
                    <a href="{{ route('login') }}" target="_blank">
                        {{ route('login') }}
                    </a>
                </td>
            </tr>
        </table>

        <p style="margin-top:16px;">
            <strong>Important:</strong><br>
            For security reasons, you are required to change your password
            after your first login.
        </p>

        <p style="margin-top: 18px;">
            <a class="btn" href="{{ route('login') }}" target="_blank">
                Login to {{ $appName }}
            </a>
        </p>

        <div class="footer">
            This email was sent automatically by {{ $appName }}.<br>
            Please do not reply to this email.
        </div>

    </div>
</body>


</html>
