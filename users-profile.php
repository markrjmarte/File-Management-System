
    
<?php 
include('db_connect.php');

if(isset($_SESSION['login_id'])){
    $user_id = $_SESSION['login_id'];
    $user = $conn->query("SELECT * FROM users WHERE id = $user_id");
    if($user && $user->num_rows > 0) {
        $meta = $user->fetch_assoc();
    }
}

if(isset($_POST['update_user'])) {
    $user_id = $_POST['id'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $name = $_POST['name'];
    $job = $_POST['job'];
    $adress = $_POST['adress'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $about = $_POST['about'];

    // Update user data in the database
    $update_query = "UPDATE users SET username = '$username', password = '$password', name = '$name', job = '$job', adress = '$adress', phone = '$phone', email = '$email', about = '$about' WHERE id = $user_id";
    $conn->query($update_query);

    // Update user data in the session
    $_SESSION['login_name'] = $name;
    $_SESSION['login_job'] = $job;
    $_SESSION['login_adress'] = $adress;
    $_SESSION['login_phone'] = $phone;
    $_SESSION['login_email'] = $email;
    $_SESSION['login_about'] = $about;

    echo 1; // Return success status
    exit();
}
?>
    
<div class="container-fluid">

<div class="pagetitle">
      <h1>Profile</h1>
    </div><!-- End Page Title -->

    <section class="section profile">
      <div class="row">
        <div class="col-xl-4">
          <div class="card">
              <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                <img src="assets/img/profiles/<?php echo $_SESSION['login_profile_image'] ?>" alt="Profile" class="rounded-circle">
                <h2><?php echo $_SESSION['login_name'] ?></h2>
                <h3><?php echo $_SESSION['login_job'] ?></h3>
              </div>
          </div>
        </div>

        <div class="col-xl-8">

          <div class="card">
            <div class="card-body pt-3">
              <!-- Bordered Tabs -->
              <ul class="nav nav-tabs nav-tabs-bordered">

                <li class="nav-item">
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
                </li>
                
              </ul>
              <div class="tab-content pt-2">

                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                  <h5 class="card-title">About</h5>
                  <p class="small fst-italic"><?php echo $_SESSION['login_about'] ?></p> 

                  <h5 class="card-title">Profile Details</h5>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label ">Full Name</div>
                    <div class="col-lg-9 col-md-8"><?php echo $_SESSION['login_name'] ?></div> 
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Job</div>
                    <div class="col-lg-9 col-md-8"><?php echo $_SESSION['login_job'] ?></div> 
                  </div>
                  
                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Address</div>
                    <div class="col-lg-9 col-md-8"><?php echo $_SESSION['login_adress'] ?></div> 
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Phone</div>
                    <div class="col-lg-9 col-md-8"><?php echo $_SESSION['login_phone'] ?></div> 
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Email</div>
                    <div class="col-lg-9 col-md-8"><?php echo $_SESSION['login_email'] ?></div> 
                  </div>

                </div>

                <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
                  <!-- Profile Edit Form -->
                  <form action="" id="update-user">
                    <input type="hidden" name="id" value="<?php echo isset($meta['id']) ? $meta['id'] : ''; ?>">

                    <div class="row mb-3">
                        <label for="profile_image" class="col-md-4 col-lg-3 col-form-label">Profile Image</label>
                        <div class="col-md-8 col-lg-9">
                          <div class = "preview">
                            <img src="" id = "img" alt = "Preview" style = "width: 100%; height: 100%">
                          </div>
                          <input type="file" name="profile_image" id="profile_image" class="form-control-file">
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="about" class="col-md-4 col-lg-3 col-form-label">About</label>
                        <div class="col-md-8 col-lg-9">
                          <textarea name="about" class="form-control" id="about" style="height: 100px"><?php echo isset($meta['about']) ? $meta['about']: '' ?></textarea> 
                        </div>
                      </div>

                      <div class="form-group row mb-3">
                        <label for="name" class="col-md-4 col-lg-3 col-form-label">Username</label>
                        <div class="col-md-8 col-lg-9">
                        <input type="text" name="username" id="username" class="form-control" value="<?php echo isset($meta['username']) ? $meta['username']: '' ?>" required> 
                        </div>
                      </div>

                      <div class="form-group row mb-3">
                      <label for="name" class="col-md-4 col-lg-3 col-form-label">Passowrd</label>
                        <div class="col-md-8 col-lg-9">
                        <input type="password" name="password" id="password" class="form-control" value="<?php echo isset($meta['password']) ? $meta['password']: '' ?>" required>
                        </div>
                      </div>

                      <div class="form-group row mb-3">
                        <label for="name" class="col-md-4 col-lg-3 col-form-label">Full Name</label>
                        <div class="col-md-8 col-lg-9">
                          <input name="name" type="text" class="form-control" id="name" value="<?php echo isset($meta['name']) ? $meta['name']: '' ?>"> 
                        </div>
                      </div>

                      <div class="form-group row mb-3">
                        <label for="job" class="col-md-4 col-lg-3 col-form-label">Job</label>
                        <div class="col-md-8 col-lg-9">
                          <input name="job" type="text" class="form-control" id="job" value="<?php echo isset($meta['job']) ? $meta['job']: '' ?>"> 
                        </div>
                      </div>

                      <div class="form-group row mb-3">
                        <label for="adress" class="col-md-4 col-lg-3 col-form-label">Address</label>
                        <div class="col-md-8 col-lg-9">
                          <input name="adress" type="text" class="form-control" id="adress" value="<?php echo isset($meta['adress']) ? $meta['adress']: '' ?>"> 
                        </div>
                      </div>

                      <div class="form-group row mb-3">
                        <label for="phone" class="col-md-4 col-lg-3 col-form-label">Phone</label>
                        <div class="col-md-8 col-lg-9">
                          <input name="phone" type="text" class="form-control" id="phone" value="<?php echo isset($meta['phone']) ? $meta['phone']: '' ?>">  
                        </div>
                      </div>

                      <div class="form-group row mb-3">
                        <label for="email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                        <div class="col-md-8 col-lg-9">
                          <input name="email" type="email" class="form-control" id="email" value="<?php echo isset($meta['email']) ? $meta['email']: '' ?>"> 
                        </div>
                      </div>

                      <div class="text-right">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                      </div>
                  </form><!-- End Profile Edit Form -->
                </div>

              </div><!-- End Bordered Tabs -->

            </div>
          </div>

        </div>
      </div>
</div>

<script>

	profile_image.onchange = evt => {
        const [file] = profile_image.files
        if (file) {
          img.src = URL.createObjectURL(file)
        }
      }

  $('#update-user').submit(function(e){
    e.preventDefault();
    start_load();

    var formData = new FormData(this);
    formData.append('action', 'update_user'); 

    $.ajax({
        url: 'ajax.php?action=update_user',
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(resp) {
            if(resp == 1) {
                alert_toast("Data successfully updated", 'success');
                setTimeout(function(){
                    location.reload();
                }, 1500);
            }
        }
    });
});
</script>

    
