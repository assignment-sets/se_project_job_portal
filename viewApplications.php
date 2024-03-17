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

<style>
    .view_application_btns {
        display: flex;
        gap: 1rem;
    }
</style>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand border-end border-light" href="./jobListings.php" style="padding-right: 1rem;">JobPortal</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="./jobListings.php">Jobs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="./viewProfile.php">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="./newListing.php">New Listing</a>
                    </li>
                    <li class="nav-item border-bottom border-light">
                        <a class="nav-link active" aria-current="page" href="./viewApplications.php">Applications</a>
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
        $host_id = $_SESSION['currentUserId'];
        $queryForApplication = "SELECT application_id, listing_id, applicant_id, status FROM applications WHERE host_id = '$host_id'";
        $resultForApplication = mysqli_query($con, $queryForApplication);

        while ($fetchForApplication = mysqli_fetch_object($resultForApplication)) {
            if ($fetchForApplication->status == null) {

                $queryForApplicantName = "SELECT full_name FROM users WHERE user_id = '$fetchForApplication->applicant_id'";
                $resultForApplicantName = mysqli_query($con, $queryForApplicantName);
                $fetchForApplicantName = mysqli_fetch_object($resultForApplicantName);

                $queryForListingDetails = "SELECT role, company_name FROM job_listings WHERE listing_id = '$fetchForApplication->listing_id'";
                $resultForListingDetails = mysqli_query($con, $queryForListingDetails);
                $fetchForListingDetails = mysqli_fetch_object($resultForListingDetails);
        ?>

                <div class="card mt-4">
                    <div class="card-header">
                        New Application
                    </div>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $fetchForApplicantName->full_name; ?> has applied for this job</h5>
                        <p class="card-text">For <?php echo $fetchForListingDetails->role; ?> post in <?php echo $fetchForListingDetails->company_name; ?></p>
                        <div class="view_application_btns">
                            <form action="index.php" method="post">
                                <input type="hidden" name="applicant_id" value="<?php echo $fetchForApplication->applicant_id; ?>">
                                <button type="submit" class="card-link btn btn-dark" name="view_applications_view_resume_btn">View Resume</button>
                            </form>
                            <form action="index.php" method="post">
                                <input type="hidden" name="application_id" value="<?php echo $fetchForApplication->application_id; ?>">
                                <button type="submit" class="card-link btn btn-success" name="view_applications_accept_btn">Accept</button>
                            </form>
                            <form action="index.php" method="post">
                                <input type="hidden" name="application_id" value="<?php echo $fetchForApplication->application_id; ?>">
                                <button type="submit" class="card-link btn btn-danger" name="view_applications_reject_btn">Reject</button>
                            </form>
                        </div>
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