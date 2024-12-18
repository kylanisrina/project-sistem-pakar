<?php include "../functions.php"; ?>
<?php
if (!isset($_SESSION['login_admin'])) {
    header("location:login_admin.php");
    exit;
}

// Handle form submission
if (isset($_POST['password_ubah'])) {
    $pass1 = isset($_POST['pass1']) ? trim($_POST['pass1']) : '';
    $pass2 = isset($_POST['pass2']) ? trim($_POST['pass2']) : '';
    $pass3 = isset($_POST['pass3']) ? trim($_POST['pass3']) : '';

    if (empty($pass1) || empty($pass2) || empty($pass3)) {
        $error = "Field bertanda * harus diisi.";
    } elseif (!$db->get_row("SELECT * FROM tb_admin WHERE user='$_SESSION[login_admin]' AND pass='$pass1'")) {
        $error = "Password lama salah.";
    } elseif ($pass2 != $pass3) {
        $error = "Password baru dan konfirmasi password tidak sama.";
    } elseif (strlen($pass2) < 6) {
        $error = "Password minimal 6 karakter.";
    } else {
        $db->query("UPDATE tb_admin SET pass='$pass2' WHERE user='$_SESSION[login_admin]'");
        $success = "Password berhasil diubah.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ubah Password | Admin</title>
    <link rel="shortcut icon" href="admin/assets/images/icon_admin.png" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-icons/4.0.0/font/MaterialIcons-Regular.ttf">
    <style>
        /* Reset & Root */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }

        :root {
            --primer: #4e73df;
            --sekunder: #858796;
            --merah: #e74a3b;
            --hijau: #1cc88a;
            --putih: #ffffff;
            --abu: #f4f7fe;
        }

        body {
            background: var(--abu);
        }

        /* Navbar */
        .navbar {
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
            height: 40px;
        }

        /* User Menu */
        .user-menu {
            position: relative;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px;
            cursor: pointer;
        }

        .user-foto {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }

        .dropdown {
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

        .dropdown.aktif {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .menu-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 15px;
            color: #333;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s;
        }

        .menu-item:hover {
            background: var(--abu);
        }

        /* Sidebar */
        .sidebar {
            background: var(--putih);
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

        .menu-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 15px;
            text-decoration: none;
            color: #333;
            border-radius: 8px;
            transition: all 0.3s;
        }

        .menu-link:hover {
            background: var(--abu);
        }

        /* Konten */
        .konten {
            margin-left: 250px;
            margin-top: 70px;
            padding: 30px;
        }

        /* Header */
        .header {
            background: var(--putih);
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
            background: linear-gradient(145deg, var(--primer), #224abe);
            color: var(--putih);
            width: 40px;
            height: 40px;
            border-radius: 12px;
            display: grid;
            place-items: center;
        }

        /* Form Card */
        .kartu {
            background: linear-gradient(145deg, #ffffff, #f5f7ff);
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(78,115,223,0.1);
            padding: 35px;
            max-width: 500px;
            margin: 0 auto;
            border: 1px solid rgba(78,115,223,0.1);
        }

        /* Form Groups */
        .form-group {
            margin-bottom: 25px;
            position: relative;
        }

        .form-label {
            display: block;
            margin-bottom: 10px;
            color: #333;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.3s;
        }

        .wajib {
            color: var(--merah);
            margin-left: 4px;
            font-size: 18px;
            line-height: 0;
        }

        .form-password {
            position: relative;
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
            transition: all 0.3s;
        }

        .form-password:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .form-input {
            width: 100%;
            padding: 15px 45px 15px 20px;
            border: 2px solid #eee;
            border-radius: 12px;
            font-size: 15px;
            transition: all 0.3s;
            background: transparent;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primer);
            box-shadow: 0 0 0 4px rgba(78,115,223,0.15);
        }

        .show-pass {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #666;
            font-size: 20px;
            padding: 5px;
            transition: all 0.3s;
        }

        .show-pass:hover {
            color: var(--primer);
        }

        /* Messages */
        .error-msg {
            color: var(--merah);
            background: linear-gradient(145deg, #fff5f5, #ffe5e5);
            padding: 15px 20px;
            border-radius: 12px;
            margin-bottom: 25px;
            font-size: 14px;
            border-left: 4px solid var(--merah);
            box-shadow: 0 4px 12px rgba(231,74,59,0.1);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .success-msg {
            color: var(--hijau);
            background: linear-gradient(145deg, #f0fff4, #e6ffed);
            padding: 15px 20px;
            border-radius: 12px;
            margin-bottom: 25px;
            font-size: 14px;
            border-left: 4px solid var(--hijau);
            box-shadow: 0 4px 12px rgba(28,200,138,0.1);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Password Strength */
        .password-strength {
            height: 4px;
            background: #eee;
            border-radius: 2px;
            margin-top: 8px;
            overflow: hidden;
            transition: all 0.3s;
        }

        .strength-bar {
            height: 100%;
            width: 0;
            border-radius: 2px;
            transition: all 0.3s;
        }

        .strength-text {
            font-size: 12px;
            margin-top: 5px;
            color: #666;
        }

        /* Buttons */
        .tombol-grup {
            display: flex;
            gap: 15px;
            margin-top: 35px;
        }

        .tombol {
            padding: 12px 25px;
            border-radius: 12px;
            border: none;
            cursor: pointer;
            font-size: 15px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s;
            text-decoration: none;
        }

        .tombol-primer {
            background: linear-gradient(145deg, var(--primer), #224abe);
            color: var(--putih);
        }

        .tombol-danger {
            background: linear-gradient(145deg, var(--merah), #c23321);
            color: var(--putih);
        }

        .tombol:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
        }

        /* Loading State */
        .tombol.loading {
            position: relative;
            pointer-events: none;
        }

        .tombol.loading:after {
            content: '';
            width: 20px;
            height: 20px;
            border: 2px solid rgba(255,255,255,0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 0.8s infinite linear;
            position: absolute;
            right: 15px;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .konten {
                margin-left: 0;
            }

            .kartu {
                margin: 0 15px;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="logo-area">
            <img src="admin/assets/images/logo_medicc.png" alt="logo" class="logo">
        </div>
        <div class="user-menu">
            <div class="user-info">
                <img src="admin/assets/images/minggtg.jpg" alt="profile" class="user-foto">
                <span><?= $_SESSION['login_admin'] ?></span>
                <i class="mdi mdi-chevron-down"></i>
            </div>
            <div class="dropdown">
                <a href="password.php" class="menu-item">
                    <i class="mdi mdi-key-variant"></i>
                    Password
                </a>
                <a href="aksi.php?act=logout" class="menu-item">
                    <i class="mdi mdi-logout"></i>
                    Signout
                </a>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <nav class="sidebar">
        <div class="menu-list">
            <a href="dashboard.php" class="menu-link">
                <i class="mdi mdi-home"></i>
                <span>Dashboard</span>
            </a>
            <a href="diagnosa.php" class="menu-link">
                <i class="mdi mdi-account-search-outline"></i>
                <span>Diagnosa</span>
            </a>
            <a href="gejala.php" class="menu-link">
                <i class="mdi mdi-alert-circle-outline"></i>
                <span>Gejala</span>
            </a>
            <a href="relasi.php" class="menu-link">
                <i class="mdi mdi-ray-start-end"></i>
                <span>Relasi</span>
            </a>
            <a href="konsultasi.php" class="menu-link">
                <i class="mdi mdi-comment-text"></i>
                <span>Konsultasi</span>
            </a>
        </div>
    </nav>

    <!-- Content -->
    <main class="konten">
        <!-- Header -->
        <div class="header">
            <div class="judul">
                <div class="judul-icon">
                    <i class="mdi mdi-key-variant"></i>
                </div>
                Ubah Password
            </div>
            <div>Overview</div>
        </div>

        <!-- Form Card -->
        <div class="kartu">
            <?php if (isset($error)): ?>
                <div class="error-msg">
                    <i class="mdi mdi-alert-circle"></i>
                    <?= $error ?>
                </div>
                </div>
                <?php endif; ?>
    
                <form method="post">
                    <div class="form-group">
                        <label class="form-label">
                            Password Lama
                            <span class="wajib">*</span>
                        </label>
                        <div class="form-password">
                            <input type="password" name="pass1" class="form-input" 
                                   placeholder="Masukkan password lama">
                            <i class="mdi mdi-eye show-pass"></i>
                        </div>
                    </div>
    
                    <div class="form-group">
                        <label class="form-label">
                            Password Baru
                            <span class="wajib">*</span>
                        </label>
                        <div class="form-password">
                            <input type="password" name="pass2" class="form-input" 
                                   placeholder="Masukkan password baru">
                            <i class="mdi mdi-eye show-pass"></i>
                            <div class="password-strength">
                                <div class="strength-bar"></div>
                            </div>
                            <div class="strength-text"></div>
                        </div>
                    </div>
    
                    <div class="form-group">
                        <label class="form-label">
                            Konfirmasi Password Baru
                            <span class="wajib">*</span>
                        </label>
                        <div class="form-password">
                            <input type="password" name="pass3" class="form-input" 
                                   placeholder="Konfirmasi password baru">
                            <i class="mdi mdi-eye show-pass"></i>
                        </div>
                    </div>
    
                    <div class="tombol-grup">
                        <button type="submit" name="password_ubah" class="tombol tombol-primer">
                            <i class="mdi mdi-content-save"></i>
                            Simpan
                        </button>
                        <a href="dashboard.php" class="tombol tombol-danger">
                            <i class="mdi mdi-arrow-left"></i>
                            Kembali
                        </a>
                    </div>
                </form>
            </div>
        </main>
    
        <script>
            // Dropdown Menu
            document.querySelector('.user-menu').addEventListener('click', function() {
                this.querySelector('.dropdown').classList.toggle('aktif');
            });
    
            document.addEventListener('click', function(e) {
                if (!e.target.closest('.user-menu')) {
                    document.querySelector('.dropdown').classList.remove('aktif');
                }
            });
    
            // Show/Hide Password
            document.querySelectorAll('.show-pass').forEach(icon => {
                icon.addEventListener('click', function() {
                    const input = this.previousElementSibling;
                    if (input.type === 'password') {
                        input.type = 'text';
                        this.classList.replace('mdi-eye', 'mdi-eye-off');
                    } else {
                        input.type = 'password';
                        this.classList.replace('mdi-eye-off', 'mdi-eye');
                    }
                });
            });
    
            // Password Strength
            const strengthBar = document.querySelector('.strength-bar');
            const strengthText = document.querySelector('.strength-text');
            const newPassword = document.querySelector('input[name="pass2"]');
    
            newPassword.addEventListener('input', function() {
                const value = this.value;
                const strength = getPasswordStrength(value);
                
                strengthBar.style.width = strength.percent + '%';
                strengthBar.style.backgroundColor = strength.color;
                strengthText.textContent = strength.text;
                strengthText.style.color = strength.color;
            });
    
            function getPasswordStrength(password) {
                if (password.length === 0) 
                    return { percent: 0, color: '#ddd', text: '' };
                if (password.length < 6)
                    return { percent: 25, color: '#e74a3b', text: 'Sangat Lemah' };
                if (password.length < 8)
                    return { percent: 50, color: '#f6c23e', text: 'Lemah' };
                if (password.length < 10)
                    return { percent: 75, color: '#36b9cc', text: 'Sedang' };
                return { percent: 100, color: '#1cc88a', text: 'Kuat' };
            }
    
            // Form Validation
            document.querySelector('form').addEventListener('submit', function(e) {
                const pass1 = document.querySelector('input[name="pass1"]').value;
                const pass2 = document.querySelector('input[name="pass2"]').value;
                const pass3 = document.querySelector('input[name="pass3"]').value;
    
                if (!pass1 || !pass2 || !pass3) {
                    e.preventDefault();
                    alert('Mohon lengkapi semua field password!');
                    return;
                }
    
                if (pass2 !== pass3) {
                    e.preventDefault();
                    alert('Password baru dan konfirmasi password tidak sama!');
                    return;
                }
    
                if (pass2.length < 6) {
                    e.preventDefault();
                    alert('Password baru minimal 6 karakter!');
                    return;
                }
    
                const button = this.querySelector('button[type="submit"]');
                button.classList.add('loading');
            });
    
            // Auto Hide Success Message
            <?php if (isset($success)): ?>
            setTimeout(() => {
                const successMsg = document.querySelector('.success-msg');
                if (successMsg) {
                    successMsg.style.opacity = '0';
                    successMsg.style.transition = 'opacity 0.5s';
                    setTimeout(() => successMsg.remove(), 500);
                }
            }, 3000);
            <?php endif; ?>
        </script>
    </body>
    </html>