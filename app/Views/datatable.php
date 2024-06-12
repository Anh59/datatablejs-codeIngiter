<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=2.0">
 
    <title>Students Table</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/v/dt/jqc-1.12.4/dt-2.0.7/b-3.0.2/sl-2.0.2/datatables.min.css" />
    <link rel="stylesheet" href="Editor-PHP-2.3.2/css/editor.dataTables.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/datetime/1.5.2/css/dataTables.dateTime.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> <!-- Thêm thư viện jQuery -->
    <script src="https://cdn.datatables.net/v/dt/jqc-1.12.4/dt-2.0.7/b-3.0.2/sl-2.0.2/datatables.min.js"></script>
    <script src="Editor-PHP-2.3.2/js/dataTables.editor.js"></script>
    <script src="https://cdn.datatables.net/datetime/1.5.2/js/dataTables.dateTime.min.js"></script>
 
    <script type="text/javascript" language="javascript" class="init">
 
 $(document).ready(function() {
    // var editor = new DataTable.Editor
    var editor = new $.fn.dataTable.Editor({
        ajax: {
            create: {
                type: 'POST',
                url: '<?= base_url('create'); ?>' 
            },
            edit: {
                type: 'PUT',
                url: '<?= base_url('update'); ?>'+'/_id_'
                
            },
            remove: {
                type: 'DELETE',
                url: '<?= base_url('delete'); ?>'+'/_id_'
            }
        },
        table: '#table',
        idSrc: "id",
        fields: [
            { label: 'id', name: 'id' },
            { label: 'Email', name: 'email' },
            { label: 'User name', name: 'username' },
            { label: 'Pass Word', name: 'password' },
            { label: 'Otp', name: 'otp' },
            { label: 'status', name: 'status' }
        ]
    });

    $('#table').DataTable({
        dom: "Tfrtip",
        processing: true,
        ajax: {
            url: "<?= base_url('listtable'); ?>",
            type: "GET",
        },
        serverSide: true,    
        columns: [
                {
                data: null,
                orderable: false,
                render: DataTable.render.select()
            },
            { data: 'id' },
            { data: 'email' },
            { data: 'username' },
            { data: 'password' },
            { data: 'otp' },
            { data: 'status' },
            { 
                data: null, 
                render: function (data, type, row) {
                    return '<button class="btn btn-danger btn-sm delete-btn" data-id="' + row.id + '">Delete</button>';
                }
            }
            
        ],
        searching: true,
        order: [[1, 'asc']],
        tableTools: {
            sRowSelect: "os",
            sSwfPath: "<?= base_url(); ?>dist/swf/copy_csv_xls_pdf.swf",
            aButtons: [
                { sExtends: "editor_create", editor: editor },
                { sExtends: "editor_edit", editor: editor },
                { sExtends: "editor_remove", editor: editor },
                {
                    sExtends: "collection",
                    sButtonText: "Save As",
                    sButtonClass: "save-collection",
                    aButtons: ['copy', 'csv', 'xls', 'pdf']
                },
               
            ]
        }
    });
                $('#table').on('click', 'tbody td:not(:first-child)', function(e) {
                            editor.inline(this);
                        });

                $('#table').on('click', '.delete-btn', function () {
                            var id = $(this).data('id');
                            if (confirm("Are you sure you want to delete this record?")) {
                                $.ajax({
                                    url: '/delete/' + id, // Đường dẫn đến phương thức xóa trong Controller
                                    type: 'DELETE',
                                    success: function (response) {
                                        // Xóa dòng từ bảng trên giao diện nếu xóa thành công
                                        $('#table').DataTable().row($(this).parents('tr')).remove().draw();
                                    },
                                    error: function (xhr, status, error) {
                                        console.error(error);
                                    }
                                });
                            }
                        });

});

 
    </script>
 
</head>
 
<body class="editor wide comments example">
    <div class="container">
        <section>
            <h1>Students Table</span></h1>
                <div id="example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                    <table id="table" class="table table-striped table-bordered table-responsive" cellspacing="0" width="100%">
                        <thead>
                            <tr>    
                                    <th></th>
                                    <th>id</th>
                                    <th>Email</th>
                                    <th>User name</th>
                                    <th>Pass Word</th>
                                    <th>Otp</th>
                                    <th>status</th>
                                    <th>Action</th>

                            </tr>
                        </thead>
                  
                        <tfoot>
                            <tr>
                                <th></th>
                                <th>id</th>
                                <th>Email</th>
                                <th>User name</th>
                                <th>Pass Word</th>
                                <th>Otp</th>
                                <th>status</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
        </section>
    </div>
</body>
</html>