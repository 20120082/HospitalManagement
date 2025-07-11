<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Báo cáo và Thống kê</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="views/css/report-styles.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="report-container">
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="report-header fade-in-up">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h1><i class="fas fa-chart-line me-3"></i>Báo cáo và Thống kê</h1>
                                <p class="subtitle">Theo dõi và phân tích dữ liệu hệ thống quản lý bệnh viện</p>
                            </div>
                            <a href="index.php" class="btn btn-outline-primary">
                                <i class="fas fa-home me-2"></i>Trang chủ
                            </a>
                        </div>
                        
                        <!-- Thông tin hệ thống -->
                        <div class="alert alert-info mt-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6><i class="fas fa-chart-pie me-2"></i>Thống kê tổng quan</h6>
                                    <ul class="mb-0">
                                        <li>📊 Tổng số bệnh nhân và đơn thuốc trong hệ thống</li>
                                        <li>📅 Dữ liệu cụ thể cho tháng hiện tại</li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <h6><i class="fas fa-chart-bar me-2"></i>Biểu đồ phân tích</h6>
                                    <ul class="mb-0">
                                        <li>📈 Xu hướng bệnh nhân theo 12 tháng</li>
                                        <li>📊 Số lượng đơn thuốc theo 12 tháng</li>
                                        <li>🍰 Tỷ lệ trạng thái đơn thuốc</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tổng quan -->
            <div class="row mb-4">
                <div class="col-12">
                    <h3 class="section-title"><i class="fas fa-chart-pie me-2"></i>Thống kê tổng quan</h3>
                    <p class="text-muted mb-3">Dữ liệu tổng hợp của toàn bộ hệ thống</p>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-lg-3 col-md-6">
                    <div class="stat-card patients fade-in-up">
                        <div class="text-center">
                            <div class="stat-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="stat-number" id="totalPatients">0</div>
                            <div class="stat-label">Tổng số bệnh nhân</div>
                            <small class="text-muted">Tất cả bệnh nhân trong hệ thống</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stat-card prescriptions fade-in-up">
                        <div class="text-center">
                            <div class="stat-icon">
                                <i class="fas fa-prescription-bottle-alt"></i>
                            </div>
                            <div class="stat-number" id="totalPrescriptions">0</div>
                            <div class="stat-label">Tổng số đơn thuốc</div>
                            <small class="text-muted">Tất cả đơn thuốc đã tạo</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stat-card monthly-patients fade-in-up">
                        <div class="text-center">
                            <div class="stat-icon">
                                <i class="fas fa-user-plus"></i>
                            </div>
                            <div class="stat-number" id="patientsThisMonth">0</div>
                            <div class="stat-label">Bệnh nhân tháng này</div>
                            <small class="text-muted">Tháng <span id="currentMonthLabel">7</span>/2025</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stat-card monthly-prescriptions fade-in-up">
                        <div class="text-center">
                            <div class="stat-icon">
                                <i class="fas fa-file-prescription"></i>
                            </div>
                            <div class="stat-number" id="prescriptionsThisMonth">0</div>
                            <div class="stat-label">Đơn thuốc tháng này</div>
                            <small class="text-muted">Tháng <span id="currentMonthLabel2">7</span>/2025</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bộ lọc và Biểu đồ -->
            <div class="row mb-4">
                <div class="col-12">
                    <h3 class="section-title"><i class="fas fa-chart-area me-2"></i>Biểu đồ phân tích</h3>
                    <p class="text-muted mb-3">Xem xu hướng và phân tích dữ liệu theo thời gian</p>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-lg-4">
                    <div class="filter-card fade-in-up">
                        <div class="card-header">
                            <h5><i class="fas fa-filter me-2"></i>Bộ lọc thời gian</h5>
                            <small class="text-muted">Chọn năm và tháng để xem dữ liệu</small>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label for="yearSelect" class="form-label"><i class="fas fa-calendar-alt me-1"></i>Năm</label>
                                    <select id="yearSelect" class="form-select">
                                        <option value="2024">2024</option>
                                        <option value="2025" selected>2025</option>
                                    </select>
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="monthSelect" class="form-label"><i class="fas fa-calendar-day me-1"></i>Tháng</label>
                                    <select id="monthSelect" class="form-select">
                                        <option value="1">Tháng 1</option>
                                        <option value="2">Tháng 2</option>
                                        <option value="3">Tháng 3</option>
                                        <option value="4">Tháng 4</option>
                                        <option value="5">Tháng 5</option>
                                        <option value="6">Tháng 6</option>
                                        <option value="7">Tháng 7</option>
                                        <option value="8">Tháng 8</option>
                                        <option value="9">Tháng 9</option>
                                        <option value="10">Tháng 10</option>
                                        <option value="11">Tháng 11</option>
                                        <option value="12">Tháng 12</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <button onclick="updateReport()" class="btn btn-primary w-100">
                                        <i class="fas fa-sync-alt me-2"></i>Cập nhật báo cáo
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="status-chart-container fade-in-up">
                        <div class="card-header">
                            <h5><i class="fas fa-chart-pie me-2"></i>Trạng thái đơn thuốc</h5>
                            <small class="text-muted">Tỷ lệ đơn thuốc đã lấy và chưa lấy</small>
                        </div>
                        <div class="chart-responsive">
                            <canvas id="prescriptionStatusChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Biểu đồ theo tháng -->
            <div class="row">
                <div class="col-12">
                    <h3 class="section-title"><i class="fas fa-chart-line me-2"></i>Xu hướng 12 tháng</h3>
                    <p class="text-muted mb-3">Biểu đồ hiển thị xu hướng dữ liệu qua 12 tháng trong năm</p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="chart-container fade-in-up">
                        <div class="chart-header">
                            <h5><i class="fas fa-chart-line me-2"></i>Số lượng bệnh nhân theo tháng</h5>
                            <small class="text-muted">Xu hướng bệnh nhân mới</small>
                        </div>
                        <div class="chart-responsive">
                            <canvas id="patientChart"></canvas>
                        </div>
                        <div class="chart-info">
                            <p><i class="fas fa-info-circle me-1"></i>Đường biểu đồ cho thấy số lượng bệnh nhân trong từng tháng. Tháng 7 có số lượng cao nhất với 200 bệnh nhân.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="chart-container fade-in-up">
                        <div class="chart-header">
                            <h5><i class="fas fa-chart-bar me-2"></i>Số lượng đơn thuốc theo tháng</h5>
                            <small class="text-muted">Số lượng đơn thuốc được tạo</small>
                        </div>
                        <div class="chart-responsive">
                            <canvas id="prescriptionChart"></canvas>
                        </div>
                        <div class="chart-info">
                            <p><i class="fas fa-info-circle me-1"></i>Các cột biểu đồ cho thấy số lượng đơn thuốc được tạo trong từng tháng. Tháng 5 và 6 có số lượng cao nhất.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // API endpoints thông qua dedicated API file
        const PATIENT_API = 'api/report.php?action=getPatientStats';
        const PRESCRIPTION_API = 'api/report.php?action=getPrescriptionStats';
        const MONTHLY_REPORT_API = 'api/report.php?action=getMonthlyReport';
        
        let patientChart;
        let prescriptionChart;
        let prescriptionStatusChart;

        // Khởi tạo trang
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Report page loaded');
            console.log('Patient API URL:', PATIENT_API);
            console.log('Prescription API URL:', PRESCRIPTION_API);
            console.log('Monthly Report API URL:', MONTHLY_REPORT_API);
            
            // Set current month
            const currentMonth = new Date().getMonth() + 1;
            document.getElementById('monthSelect').value = currentMonth;
            
            // Update month labels
            document.getElementById('currentMonthLabel').textContent = currentMonth;
            document.getElementById('currentMonthLabel2').textContent = currentMonth;
            
            loadDashboard();
        });

        // Load dashboard data
        async function loadDashboard() {
            try {
                await loadGeneralStats();
                await loadMonthlyStats();
                await loadPrescriptionStatusChart();
                await loadCharts();
            } catch (error) {
                console.error('Error loading dashboard:', error);
                alert('Có lỗi xảy ra khi tải dữ liệu dashboard');
            }
        }

        // Load tổng quan
        async function loadGeneralStats() {
            try {
                console.log('Loading general stats...');
                
                const [patientsResponse, prescriptionsResponse] = await Promise.all([
                    fetch(PATIENT_API, {
                        method: 'GET',
                        credentials: 'same-origin'
                    }),
                    fetch(PRESCRIPTION_API, {
                        method: 'GET',
                        credentials: 'same-origin'
                    })
                ]);

                console.log('Patient response status:', patientsResponse.status);
                console.log('Prescription response status:', prescriptionsResponse.status);

                if (!patientsResponse.ok || !prescriptionsResponse.ok) {
                    throw new Error(`API Error: Patient ${patientsResponse.status}, Prescription ${prescriptionsResponse.status}`);
                }

                const patientsData = await patientsResponse.json();
                const prescriptionsData = await prescriptionsResponse.json();

                console.log('Patients data:', patientsData);
                console.log('Prescriptions data:', prescriptionsData);

                document.getElementById('totalPatients').textContent = (patientsData.total || 0).toLocaleString();
                document.getElementById('totalPrescriptions').textContent = (prescriptionsData.total || 0).toLocaleString();
            } catch (error) {
                console.error('Error loading general stats:', error);
                document.getElementById('totalPatients').textContent = 'Error';
                document.getElementById('totalPrescriptions').textContent = 'Error';
            }
        }

        // Load thống kê tháng hiện tại
        async function loadMonthlyStats() {
            const currentYear = new Date().getFullYear();
            const currentMonth = new Date().getMonth() + 1;

            try {
                console.log('Loading monthly stats for:', currentYear, currentMonth);
                
                const [patientsResponse, prescriptionsResponse] = await Promise.all([
                    fetch(`${PATIENT_API}&year=${currentYear}&month=${currentMonth}`, {
                        method: 'GET',
                        credentials: 'same-origin'
                    }),
                    fetch(`${PRESCRIPTION_API}&year=${currentYear}&month=${currentMonth}`, {
                        method: 'GET',
                        credentials: 'same-origin'
                    })
                ]);

                console.log('Monthly patient response status:', patientsResponse.status);
                console.log('Monthly prescription response status:', prescriptionsResponse.status);

                const patientsData = await patientsResponse.json();
                const prescriptionsData = await prescriptionsResponse.json();

                console.log('Monthly patients data:', patientsData);
                console.log('Monthly prescriptions data:', prescriptionsData);

                document.getElementById('patientsThisMonth').textContent = (patientsData.monthly || 0).toLocaleString();
                document.getElementById('prescriptionsThisMonth').textContent = (prescriptionsData.monthly || 0).toLocaleString();
            } catch (error) {
                console.error('Error loading monthly stats:', error);
                document.getElementById('patientsThisMonth').textContent = 'Error';
                document.getElementById('prescriptionsThisMonth').textContent = 'Error';
            }
        }

        // Load biểu đồ trạng thái đơn thuốc
        async function loadPrescriptionStatusChart() {
            try {
                console.log('Loading prescription status chart...');
                const response = await fetch(PRESCRIPTION_API, {
                    method: 'GET',
                    credentials: 'same-origin'
                });
                
                console.log('Prescription status response status:', response.status);
                
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                
                const data = await response.json();
                console.log('Prescription status data:', data);

                const ctx = document.getElementById('prescriptionStatusChart').getContext('2d');
                
                if (prescriptionStatusChart) {
                    prescriptionStatusChart.destroy();
                }

                const statusData = data.status || {};
                const labels = Object.keys(statusData);
                const values = Object.values(statusData);

                console.log('Chart labels:', labels);
                console.log('Chart values:', values);

                prescriptionStatusChart = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: labels,
                        datasets: [{
                            data: values,
                            backgroundColor: [
                                '#FF6384',
                                '#36A2EB',
                                '#FFCE56',
                                '#4BC0C0',
                                '#9966FF'
                            ]
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }
                });
            } catch (error) {
                console.error('Error loading prescription status chart:', error);
            }
        }

        // Load biểu đồ 12 tháng
        async function loadCharts() {
            const year = document.getElementById('yearSelect').value;
            
            try {
                const response = await fetch(`${MONTHLY_REPORT_API}&year=${year}`, {
                    method: 'GET',
                    credentials: 'same-origin'
                });
                const data = await response.json();

                const months = [];
                const patientData = [];
                const prescriptionData = [];

                data.forEach(item => {
                    months.push(`Tháng ${item.month}`);
                    patientData.push(item.patients);
                    prescriptionData.push(item.prescriptions);
                });

                // Biểu đồ bệnh nhân
                const patientCtx = document.getElementById('patientChart').getContext('2d');
                if (patientChart) {
                    patientChart.destroy();
                }
                patientChart = new Chart(patientCtx, {
                    type: 'line',
                    data: {
                        labels: months,
                        datasets: [{
                            label: 'Số lượng bệnh nhân',
                            data: patientData,
                            borderColor: '#667eea',
                            backgroundColor: 'rgba(102, 126, 234, 0.1)',
                            borderWidth: 3,
                            fill: true,
                            tension: 0.4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });

                // Biểu đồ đơn thuốc
                const prescriptionCtx = document.getElementById('prescriptionChart').getContext('2d');
                if (prescriptionChart) {
                    prescriptionChart.destroy();
                }
                prescriptionChart = new Chart(prescriptionCtx, {
                    type: 'bar',
                    data: {
                        labels: months,
                        datasets: [{
                            label: 'Số lượng đơn thuốc',
                            data: prescriptionData,
                            backgroundColor: 'rgba(40, 167, 69, 0.8)',
                            borderColor: '#28a745',
                            borderWidth: 1,
                            borderRadius: 5
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            } catch (error) {
                console.error('Error loading charts:', error);
            }
        }

        // Cập nhật báo cáo
        async function updateReport() {
            const year = document.getElementById('yearSelect').value;
            const month = document.getElementById('monthSelect').value;

            // Show loading indicators
            document.getElementById('patientsThisMonth').innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            document.getElementById('prescriptionsThisMonth').innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            
            // Update month labels
            document.getElementById('currentMonthLabel').textContent = month;
            document.getElementById('currentMonthLabel2').textContent = month;

            try {
                const [patientsResponse, prescriptionsResponse] = await Promise.all([
                    fetch(`${PATIENT_API}&year=${year}&month=${month}`, {
                        method: 'GET',
                        credentials: 'same-origin'
                    }),
                    fetch(`${PRESCRIPTION_API}&year=${year}&month=${month}`, {
                        method: 'GET',
                        credentials: 'same-origin'
                    })
                ]);

                const patientsData = await patientsResponse.json();
                const prescriptionsData = await prescriptionsResponse.json();

                // Update monthly stats
                document.getElementById('patientsThisMonth').textContent = (patientsData.monthly || 0).toLocaleString();
                document.getElementById('prescriptionsThisMonth').textContent = (prescriptionsData.monthly || 0).toLocaleString();

                // Show success message
                const alert = document.createElement('div');
                alert.className = 'alert alert-success alert-dismissible fade show position-fixed';
                alert.style.top = '20px';
                alert.style.right = '20px';
                alert.style.zIndex = '9999';
                alert.innerHTML = `
                    <i class="fas fa-check-circle me-2"></i>
                    Đã cập nhật báo cáo cho tháng ${month}/${year}<br>
                    <small>Bệnh nhân: ${(patientsData.monthly || 0).toLocaleString()} | Đơn thuốc: ${(prescriptionsData.monthly || 0).toLocaleString()}</small>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                `;
                document.body.appendChild(alert);
                
                // Auto remove after 4 seconds
                setTimeout(() => {
                    if (alert.parentNode) {
                        alert.parentNode.removeChild(alert);
                    }
                }, 4000);

                // Reload charts for the selected year
                await loadCharts();
            } catch (error) {
                console.error('Error updating report:', error);
                
                // Reset to original values
                document.getElementById('patientsThisMonth').textContent = 'Error';
                document.getElementById('prescriptionsThisMonth').textContent = 'Error';
                
                // Show error message
                const alert = document.createElement('div');
                alert.className = 'alert alert-danger alert-dismissible fade show position-fixed';
                alert.style.top = '20px';
                alert.style.right = '20px';
                alert.style.zIndex = '9999';
                alert.innerHTML = `
                    <i class="fas fa-exclamation-circle me-2"></i>
                    Có lỗi xảy ra khi cập nhật báo cáo cho tháng ${month}/${year}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                `;
                document.body.appendChild(alert);
                
                // Auto remove after 5 seconds
                setTimeout(() => {
                    if (alert.parentNode) {
                        alert.parentNode.removeChild(alert);
                    }
                }, 5000);
            }
        }
    </script>
</body>
</html>
