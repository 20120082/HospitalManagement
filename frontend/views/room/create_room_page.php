<?php include_once 'views/layouts/header.php'; ?>

<div class="container mt-5">
    <h2 class="mb-4">Tạo Phòng Khám Mới</h2>

    <?php if (isset($error)) : ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="index.php?controller=Room&action=create">
        <div class="form-group">
            <label for="roomName">Tên Phòng</label>
            <input type="text" name="roomName" id="roomName" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="department">Phòng Ban</label>
            <input type="text" name="department" id="department" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="doctorId">Chọn Bác Sĩ</label>
            <select name="doctorId" id="doctorId" class="form-control" required>
                <option value="">-- Chọn bác sĩ --</option>
                <?php foreach ($doctors as $doctor): ?>
                    <option value="<?= $doctor['id'] ?>" data-name="<?= $doctor['fullName'] ?>">
                        <?= $doctor['fullName'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="doctorName">Tên Bác Sĩ</label>
            <input type="text" name="doctorName" id="doctorName" class="form-control" readonly>
        </div>


        <button type="submit" class="btn btn-primary">Tạo Phòng</button>
        <a href="index.php?controller=Room&action=listPage" class="btn btn-secondary">Quay về</a>
    </form>
    <script>
    const doctorSelect = document.getElementById("doctorId");
    const doctorNameInput = document.getElementById("doctorName");

    doctorSelect.addEventListener("change", function () {
        const doctorId = this.value;
        if (doctorId) {
            fetch(`index.php?controller=Room&action=fetchDoctorInfo&id=${doctorId}`)
                .then(response => response.json())
                .then(data => {
                    doctorNameInput.value = data.fullName || "Không rõ";
                })
                .catch(() => {
                    doctorNameInput.value = "Không tìm thấy bác sĩ";
                });
        } else {
            doctorNameInput.value = "";
        }
    });
</script>



</div>

<?php include_once 'views/layouts/footer.php'; ?>