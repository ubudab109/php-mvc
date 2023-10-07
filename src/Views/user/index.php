<?= include('src/Views/layouts/header.php'); ?>
<div class="container-fluid">
    <!-- Modal Create Role-->
    <div class="modal fade" id="modalCreateRole" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createRoleButton">Create Role</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="create_role">
                        <div class="form-group">
                            <input type="text" name="name" id="name-role" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Role-->
    <div class="modal fade" id="modalUpdateRole" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createRoleButton">Update Role</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="update_role">
                        <div class="form-group">
                            <input type="text" name="name" id="name-role-update" class="form-control">
                            <input type="hidden" name="id_role" id="id_role">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-12">
            <h5 class="text-center mb-5">User and Roles Data</h5>
        </div>
        <div class="col-12">
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <h5 class="mb-5">User Data</h5>
                                <a href="/create-users" class="btn btn-primary mb-5">Add User</a>
                                <table id="tabel-data" class="table table-stripped">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Id</th>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Roles</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($users as $user): ?>
                                        <tr>
                                            <td class="text-center"><?= $user['id'] ?></td>
                                            <td class="text-center"><?= $user['name'] ?></td>
                                            <td class="text-center">
                                                <?php foreach($user['roles'] as $role): ?>
                                                <span class="badge badge-secondary"><?= $role['name'] ?></span>
                                                <?php endforeach; ?>
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-danger"
                                                    onclick="deleteUser('<?= $user['id'] ?>')">Delete</button>
                                                <a href="/detail-users?id=<?= $user['id'] ?>" class="btn btn-warning">Edit</a>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">

                                <h5 class="mb-5">Role Data</h5>
                                <button type="button" class="btn btn-primary mb-5" data-toggle="modal"
                                    data-target="#modalCreateRole">Add Roles</button>

                                <table id="tabel-data-role" class="table table-stripped">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Id</th>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($roles as $role): ?>
                                        <tr>
                                            <td class="text-center"><?= $role['id'] ?></td>
                                            <td class="text-center"><?= $role['name'] ?></td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-danger"
                                                    onclick="deleteRole('<?= $role['id'] ?>')">Delete</button>
                                                <button type="button" class="btn btn-warning"
                                                    onclick="detailRole('<?= $role['id'] ?>', '<?= $role['name'] ?>')">Edit</button>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</script>
<script>
    $(document).ready(function () {
        var tableUser = $('#tabel-data').DataTable({
            processing: true,
        });
        var tableRole = $('#tabel-data-role').DataTable({
            processing: true,
        });
        $("#create_role").submit(async (e) => {
            e.preventDefault();
            await $.ajax({
                url: '/add-roles',
                type: 'POST',
                data: {
                    name: $("#name-role").val(),
                },
                success: (res) => {
                    const response = JSON.parse(res);
                    if (response.code === 500) {
                        alert(response.message);
                    } else {
                        alert(response.message);
                        window.location.reload();
                    }
                },
            })
        });
        $("#modalUpdateRole").submit(async (e) => {
            e.preventDefault();
            const name = $("#name-role-update").val();
            const id = $("#id_role").val();
            $.ajax({
                type: 'POST',
                url: '/update-roles',
                data: {
                    id: id,
                    name: name,
                },
                success: (res) => {
                    const response = JSON.parse(res);
                    if (response.code === 500) {
                        alert(
                            'Failed to edit data. Check if data is exists. You can reload this page');
                    } else {
                        alert(response.message);
                        window.location.reload();
                    }
                }
            })
        })
    });

    async function deleteRole(id) {
        if (confirm('Want to delete this data?')) {
            await $.ajax({
                url: '/delete-roles',
                type: 'post',
                data: {
                    id: id,
                },
                success: (res) => {
                    const response = JSON.parse(res);
                    if (response.code === 500) {
                        alert(
                            'Failed to delete data. Check if data is exists. You can reload this page');
                    } else {
                        alert(response.message);
                        window.location.reload();
                    }
                }
            });
        } else {
            return false;
        }
    }

    async function deleteUser(id) {
        if (confirm('Want to delete this data?')) {
            await $.ajax({
                url: '/delete-users',
                type: 'post',
                data: {
                    id: id,
                },
                success: (res) => {
                    const response = JSON.parse(res);
                    if (response.code === 500) {
                        alert(
                            'Failed to delete data. Check if data is exists. You can reload this page');
                    } else {
                        alert(response.message);
                        window.location.reload();
                    }
                }
            });
        } else {
            return false;
        }
    }

    async function detailRole(id, name) {
        $("#modalUpdateRole").modal('show');
        $("#name-role-update").val(name);
        $("#id_role").val(id);
    }
</script>
<?= include('src/Views/layouts/footer.php'); ?>