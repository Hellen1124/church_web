<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toshaserve - Login</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>
      body {
    background: linear-gradient(135deg, #e6f4ea 0%, #c8e6c9 100%);
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
}

    .card {
    background: #f8f9fa; /* soft light grey instead of pure white */
    border-radius: 0.75rem;
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
    max-width: 520px;
    width: 100%;
    margin: auto;
    padding: 2rem;
    transition: transform 0.25s ease, box-shadow 0.25s ease;
    border: 1px solid rgba(0, 0, 0, 0.05);
}

    .btn-warning {
        background-color: #d4a017;
        border-color: #d4a017;
    }

    .btn-warning:hover {
        background-color: #b58910;
        border-color: #b58910;
    }
</style>

</head>
<body>
    @yield('content')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
