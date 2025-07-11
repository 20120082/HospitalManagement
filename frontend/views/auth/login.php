<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - Hospital Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .login-container {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .login-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            padding: 2rem;
        }
        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .login-header h3 {
            color: #333;
            font-weight: 600;
        }
        .login-header .fa-hospital {
            color: #007bff;
            font-size: 3rem;
            margin-bottom: 1rem;
        }
        .form-control {
            border-radius: 10px;
            padding: 0.75rem 1rem;
            border: 1px solid #ddd;
        }
        .btn-login {
            border-radius: 10px;
            padding: 0.75rem 2rem;
            font-weight: 600;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            transition: transform 0.2s;
        }
        .btn-login:hover {
            transform: translateY(-2px);
        }
        .alert {
            border-radius: 10px;
        }
        .demo-accounts {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 1rem;
            margin-top: 2rem;
        }
        .demo-accounts h6 {
            color: #495057;
            margin-bottom: 0.5rem;
        }
        .demo-accounts small {
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="login-container d-flex align-items-center justify-content-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-4">
                    <div class="login-card">
                        <div class="login-header">
                            <i class="fas fa-hospital"></i>
                            <h3>Hospital Management</h3>
                            <p class="text-muted">Đăng nhập vào hệ thống</p>
                        </div>

                        <?php if(isset($error)): ?>
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="index.php?controller=Auth&action=login">
                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="fas fa-user"></i> Tên đăng nhập hoặc Email
                                </label>
                                <input type="text" class="form-control" name="username" required 
                                       value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="fas fa-lock"></i> Mật khẩu
                                </label>
                                <input type="password" class="form-control" name="password" required>
                            </div>

                            <button type="submit" class="btn btn-primary btn-login w-100">
                                <i class="fas fa-sign-in-alt"></i> Đăng nhập
                            </button>
                        </form>

                        <div class="demo-accounts">
                            <h6><i class="fas fa-info-circle"></i> Tài khoản demo:</h6>
                            <small>
                                <strong>Admin:</strong> admin1 / password123<br>
                                <strong>Doctor:</strong> doctor1 / password123<br>
                                <strong>Nurse:</strong> nurse1 / password123<br>
                                <strong>Receptionist:</strong> receptionist1 / password123
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
