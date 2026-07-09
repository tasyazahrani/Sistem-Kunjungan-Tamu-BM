<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Buku Tamu Digital') — Setda Bener Meriah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        body { background: linear-gradient(135deg,#0b3d2e,#145c44); min-height:100vh; font-family:'Segoe UI',system-ui,sans-serif; }
        .guest-card { max-width:640px; margin:2.5rem auto; background:#fff; border-radius:1rem; box-shadow:0 10px 35px rgba(0,0,0,.25); overflow:hidden; }
        .guest-header { background:#0b3d2e; color:#fff; padding:1.5rem 2rem; text-align:center; }
        .guest-header h1 { font-size:1.15rem; font-weight:700; margin:0; }
        .guest-header p { margin:.25rem 0 0; opacity:.85; font-size:.85rem; }
        .guest-body { padding:2rem; }
    </style>
</head>
<body>
    <div class="guest-card">
        <div class="guest-header">
            <h1>Buku Tamu Digital</h1>
            <p>Sekretariat Daerah Kabupaten Bener Meriah</p>
        </div>
        <div class="guest-body">
            @yield('content')
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
