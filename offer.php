<?php
    include('include/connectdb.php');

    function fetchActiveOffers($conn) {
        $today = date('Y-m-d');
        $selectQuery = "SELECT offer_name, coupon_code FROM offers WHERE start_date <= ? AND end_date >= ?";
        $stmt = $conn->prepare($selectQuery);
        $stmt->bind_param('ss', $today, $today);
        $stmt->execute();
        $result = $stmt->get_result();
        $offers = [];

        while ($row = $result->fetch_assoc()) {
            $offers[] = $row;
        }

        $stmt->close();
        return $offers;
    }

    $offers = fetchActiveOffers($conn);
    echo json_encode($offers);

    $conn->close();
?>
