<?php include "../functions.php" ?>
<?php
if (!isset($_SESSION['login_admin'])) {
    header("location:login_admin.php");
}
?>
<?php
$row = $db->get_row("SELECT * FROM tb_gejala WHERE kode_gejala='$_GET[ID]'");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Gejala_ubah | Admin</title>
    <link rel="shortcut icon" href="images/icon_admin.png" />
    <style>
        /* Root Variables */
        :root {
            --primary-color: #0d636e;
            --hover-color: #2C9582;
            --white: #ffffff;
            --light-gray: #f5f5f5;
            --gray: #666;
            --shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        /* Reset & Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f4f7fe;
            color: #333;
            line-height: 1.6;
        }

        /* Navbar Styles */
        .navbar {
            background: var(--white);
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
            box-shadow: var(--shadow);
        }

        .brand-logo {
            height: 60px;
            margin-left: 40px;
        }

        .user-dropdown {
            position: relative;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 12px;
            border-radius: 8px;
            cursor: pointer;
        }

        .profile-image {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }

        .dropdown-content {
            position: absolute;
            top: 100%;
            right: 0;
            width: 200px;
            background: var(--white);
            border-radius: 10px;
            box-shadow: var(--shadow);
            padding: 10px;
            margin-top: 10px;
            display: none;
        }

        .dropdown-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 15px;
            color: #333;
            text-decoration: none;
            border-radius: 8px;
            transition: background 0.3s;
        }

        .dropdown-link:hover {
            background: var(--light-gray);
        }

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

         /* Konten Utama */
         .konten {
            margin-left: 250px;
            margin-top: 70px;
            padding: 30px;
        }

        /* Header */
        .header {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
            margin-top: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .judul {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 20px;
        }

        .judul-icon {
            background: #0d636e;
            color: #fff;
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: grid;
            place-items: center;
        }

        /* Form Container Styles */
        .form-container {
            background: var(--white);
            padding: 25px;
            border-radius: 10px;
            box-shadow: var(--shadow);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }

        .required {
            color: #e74c3c;
            margin-left: 4px;
        }

        .form-input {
            width: 100%;
            padding: 12px;
            border: 1px solid #dce4ec;
            border-radius: 6px;
            font-size: 14px;
            transition: all 0.3s;
        }

        .form-input:focus {
            border-color: var(--primary-color);
            outline: none;
            box-shadow: 0 0 0 2px rgba(13, 99, 110, 0.2);
        }

        .form-input:read-only {
            background-color: var(--light-gray);
            cursor: not-allowed;
        }

        /* Button Styles */
        .button-group {
            display: flex;
            gap: 15px;
            margin-top: 25px;
        }

        .btn {
            padding: 10px 20px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
            color: #fff;
            text-decoration: none;
            transition: all 0.4s ease;
            box-shadow: 0 5px 15px rgba(22, 66, 60, 0.2);
            position: relative;
            overflow: hidden;
        }

        .btn-primary {
            background: linear-gradient(45deg, #16423C, #6A9C89);
            color: #fff;
        }
        
        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(120deg,transparent,rgba(255, 255, 255, 0.3),transparent);
            transition: 0.5s;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(22, 66, 60, 0.3);
        }

        .btn-primary:hover::before {
        left: 100%;
        }

        .btn-danger {
            text-decoration: none;
            background: linear-gradient(45deg, #6A9C89, #16423C);
            color: #fff;
        }

        .btn-danger::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(120deg,transparent,rgba(255, 255, 255, 0.3),transparent);
            transition: 0.5s;
        }

        .btn-danger:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(22, 66, 60, 0.3);
        }

        .btn-danger:hover::before {
        left: 100%;
        }

        /* Alert Styles */
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 6px;
            border: 1px solid transparent;
        }

        .alert-danger {
            background-color: #fee2e2;
            border-color: #fecaca;
            color: #dc2626;
        }

        .user-img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .sidebar {
                width: 0;
                padding: 0;
                overflow: hidden;
            }

            .main-content {
                margin-left: 0;
                padding: 15px;
            }

            .content-header {
                flex-direction: column;
                gap: 15px;
            }

            .button-group {
                flex-direction: column;
            }

            .navbar {
                padding: 15px;
            }
        }
    </style>
</head>
<body>
<!-- Navbar -->
<nav class="navbar">
        <div class="brand">
            <img src="images/medicmate_logoo.png" alt="logo" class="brand-logo">
        </div>
        <div class="user-dropdown">
            <div class="user-profile">
                <img src="images/minggtg.jpg" alt="profile" class="profile-image">
                <span class="user-name"><?= $_SESSION['login'] ?></span>
                <i class="mdi mdi-chevron-down"></i>
            </div>
            <div class="dropdown-content">
                <a href="password.php" class="dropdown-link">
                    <i class="mdi mdi-key-variant"></i>
                    Password
                </a>
                <a href="aksi.php?act=logout" class="dropdown-link">
                    <i class="mdi mdi-logout"></i>
                    Signout
                </a>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <nav class="sidebar">
        <div class="menu-list">
        <div class="menu-item">
                <center>
            <img src="images/minggtg.jpg" alt="profile" class="user-img">
            <p style="color: #fff; margin-top:10px; "><?= $_SESSION['login_admin'] ?></p>
            </center>
        </div>
            <div class="menu-item">
                <a href="dashboard.php" class="menu-link">
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

    <!-- Konten -->
    <main class="konten">
        <div class="header">
            <div class="judul">
                <div class="judul-icon">
                <i class="icon-png"><img src="images/gejala.png" class="icon" width="30" alt="Icon Diagnosa"></i>
                </div>
                Ubah Gejala
            </div>
            <div>Overview</div>
        </div>

        <div class="form-container">
            <?php
            if (isset($_POST['gejala_ubah'])) {
                $kode = $_POST['kode'];
                $nama = $_POST['nama'];

                if ($kode == '' || $nama == '') {
                    echo '<div class="alert alert-danger">Field bertanda * tidak boleh kosong!</div>';
                } else {
                    $db->query("UPDATE tb_gejala SET nama_gejala='$nama' WHERE kode_gejala='$_GET[ID]'");
                    redirect_js("gejala.php");
                }
            }
            ?>
            <form method="post">
                <div class="form-group">
                    <label class="form-label">
                        Kode Gejala <span class="required">*</span>
                    </label>
                    <input class="form-input" type="text" name="kode" readonly="readonly" 
                           value="<?= htmlspecialchars($row->kode_gejala) ?>" />
                </div>
                <div class="form-group">
                    <label class="form-label">
                        Nama Gejala <span class="required">*</span>
                    </label>
                    <input class="form-input" type="text" name="nama" 
                           value="<?= htmlspecialchars($row->nama_gejala) ?>" />
                </div>
                <div class="button-group">
                    <button type="submit" name="gejala_ubah" class="btn btn-primary">Update</button>
                    <a class="btn btn-danger" href="gejala.php">Kembali</a>
                </div>
            </form>
        </div>
    </main>

    <script>
        // Dropdown functionality
        const userProfile = document.querySelector('.user-profile');
        const dropdownContent = document.querySelector('.dropdown-content');

        userProfile.addEventListener('click', () => {
            dropdownContent.style.display = dropdownContent.style.display === 'block' ? 'none' : 'block';
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', (e) => {
            if (!userProfile.contains(e.target)) {
                dropdownContent.style.display = 'none';
            }
        });
    </script>

</body>
</html>