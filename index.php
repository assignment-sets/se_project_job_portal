<?php
session_start();
ob_start();
include('connection.php');
include('registration.php');


// -----------------------------------------------------Functions--------------------------------------------------------------------

// generates unique user_id's based on timestamp and date (length : 27)
function generateUserId()
{
    $id = uniqid() . date('YmdHis');
    return $id;
}

// generates unique listing_id's based on timestamp and date (length : 28)
function generateListingId()
{
    $id = 'L' . uniqid() . date('YmdHis');
    return $id;
}

// generates unique application_id's based on timestamp and date (length : 29)
function generateApplicationId()
{
    $id = 'AP' . uniqid() . date('YmdHis');
    return $id;
}

// generates unique image file names based on timestamp and date (length : 29)
function generateUniqueFileName()
{
    $id = 'IMG' . uniqid() . date('YmdHis');
    return $id;
}

//returns the location of uploaded file for input type file
function fileUpload($uploaded_file, $targetFolder)
{
    if ($uploaded_file["error"] != 0) {
        echo "<script>
                alert('Error Uploading File');
            </script>";
    } else {
        $fileName = $uploaded_file["name"];
        $fileSize = $uploaded_file["size"];
        $TempfileLocation = $uploaded_file["tmp_name"];

        $validExtension = ['jpg', 'jpeg', 'png'];
        $fileExtension = explode('.', $fileName);
        $fileExtension = strtolower(end($fileExtension));
        if (!in_array($fileExtension, $validExtension)) {
            echo "<script>
                alert('Invaid File Type');
            </script>";
        } else if ($fileSize > 1000000) {
            echo "<script>
                alert('File Size Too Large');
            </script>";
        } else {
            $newFileName = generateUniqueFileName() . '.' . $fileExtension;
            move_uploaded_file($TempfileLocation, $targetFolder . $newFileName);
            return $newFileName;
        }
    }
}

// handles new registration and sends data to users table in main DB
function newRegistration($user_id, $full_name, $user_name, $email, $password, $contact_num, $profile_pic, $resume, $skills, $interests, $city, $bio, $account_type, $con)
{
    $query = "INSERT INTO users (user_id, full_name, user_name, account_type, email, password, contact_num, profile_pic, resume, skills, interests, city, bio) VALUES ('$user_id', '$full_name', '$user_name', '$account_type', '$email', '$password', '$contact_num', '$profile_pic', '$resume', '$skills', '$interests', '$city', '$bio')";

    $result = mysqli_query($con, $query);
    if (!$result) {
        echo "Error: " . mysqli_error($con);
    } else {
        header("location: login.php");
        ob_end_flush();
        exit();
    }
}

// handles login by fetching and matching password from users table in main DB
function login($user_name, $password, $con)
{
    $query = "SELECT user_id, user_name, password FROM users WHERE user_name = '$user_name'";
    $result = mysqli_query($con, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);

        if ($row) {
            $hashed_password = $row['password'];

            if ($password === $hashed_password) {
                $_SESSION['currentUserId'] = $row['user_id'];
                header("Location: viewProfile.php");
            } else {
                echo '<script>alert("Incorrect password");</script>';
            }
        } else {
            echo '<script>alert("User not found");</script>';
        }
    } else {
        echo '<script>alert("Error: ' . mysqli_error($con) . '");</script>';
    }
}

// handles new job listing functionality and pushes data to job_listings DB
function newListing($listing_id, $user_id, $company_name, $company_logo, $work_location, $role, $salary, $con)
{
    $query = "INSERT INTO job_listings (listing_id, user_id, company_name, company_logo, work_location, role, salary) 
          VALUES ('$listing_id', '$user_id', '$company_name', '$company_logo', '$work_location', '$role', '$salary')";

    $result = mysqli_query($con, $query);
    if (!$result) {
        echo "Error: " . mysqli_error($con);
    } else {
        header("location: jobListings.php");
        exit();
    }
}

// handles login by fetching and matching password from users table in main DB
function logout()
{
    $_SESSION = array();

    session_destroy();

    header("Location: login.php");
    // exit();
}

// new insertion in applications table on clicking apply button
function newApplication($application_id, $listing_id, $applicant_id, $host_id, $con)
{
    $query = "INSERT INTO applications (application_id, listing_id, applicant_id, host_id) VALUES ('$application_id', '$listing_id', '$applicant_id', '$host_id')";

    $result = mysqli_query($con, $query);
    if (!$result) {
        echo "Error: " . mysqli_error($con);
    } else {
        header("location: jobListings.php");
        exit();
    }
}

// handles cases where job providers clicks on accept or reject btn for an application and updates status in applications table
function changeApplicationStatus($application_id, $status, $con)
{
    $query = "UPDATE applications SET status = '$status' WHERE application_id = '$application_id'";

    $result = mysqli_query($con, $query);
    if (!$result) {
        echo "Error: " . mysqli_error($con);
    } else {
        header("location: viewApplications.php");
        exit();
    }
}

// redirects to viewResume page to display Resume of an user acting as applicant
function displayResumeOfApplicant($resume_location)
{
    $_SESSION['resume_path'] = $resume_location;

    header("Location: viewResumeOfApplicant.php");
    exit();
}

// redirects to viewResume page to display Resume of an user if instructed from profile section
function displayResumeOfUser($resume_location)
{
    $_SESSION['resume_path'] = $resume_location;

    header("Location: viewResumeOfUser.php");
    exit();
}

// returns default input values while updating profile if input is not explicitly given by user
function getDefaultIfEmpty($field_name, $val, $con)
{
    if ($val === '') {
        $user_id = $_SESSION['currentUserId'];
        $query = "SELECT $field_name FROM users WHERE user_id = '$user_id'";
        $result = mysqli_query($con, $query);

        if ($result) {
            $row = mysqli_fetch_assoc($result);
            if ($row) {
                return $row[$field_name];
            } else {
                echo '<script>alert("User not found");</script>';
            }
        } else {
            echo '<script>alert("Error: ' . mysqli_error($con) . '");</script>';
        }
    } else {
        return $val;
    }
}

// updates profile data of an user 
function updateProfile($user_id, $full_name, $user_name, $email, $password, $contact_num, $skills, $interests, $city, $bio, $account_type, $con)
{
    $query = "UPDATE users SET 
    full_name = '$full_name',
    user_name = '$user_name',
    account_type = '$account_type',
    email = '$email',
    password = '$password',
    contact_num = '$contact_num',
    skills = '$skills',
    interests = '$interests',
    city = '$city',
    bio = '$bio'
    WHERE user_id = '$user_id'";

    $result = mysqli_query($con, $query);
    if (!$result) {
        echo "Error: " . mysqli_error($con);
    } else {
        header("location: viewProfile.php");
        exit();
    }
}

// updates image files or media of an user however doesn't redirect or exit
function updateUserMedia($user_id, $field_name, $updatedFileName, $con)
{
    $query = "UPDATE users SET $field_name = '$updatedFileName' WHERE user_id = '$user_id'";

    $result = mysqli_query($con, $query);
    if (!$result) {
        echo "Error: " . mysqli_error($con);
    }
}

// ------------------------------------------------------form submissions-----------------------------------------------------------


// handling case where register btn is clicked
if (isset($_POST['reg_form_submit'])) {
    $user_id = generateUserId();
    $full_name = $_POST['full_name'];
    $user_name = $_POST['user_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $contact_num = $_POST['contact_num'];
    $account_type = $_POST['account_type'];

    $profile_pic = fileUpload($_FILES["profile_pic"], 'pfp_pics/');
    $resume = fileUpload($_FILES["resume"], 'resumes/');

    $skills = $_POST['skills'];
    $interests = $_POST['interests'];
    $city = $_POST['city'];
    $bio = $_POST['bio'];

    newRegistration($user_id, $full_name, $user_name, $email, $password, $contact_num, $profile_pic, $resume, $skills, $interests, $city, $bio, $account_type, $con);
}

// handling case where login btn is clicked
if (isset($_POST['login_form_submit'])) {
    $user_name = $_POST['user_name'];
    $password = $_POST['password'];
    login($user_name, $password, $con);
}

// handling case where new post listing btn is clicked
if (isset($_POST['new_listing_form_submit'])) {
    $listing_id = generateListingId();
    $company_name = $_POST['company_name'];
    $work_location = $_POST['work_location'];
    $role = $_POST['role'];
    $salary = $_POST['salary'];

    $company_logo = fileUpload($_FILES["company_logo"], 'company_logos/');

    newListing($listing_id, $_SESSION['currentUserId'], $company_name, $company_logo, $work_location, $role, $salary, $con);
}

// handling case where log out btn is clicked
if (isset($_POST['log_out_btn_submit'])) {
    logout();
}

// handling case where apply btn is clicked
if (isset($_POST['job_apply_btn_submit'])) {
    $application_id = generateApplicationId();
    $listing_id = $_POST['listing_id'];

    $query = "SELECT user_id FROM job_listings WHERE listing_id = '$listing_id'";
    $result = mysqli_query($con, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);

        if ($row) {
            $host_id = $row['user_id'];
            if (isset($host_id)) {
                newApplication($application_id, $listing_id, $_SESSION['currentUserId'], $host_id, $con);
            } else {
                echo '<script>alert("Something Is Wrong, Kindly Try Again Later!");</script>';
            }
        } else {
            echo '<script>alert("Something Is Wrong, Kindly Try Again Later!");</script>';
        }
    } else {
        echo '<script>alert("Error: ' . mysqli_error($con) . '");</script>';
    }
}

// handling case where view resume btn is clicked from *applications page
if (isset($_POST['view_applications_view_resume_btn'])) {
    $applicant_id = $_POST['applicant_id'];

    $query = "SELECT resume FROM users WHERE user_id = '$applicant_id'";
    $result = mysqli_query($con, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        displayResumeOfApplicant($row['resume']);
    } else {
        echo '<script>alert("Error: ' . mysqli_error($con) . '");</script>';
    }
}

// handling case where view resume btn is clicked from *profile section
if (isset($_POST['view_profile_view_resume_btn'])) {
    $resume_location = $_POST['resume_location'];
    displayResumeOfUser($resume_location);
}

// handling case where Accept btn is clicked from applications page
if (isset($_POST['view_applications_accept_btn'])) {
    $application_id = $_POST['application_id'];
    $status = 'Accepted';
    changeApplicationStatus($application_id, $status, $con);
}

// handling case where Reject btn is clicked from applications page
if (isset($_POST['view_applications_reject_btn'])) {
    $application_id = $_POST['application_id'];
    $status = 'Rejected';
    changeApplicationStatus($application_id, $status, $con);
}

// handling case where update profile btn is clicked
if (isset($_POST['update_profile_submit_btn'])) {
    $user_id = $_SESSION['currentUserId'];
    $full_name = getDefaultIfEmpty('full_name', $_POST['full_name'], $con);
    $user_name = getDefaultIfEmpty('user_name', $_POST['user_name'], $con);
    $email = getDefaultIfEmpty('email', $_POST['email'], $con);
    $password = getDefaultIfEmpty('password', $_POST['password'], $con);
    $contact_num = getDefaultIfEmpty('contact_num', $_POST['contact_num'], $con);
    $account_type = getDefaultIfEmpty('account_type', $_POST['account_type'], $con);
    $skills = getDefaultIfEmpty('skills', $_POST['skills'], $con);
    $interests = getDefaultIfEmpty('interests', $_POST['interests'], $con);
    $city = getDefaultIfEmpty('city', $_POST['city'], $con);
    $bio = getDefaultIfEmpty('bio', $_POST['bio'], $con);


    if (!empty($_FILES["profile_pic"]) && $_FILES["profile_pic"]["error"] === 0) {
        $profile_pic = fileUpload($_FILES["profile_pic"], 'pfp_pics/');
        updateUserMedia($user_id, 'profile_pic', $profile_pic, $con);
    }
    if (!empty($_FILES["resume"]) && $_FILES["resume"]["error"] === 0) {
        $resume = fileUpload($_FILES["resume"], 'resumes/');
        updateUserMedia($user_id, 'resume', $resume, $con);
    }

    updateProfile($user_id, $full_name, $user_name, $email, $password, $contact_num, $skills, $interests, $city, $bio, $account_type, $con);
}