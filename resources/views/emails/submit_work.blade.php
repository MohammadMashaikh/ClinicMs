<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Work Submitted</title>
</head>
<body>
    <h2>Hello {{ $submission->user->full_name }},</h2>
    <p>You have successfully submitted your work for:</p>
    <p><strong>{{ $assignment->title }} Assignment</strong></p>
    <p>Due Date: {{ $assignment->due_date->format('d M Y') }}</p>
    <p>Thank you!</p>
</body>
</html>
