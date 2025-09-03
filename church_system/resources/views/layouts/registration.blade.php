<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toshaserve - SignUp</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

   <style>
        body {
        /* Deep, inspiring gradient with contrast */
        background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }
        .card {
        background: #ffffff;
        border-radius: 1rem;
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }
        .btn-primary {
            background-color: #f4c542; /* gold accent */
            border: none;
            color: #000;
            font-weight: bold;
        }
        .btn-primary:hover {
            background-color: #e0b93d;
        }
    </style>

</head>
<body>
    @yield('content')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>