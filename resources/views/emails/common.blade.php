<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>{{ getAppName() }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        p a {
            display: table;
            background-color: #6571ff;
            border-color: #6571ff;
            color: #ffffff;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            font-size: 14px;
            margin: 0 auto;
        }
    </style>
</head>

<body style="margin:0; padding:0; background:#f3f4f6; font-family: Arial, sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#f3f4f6;">

        <!-- Wrapper -->
        <tr>
            <td align="center">
                <table width="100%" cellpadding="0" cellspacing="0" border="0"
                    style="max-width:600px; background:#ffffff;">
                    <!-- Header -->
                    <tr>
                        <td align="center" style="padding:20px; border-bottom:1px solid #e5e7eb; background:#f9fafb;">
                            <img src="{{ asset(getLogoUrl()) }}" alt="{{ getAppName() }}"
                                style="max-width:150px; height:50px; display:block;">
                        </td>
                    </tr>
                    <!-- Content -->
                    <tr>
                        <td style="padding:25px 20px; font-size:14px; line-height:1.7; color:#333;">
                            {!! $data !!}
                        </td>
                    </tr>
                    <!-- Footer -->
                    <tr>
                        <td align="center" style="padding:18px; border-top:1px solid #e5e7eb; background:#f9fafb;">
                            <p style="margin:0; font-size:12px; color:#9ca3af;">
                                © {{ date('Y') }} {{ getAppName() }}. All rights reserved.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

</body>

</html>
