<div class="container-fluid">
    <h1 class="dash-title">Trang chủ / Tài khoản</h1>
    <div class="row">
        <div class="col-lg-12">
            <?= view('messages/message')?>
            <div class="card easion-card">
                <div class="card-header">
                    <div class="easion-card-icon">
                        <i class="fas fa-table"></i>
                    </div>
                    <div class="easion-card-title">Danh sách tài khoản</div>
                </div>
                <div class="card-body ">
                    <table id="datatable" class="cell-border" width="100%">
                        <thead>
                            <tr>
                                <th scope="col">id</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <!-- <th scope="col">Chức Năng</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($users as $user): ?>
                            <tr>
                                <td><?= $user['id']?></td>
                                <td><?= $user['name']?></td>
                                <td><?= $user['email']?></td>
                                <!-- <td class="text-center">
                                    <a href="admin/user/edit/<?= $user['id']?>" class="btn btn-primary"><i class="fas fa-edit" name="btn-edit"></i></a>
                                    <a data-url="<?= base_url()?>admin/user/delete/<?= $user['id']?>" class="btn btn-danger btn-del-confirm"><i
                                            class="far fa-trash-alt"></i></a>
                                </td> -->
                            </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
    $('#datatable').DataTable({
        "language": {
            "lengthMenu": "Hiển thị _MENU_ dòng",
            "zeroRecords": "Không có dữ liệu",
            "info": "Hiển thị trang _PAGE_ trên _PAGES_ trang",
            "infoEmpty": "Không có dữ liệu",
            "search": "Tìm kiếm: ",
            paginate: {
                previous: '‹',
                next: '›'
            },
        },
        columns:[
            {data: 'id'},
            {data: 'name'},
            {data: 'email'}
        ]
    });

    const editor = new $.fn.dataTable.Editor({
        ajax: [
            {
                type: "PUT",
                url: "<?=base_url('admin/user/update')?> " + "_id_",
                datatype: "JSON"
            },
        ],
        idSrc:  'id',
        table: '#datatable',
        fields: [
            {
                label: 'Name:',
                name: 'name',
            },
{
                label: 'Email:',
                name: 'email'
            },
        ],
    });

    const table = new DataTable('#datatable', {
        retrieve: true,
        paging: false,
        ajax: '',
        columns: [
            {
                data: null,
                orderable: false,
                render: DataTable.render.select()
            },
            { data: 'name' },
            { data: 'email' },
        ],
        layout: {
            topStart: {
                buttons: [
                    { extend: 'create', editor: editor },
                    { extend: 'edit', editor: editor },
                    { extend: 'remove', editor: editor }
                ]
            }
        },
        order: [[1, 'asc']],
        select: {
            style: 'os',
            selector: 'td:first-child'
        }
    });
    table.on('click', 'tbody td:not(:first-child)', function (e) {  
        editor.inline(this);
    });
});

</script>