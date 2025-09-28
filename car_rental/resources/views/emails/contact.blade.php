<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Contact Form Submission</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #007bff;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .content {
            background-color: #f8f9fa;
            padding: 30px;
            border-radius: 0 0 8px 8px;
        }
        .field {
            margin-bottom: 20px;
        }
        .field label {
            font-weight: bold;
            color: #495057;
            display: block;
            margin-bottom: 5px;
        }
        .field-value {
            background-color: white;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #dee2e6;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            color: #6c757d;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>New Contact Form Submission</h1>
        <p>Caravel Car Rental</p>
    </div>
    
    <div class="content">
        <div class="field">
            <label>Name:</label>
            <div class="field-value">{{ $name }}</div>
        </div>
        
        <div class="field">
            <label>Email:</label>
            <div class="field-value">{{ $email }}</div>
        </div>
        
        <div class="field">
            <label>Message:</label>
            <div class="field-value">{{ $message }}</div>
        </div>
        
        <div class="field">
            <label>Submitted At:</label>
            <div class="field-value">{{ $submittedAt }}</div>
        </div>
    </div>
    
    <div class="footer">
        <p>This message was sent from the Caravel contact form.</p>
        <p>Please reply directly to {{ $email }} to respond to this inquiry.</p>
    </div>
</body>
</html>