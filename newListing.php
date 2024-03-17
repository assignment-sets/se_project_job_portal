<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>New Listing</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
        .new_listing_heading {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1rem;
        }
    </style>

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
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="./jobListings.php">Jobs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="./viewProfile.php">Profile</a>
                    </li>
                    <li class="nav-item border-bottom border-light">
                        <a class="nav-link active" aria-current="page" href="./newListing.php">New Listing</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="./viewApplications.php">Applications</a>
                    </li>
                </ul>
                <form class="d-flex" action="index.php" method="post">
                    <button class="btn btn-outline-danger" type="submit" name="log_out_btn_submit">Log Out</button>
                </form>
            </div>
        </div>
    </nav>

    <form action="index.php" method="post" enctype="multipart/form-data" class="mt-4">
        <div class="container">
            <div class="new_listing_heading">
                <div>
                    <h1 class="mb-3">New Job Listing</h1>
                </div>
            </div>
            <div class="form-floating mb-4">
                <input type="text" class="form-control" id="floatingInput" name="company_name" placeholder="name@example.com" required>
                <label for="floatingInput">Company Name</label>
            </div>
            <div class="form-floating mb-4">
                <input type="text" class="form-control" id="floatingInput" name="work_location" placeholder="name@example.com" required>
                <label for="floatingInput">Work Location</label>
            </div>
            <div class="form-floating mb-4">
                <input type="text" class="form-control" id="floatingInput" name="role" placeholder="name@example.com" required>
                <label for="floatingInput">Role</label>
            </div>
            <div class="form-floating mb-4">
                <input type="text" class="form-control" id="floatingPassword" name="salary" placeholder="Password" required>
                <label for="floatingPassword">Salary Per Month (Thousand INR)</label>
            </div>

            <div class="mb-3 mt-4">
                <label for="formFile" class="form-label">Upload logo (JPG / JPEG / PNG)</label>
                <input class="form-control" type="file" id="company_logo" name="company_logo" required>
            </div>

            <div class="mt-5">
                <button class="btn btn-primary" type="submit" name="new_listing_form_submit">Post Listing</button>
            </div>
        </div>

    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>