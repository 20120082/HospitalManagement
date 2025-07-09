$(document).ready(function() {
    $('#reportForm').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: '/service4/report/generate',
            method: 'POST',
            data: $(this).serialize(),
            success: function(data) {
                $('#reportResult').html(`Kết quả: ${data.count} ${data.type === 'patient_count' ? 'bệnh nhân' : 'đơn thuốc'}`);
                $.get('/service4/report/list', function(data) {
                    $('#reportTable').html(data);
                });
            },
            error: function(xhr) {
                $('#reportResult').html('Lỗi: ' + (xhr.responseJSON?.error || 'Không thể tạo báo cáo'));
            }
        });
    });
});