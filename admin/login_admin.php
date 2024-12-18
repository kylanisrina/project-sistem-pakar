<?php require_once "../functions.php";
if (isset($_POST['login_admin'])) {
    $user = esc_field($_POST['user']);
    $pass = esc_field($_POST['pass']);

    $row = $db->get_row("SELECT * FROM tb_admin WHERE user='$user' AND pass='$pass'");
    if ($row) {
        $_SESSION['login_admin'] = $row->user;
        $_SESSION['level'] = $row->level;
        redirect_js("admin_dashboard.php");
    } else {
        $error = "Username dan Password Salah.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | Admin</title>
    <link rel="shortcut icon" href="images/icon_admin.png" />
    <style>
        /* Reset & Root */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }

        /* Main Styles */
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #66ead2 0%, #0d636e 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-container {
            width: 100%;
            max-width: 420px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            animation: fadeIn 0.6s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .logo-area {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo-area img {
            max-width: 340px;
            height: auto;
        }

        .login-title {
            color: #1e293b;
            font-size: 16px;
            margin-bottom: 30px;
            text-align: center;
        }

        /* Form Styles */
        .form-group {
            margin-bottom: 25px;
            position: relative;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            color: #1e293b;
            font-size: 14px;
            font-weight: 500;
        }

        .form-input {
            width: 100%;
            padding: 14px;
            border: 2px solid #e2e8f0;
            background: white;
            border-radius: 12px;
            font-size: 15px;
            transition: all 0.3s;
        }

        .form-input:focus {
            outline: none;
            border-color: #66ead2;
            box-shadow: 0 0 0 4px rgb(102, 234, 210, 0.1);
        }

        .input-icon {
            position: absolute;
            right: 15px;
            top: 40px;
            color: #94a3b8;
            cursor: pointer;
            transition: all 0.3s;
        }

        .input-icon:hover {
            color: #66ead2;
        }

        /* Button */
        .login-button {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 12px;
            background: linear-gradient(135deg, #66ead2 0%, #0d636e 100%);
            color: white;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .login-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(249, 115, 22, 0.2);
        }

        .login-button:active {
            transform: translateY(0);
        }

        /* Back Link */
        .back-link {
            display: inline-block;
            margin-top: 20px;
            color: #1e293b;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s;
        }

        .back-link:hover {
            color: #66ead2;
        }

        /* Error Message */
        .error-msg {
            background: #fef2f2;
            border-left: 4px solid #ef4444;
            color: #dc2626;
            padding: 12px 15px;
            border-radius: 8px;
            font-size: 14px;
            margin-bottom: 20px;
            animation: shake 0.5s ease-in-out;
        }

        @keyframes shake {
            0%,
            100% {
                transform: translateX(0);
            }

            10%,
            30%,
            50%,
            70%,
            90% {
                transform: translateX(-5px);
            }

            20%,
            40%,
            60%,
            80% {
                transform: translateX(5px);
            }
        }
    </style>
</head>
<body>

    <div class="login-container">
        <div class="logo-area">
            <img src="images/medicmate_logoo.png" alt="Logo">
        </div>

        <h2 class="login-title">Masuk untuk melanjutkan sebagai Admin</h2>

        <?php if (isset($error)): ?>
            <div class="error-msg"><?= $error ?></div>
        <?php endif; ?>

        <form method="post">
            <div class="form-group">
                <label class="form-label">Username</label>
                <input type="text"
                    class="form-input"
                    name="user"
                    placeholder="Enter your username"
                    autofocus>
            </div>

            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password"
                    class="form-input"
                    name="pass"
                    placeholder="Enter your password">
                <i class="input-icon" id="togglePassword">👁️</i>
            </div>

            <button type="submit" name="login_admin" class="login-button">
                Sign In
            </button>
        </form>

        <a href="../index.php" class="back-link">← Back to Home</a>
    </div>

    <script>
        // Toggle Password Visibility
        const togglePassword = document.getElementById('togglePassword');
        const password = document.querySelector('input[name="pass"]');

        togglePassword.addEventListener('click', function() {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.textContent = type === 'password' ? '👁️' : '👁️‍🗨️';
        });

        // Form Animation
        const inputs = document.querySelectorAll('.form-input');
        inputs.forEach(input => {
            input.addEventListener('focus', () => {
                input.parentElement.style.transform = 'translateY(-2px)';
            });
            input.addEventListener('blur', () => {
                input.parentElement.style.transform = 'translateY(0)';
            });
        });

        // Error Message Auto-hide
        const errorMsg = document.querySelector('.error-msg');
        if (errorMsg) {
            setTimeout(() => {
                errorMsg.style.opacity = '0';
                errorMsg.style.transition = 'opacity 0.5s';
                setTimeout(() => errorMsg.remove(), 500);
            }, 5000);
        }
    </script>
</body>

</html>