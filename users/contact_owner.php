<?php
include('../connection.php');
include('session_check.php');

if (isset($_POST['delete_request'])) {
    $sendmsg_id = $_POST['sendmsg_id'];
    $query = "DELETE FROM owner_messages WHERE id = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $sendmsg_id);

    if ($stmt->execute()) {
        $message = "User Request deleted successfully.";
    } else {
        $error = "Failed to delete the request.";
    }

    $stmt->close();
}

if (isset($_POST['delete_request2'])) {
    $schedule_id = $_POST['schedule_id'];
    $query = "DELETE FROM scheduled_visits WHERE id = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $schedule_id);

    if ($stmt->execute()) {
        $message1 = "User Visit Schedule deleted successfully.";
    } else {
        $error1 = "Failed to delete visit schedule.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enquiries - Rent Right Bangalore</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="shortcut icon" href="../admin/assets/images/favi.ico" type="image/x-icon">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <script src="../js/bootstrap.bundle.js"></script>
    <?php include('../links.php'); ?>
</head>

<body>

<?php  include('user-head.php'); ?>

    <div class="container">
        <div class="property-card-heading">
            <h4>Scheduled Visits</h4>
        </div>

        <?php 
            if (isset($message1)) {
                echo "<div class='alert alert-success'>$message1</div>";
            } elseif (isset($error1)) {
                echo "<div class='alert alert-danger'>$error1</div>";
            }

            $user_id = $_SESSION['user_id'];

            // Query to fetch scheduled visits
            $scheduled_query = "
                SELECT scheduled_visits.*, 
                properties.available_for, properties.property_type,
                customer_register.name, customer_register.emailaddress, customer_register.phonenumber
                FROM scheduled_visits
                JOIN properties ON scheduled_visits.property_id = properties.id
                JOIN customer_register ON scheduled_visits.user_id = customer_register.id
                WHERE properties.user_id = ?";

            $stmt = $conn->prepare($scheduled_query);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $scheduled_result = $stmt->get_result();

            if ($scheduled_result->num_rows > 0) {
                while ($row = $scheduled_result->fetch_assoc()) {
        ?>

        <div class="row enquiry_listing_card">
            <div class="col-md-12 float-start">
                <div class="enquiry_listing">
                    <p><b>For</b> <?php echo htmlspecialchars($row['available_for']); ?></p>
                    <p><b>Name: </b><?php echo htmlspecialchars($row['name']); ?></p>
                    <p><b>Email: </b><?php echo htmlspecialchars($row['emailaddress']); ?></p>
                    <p><b>Phone: </b><?php echo htmlspecialchars($row['phonenumber']); ?></p>
                    <p><b>Property Type: </b><?php echo htmlspecialchars($row['property_type']); ?></p>
                    <p><b>Visit Date: </b><?php echo htmlspecialchars($row['visit_date']); ?></p>
                    <p><b>Date: </b><?php echo date('d M y', strtotime($row['created_at'])); ?></p>

                    <form action="" method="post" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this request?');">
                        <input type="hidden" name="schedule_id" value="<?php echo $row['id']; ?>">
                        <button type="submit" name="delete_request2" class="btn btn-danger btn-custom">Delete Request</button>
                    </form>

                    <a href="<?php echo $row['property_type'] == 'property_list.php' ? 'property_list_details.php' : 'property_all_list_details.php'; ?>?id=<?php echo $row['property_id']; ?>"
                        class="btn btn-primary btn-custom text-white">
                        View Property
                    </a>
                </div>
            </div>
        </div>

        <?php
                }
            } else {
                echo "<div class='row'><div class='col-12'><p>No Scheduled Visits.</p></div></div>";
            }
            $stmt->close();
        ?>

        <div class="property-card-heading">
            <h4>Users Messages</h4>
        </div>

        <?php 
            if (isset($message)) {
                echo "<div class='alert alert-success'>$message</div>";
            } elseif (isset($error)) {
                echo "<div class='alert alert-danger'>$error</div>";
            }

            // Query to fetch owner messages
            $owner_query = "
                SELECT owner_messages.*, 
                properties.available_for, properties.property_type,
                customer_register.name, customer_register.emailaddress, customer_register.phonenumber
                FROM owner_messages
                JOIN properties ON owner_messages.property_id = properties.id
                JOIN customer_register ON owner_messages.user_id = customer_register.id
                WHERE properties.user_id = ?";

            $stmt = $conn->prepare($owner_query);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $owner_result = $stmt->get_result();

            if ($owner_result->num_rows > 0) {
                while ($row = $owner_result->fetch_assoc()) {
        ?>

        <div class="row enquiry_listing_card">
            <div class="col-md-12 float-start">
                <div class="enquiry_listing">
                    <p><b>For</b> <?php echo htmlspecialchars($row['available_for']); ?></p>
                    <p><b>Name: </b><?php echo htmlspecialchars($row['name']); ?></p>
                    <p><b>Email: </b><?php echo htmlspecialchars($row['emailaddress']); ?></p>
                    <p><b>Phone: </b><?php echo htmlspecialchars($row['phonenumber']); ?></p>
                    <p><b>Property Type: </b><?php echo htmlspecialchars($row['property_type']); ?></p>
                    <p><?php echo htmlspecialchars($row['message']); ?></p>
                    <p><b>Date: </b><?php echo date('d M y', strtotime($row['created_at'])); ?></p>

                    <form action="" method="post" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this request?');">
                        <input type="hidden" name="sendmsg_id" value="<?php echo $row['id']; ?>">
                        <button type="submit" name="delete_request" class="btn btn-danger btn-custom">Delete Request</button>
                    </form>

                    <a href="<?php echo $row['property_type'] == 'property_list.php' ? 'property_list_details.php' : 'property_all_list_details.php'; ?>?id=<?php echo $row['property_id']; ?>"
                        class="btn btn-primary btn-custom text-white">
                        View Property
                    </a>
                </div>
            </div>
        </div>

        <?php
                }
            } else {
                echo "<div class='row'><div class='col-12'><p>No Owner Messages.</p></div></div>";
            }
            $stmt->close();
        ?>
    </div>


    <?php
     include('../footer.php');
    ?>

    
    <script src="../js/script.js"></script>
</body>

</html>
