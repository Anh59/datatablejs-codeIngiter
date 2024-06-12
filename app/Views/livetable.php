<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.0.8/css/buttons.dataTables.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.0.8/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.0.8/js/buttons.html5.min.js"></script>
</head>
<body>
    <h1>Datatable js</h1>
    <table id="table" class="display" style="width:100%">
        <thead>
            <tr>
                <th>id</th>
                <th>Email</th>
                <th>User name</th>
                <th>Pass Word</th>
                <th>Otp</th>
                <th>status</th>
            </tr>
        </thead>
    </table>

    <script>
        $(document).ready(function() {
            // Khởi tạo DataTable
            const table = $('#table').DataTable({
                ajax: {
                    url: '<?= base_url('livedatatable') ?>',
                    type: 'GET',
                },
                processing: true,
                serverSide: true,
                searching: true,
                ordering: true,
                paging: true,
                columns: [
                    { data: 'id' },
                    { data: 'email' },
                    { data: 'username' },
                    { data: 'password' },
                    { data: 'otp' },
                    { data: 'status' }
                ]
            });

            // Thêm sự kiện click vào mỗi dòng của bảng
            $('#table').on('click', 'tbody tr', function() {
                const rowData = table.row(this).data();
                const id = rowData.id;

                // Sửa dữ liệu
                const newEmail = prompt('Enter new email:', rowData.email);
                const newUsername = prompt('Enter new username:', rowData.username);
                const newPassword = prompt('Enter new password:', rowData.password);
                const newOtp = prompt('Enter new OTP:', rowData.otp);
                const newStatus = prompt('Enter new status:', rowData.status);

                if (newEmail !== null && newUsername !== null && newPassword !== null && newOtp !== null && newStatus !== null) {
                    // Tạo object chứa dữ liệu mới
                    const newData = {
                        id: id,
                        email: newEmail,
                        username: newUsername,
                        password: newPassword,
                        otp: newOtp,
                        status: newStatus
                    };

                    // Gửi yêu cầu cập nhật thông qua AJAX
                    $.ajax({
                        url: '<?= base_url('table/updateDataByAjax') ?>',
                        type: 'POST',
                        data: { data: { [id]: newData } }, // Định dạng lại dữ liệu gửi đi
                        
                        success: function (response) {
                            if (response.status === 'success') {
                                alert('Data updated successfully!');
                                table.ajax.reload(null, false);
                            } else {
                                alert('Failed to update data!');
                            }
                        },
                        error: function () {
                            alert('Error occurred while updating data!');
                        }
                    });
                }
            });

            // Thêm sự kiện click vào nút xóa
            $('#table').on('dblclick', 'tbody tr', function() {
                const rowData = table.row(this).data();
                const id = rowData.id;

                if (confirm('Are you sure you want to delete this record?')) {
                    // Gửi yêu cầu xóa thông qua AJAX
                    $.ajax({
                        url: '<?= base_url('table/deleteDataByAjax') ?>',
                        type: 'POST',
                        data: { data: { [id]: {} } }, // Định dạng lại dữ liệu gửi đi
                        success: function (response) {
                            if (response.status === 'success') {
                                alert('Data deleted successfully!');
                                table.ajax.reload(null, false);
                            } else {
                                alert('Failed to delete data!');
                            }
                        },
                        error: function () {
                            alert('Error occurred while deleting data!');
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>
