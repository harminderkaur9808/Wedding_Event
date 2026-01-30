<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Email – {{ $success ? 'Sent' : 'Failed' }}</title>
    <style>
        body { font-family: system-ui, sans-serif; max-width: 500px; margin: 60px auto; padding: 20px; }
        .ok { color: #0a0; }
        .err { color: #c00; }
        pre { background: #f5f5f5; padding: 12px; border-radius: 6px; overflow-x: auto; }
    </style>
</head>
<body>
    @if($success)
        <h1 class="ok">Test email sent</h1>
        <p>A test email was sent to <strong>{{ $to }}</strong>. Check that inbox (and spam).</p>
        <p>If you see it, mail is working correctly.</p>
    @else
        <h1 class="err">Test email failed</h1>
        <p>Could not send to <strong>{{ $to }}</strong>.</p>
        <p><strong>Error:</strong></p>
        <pre>{{ $error ?? 'Unknown error' }}</pre>
        <p>Check <code>storage/logs/laravel.log</code> and your <code>.env</code> MAIL_* settings.</p>
    @endif
</body>
</html>
