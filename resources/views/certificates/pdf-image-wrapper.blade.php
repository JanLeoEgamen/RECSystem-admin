<!DOCTYPE html>
<html>
<head>
    <style>
        @page {
            size: A4 landscape;
            margin: 0;
        }
        html, body {
            margin: 0;
            padding: 0;
            width: 297mm;
            height: 210mm;
        }
        img {
            width: 100%;
            height: auto;
            display: block;
        }
    </style>
</head>
<body>
    <img src="file://{{ $imagePath }}" alt="Certificate Image">
</body>
</html>
