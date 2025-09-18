<!DOCTYPE html>
<html>
<head>
    <title>Invoice PDF</title>
    <style>
        body { font-family: sans-serif; }
        h1 { color: #3490dc; }
        .content { margin-top: 20px; }
    </style>
</head>
<body>
    <h1>{{ $title }}</h1>
    <p class="content">This PDF was generated using Laravel 12 and DomPDF.</p>
    <p>Date: {{ $date }}</p>
</body>
</html>
