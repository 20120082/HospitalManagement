<?php include_once 'views/layouts/header.php'; ?>

<div class="container mt-5">
    <h2 class="mb-4">Tạo Bệnh Án Mới</h2>

    <?php if (isset($error)) : ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="index.php?controller=MedicalRecord&action=create">
        <div>
            <!-- Bệnh nhân -->
            <label for="patientSelect">Bệnh nhân</label>
            <select id="patientSelect" onchange="fillPatientFields()" required>
                <option value="">-- Chọn bệnh nhân --</option>
                <?php foreach ($patients as $patient): ?>
                    <option value="<?= htmlspecialchars($patient['patientId']) ?>"
                        data-name="<?= htmlspecialchars($patient['fullName']) ?>">
                        <?= htmlspecialchars($patient['patientId']) ?> - <?= htmlspecialchars($patient['fullName']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <!-- Các trường sẽ được điền tự động -->
            <label for="patientId">Mã bệnh nhân</label>
            <input type="text" name="patientId" id="patientId" readonly required>

            <label for="fullName">Họ tên bệnh nhân</label>
            <input type="text" name="fullName" id="fullName" readonly required>
        </div>

        <div>
            <!-- Phòng khám -->
            <label for="roomSelect">Phòng khám</label>
            <select id="roomSelect" onchange="fillRoomFields()" required>
                <option value="">-- Chọn phòng khám --</option>
                <?php foreach ($rooms as $room): ?>
                    <option value="<?= htmlspecialchars($room['roomId']) ?>"
                        data-name="<?= htmlspecialchars($room['roomName']) ?>">
                        <?= htmlspecialchars($room['roomId']) ?> - <?= htmlspecialchars($room['roomName']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <!-- Các trường sẽ được điền tự động -->
            <label for="roomId">Mã phòng</label>
            <input type="text" name="roomId" id="roomId" readonly required>

            <label for="roomName">Tên phòng</label>
            <input type="text" name="roomName" id="roomName" readonly required>
        </div>

        <div>
            <!-- Bác sĩ -->
            <label for="doctorSelect">Bác sĩ</label>
            <select id="doctorSelect" onchange="fillDoctorFields()" required>
                <option value="">-- Chọn bác sĩ --</option>
                <?php foreach ($doctors as $doctor): ?>
                    <option value="<?= htmlspecialchars($doctor['id']) ?>"
                        data-name="<?= htmlspecialchars($doctor['name']) ?>">
                        <?= htmlspecialchars($doctor['id']) ?> - <?= htmlspecialchars($doctor['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <!-- Các trường sẽ được điền tự động -->
            <label for="doctorId">Mã bác sĩ</label>
            <input type="text" name="doctorId" id="doctorId" readonly required>

            <label for="doctorName">Tên bác sĩ</label>
            <input type="text" name="doctorName" id="doctorName" readonly required>
        </div>


        <script>
            function fillPatientFields() {
                const select = document.getElementById('patientSelect');
                const selected = select.options[select.selectedIndex];
                document.getElementById('patientId').value = selected.value;
                document.getElementById('fullName').value = selected.getAttribute('data-name') || '';
            }

            function fillRoomFields() {
                const select = document.getElementById('roomSelect');
                const selected = select.options[select.selectedIndex];
                document.getElementById('roomId').value = selected.value;
                document.getElementById('roomName').value = selected.getAttribute('data-name') || '';
            }

            function fillDoctorFields() {
                const select = document.getElementById('doctorSelect');
                const selected = select.options[select.selectedIndex];
                document.getElementById('doctorId').value = selected.value;
                document.getElementById('doctorName').value = selected.getAttribute('data-name') || '';
            }
        </script>




        <div class="form-group">
            <label for="diagnosis">Chẩn Đoán</label>
            <textarea name="diagnosis" id="diagnosis" class="form-control" rows="3"></textarea>
        </div>

        <div class="form-group">
            <label for="treatment">Phác Đồ Điều Trị</label>
            <textarea name="treatment" id="treatment" class="form-control" rows="3"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Tạo Bệnh Án</button>
        <a href="index.php?controller=MedicalRecord&action=listPage" class="btn btn-secondary">Quay về</a>
    </form>
</div>

<?php include_once 'views/layouts/footer.php'; ?>