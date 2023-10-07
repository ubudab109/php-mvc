<?= include('src/Views/layouts/header.php'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h5 class="text-center mb-5">Detail User</h5>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body p-5">
                    <form id="update_user" action="">
                        <div class="form-group">
                            <label for="">User Fullname</label>
                            <input type="text" name="name" id="name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">User Roles</label>
                            <select id="roles-select" placeholder="Select upto 5 roles" multiple>
                                <?php foreach($roles as $role): ?>
                                    <option value="<?= $role['id'] ?>"><?= $role['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <a href="/" class="btn btn-secondary">Back</a>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        var multipleCancelButton = new Choices('#roles-select', {
            removeItemButton: true,
            maxItemCount: 5,
            searchResultLimit: 5,
            renderChoiceLimit: 5
        });

        $("#update_user").submit(async (e) => {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: '/add-users',
                data: {
                    name: $("#name").val(),
                    roles: $("#roles-select").val()
                },
                success: (res) => {
                    console.log(res);
                    const response = JSON.parse(res);
                    if (response.code === 500) {
                        alert(response.message);
                    } else {
                        alert(response.message);
                        window.location.href = "/";
                    }
                }
            })
        })
    });
</script>
<?= include('src/Views/layouts/footer.php'); ?>