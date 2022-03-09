<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>

<div class="container">
    <h3>User List</h3><br>
    <div class="row">

        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered datatbl2" id="userDatatbl">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Full Name</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
           
                    </tbody>
                </table>
            </div>

        </div>
    </div><br>

    <script>
        $(window.document).on('click', '.delete-banner', function() {
            var userId = $(this).attr('data-user');
            if (confirm('Are you sure to delete this item ?')) {
                $.ajax({
                    url: "<?= base_url(route_to('banner_remove')) ?>",
                    type: 'post',
                    data: {
                        'remId': userId
                    },
                    success: function(data) {
                        alert(data);
                        window.location.reload();
                    }
                });
            }
        });


        $(document).ready(function() {
            $('.datatbl').DataTable();

            //***********************  Banner DataTable Script ********************
            $("#userDatatbl").DataTable({
                processing: true,
                serverSide: true,
                serverMethod: "post",
                autoWidth: false,
                sPaginationType: "full_numbers",
                ajax: {
                    url: "<?=base_url('Home/getUsersDatatable')?>",
                },
                aoColumnDefs: [{
                    bSortable: false,
                    aTargets: [5]
                }],
                columns: [
                    {
                        data: "id"
                    },
                    {
                        data: "name"
                    },
                    {
                        data: "username"
                    },
                    {
                        data: "email"
                    },
                    {
                        data: "image_gallery"
                    },                    
                    {
                        data: "action"
                    },
                ],
            });
        });
    </script>


    </body>

    </html>