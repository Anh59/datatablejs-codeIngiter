<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
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
            const table = $('#table').DataTable({
                ajax: {
                    url: '<?= base_url('listtable') ?>',
                    type: 'GET',
                },
                processing: true,
                serverSide: true,
                searching: true,
                ordering: true,
                paging: true,
                columns: [
                    { "data": 'id' },
                    { "data": 'email' },
                    { "data": 'username' },
                    { "data": 'password' },
                    { "data": 'otp' },
                    { "data": 'status' }
                ],
              
            });

            // Thêm sự kiện click vào mỗi ô của bảng để kích hoạt chỉnh sửa trực tiếp
            // $('#table').on('click', 'tbody td:not(:first-child)', function() {
            //     const cell = table.cell(this);
            //     // Giả sử cell.edit() là một phương thức tùy chỉnh để chỉnh sửa
            //     if (cell.edit) {
            //         cell.edit();
            //     } else {
            //         console.log('Chức năng chỉnh sửa chưa được định nghĩa');
            //     }
            // });
        });
    </script>
</body>
</html>
