<?php
session_start();
include('connection.php');
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>View Applications</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand border-end border-light" href="./jobListings.php" style="padding-right: 1rem;">JobPortal</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item border-bottom border-light">
                        <a class="nav-link active" aria-current="page" href="./updates.php">Updates</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="./jobListings.php">Jobs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="./viewProfile.php">Profile</a>
                    </li>
                </ul>
                <form class="d-flex" action="index.php" method="post">
                    <button class="btn btn-outline-danger" type="submit" name="log_out_btn_submit">Log Out</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <?php
        $applicant_id = $_SESSION['currentUserId'];
        $queryForApplication = "SELECT listing_id, host_id, status FROM applications WHERE applicant_id = '$applicant_id'";
        $resultForApplication = mysqli_query($con, $queryForApplication);

        while ($fetchForApplication = mysqli_fetch_object($resultForApplication)) {
            if ($fetchForApplication->status != null) {
                $queryForHostDetails = "SELECT full_name, contact_num, email FROM users WHERE user_id = '$fetchForApplication->host_id'";
                $resultForHostDetails = mysqli_query($con, $queryForHostDetails);
                $fetchForHostDetails = mysqli_fetch_object($resultForHostDetails);

                $queryForListingDetails = "SELECT role, company_name, work_location FROM job_listings WHERE listing_id = '$fetchForApplication->listing_id'";
                $resultForListingDetails = mysqli_query($con, $queryForListingDetails);
                $fetchForListingDetails = mysqli_fetch_object($resultForListingDetails);

        ?>

                <div class="card mt-4">

                    <div class="card-header">
                        New Update
                    </div>

                    <div class="card-body">
                        <h5 class="card-title"><?php echo $fetchForHostDetails->full_name; ?> has <?php echo $fetchForApplication->status; ?> your application at <?php echo $fetchForListingDetails->company_name; ?> for the role of <?php echo $fetchForListingDetails->role; ?> in <?php echo $fetchForListingDetails->work_location; ?></h5>

                        <?php
                        if ($fetchForApplication->status == 'Accepted') {
                        ?>
                            <p class="card-text">Contact details of Employer -> Email : <?php echo $fetchForHostDetails->email; ?> or Phone : <?php echo $fetchForHostDetails->contact_num; ?></p>
                        <?php
                        }
                        ?>

                    </div>
                </div>

        <?php
            }
        }
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>

</html>