<?php
    require('fpdf/fpdf.php');  // Ensure this path is correct
    include('include/connectdb.php');

    // Function to fetch all orders from the database
    function fetchOrders($conn) {
        $selectQuery = "SELECT orderid, userid, name, pid, pname, pimage, price, quantity, totalprice FROM orders";
        $result = $conn->query($selectQuery);

        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return [];
        }
    }

    $orders = fetchOrders($conn);

    class PDF extends FPDF {
        function Header() {
            $this->SetFont('Arial', 'B', 12);
            $this->Cell(0, 10, 'Orders List', 0, 1, 'C');
            $this->Ln(10);
        }

        function Footer() {
            $this->SetY(-15);
            $this->SetFont('Arial', 'I', 8);
            $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
        }

        function OrderTable($orders) {
            $this->SetFont('Arial', 'B', 12);
            $this->Cell(20, 10, 'Order ID', 1);
            $this->Cell(20, 10, 'User ID', 1);
            $this->Cell(30, 10, 'Name', 1);
            $this->Cell(20, 10, 'Product ID', 1);
            $this->Cell(40, 10, 'Product Name', 1);
            $this->Cell(30, 10, 'Product Image', 1);
            $this->Cell(20, 10, 'Price', 1);
            $this->Cell(20, 10, 'Quantity', 1);
            $this->Cell(30, 10, 'Total Price', 1);
            $this->Ln();

            $this->SetFont('Arial', '', 12);
            foreach ($orders as $order) {
                $this->Cell(20, 10, $order['orderid'], 1);
                $this->Cell(20, 10, $order['userid'], 1);
                $this->Cell(30, 10, $order['name'], 1);
                $this->Cell(20, 10, $order['pid'], 1);
                $this->Cell(40, 10, $order['pname'], 1);
                $this->Cell(30, 10, '', 1); // For image, left empty
                $this->Cell(20, 10, $order['price'], 1);
                $this->Cell(20, 10, $order['quantity'], 1);
                $this->Cell(30, 10, $order['totalprice'], 1);
                $this->Ln();
            }
        }
    }

    $pdf = new PDF();
    $pdf->AddPage();
    $pdf->OrderTable($orders);
    $pdf->Output();
?>
