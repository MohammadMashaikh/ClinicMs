<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Assignment {{ $assignment->title }} Grade</title>
</head>
<body>
    <h2>Hello {{ $submission->user->full_name }},</h2>
    <p>Your work for:</p>
    <p><strong>{{ $assignment->title }} Assignment</strong></p>
    <p>Due Date: {{ $assignment->due_date->format('d M Y') }}</p>
    <p>Score: {{ $submission->score }} / {{ $assignment->points }}</p>
    <p>Status: {{ ucfirst($submission->status) }}</p>
    <p>Thank you!</p>
</body>
</html>
