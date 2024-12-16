<?php
include('../connection.php');
include('session_check.php');

$message = "";

if (isset($_POST['delete_request'])) {
    $enquiry_id = intval($_POST['enquiry_id']);
    $query = "DELETE FROM enquiries WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $enquiry_id);
    if ($stmt->execute()) {
        $message = "Enquiry deleted successfully.";
    } else {
        $message = "Failed to delete the enquiry.";
    }
    $stmt->close();
}

$user_id = $_SESSION['user_id'];
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
    <script>
    function confirmDeletion(event) {
        if (!confirm("Are you sure you want to delete this request?")) {
            event.preventDefault();
        }
    }
    </script>
</head>

<body>

<?php  include('user-head.php');  ?>

    <div class="container">
        <div class="row">
            <div class="property-card-heading">
                <h4>Your Enquiries</h4>
            </div>

            <?php if ($message): ?>
            <div class="alert alert-info">
                <?php echo htmlspecialchars($message); ?>
            </div>
            <?php endif; ?>

            <?php 
                $query = "
                    SELECT enquiries.*, 
                    properties.available_for, properties.property_type,
                    customer_register.name, customer_register.emailaddress, customer_register.phonenumber
                    FROM enquiries
                    JOIN properties ON enquiries.property_id = properties.id
                    JOIN customer_register ON enquiries.user_id = customer_register.id
                    WHERE enquiries.user_id = ?";
                
                $stmt = $conn->prepare($query);
                $stmt->bind_param("i", $user_id);
                $stmt->execute();
                $result = $stmt->get_result();
                
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
            ?>

            <div class="row enquiry_listing_card">
                <div class="col-md-6 float-start">
                    <div class="enquiry_listing">
                        <b>Sender Details</b>
                        <p>For <?php echo htmlspecialchars($row['available_for']); ?></p>
                        <p>Name: <?php echo htmlspecialchars($row['name']); ?></p>
                        <p>Email: <?php echo htmlspecialchars($row['emailaddress']); ?></p>
                        <p>Phone: <?php echo htmlspecialchars($row['phonenumber']); ?></p>
                        <p>Property Type: <?php echo htmlspecialchars($row['property_type']); ?></p>
                        <p><?php echo htmlspecialchars($row['message']); ?></p>
                        <p>Date: <?php echo date('d M y', strtotime($row['created_at'])); ?></p>

                        <b>Receive Details</b>
                        <form action="" method="post" style="display:inline;" onsubmit="confirmDeletion(event)">
                            <input type="hidden" name="enquiry_id" value="<?php echo htmlspecialchars($row['id']); ?>">
                            <button type="submit" name="delete_request" class="btn btn-danger btn-custom">Delete Request</button>
                        </form>

                        <a href="<?php echo htmlspecialchars($row['property_type'] == 'property_list.php' ? 'property_list_details.php' : 'property_all_list_details.php'); ?>?id=<?php echo htmlspecialchars($row['property_id']); ?>" class="btn btn-primary btn-custom text-white">
                            View Property
                        </a>
                    </div>
                </div>
            </div>

            <?php
                    }
                } else {
                    echo "<div class='row'><div class='col-12'><p>No Enquiries.</p></div></div>";
                }
                $stmt->close();
            ?>
        </div>
    </div>

</body>

</html>
