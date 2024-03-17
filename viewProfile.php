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
            background: rgba(0, 0, 0, 0.2)
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

        .form-control:focus {
            box-shadow: none;
            border-color: #BA68C8
        }

        .back:hover {
            color: #682773;
            cursor: pointer
        }

        .labels {
            font-size: 11px
        }

        .add-experience:hover {
            background: #BA68C8;
            color: #fff;
            cursor: pointer;
            border: solid 1px #BA68C8
        }
    </style>
</head>

<body>

    <?php
    $user_id = $_SESSION['currentUserId'];
    $queryForAccType = "SELECT * FROM users WHERE user_id = '$user_id'";
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

                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="./jobListings.php">Jobs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active border-bottom border-light" aria-current="page" href="./viewProfile.php">Profile</a>
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

    <div class="container rounded bg-white mt-5 mb-5">

        <div class="row">

            <div class="col-md-3 border-right">

                <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                    <img class="rounded-circle mt-5" width="150px" src="pfp_pics\<?php echo $fetchForAccType->profile_pic; ?>">
                    <span class="font-weight-bold"><?php echo $fetchForAccType->user_name; ?></span>
                    <span class="text-black-50"><?php echo $fetchForAccType->email; ?></span></span>
                    <span class="mt-3">
                        <form action="index.php" method="post">
                            <input type="hidden" name="resume_location" value="<?php echo $fetchForAccType->resume ?>">
                            <button type="submit" class="card-link btn btn-dark" name="view_profile_view_resume_btn">View Resume</button>
                        </form>
                    </span>
                </div>

            </div>

            <div class="col-md-8 border-right">

                <form action="index.php" method="post" enctype="multipart/form-data">

                    <div class="p-3 py-5">

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="text-right">Profile Settings</h4>
                        </div>

                        <div class="row mt-3">

                            <div class="col-md-12 mt-2">
                                <label class="labels">Edit Full Name</label>
                                <input type="text" class="form-control" name="full_name" placeholder="<?php echo $fetchForAccType->full_name; ?>" value="">
                            </div>

                            <div class="col-md-12 mt-2">
                                <label class="labels">Edit User Name</label>
                                <input type="text" class="form-control" name="user_name" placeholder="<?php echo $fetchForAccType->user_name; ?>" value="">
                            </div>

                            <div class="col-md-12 mt-2">
                                <label class="labels">Edit Contact Number</label>
                                <input type="number" class="form-control" name="contact_num" placeholder="<?php echo $fetchForAccType->contact_num; ?>" value="">
                            </div>

                            <div class="col-md-12 mt-2">
                                <label class="labels">Edit Email</label>
                                <input type="email" class="form-control" name="email" placeholder="<?php echo $fetchForAccType->email; ?>" value="">
                            </div>

                            <div class="col-md-12 mt-2">
                                <label class="labels">Edit Password</label>
                                <input type="text" class="form-control" name="password" placeholder="------------" value="">
                            </div>

                            <div class="col-md-12 mt-2">
                                <label class="labels">Change Account Type</label>
                                <select class="form-select form-control" aria-label="Default select example" name="account_type">
                                    <option selected value=""><?php echo "Job " . $fetchForAccType->account_type; ?></option>
                                    <option value="seeker">Job Seeker</option>
                                    <option value="provider">Job Provider</option>
                                </select>
                            </div>

                            <div class="col-md-12 mt-2">
                                <label class="labels">Change City</label>
                                <select class="form-select form-control" aria-label="Default select example" name="city">
                                    <option selected value=""><?php echo $fetchForAccType->city; ?></option>
                                    <option value="Ahmedpur">Ahmedpur</option>
                                    <option value="Aistala">Aistala</option>
                                    <option value="Aknapur">Aknapur</option>
                                    <option value="Alipurduar">Alipurduar</option>
                                    <option value="Amlagora">Amlagora</option>
                                    <option value="Amta">Amta</option>
                                    <option value="Amtala">Amtala</option>
                                    <option value="Andal">Andal</option>
                                    <option value="Arambagh community development block">Arambagh community development block</option>
                                    <option value="Asansol">Asansol</option>
                                    <option value="Ashoknagar Kalyangarh">Ashoknagar Kalyangarh</option>
                                    <option value="Badkulla">Badkulla</option>
                                    <option value="Baduria">Baduria</option>
                                    <option value="Bagdogra">Bagdogra</option>
                                    <option value="Bagnan">Bagnan</option>
                                    <option value="Bagula">Bagula</option>
                                    <option value="Bahula">Bahula</option>
                                    <option value="Baidyabati">Baidyabati</option>
                                    <option value="Bakreswar">Bakreswar</option>
                                    <option value="Balarampur">Balarampur</option>
                                    <option value="Bali Chak">Bali Chak</option>
                                    <option value="Bally">Bally</option>
                                    <option value="Balurghat">Balurghat</option>
                                    <option value="Bamangola community development block">Bamangola community development block</option>
                                    <option value="Baneswar">Baneswar</option>
                                    <option value="Bangaon">Bangaon</option>
                                    <option value="Bankra">Bankra</option>
                                    <option value="Bankura">Bankura</option>
                                    <option value="Bansberia">Bansberia</option>
                                    <option value="Bansihari community development block">Bansihari community development block</option>
                                    <option value="Barabazar">Barabazar</option>
                                    <option value="Baranagar">Baranagar</option>
                                    <option value="Barasat">Barasat</option>
                                    <option value="Bardhaman">Bardhaman</option>
                                    <option value="Barjora">Barjora</option>
                                    <option value="Barrackpore">Barrackpore</option>
                                    <option value="Baruipur">Baruipur</option>
                                    <option value="Basanti">Basanti</option>
                                    <option value="Basirhat">Basirhat</option>
                                    <option value="Bawali">Bawali</option>
                                    <option value="Begampur">Begampur</option>
                                    <option value="Belda">Belda</option>
                                    <option value="Beldanga">Beldanga</option>
                                    <option value="Beliatore">Beliatore</option>
                                    <option value="Berhampore">Berhampore</option>
                                    <option value="Bhadreswar">Bhadreswar</option>
                                    <option value="Bhandardaha">Bhandardaha</option>
                                    <option value="Bhatpara">Bhatpara</option>
                                    <option value="Birbhum district">Birbhum district</option>
                                    <option value="Birpara">Birpara</option>
                                    <option value="Bishnupur">Bishnupur</option>
                                    <option value="Bolpur">Bolpur</option>
                                    <option value="Budge Budge">Budge Budge</option>
                                    <option value="Canning">Canning</option>
                                    <option value="Chakapara">Chakapara</option>
                                    <option value="Chakdaha">Chakdaha</option>
                                    <option value="Champadanga">Champadanga</option>
                                    <option value="Champahati">Champahati</option>
                                    <option value="Champdani">Champdani</option>
                                    <option value="Chandannagar">Chandannagar</option>
                                    <option value="Chandrakona">Chandrakona</option>
                                    <option value="Chittaranjan">Chittaranjan</option>
                                    <option value="Churulia">Churulia</option>
                                    <option value="Contai">Contai</option>
                                    <option value="Cooch Behar">Cooch Behar</option>
                                    <option value="Cossimbazar">Cossimbazar</option>
                                    <option value="Dakshin Dinajpur district">Dakshin Dinajpur district</option>
                                    <option value="Dalkola">Dalkola</option>
                                    <option value="Dam Dam">Dam Dam</option>
                                    <option value="Darjeeling">Darjeeling</option>
                                    <option value="Daulatpur">Daulatpur</option>
                                    <option value="Debagram">Debagram</option>
                                    <option value="Debipur">Debipur</option>
                                    <option value="Dhaniakhali community development block">Dhaniakhali community development block</option>
                                    <option value="Dhulagari">Dhulagari</option>
                                    <option value="Dhulian">Dhulian</option>
                                    <option value="Dhupguri">Dhupguri</option>
                                    <option value="Diamond Harbour">Diamond Harbour</option>
                                    <option value="Digha">Digha</option>
                                    <option value="Dinhata">Dinhata</option>
                                    <option value="Domjur">Domjur</option>
                                    <option value="Dubrajpur">Dubrajpur</option>
                                    <option value="Durgapur">Durgapur</option>
                                    <option value="Egra">Egra</option>
                                    <option value="Falakata">Falakata</option>
                                    <option value="Farakka">Farakka</option>
                                    <option value="Fort Gloster">Fort Gloster</option>
                                    <option value="Gaighata community development block">Gaighata community development block</option>
                                    <option value="Gairkata">Gairkata</option>
                                    <option value="Gangadharpur">Gangadharpur</option>
                                    <option value="Gangarampur">Gangarampur</option>
                                    <option value="Garui">Garui</option>
                                    <option value="Garulia">Garulia</option>
                                    <option value="Ghatal">Ghatal</option>
                                    <option value="Giria">Giria</option>
                                    <option value="Gobardanga">Gobardanga</option>
                                    <option value="Gobindapur">Gobindapur</option>
                                    <option value="Gopalpur">Gopalpur</option>
                                    <option value="Gopinathpur">Gopinathpur</option>
                                    <option value="Gorubathan">Gorubathan</option>
                                    <option value="Gosaba">Gosaba</option>
                                    <option value="Gosanimari">Gosanimari</option>
                                    <option value="Gurdaha">Gurdaha</option>
                                    <option value="Guskhara">Guskhara</option>
                                    <option value="Habra">Habra</option>
                                    <option value="Haldia">Haldia</option>
                                    <option value="Haldibari">Haldibari</option>
                                    <option value="Halisahar">Halisahar</option>
                                    <option value="Harindanga">Harindanga</option>
                                    <option value="Haringhata">Haringhata</option>
                                    <option value="Haripur">Haripur</option>
                                    <option value="Hasimara">Hasimara</option>
                                    <option value="Hindusthan Cables Town">Hindusthan Cables Town</option>
                                    <option value="Hooghly district">Hooghly district</option>
                                    <option value="Howrah">Howrah</option>
                                    <option value="Ichapur">Ichapur</option>
                                    <option value="Indpur community development block">Indpur community development block</option>
                                    <option value="Ingraj Bazar">Ingraj Bazar</option>
                                    <option value="Islampur">Islampur</option>
                                    <option value="Jafarpur">Jafarpur</option>
                                    <option value="Jaigaon">Jaigaon</option>
                                    <option value="Jalpaiguri">Jalpaiguri</option>
                                    <option value="Jamuria">Jamuria</option>
                                    <option value="Jangipur">Jangipur</option>
                                    <option value="Jaynagar Majilpur">Jaynagar Majilpur</option>
                                    <option value="Jejur">Jejur</option>
                                    <option value="Jhalida">Jhalida</option>
                                    <option value="Jhargram">Jhargram</option>
                                    <option value="Jhilimili">Jhilimili</option>
                                    <option value="Kakdwip">Kakdwip</option>
                                    <option value="Kalaikunda">Kalaikunda</option>
                                    <option value="Kaliaganj">Kaliaganj</option>
                                    <option value="Kalimpong">Kalimpong</option>
                                    <option value="Kalna">Kalna</option>
                                    <option value="Kalyani">Kalyani</option>
                                    <option value="Kamarhati">Kamarhati</option>
                                    <option value="Kamarpukur">Kamarpukur</option>
                                    <option value="Kanchrapara">Kanchrapara</option>
                                    <option value="Kandi">Kandi</option>
                                    <option value="Karimpur">Karimpur</option>
                                    <option value="Katwa">Katwa</option>
                                    <option value="Kenda">Kenda</option>
                                    <option value="Keshabpur">Keshabpur</option>
                                    <option value="Kharagpur">Kharagpur</option>
                                    <option value="Kharar">Kharar</option>
                                    <option value="Kharba">Kharba</option>
                                    <option value="Khardaha">Khardaha</option>
                                    <option value="Khatra">Khatra</option>
                                    <option value="Kirnahar">Kirnahar</option>
                                    <option value="Kolkata">Kolkata</option>
                                    <option value="Konnagar">Konnagar</option>
                                    <option value="Krishnanagar">Krishnanagar</option>
                                    <option value="Krishnapur">Krishnapur</option>
                                    <option value="Kshirpai">Kshirpai</option>
                                    <option value="Kulpi">Kulpi</option>
                                    <option value="Kultali">Kultali</option>
                                    <option value="Kulti">Kulti</option>
                                    <option value="Kurseong">Kurseong</option>
                                    <option value="Lalgarh">Lalgarh</option>
                                    <option value="Lalgola">Lalgola</option>
                                    <option value="Loyabad">Loyabad</option>
                                    <option value="Madanpur">Madanpur</option>
                                    <option value="Madhyamgram">Madhyamgram</option>
                                    <option value="Mahiari">Mahiari</option>
                                    <option value="Mahishadal community development block">Mahishadal community development block</option>
                                    <option value="Mainaguri">Mainaguri</option>
                                    <option value="Manikpara">Manikpara</option>
                                    <option value="Masila">Masila</option>
                                    <option value="Mathabhanga">Mathabhanga</option>
                                    <option value="Matiali community development block">Matiali community development block</option>
                                    <option value="Matigara community development block">Matigara community development block</option>
                                    <option value="Medinipur">Medinipur</option>
                                    <option value="Mejia community development block">Mejia community development block</option>
                                    <option value="Memari">Memari</option>
                                    <option value="Mirik">Mirik</option>
                                    <option value="Mohanpur community development block">Mohanpur community development block</option>
                                    <option value="Monoharpur">Monoharpur</option>
                                    <option value="Muragacha">Muragacha</option>
                                    <option value="Muri">Muri</option>
                                    <option value="Murshidabad">Murshidabad</option>
                                    <option value="Nabadwip">Nabadwip</option>
                                    <option value="Nabagram">Nabagram</option>
                                    <option value="Nadia district">Nadia district</option>
                                    <option value="Nagarukhra">Nagarukhra</option>
                                    <option value="Nagrakata">Nagrakata</option>
                                    <option value="Naihati">Naihati</option>
                                    <option value="Naksalbari">Naksalbari</option>
                                    <option value="Nalhati">Nalhati</option>
                                    <option value="Nalpur">Nalpur</option>
                                    <option value="Namkhana community development block">Namkhana community development block</option>
                                    <option value="Nandigram">Nandigram</option>
                                    <option value="Nangi">Nangi</option>
                                    <option value="Nayagram community development block">Nayagram community development block</option>
                                    <option value="North 24 Parganas district">North 24 Parganas district</option>
                                    <option value="Odlabari">Odlabari</option>
                                    <option value="Paikpara">Paikpara</option>
                                    <option value="Panagarh">Panagarh</option>
                                    <option value="Panchla">Panchla</option>
                                    <option value="Panchmura">Panchmura</option>
                                    <option value="Pandua">Pandua</option>
                                    <option value="Panihati">Panihati</option>
                                    <option value="Panskura">Panskura</option>
                                    <option value="Parbatipur">Parbatipur</option>
                                    <option value="Paschim Medinipur district">Paschim Medinipur district</option>
                                    <option value="Patiram">Patiram</option>
                                    <option value="Patrasaer">Patrasaer</option>
                                    <option value="Patuli">Patuli</option>
                                    <option value="Pujali">Pujali</option>
                                    <option value="Puncha community development block">Puncha community development block</option>
                                    <option value="Purba Medinipur district">Purba Medinipur district</option>
                                    <option value="Purulia">Purulia</option>
                                    <option value="Raghudebbati">Raghudebbati</option>
                                    <option value="Raghunathpur">Raghunathpur</option>
                                    <option value="Raiganj">Raiganj</option>
                                    <option value="Rajmahal">Rajmahal</option>
                                    <option value="Rajnagar community development block">Rajnagar community development block</option>
                                    <option value="Ramchandrapur">Ramchandrapur</option>
                                    <option value="Ramjibanpur">Ramjibanpur</option>
                                    <option value="Ramnagar">Ramnagar</option>
                                    <option value="Rampur Hat">Rampur Hat</option>
                                    <option value="Ranaghat">Ranaghat</option>
                                    <option value="Raniganj">Raniganj</option>
                                    <option value="Raypur">Raypur</option>
                                    <option value="Rishra">Rishra</option>
                                    <option value="Sahapur">Sahapur</option>
                                    <option value="Sainthia">Sainthia</option>
                                    <option value="Salanpur community development block">Salanpur community development block</option>
                                    <option value="Sankarpur">Sankarpur</option>
                                    <option value="Sankrail">Sankrail</option>
                                    <option value="Santipur">Santipur</option>
                                    <option value="Santoshpur">Santoshpur</option>
                                    <option value="Santuri community development block">Santuri community development block</option>
                                    <option value="Sarenga">Sarenga</option>
                                    <option value="Serampore">Serampore</option>
                                    <option value="Serpur">Serpur</option>
                                    <option value="Shyamnagar, West Bengal">Shyamnagar, West Bengal</option>
                                    <option value="Siliguri">Siliguri</option>
                                    <option value="Singur">Singur</option>
                                    <option value="Sodpur">Sodpur</option>
                                    <option value="Solap">Solap</option>
                                    <option value="Sonada">Sonada</option>
                                    <option value="Sonamukhi">Sonamukhi</option>
                                    <option value="Sonarpur community development block">Sonarpur community development block</option>
                                    <option value="South 24 Parganas district">South 24 Parganas district</option>
                                    <option value="Srikhanda">Srikhanda</option>
                                    <option value="Srirampur">Srirampur</option>
                                    <option value="Suri">Suri</option>
                                    <option value="Swarupnagar community development block">Swarupnagar community development block</option>
                                    <option value="Takdah">Takdah</option>
                                    <option value="Taki">Taki</option>
                                    <option value="Tamluk">Tamluk</option>
                                    <option value="Tarakeswar">Tarakeswar</option>
                                    <option value="Titagarh">Titagarh</option>
                                    <option value="Tufanganj">Tufanganj</option>
                                    <option value="Tulin">Tulin</option>
                                    <option value="Uchalan">Uchalan</option>
                                    <option value="Ula">Ula</option>
                                    <option value="Uluberia">Uluberia</option>
                                    <option value="Uttar Dinajpur district">Uttar Dinajpur district</option>
                                    <option value="Uttarpara Kotrung">Uttarpara Kotrung</option>
                                </select>
                            </div>

                            <div class="col-md-12 mt-2">
                                <label class="labels">Change Skills</label>
                                <select class="form-select form-control" aria-label="Default select example" name="skills">
                                    <option selected value=""><?php echo $fetchForAccType->skills; ?></option>
                                    <option value="programming">Programming</option>
                                    <option value="web-development">Web Development</option>
                                    <option value="software-engineering">Software Engineering</option>
                                    <option value="data-analysis">Data Analysis</option>
                                    <option value="graphic-design">Graphic Design</option>
                                    <option value="project-management">Project Management</option>
                                    <option value="marketing">Marketing</option>
                                    <option value="communication">Communication</option>
                                    <option value="customer-service">Customer Service</option>
                                    <option value="sales">Sales</option>
                                    <option value="leadership">Leadership</option>
                                    <option value="problem-solving">Problem Solving</option>
                                    <option value="teamwork">Teamwork</option>
                                    <option value="analytical-skills">Analytical Skills</option>
                                    <option value="creativity">Creativity</option>
                                    <option value="time-management">Time Management</option>
                                    <option value="adaptability">Adaptability</option>
                                    <option value="attention-to-detail">Attention to Detail</option>
                                    <option value="critical-thinking">Critical Thinking</option>
                                    <option value="negotiation">Negotiation</option>
                                </select>
                            </div>

                            <div class="col-md-12 mt-2">
                                <label class="labels">Change interests</label>
                                <select class="form-select form-control" aria-label="Default select example" name="interests">
                                    <option selected value=""><?php echo $fetchForAccType->interests; ?></option>
                                    <option value="programming">Programming</option>
                                    <option value="web-development">Web Development</option>
                                    <option value="software-engineering">Software Engineering</option>
                                    <option value="data-analysis">Data Analysis</option>
                                    <option value="graphic-design">Graphic Design</option>
                                    <option value="project-management">Project Management</option>
                                    <option value="marketing">Marketing</option>
                                    <option value="communication">Communication</option>
                                    <option value="customer-service">Customer Service</option>
                                    <option value="sales">Sales</option>
                                    <option value="leadership">Leadership</option>
                                    <option value="problem-solving">Problem Solving</option>
                                    <option value="teamwork">Teamwork</option>
                                    <option value="analytical-skills">Analytical Skills</option>
                                    <option value="creativity">Creativity</option>
                                    <option value="time-management">Time Management</option>
                                    <option value="adaptability">Adaptability</option>
                                    <option value="attention-to-detail">Attention to Detail</option>
                                    <option value="critical-thinking">Critical Thinking</option>
                                    <option value="negotiation">Negotiation</option>
                                </select>
                            </div>

                            <div class="mt-2">
                                <label class="labels">Update Profile Pic (JPG / JPEG / PNG)</label>
                                <input class="form-control" type="file" id="profile_pic" name="profile_pic">
                            </div>

                            <div class="mt-2">
                                <label class="labels">Update Resume (JPG / JPEG / PNG)</label>
                                <input class="form-control" type="file" id="resume" name="resume">
                            </div>

                            <div class="mt-2">
                                <label class="labels">Update Bio</label>
                            </div>
                            <div class="">
                                <textarea class="form-control" placeholder="<?php echo $fetchForAccType->bio ?>" id="floatingTextarea2" name="bio"></textarea>
                            </div>

                        </div>

                        <div class="mt-5">
                            <button class="btn btn-primary btn-danger" type="submit" name="update_profile_submit_btn">Update Profile</button>
                        </div>

                    </div>

                </form>

            </div>

        </div>

    </div>

</body>

</html>