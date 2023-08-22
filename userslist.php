<?php
include('db_connect.php');
if (isset($_GET['id'])) {
    $user = $conn->query("SELECT * FROM users where id =" . $_GET['id']);
    foreach ($user->fetch_array() as $k => $v) {
        $meta[$k] = $v;
    }
}
?>

<style>
.folder-item {
    cursor: pointer;
}

.user-card {
    border: 1px solid #ccc;
    padding: 15px;
    margin: 10px;
    border-radius: 5px;
    box-shadow: 3px 3px 5px rgb(15 182 237 / 71%);
    transition: box-shadow 0.3s cubic-bezier(0, -1.49, 1, 0.3);
}

.user-card:hover {
    box-shadow: 3px 3px 5px rgb(243 9 146 / 84%);
    transition: box-shadow 0.3s cubic-bezier(0, -1.49, 1, 0.3);
}

.user-card img {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    object-fit: cover;
    margin-bottom: 10px;
}

.user-card .btn {
    margin-top: 10px;
}
</style>
<br>
<div class="container-fluid">
    <div class="col-lg-12">
        <!-- <div class="pagetitle">
            <h1>Manage Users</h1>
        </div>End Page Title -->
        
		<div class="button-container d-flex align-items-center">
			<button class="btn btn-primary btn-sm mr-2" id="new_user"><i class="bi bi-plus"></i> New User</button>
			<div class="col-md-4 input-group ml-auto">
				<input type="text" class="form-control" id="search" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
				<div class="input-group-append">
					<span class="input-group-text" id="inputGroup-sizing-sm"><i class="bi bi-search"></i></span>
				</div>
			</div>
		</div>
        <hr>
        <section class="section dashboard">
			<h5><b>Users</b></h5>
			<div class="row">
				<?php
				$users = $conn->query("SELECT * FROM users");
				while ($row = $users->fetch_assoc()):
				?>
				<div class="col-xxl-3 col-md-6 folder-item" data-id="<?php echo $row['id'] ?>">
					<div class="card info-card revenue-card">
						<div class="user-card">
							<img src="assets/img/profiles/<?php echo $row['profile_image'] ?>" alt="Profile" class="rounded-circle">
							<h6><?php echo $row['username'] ?></h6>
							<hr>
							<p><span class="text-muted small pt-2 ps-1">Fullname: </span>
							<span class="text-success small pt-1 fw-bold"><?php echo $row['name'] ?></span><p>
							<p><span class="text-muted small pt-2 ps-1">Address: </span>
							<span class="text-success small pt-1 fw-bold"><?php echo $row['adress'] ?></span></p>
							<p><span class="text-muted small pt-2 ps-1">Email </span>
							<span class="text-success small pt-1 fw-bold"><?php echo $row['email'] ?></span></p>
							<div class="float-right">
								<button class="mr-1 btn btn-primary edit_user" data-id="<?php echo $row['id'] ?>"><i class="bi bi-pen-fill mr-2"></i>Edit</button>
								<button class="btn btn-danger delete" data-id="<?php echo $row['id'] ?>"><i class="bi bi-trash-fill mr-2"></i>Delete</button>
							</div>
						</div>
					</div>
				</div>
				<?php endwhile; ?>
			</div>
		</section>	
    </div>
</div>

<script>

	$(document).ready(function() {    
        $('#search').keyup(function() {
            var searchTerm = $(this).val().toLowerCase();

            // Filter users
            $('.user-card').each(function() {
                var userName = $(this).find('h6').text().toLowerCase();
                $(this).parent().parent().toggle(userName.includes(searchTerm));
            });
        });
    })
	
    $('#new_user').click(function(){
        uni_modal('New User','manage_user.php')
    })
    $('.edit_user').click(function(){
        uni_modal('Edit User','manage_user.php?id='+$(this).attr('data-id'))
    })
    
    window.confirm = function ($msg = '', $func = '', $params = []) {
        $('#confirm_modal #confirm').attr('onclick', $func + "(" + $params.join(',') + ")");
        $('#confirm_modal .modal-body').html($msg);
        $('#confirm_modal').modal('show');
    };

    $('.delete').click(function (e) {
    e.preventDefault();
    var userId = $(this).attr('data-id');
    confirm("Are you sure to delete this user?", "delete_user", [userId]);
	});

    function delete_user(userId) {
        $.ajax({
            url: 'ajax.php?action=delete_user',
            method: 'POST',
            data: {
                action: 'delete_user',
                id: userId
            },
            success: function (response) {
                if (response === '1') {
                    alert_toast("Data successfully saved", 'success');
                    setTimeout(function(){
                        location.reload();
                    }, 1500);
                }
            }
        });
    }

</script>
