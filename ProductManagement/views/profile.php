<?php
session_start();
include("../connection.php");
include '../controller/nav.php';
include("../controller/user.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/main.css">
    
</head>

<body>
    <div class="container">
        <h1 class="mt-5">My Profile</h1>
        <div class="card mt-3">
            <div class="card-body">
                <h5 class="card-title">Profile Details</h5>
                <img src="../uploads/<?php echo $user['profile_picture'];?>" alt="Profile Picture" class="img-fluid mb-3 profile-picture">
                <p class="card-text"><strong>First Name:</strong> <?php echo htmlspecialchars($user['firstname']);?></p>
                <p class="card-text"><strong>Last Name:</strong> <?php echo htmlspecialchars($user['lastname']);?></p>
                <p class="card-text"><strong>Date of Birth:</strong> <?php echo htmlspecialchars($user['dob']);?></p>
                <p class="card-text"><strong>Email:</strong> <?php echo htmlspecialchars($user['email']);?></p>
                <a href="edit_profile.php" class="btn btn-primary">Edit Profile</a>
            </div>
        </div>
        
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>

</html>