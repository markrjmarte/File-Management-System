<style>
  .nav-tabs-bordered .nav-link.active {
    font-weight: bold;
    color: #012970;

  }
</style>

 
   <div class="row">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs nav-tabs-bordered">
                        <li class="nav-item">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Manage Users</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Logs</button>
                        </li>
                    </ul>
               <div class="tab-content pt-2">
              
                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                    <?php include 'userslist.php' ?>
                </div>

                <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
                    <?php include 'logs.php' ?>
                </div>
            </div>
      </div>
