<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= isset($description) ? $description :'Website Donasi' ?>">
    <meta name="keywords" content="<?= isset($keyword) ? $keyword :'Website Donasi' ?>">
    <meta name="author" content="Imam">
    <meta property="og:title" content="Donation Program - Support Meaningful Causes">
    <meta property="og:description" content="Join us in making a difference through your donations">
    <meta property="og:type" content="website">
    <title><?= isset($title) ? $title :'Website Donasi' ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            500: '#22c55e',
                            600: '#16a34a',
                        }
                    },
                    fontFamily: {
                        'poppins': ['Poppins', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    <style>
        .hero-slide {
            opacity: 0;
            transition: opacity 1s ease-in-out;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
        .hero-slide.active {
            opacity: 1;
        }
        .animate-fadeIn {
            animation: fadeIn 1s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="font-poppins bg-gray-50">