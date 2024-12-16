<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"
      integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA=="
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="../css/main.css" />
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
    <script src="../js/main.js" defer></script>
    
  </head>
  <body>
    <header class="header">
      <a href="" class="logo"><img src="../img/logo.png"></a>
      <div class="menu-btn">
        <div class="menu-btn__lines"></div>
      </div>
      <ul class="menu-items">
        <li><a href="#" class="menu-item">Home</a></li>
        <li class="dropdown">
          <a href="#" class="menu-item expand-btn">Package
            <i class = "fas fa-chevron-down"></i>
          </a>
          <ul class="dropdown-menu expandable">
            <li><a href="#" class="menu-item">Kids Special</a></li>
            <li><a href="#" class="menu-item">Senior Citizen Special</a></li>
            <li class="dropdown dropdown-right">
              <a href="#" class="menu-item expand-btn">
                Family Special
                <i class="fas fa-angle-right"></i>
              </a>
              <ul class="menu-right expandable">
                <li><a href="#" class="menu-item">Goa</a></li>
                <li><a href="#" class="menu-item">Kashmir</a></li>
                <li><a href="#" class="menu-item">Rajasthan</a></li>
                <li><a href="#" class="menu-item">Himachal Pradesh</a></li>
              </ul>
            </li>
            <li><a href="#" class="menu-item">Ladies Special</a></li>
          </ul>
        </li>
        <li>
          <a href="#" class="menu-item expand-btn">Destination
            <i class = "fas fa-chevron-down"></i>
          </a>
          <div class="mega-menu expandable">
            <div class="content">
              <div class="col">
                <section>
                  <h2>UAE</h2>
                  <ul class="mega-links">
                    <li><a href="#">Dubai</a></li>
                    <li><a href="#">Abu Dhabi</a></li>
                    <li><a href="#">Sharjah</a></li>
                    <li><a href="#">Oman</a></li>
                    <li><a href="#">Qatar</a></li>
                  </ul>
                </section>
              </div>
              <div class="col">
                <section>
                  <h2>USA</h2>
                  <ul class="mega-links">
                    <li><a href="#">Arizona</a></li>
                    <li><a href="#">Toronto</a></li>
                    <li><a href="#">Los Angles</a></li>
                    <li><a href="#">Canada</a></li>
                    <li><a href="#">Boston</a></li>
                  </ul>
                </section>
              </div>
              <div class="col">
                <section>
                  <h2>Europe</h2>
                  <ul class="mega-links">
                    <li><a href="#">London</a></li>
                    <li><a href="#">Germany</a></li>
                    <li><a href="#">Switzerland</a></li>
                    <li><a href="#">Paris</a></li>
                    <li><a href="#">Italy</a></li>
                  </ul>
                  
                </section>
              </div>
            </div>
          </div>
        </li>
        <li>
          <a href="home2.php" class="menu-item">Shop</a>
        </li>
        <li><a href="" class="menu-item">Team</a></li>
        
        <li class="nav-item">
          <div class="dropdown">
            <?php if (isset($_SESSION['firstname'])): ?>
              <a class='nav-link dropdown-toggle' href='' id='dropdownMenuLink'
                  data-bs-toggle='dropdown' aria-expanded='false'>
                  <i class='bi bi-person'></i> <?php echo $_SESSION['firstname']; ?>
              </a>
              <ul class="dropdown-menu mt-2 mr-0" aria-labelledby="dropdownMenuLink">
                  <li><a class='dropdown-item' href='profile.php'>My Profile</a></li>
                  <li><a class="dropdown-item" href="../logout.php">Logout</a></li>
              </ul>
            <?php else: ?>
              <a class='nav-link dropdown-toggle' href='' id='dropdownMenuLink'
                  data-bs-toggle='dropdown' aria-expanded='false'>
                  <i class='bi bi-person'></i>
              </a>
              <ul class="dropdown-menu mt-2 mr-0" aria-labelledby="dropdownMenuLink">
                  <li><a class='dropdown-item' href='login.php'>Login</a></li>
                  <li><a class="dropdown-item" href="register.php">Sign Up</a></li>
              </ul>
            <?php endif; ?>
          </div>
        </li>
      </ul>
    </header>
  </body>
</html>
