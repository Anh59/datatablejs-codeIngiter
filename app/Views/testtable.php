<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/v/dt/jqc-1.12.4/dt-2.0.7/b-3.0.2/sl-2.0.2/datatables.min.css" />
    <link rel="stylesheet" href="Editor-PHP-2.3.2/css/editor.dataTables.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/datetime/1.5.2/css/dataTables.dateTime.min.css">
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

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> <!-- Thêm thư viện jQuery -->
    <script src="https://cdn.datatables.net/v/dt/jqc-1.12.4/dt-2.0.7/b-3.0.2/sl-2.0.2/datatables.min.js"></script>
    <script src="Editor-PHP-2.3.2/js/dataTables.editor.js"></script>
    <script src="https://cdn.datatables.net/datetime/1.5.2/js/dataTables.dateTime.min.js"></script>

    <script>
        $(document).ready(function() {
            // Khởi tạo DataTable
             var editor = new $.fn.dataTable.Editor({
                ajax:{
                    url: '<?= base_url('update') ?>',
                    type: 'POST',
                },
                table: '#table',
                idSrc: 'id',
                fields: [
                    { label: 'id', name: 'id' },
                    { label: 'Email', name: 'email' },
                    { label: 'User name', name: 'username' },
                    { label: 'Pass Word', name: 'password' },
                    { label: 'Otp', name: 'otp' },
                    { label: 'status', name: 'status' }
                ]
            });
            
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
                    { data: 'id' },
                    { data: 'email' },
                    { data: 'username' },
                    { data: 'password' },
                    { data: 'otp' },
                    { data: 'status' }
                ]
            });

            // Khởi tạo Editor
           

            // Thêm sự kiện click vào mỗi ô của bảng để kích hoạt chỉnh sửa trực tiếp
            $('#table').on('click', 'tbody td:not(:first-child)', function() {
                editor.inline(this);
            });
        });
    </script>
</body>
</html>
