<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar | Admin</title>
    <style>
        /* Top Bar */
        .topbar {
            background: var(--putih);
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .logo-area {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .logo {
            height: 60px;
            margin-left: 40px;
        }

        /* User Dropdown */
        .user-dropdown {
            position: relative;
            cursor: pointer;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 12px;
            border-radius: 8px;
            transition: all 0.3s;
        }

        .user-info:hover {
            background: var(--abu);
        }

        .user-foto {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }

        .user-name {
            color: #333;
            font-weight: 500;
        }

        .dropdown-icon {
            color: #666;
            transition: transform 0.3s;
        }

        .dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            width: 200px;
            background: var(--putih);
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            padding: 10px;
            margin-top: 10px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s;
        }

        .dropdown-menu.active {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 15px;
            color: #333;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s;
        }

        .dropdown-item:hover {
            background: var(--abu);
        }

        .dropdown-item i {
            font-size: 18px;
            color: #666;
        }
    </style>
</head>
<body>
      <!-- Top Bar -->
      <nav class="topbar">
        <div class="logo-area">
            <img src="images/medicmate_logoo.png" alt="logo" class="logo">
        </div>
        <div class="user-dropdown">
            <div class="user-info">
                <img src="images/minggtg.jpg" alt="profile" class="user-foto">
                <span class="user-name"><?= $_SESSION['login_admin'] ?></span>
            </div>
            <div class="dropdown-menu">
                <a href="../pw_admin.php" class="dropdown-item">
                    Password
                </a>
                <a href="../logout_admin.php?act=logout" class="dropdown-item">
                    Signout
                </a>
            </div>
        </div>
    </nav>
</body>
</html>