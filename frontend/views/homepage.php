<?php
// Session đã được khởi động trong index.php
if(!isset($_SESSION['user_id'])) {
    header('Location: index.php?controller=Auth&action=loginPage');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" >
    <link rel="stylesheet" href="views/css/styles.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <i class="fas fa-hospital"></i> Hospital Management
            </a>
            <div class="navbar-nav ms-auto">
                <span class="navbar-text me-3">
                    Xin chào, <?php echo $_SESSION['full_name']; ?> (<?php echo ucfirst($_SESSION['role_name']); ?>)
                </span>
                <a class="btn btn-outline-light btn-sm" href="index.php?controller=Auth&action=logout">
                    <i class="fas fa-sign-out-alt"></i> Đăng xuất
                </a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h1>Hospital Management Homepage</h1>
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-info">
                    <strong>Vai trò của bạn:</strong> <?php echo ucfirst($_SESSION['role_name']); ?><br>
                    <small>Bạn chỉ có thể truy cập các module được phép cho vai trò này.</small>
                </div>
                
                <div class="row">
                    <?php 
                    $role = $_SESSION['role_name'];
                    
                    // Prescription Service - Admin, Doctor, Nurse, Patient
                    if(in_array($role, ['admin', 'doctor', 'nurse', 'patient'])): ?>
                    <div class="col-md-3 mb-3">
                        <a href="index.php?controller=Prescription&action=index" class="btn btn-primary w-100">
                            <i class="fas fa-prescription-bottle"></i><br>
                            Prescription Service
                        </a>
                    </div>
                    <?php endif; ?>
                    
                    <?php 
                    // Doctor Service - Admin, Doctor
                    if(in_array($role, ['admin', 'doctor'])): ?>
                    <div class="col-md-3 mb-3">
                        <a href="index.php?controller=Doctor&action=index" class="btn btn-primary w-100">
                            <i class="fas fa-user-md"></i><br>
                            Doctor Service
                        </a>
                    </div>
                    <?php endif; ?>
                    
                    <?php 
                    // Medicine Service - Admin, Doctor, Nurse
                    if(in_array($role, ['admin', 'doctor', 'nurse'])): ?>
                    <div class="col-md-3 mb-3">
                        <a href="index.php?controller=Medicine&action=ListPage" class="btn btn-primary w-100">
                            <i class="fas fa-pills"></i><br>
                            Medicine Service
                        </a>
                    </div>
                    <?php endif; ?>
                    
                    <?php 
                    // Appointment Service - Admin, Doctor, Patient, Receptionist
                    if(in_array($role, ['admin', 'doctor', 'patient', 'receptionist'])): ?>
                    <div class="col-md-3 mb-3">
                        <a href="index.php?controller=Appointment&action=index" class="btn btn-primary w-100">
                            <i class="fas fa-calendar-alt"></i><br>
                            Appointment Service
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="row">
                    <?php 
                    // Notification Management - Admin, Receptionist
                    if(in_array($role, ['admin', 'receptionist'])): ?>
                    <div class="col-md-3 mb-3">
                        <a href="index.php?controller=Notification&action=index" class="btn btn-success w-100">
                            <i class="fas fa-bell"></i><br>
                            Notification Management
                        </a>
                    </div>
                    <?php endif; ?>
                    
                    <!-- My Dashboard - Tất cả role -->
                    <div class="col-md-3 mb-3">
                        <a href="index.php?controller=Auth&action=<?php echo $_SESSION['role_name']; ?>Dashboard" class="btn btn-info w-100">
                            <i class="fas fa-tachometer-alt"></i><br>
                            My Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
</body>
</html>