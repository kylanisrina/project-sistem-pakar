<?php include "../functions.php"; ?>
<?php
if (!isset($_SESSION['login_admin'])) {
    header("location:login_admin.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
    <link rel="shortcut icon" href="images/icon_admin.png" />
   
    <style>
        /* Reset & Root */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }

        :root {
            --merah: linear-gradient(45deg, #ff416c, #ff4b2b);
            --biru: linear-gradient(45deg, #2193b0, #6dd5ed);
            --hijau: linear-gradient(45deg, #11998e, #38ef7d);
            --oren: linear-gradient(45deg, #f7971e, #ffd200);
            --putih: #ffffff;
            --abu: #f4f7fe;
        }

        body {
            background: var(--abu);
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

        /* Menu Cards */
        .kartu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        .kartu {
            padding: 25px;
            border-radius: 15px;
            color: #fff;
            position: relative;
            overflow: hidden;
            min-height: 150px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }

        .kartu:hover {
            transform: translateY(-5px);
        }

        .kartu-merah { background: var(--merah); }
        .kartu-biru { background: var(--biru); }
        .kartu-hijau { background: var(--hijau); }
        .kartu-oren { background: var(--oren); }

        .kartu-icon {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 24px;
        }

        .kartu-judul {
            font-size: 20px;
            margin-bottom: 20px;
        }

        .tombol-lihat {
            background: rgba(255,255,255,0.2);
            color: #fff;
            border: none;
            padding: 10px;
            width: 100%;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .tombol-lihat:hover {
            background: rgba(255,255,255,0.3);
        }

        .bg-icon {
            position: absolute;
            top: 0;
            right: 0;
            opacity: 0.1;
            width: 150px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .konten {
                margin-left: 0;
            }

            .kartu-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
<?php require "sidebar-navbar/navbar.php"; ?>
  <div class="container-fluid page-body-wrapper">
    <?php require "sidebar-navbar/sidebar.php"; ?>

    <!-- Konten -->
    <main class="konten">
        <div class="header">
            <div class="judul">
                <div class="judul-icon">
                <i class="icon-png"><img src="images/home.png" class="icon" width="30" alt="Icon Diagnosa"></i>
                </div>
                Dashboard
            </div>
            <div>Overview</div>
        </div>

        <div class="kartu-grid">
            <!-- Kartu Diagnosa -->
            <div class="kartu kartu-merah">
                <img src="images/dashboard/circle.svg" class="bg-icon" alt="background">
                <h4 class="kartu-judul">Data Diagnosa <i class="icon-png"><img src="images/diagnosa.png" class="icon" alt="Icon Diagnosa"></i></h4>
                
                <a href="diagnosa.php">
                    <button class="tombol-lihat">Lihat Data</button>
                </a>
            </div>

            <!-- Kartu Gejala -->
            <div class="kartu kartu-biru">
                <img src="images/dashboard/circle.svg" class="bg-icon" alt="background">
                <h4 class="kartu-judul">Data Gejala <i class="icon-png"><img src="images/gejala.png" class="icon" alt="Icon Gejala"></i></h4>
                <a href="gejala.php">
                    <button class="tombol-lihat">Lihat Data</button>
                </a>
            </div>

            <!-- Kartu Relasi -->
            <div class="kartu kartu-hijau">
                <img src="images/dashboard/circle.svg" class="bg-icon" alt="background">
                <h4 class="kartu-judul">Data Relasi <i class="icon-png"><img src="images/relasi.png" class="icon" alt="Icon Relasi"></i></h4>
                <a href="relasi.php">
                    <button class="tombol-lihat">Lihat Data</button>
                </a>
            </div>

            <!-- Kartu Konsultasi -->
            <div class="kartu kartu-oren">
                <img src="images/dashboard/circle.svg" class="bg-icon" alt="background">
                <h4 class="kartu-judul">Konsultasi <i class="icon-png"><img src="images/konsultasi.png" class="icon" alt="Icon Konsultasi"></i></h4>
                <a href="konsultasi.php">
                    <button class="tombol-lihat">Lihat Data</button>
                </a>
            </div>
        </div>
    </main>

    <script>
        // Dropdown functionality
        document.querySelector('.user-dropdown').addEventListener('click', function() {
            this.querySelector('.dropdown-menu').classList.toggle('active');
            this.querySelector('.dropdown-icon').style.transform = 
                this.querySelector('.dropdown-menu').classList.contains('active') 
                    ? 'rotate(180deg)' 
                    : 'rotate(0)';
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.user-dropdown')) {
                document.querySelector('.dropdown-menu').classList.remove('active');
                document.querySelector('.dropdown-icon').style.transform = 'rotate(0)';
            }
        });
    </script>
</body>
</html>