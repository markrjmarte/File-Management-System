
<style>
  /* Add your sidebar styling here */
  .sidebar {
    background-color: #f4f4f4;
    width: 250px;
  }
  .sidebar-nav li {
    list-style: none;
    margin: 10px 0;
  }
  .sidebar-nav a {
    text-decoration: none;
    color: #012970;
    display: block;
    padding: 10px;
  }
  .sidebar-nav a:hover {
    background-color: #ddd;
  }
  .selected {
    background-color: #7ba8e9;
    color: white;
    font-weight: bold;
  }
  .notselected {
    background-color: #f4f4f4;
    font-weight: normal;
  }
</style>

<aside id="sidebar" class="sidebar">
  <ul class="sidebar-nav" id="sidebar-nav">
    <li>
      <a href="index.php?page=notary" class = "selected">
        <i class="bi bi-grid-1x2-fill"></i>
        <span>Dashboard</span>
      </a>
    </li>
    <li>
      <a href="index.php?page=files2">
        <i class="bi bi-database-fill"></i>
        <span>Repository</span>
      </a>
    </li>
    <li>
      <a href="index.php?page=template">
        <i class="bi bi-file-text-fill"></i>
        <span>Templates</span>
      </a>
    </li>
    <?php if($_SESSION['login_type'] == 1): ?>
    <li>
      <a href="index.php?page=managusers">
        <i class="bi bi-file-person-fill"></i>
        <span>Users</span>
      </a>
    </li> 
    <?php endif; ?>
    <!-- <?php if($_SESSION['login_type'] == 1): ?>
    <li>
      <a href="index.php?page=logs">
        <i class="bi bi-calendar-range-fill"></i>
        <span>Logs</span>
      </a>
    </li> 
    <?php endif; ?> -->
  </ul>
</aside>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
  // Get the current URL
  var url = window.location.href;

  // Iterate through each sidebar link and compare with the URL
  $('.sidebar-nav a').each(function() {
    if (url.includes($(this).attr('href'))) {
      $(this).addClass('selected');
    }else{
      $(this).addClass('notselected');
    }
  });
});
</script>