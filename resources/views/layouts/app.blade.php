<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Restaurant ERP')</title>
    <style>
        :root {
            --bg: #f5f7fb;
            --panel: #ffffff;
            --text: #1f2937;
            --muted: #6b7280;
            --primary: #7c3aed;
            --success: #16a34a;
            --warning: #f59e0b;
            --danger: #dc2626;
            --border: #e5e7eb;
        }

        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: var(--bg);
            color: var(--text);
        }

        .topbar {
            background: #111827;
            color: white;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .brand { font-weight: 700; font-size: 1.2rem; }
        .nav { display: flex; gap: 1rem; flex-wrap: wrap; }
        .nav a {
            color: #e5e7eb;
            text-decoration: none;
            font-size: 0.95rem;
        }

        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .card-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .card {
            background: var(--panel);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 1.25rem;
            box-shadow: 0 2px 8px rgba(15, 23, 42, 0.04);
        }

        .card h3, .card h4 { margin: 0 0 0.8rem; color: var(--muted); font-size: 0.9rem; text-transform: uppercase; }
        .metric {
            font-size: 2rem;
            font-weight: 700;
            margin: 0;
        }

        .panel {
            background: var(--panel);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 1.25rem;
            margin-bottom: 1.5rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            text-align: left;
            border-bottom: 1px solid var(--border);
            padding: 0.8rem 0.6rem;
        }

        th {
            color: var(--muted);
            font-size: 0.8rem;
            text-transform: uppercase;
        }

        .tag {
            display: inline-block;
            padding: 0.25rem 0.6rem;
            border-radius: 999px;
            font-size: 0.75rem;
            font-weight: 700;
            background: #ede9fe;
            color: #6d28d9;
        }

        .status-available { background: #dcfce7; color: #166534; }
        .status-reserved { background: #fef3c7; color: #92400e; }
        .status-occupied { background: #fee2e2; color: #991b1b; }
        .status-pending { background: #e0f2fe; color: #075985; }
        .status-ready { background: #dcfce7; color: #166534; }
        .status-served { background: #ede9fe; color: #6d28d9; }
        .status-paid { background: #d1fae5; color: #065f46; }
        .status-cancelled { background: #fee2e2; color: #991b1b; }

        .grid-2 {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        .muted { color: var(--muted); }
        .actions { display: flex; gap: 0.75rem; flex-wrap: wrap; }
        .pill {
            background: var(--primary);
            color: white;
            padding: 0.5rem 0.8rem;
            border-radius: 999px;
            text-decoration: none;
            font-size: 0.85rem;
        }
        .list { list-style: none; padding-left: 0; margin: 0; }
        .list li { padding: 0.5rem 0; border-bottom: 1px solid var(--border); }
    </style>
</head>
<body>
    <header class="topbar">
        <div class="brand">Restaurant ERP</div>
        <nav class="nav">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <a href="{{ route('categories') }}">Categories</a>
            <a href="{{ route('menu-items') }}">Menu Items</a>
            <a href="{{ route('tables') }}">Tables</a>
            <a href="{{ route('orders') }}">Orders</a>
        </nav>
    </header>

    <main class="container">
        @yield('content')
    </main>
</body>
</html>
