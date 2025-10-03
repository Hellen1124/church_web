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
    /* Background */
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


/* Hover / Focus effect (professional, not flashy) */
.card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
}


    /* Card Body */
    .card-body {
        padding: 2.5rem;
    }

    /* Headings */
    h4, h5 {
        font-weight: 700;
        color: #2c3e50;
    }
    p.small {
        color: #6c757d;
    }

    /* Form Controls */
    .form-control {
        border-radius: 0.6rem;
        border: 1px solid #dee2e6;
        padding: 0.75rem 1rem;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .form-control:focus {
        border-color: #d4a017;
        box-shadow: 0 0 0 0.2rem rgba(212,160,23,0.25);
    }

    .input-group-text {
        border-radius: 0.6rem 0 0 0.6rem;
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
    }

    /* Buttons */
    .btn-warning {
        background-color: #d4a017;
        border: none;
        color: #fff;
        font-weight: 600;
        border-radius: 0.6rem;
        padding: 0.75rem;
        transition: background-color 0.25s ease, transform 0.15s ease;
    }
    .btn-warning:hover {
        background-color: #b58910;
        transform: translateY(-2px);
    }

    /* Social Buttons */
    .btn-outline-secondary {
        border: 1px solid #dee2e6;
        background-color: #fff;
        transition: all 0.2s;
    }
    .btn-outline-secondary:hover {
        border-color: #d4a017;
        background-color: #fff8e1;
    }

    .btn.rounded-circle {
        width: 42px;
        height: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50% !important;
    }

    /* Divider */
    hr {
        border-color: #dee2e6;
    }

    /* Links */
    a.text-warning {
        text-decoration: none;
        transition: color 0.2s;
    }
    a.text-warning:hover {
        color: #b58910;
    }
</style>

</head>
<body>
    @yield('content')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>