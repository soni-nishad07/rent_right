<?php
session_start();
include('../connection.php');

// Check if the user is logged in
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header('Location: index');
    exit;
}

// Check if a search query was submitted
$searchQuery = '';
if (isset($_POST['search'])) {
    $searchQuery = $_POST['search'];
    $searchQueryEscaped = $conn->real_escape_string($searchQuery);

    if (is_numeric($searchQueryEscaped)) {
        // Query for numeric searches
        $result = $conn->query("SELECT * FROM category WHERE expected_rent_from >= $searchQueryEscaped OR expected_rent_to >= $searchQueryEscaped OR expected_deposit_from >= $searchQueryEscaped OR expected_deposit_to >= $searchQueryEscaped");
    } else {
        // Query for string searches
        $result = $conn->query("SELECT * FROM category WHERE property_type LIKE '%$searchQueryEscaped%' OR property_choose LIKE '%$searchQueryEscaped%'");
    }
} else {
    // Fetch all categories if no search query
    $result = $conn->query("SELECT * FROM category");
}
$categories = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rent Right Bangalore</title>
    <?php include('admin-link.php'); ?>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <?php include('header.php'); ?>
        <?php include('sidebar.php'); ?>

        <div class="content-wrapper">
            <section class="content-header">
                <div class="header-icon">
                    <i class="fa fa-sticky-note-o"></i>
                </div>
                <div class="header-title">
                    <h1>Category List</h1>
                    <div class="searchbar">
                        <form class="search-bar" method="POST" role="search">
                            <input class="form-control me-2" type="search" name="search" placeholder="Search by Property" aria-label="Search" value="<?php echo htmlspecialchars($searchQuery); ?>">
                        </form>
                        <button type="button" class="btn-reset" onclick="window.location.href='category_list.php'">
                            <i class="fa fa-refresh home_reset" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
            </section>

            <section class="content">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-bd panel-shadow">
                            <div class="panel-heading">
                                <div class="btn-group" id="buttonexport">
                                    <h4>Category</h4>
                                </div>
                                <a href="category" class="btn btn-danger c-p-invoice">Back</a>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr class="info">
                                                <th>#</th>
                                                <th>Selected Property</th>
                                                <th>Property Name</th>
                                                <th>Price Range (Rent/Buy/Commercial)</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($categories as $category): ?>
                                                <tr>
                                                    <td><?php echo $category['id']; ?></td>
                                                    <td><?php echo htmlspecialchars($category['property_choose']); ?></td>
                                                    <td>
                                                        <?php
                                                        if ($category['property_choose'] === 'Rent') {
                                                            echo htmlspecialchars($category['bhk_type']);
                                                        } else {
                                                            echo htmlspecialchars($category['property_type']);
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        if ($category['property_choose'] === 'Rent') {
                                                            $priceFrom = isset($category['expected_rent_from']) && $category['expected_rent_from'] !== '' ? 'Rs' . number_format($category['expected_rent_from'], 2) : '-';
                                                            $priceTo = isset($category['expected_rent_to']) && $category['expected_rent_to'] !== '' ? 'Rs' . number_format($category['expected_rent_to'], 2) : '-';
                                                        } elseif ($category['property_choose'] === 'Commercial') {
                                                            $priceFrom = isset($category['commercial_rent_from']) && $category['commercial_rent_from'] !== '' ? 'Rs' . number_format($category['commercial_rent_from'], 2) : '-';
                                                            $priceTo = isset($category['commercial_rent_to']) && $category['commercial_rent_to'] !== '' ? 'Rs' . number_format($category['commercial_rent_to'], 2) : '-';
                                                        } else {
                                                            $priceFrom = isset($category['expected_deposit_from']) && $category['expected_deposit_from'] !== '' ? 'Rs' . number_format($category['expected_deposit_from'], 2) : '-';
                                                            $priceTo = isset($category['expected_deposit_to']) && $category['expected_deposit_to'] !== '' ? 'Rs' . number_format($category['expected_deposit_to'], 2) : '-';
                                                        }
                                                        echo "$priceFrom - $priceTo";
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal<?php echo $category['id']; ?>">
                                                            <i class="fa fa-trash-o"></i>
                                                        </button>
                                                    </td>
                                                </tr>


                                                     <!-- Delete Modal -->
                                                     <div class="modal fade" id="deleteModal<?php echo $category['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header modal-header-danger">
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                <h3><i class="fa fa-trash m-r-5"></i> Delete Category</h3>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="delete_category.php" method="POST">
                                                                    <input type="hidden" name="id" value="<?php echo $category['id']; ?>">
                                                                    <p>Are you sure you want to delete this category?</p>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">No</button>
                                                                        <button type="submit" class="btn btn-add">Yes</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <?php include('copy.php'); ?>
    </div>
    <?php include('footer-link.php'); ?>
</body>
</html>