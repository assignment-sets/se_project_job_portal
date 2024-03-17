<?php
session_start();
include('connection.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
        *,
        *::after,
        *::before {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            height: 100dvh;
            width: 100dvw;
        }

        .job_listings_outer_container {
            width: 100%;
            padding: 1.5rem;
        }

        .job_listings_inner_container {
            width: 95%;
        }

        .card {
            margin-bottom: 20px;
        }

        .company_logo_img {
            min-height: 300px;
            max-height: 300px;
            object-fit: cover;
        }
    </style>
</head>

<body>

    <?php
    $user_id = $_SESSION['currentUserId'];
    $queryForAccType = "SELECT account_type FROM users WHERE user_id = '$user_id'";
    $resultForAccType = mysqli_query($con, $queryForAccType);
    if ($resultForAccType) {
        $fetchForAccType = mysqli_fetch_object($resultForAccType);
    } else {
        echo "Error: " . mysqli_error($con);
    }
    ?>
    <nav class="navbar navbar-expand-lg bg-body-tertiary" data-bs-theme="dark" style="position: sticky; top: 0; z-index: 999;">
        <div class="container-fluid">
            <a class="navbar-brand border-end border-light" href="./jobListings.php" style="padding-right: 1rem;">JobPortal</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <?php
                    if ($fetchForAccType->account_type === 'seeker') {
                    ?>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="./updates.php">Updates</a>
                        </li>
                    <?php
                    }
                    ?>

                    <li class="nav-item border-bottom border-light">
                        <a class="nav-link active" aria-current="page" href="./jobListings.php">Jobs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="./viewProfile.php">Profile</a>
                    </li>

                    <?php
                    if ($fetchForAccType->account_type === 'provider') {
                    ?>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="./newListing.php">New Listing</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="./viewApplications.php">Applications</a>
                        </li>
                    <?php
                    }
                    ?>
                </ul>
                <form class="d-flex" action="index.php" method="post">
                    <button class="btn btn-outline-danger" type="submit" name="log_out_btn_submit">Log Out</button>
                </form>
            </div>
        </div>
    </nav>


    <div class="job_listings_outer_container container-fluid">
        <div class="job_listings_inner_container container-fluid">
            <div class="row">
                <?php
                $query = "select listing_id, user_id, company_name, company_logo, role, salary, work_location, date from job_listings";
                $result = mysqli_query($con, $query);
                $count = 0;

                while ($fetch = mysqli_fetch_object($result)) {
                    $applicant_id = $_SESSION['currentUserId'];
                    $queryForApplication = "SELECT COUNT(*) AS row_count FROM applications WHERE listing_id = '$fetch->listing_id' AND applicant_id = '$applicant_id'";
                    $resultForApplication = mysqli_query($con, $queryForApplication);
                    $row = mysqli_fetch_assoc($resultForApplication);

                    if ($row['row_count'] == 0) {
                ?>
                        <div class="col-md-4">
                            <div class="card" style="width: 100%;">
                                <img src="company_logos\<?php echo $fetch->company_logo; ?>" class="card-img-top company_logo_img" alt="company logo">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $fetch->company_name; ?></h5>
                                    <p class="card-text"><?php echo $fetch->date; ?></p>
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">Role : <?php echo $fetch->role; ?></li>
                                    <li class="list-group-item">Salary : <?php echo $fetch->salary; ?>k / Month</li>
                                    <li class="list-group-item">Location : <?php echo $fetch->work_location; ?></li>
                                </ul>
                                <div class="card-body">
                                    <form action="index.php" method="post">
                                        <input type="hidden" name="listing_id" value="<?php echo $fetch->listing_id; ?>">
                                        <?php if ($fetchForAccType->account_type === 'provider') : ?>
                                            <button type="submit" class="card-link btn btn-success" name="job_apply_btn_submit" disabled>Apply</button>
                                        <?php else : ?>
                                            <button type="submit" class="card-link btn btn-success" name="job_apply_btn_submit">Apply</button>
                                        <?php endif; ?>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <?php
                        $count++;
                        if ($count % 3 == 0) {
                            echo '</div><div class="row">';
                        }
                        ?>

                <?php
                    }
                }
                ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>

</html>