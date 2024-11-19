<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 2rem;
            background: linear-gradient(to right, #243642, #1a252d);
        }

        .logo {
            color: black;
            font-weight: bold;
            cursor: pointer;
        }

        .nav-links {
            display: flex;
            width: 70%;
            font-weight: bold;
            gap: 5rem;
           
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .nav-links a:hover {
            color: grey;
    }

        .cart-icon {
            color: white;
            background: white;
            padding: 0.5rem 3rem;
            border-radius: 25px;
            font-size: 1.5rem;
        }
        
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav>
    
        <div class="logo">
            <a href="/dwp/"><img src="images/11.png" alt="Logotype" height="40px" width="145px"></a>
        </div>
        <div class="nav-links">
            <a href="/dwp/news">NEWS</a>
            <a href="/dwp/movies">MOVIES</a>
            <a href="/dwp/about">ABOUT US</a>
        </div>
        <div class="cart-icon">🛒</div>
    </nav>
</body>
</html>