<?php 
include '../controller/nav.php';
?>
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
    
    <title>Home</title>
  </head>
  <body>

  <div class="home-text">
            <h1>Wanderes Unite</h1>
            <p>At Wanderes Unite, we believe that traveling is not just about visiting new places, but about creating unforgettable experiences. Whether you're a seasoned explorer or embarking on your first journey, our mission is to inspire and guide you every step of the way.Founded in 2000, Wanderes Unite has grown from a passion project into a trusted resource for travelers worldwide.</p>
        </div>
    
    
    <h1>Our Team</h1>
    <!--Our Team-->
    <div class="con">
        <div class="cards">
            <img src="../img/dummy.jpg" alt="dummy" class="card-image">
            <h3 class="card-title">Paul</h3>
            <p class="card-text">Founder,CEO</p>
            
        </div>
        <div class="cards">
            <img src="../img/dummy1.png" alt="dummy" class="card-image">
            <h3 class="card-title">Jack</h3>
            <p class="card-text">Jack is a seasoned professional with two decades of extensive experience in the travel industry.His expertise spans various roles, from tour guiding and itinerary planning to destination management and customer relations</p>
            
        </div>
        <div class="cards">
            <h3 class="card-title">About Us</h3>
            <p class="card-text">Since 2000, Wanderes Unite has specialized in creating authentic cultural experiences and immersive adventures.<br> With over 25 years of nurturing strong partnerships with local guides globally, they offer a diverse portfolio including luxury cruises in the Mediterranean and eco-tours in the Amazon rainforest.<br> Achieving a remarkable client retention rate of over 90%, Wanderes Unite has been recognized as the "Best Adventure Travel Company" by Travel & Leisure for three consecutive years.<br> They are committed to sustainable tourism practices and actively engage in supporting local communities.<br>As attested by Emily and Mark Thompson, travelers can expect meticulously planned journeys that exceed expectations, whether exploring Bali or visiting Angkor Wat.</p>
            
        </div>
    </div>
    
    <h1>Our Packages</h1>
    <!--Our Package-->
    <div class="con">
    <div class="cards" style="width: 18rem;">
        <img src="../img/kashmir2.jpg" class="image-cap">
        <div class="card-body">
          <h5 class="card-title">Kashmir</h5>
          <a href="#" class="btn btn-primary">Get a Quote</a>
        </div>
      </div>

      <div class="cards" style="width: 18rem;">
        <img src="../img/goa.jpg" class="image-cap">
        <div class="card-body">
          <h5 class="card-title">Goa</h5>
          <a href="#" class="btn btn-primary">Get a Quote</a>
        </div>
      </div>
    </div>

    <!--Footer-->
    <?php
    include '../controller/footer.php';
    ?>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>  
     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
        crossorigin="anonymous"></script>
  </body>
</html>