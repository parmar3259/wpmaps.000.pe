<!DOCTYPE html>
<html lang="en">

<head>
    <title>phulkari eva - Contact</title>
    <?php
    include('./cssfiles.php');
    include('./session.php');

    ?>
    <style type="text/css">
        .card {
            box-shadow: 0 20px 27px 0 rgb(0 0 0 / 5%);
        }

        .card {
            position: relative;
            display: flex;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 0 solid rgba(0, 0, 0, 0.125);
            border-radius: 1rem;
        }

        .card-body {
            -webkit-box-flex: 1;
            -ms-flex: 1 1 auto;
            flex: 1 1 auto;
            padding: 1.5rem 1.5rem;
        }
    </style>
</head>

<body>
    <?php
    include('./navbar.php');
    include('../database/connection.php');
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // Retrieve existing data
    $sql = "SELECT * FROM login WHERE fullname = '$fullname' AND email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Data exists, retrieve and display it
        $row = $result->fetch_assoc();
        $phone = $row['phone_number'];
        $address1 = $row['user_address'];
        $address2 = $row['user_address2'];
        $city = $row['user_city'];
        $zip = $row['city_zipcode'];
    } else {
        // Data doesn't exist, initialize variables
        $phone = "";
        $address1 = "";
        $address2 = "";
        $city = "";
        $zip = "";
    }

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Retrieve new values from form fields
        $newPhone = $_POST['phone'];
        $newAddress1 = $_POST['address1'];
        $newAddress2 = $_POST['address2'];
        $newCity = $_POST['city'];
        $newZip = $_POST['zip'];

        // Check if data is already up to date
        if ($newPhone == $phone && $newAddress1 == $address1 && $newAddress2 == $address2 && $newCity == $city && $newZip == $zip) {

            echo "<script> location.replace('finalcart.php') </script>";
        }


        // Update the database with new values
        $updateSql = "UPDATE login SET phone_number = '$newPhone', user_address = '$newAddress1', user_address2 = '$newAddress2', user_city = '$newCity', city_zipcode = '$newZip' WHERE fullname = '$fullname' AND email = '$email'";
        if ($conn->query($updateSql) === TRUE) {
            // echo "Data updated successfully!";
            // Update the variables for display
            $phone = $newPhone;
            $address1 = $newAddress1;
            $address2 = $newAddress2;
            $city = $newCity;
            $zip = $newZip;


            echo "<script> location.replace('finalcart.php') </script>";
            exit();
        } else {
            echo "Error updating data: " . $conn->error;
        }
    }


    ?>
    <div class="container-fluid">
        <div class="container">
            <div class="d-flex justify-content-between align-items-lg-center py-3 flex-column flex-lg-row">
                <h2 class="mb-3 mb-lg-0">
                    <a href="#" class="text-muted"><i class="bi bi-arrow-left-square me-2"></i></a>
                    proceed to checkout
                </h2>
            </div>
            <form action="" method="post">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h3 class="h6 mb-4">Basic information</h3>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label class="form-label">Full name</label>
                                            <input type="text" class="form-control" value="<?php echo $fullname; ?>" readonly />
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">Email</label>
                                            <input type="email" class="form-control" value="<?php echo $email; ?>" readonly />
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">Phone number</label>
                                            <input type="text" class="form-control" name="phone" value="<?php echo $phone; ?>" required />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-4">
                            <div class="card-body">
                                <h3 class="h6 mb-4">Address</h3>
                                <div class="mb-3">
                                    <label class="form-label">Address Line 1</label>
                                    <input type="text" class="form-control" name="address1" value="<?php echo $address1; ?>" required />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Address Line 2</label>
                                    <input type="text" class="form-control" name="address2" value="<?php echo $address2; ?>" />
                                </div>
                                <div class="row">

                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">City</label>
                                            <!-- <select class="select2 form-control select2-hidden-accessible" data-select2-placeholder="Select city" data-select2-id="select2-data-7-809c" tabindex="-1" aria-hidden="true">
                                                <option data-select2-id="select2-data-9-k35n"></option>
                                                <option value="Deshnok">Deshnok</option>
                                                <option value="Napasar">Napasar</option>
                                                <option value="Nagaur">Nagaur</option>
                                                <option value="jaipur">jaipur</option>
                                            </select> -->
                                            <select class="form-control" name="city">
                                                <option value="Deshnok" <?php if ($city == "Deshnok") echo "selected"; ?>>Deshnok</option>
                                                <option value="Napasar" <?php if ($city == "Napasar") echo "selected"; ?>>Napasar</option>
                                                <option value="Nagaur" <?php if ($city == "Nagaur") echo "selected"; ?>>Nagaur</option>
                                                <option value="jaipur" <?php if ($city == "jaipur") echo "selected"; ?>>Jaipur</option>
                                            </select>
                                            <span class="select2 select2-container select2-container--bootstrap-5" dir="ltr" data-select2-id="select2-data-8-3peu" style="width: 391px"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-jdfi-container" aria-controls="select2-jdfi-container"><span class="select2-selection__rendered" id="select2-jdfi-container" role="textbox" aria-readonly="true" title="Select city"><span class="select2-selection__placeholder">Select city</span></span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">ZIP code</label>
                                            <input type="text" class="form-control" name="zip" value="<?php echo $zip; ?>" required />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="col-lg-12">
                                        <button type="submit" class="btn btn-primary btn-lg btn-icon-text">
                                            <i class="bi bi-save"></i> <span class="text">Place Order</span>
                                        </button>
                                        <button class="btn btn-light btn-lg btn-icon-text">
                                            <i class="bi bi-x"></i> <span class="text">Cancel</span>
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </form>
        </div>
    </div>

    <?php
    include('./footer.php');
    ?>
</body>

</html>