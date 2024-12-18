<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar | Admin</title>
    <style>
        /* Sidebar */
        .sidebar {
            background: #0d636e;
            width: 250px;
            height: 100vh;
            position: fixed;
            top: 70px;
            left: 0;
            padding: 20px;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }

        .menu-list {
            list-style: none;
            margin-top: 20px;
        }

        .menu-item {
            margin-bottom: 10px;
        }

        .menu-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 15px;
            text-decoration: none;
            color: #fff;
            border-radius: 8px;
            transition: all 0.3s;
        }

        .menu-link:hover {
            background: #2C9582;
        }


        .icon {
            width: 24px;
            height: auto;
        }
        
        .user-img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <nav class="sidebar">
        <div class="menu-list">
            <div class="menu-item">
                <center>
            <img src="images/minggtg.jpg" alt="profile" class="user-img">
            <p style="color: #fff; margin-top:10px; font-size: 25px; "><?= $_SESSION['login_admin'] ?>   </p>
            </center>
        </div>
            <div class="menu-item">
                <a href="admin_dashboard.php" class="menu-link">
                    <i class="icon-png"><img src="images/home.png" class="icon" alt="Icon Home"></i>
                    <span>Dashboard</span>
                </a>
            </div>
            <div class="menu-item">
                <a href="diagnosa.php" class="menu-link">
                    <i class="icon-png"><img src="images/diagnosa.png" class="icon" alt="Icon Diagnosa"></i>
                    <span>Diagnosa</span>
                </a>
            </div>
            <div class="menu-item">
                <a href="gejala.php" class="menu-link">
                    <i class="icon-png"><img src="images/gejala.png" class="icon" alt="Icon Gejala"></i>
                    <span>Gejala</span>
                </a>
            </div>
            <div class="menu-item">
                <a href="relasi.php" class="menu-link">
                    <i class="icon-png"><img src="images/relasi.png" class="icon" alt="Icon Relasi"></i>
                    <span>Relasi</span>
                </a>
            </div>
            <div class="menu-item">
                <a href="konsultasi.php" class="menu-link">
                    <i class="icon-png"><img src="images/konsultasi.png" class="icon" alt="Icon Konsultasi"></i>
                    <span>Konsultasi</span>
                </a>
            </div>
        </div>
    </nav>
</body>
</html>