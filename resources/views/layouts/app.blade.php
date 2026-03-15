<!DOCTYPE html>
<html lang="en">
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<style>
    body{
        font-family: "Lucida Console", "Courier New", monospace;
        display: flex;
        flex-direction: column;
       
    }
    .nav-link {
        padding: 8px 14px;
        border-radius: 6px;
        transition: box-shadow 0.3s ease;
        color: white;
    }

    .nav-link.active {
        box-shadow: 0 0 12px 3px rgba(230, 237, 239, 0.8); /* light blue glow */
        
    }
    html, body {
        height: 100%;
        margin: 0;
    }


    .page-content {
        flex: 1; /* pushes footer down */
    }
    header{
    }

    footer {
        color: white;
        text-align: center;
        margin-top: 22%;
    }

</style>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
</head>

<body>
<header style="text-align: center">
    <img style=" width: 1550px; height: 200px;"
            src="{{ asset('images/blog_app_header.png') }}"
            alt="an image"
            height="250"
            width="250"
     />
</header>

<div style="text-align: center;">
    <nav style="display: flex; gap: 100px; justify-content: center; background-color: #7f97c8; padding:2%;">
        <h4><a href="/blog" class="nav-link {{ request()->is('blog') ? 'active' : '' }}">Blog</a></h4>
        <h4><a href="/manage" class="nav-link {{ request()->is('manage') ? 'active' : '' }}">Manage</a></h4>
        
        @guest
            <h4><a href="/login" class="nav-link {{ request()->is('login') ? 'active' : '' }}">Login</a></h4>
            <h4><a href="/register" class="nav-link {{ request()->is('register') ? 'active' : '' }}">Register</a></h4>
        @endguest

        @auth
            <h4><a href="/logout" class="nav-link">Logout</a></h4>
        @endauth
    </nav>
    <br/>
    <main class= "page-content">
       @yield('content')
    </main>
        <br/>

    <footer style=" background-color: #7f97c8;; padding:2%;">
       <h4> &#169; Colin okafor</h4>
    </footer>
</div>
</body>

</html>