<?php
include('connection.php');

if (isset($_GET['q'])) {
    $searchTerm = mysqli_real_escape_string($conn, $_GET['q']);

    // Example query to search dropdown_values or any other relevant table
    $query = "SELECT * FROM dropdown_values WHERE value LIKE '%$searchTerm%'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $link = '';
            switch ($row['value']) {
                case 'Rent':
                    $link = 'index.php';
                    break;
                case 'Sale':
                    $link = 'home2.php';
                    break;
                case 'Commercial':
                    $link = 'home3.php';
                    break;
                default:
                    // Change to your service redirect logic if necessary
                    $link = './services?service=' . urlencode($row['value']);
                    break;
            }
            echo '<div class="result-item" onclick="redirectTo(\'' . $link . '\')">' . htmlspecialchars($row['value']) . '</div>';
        }
    } else {
        echo '<div class="result-item">No results found</div>';
    }
} else {
    echo '<div class="result-item">Please enter a search term.</div>';
}
?>
