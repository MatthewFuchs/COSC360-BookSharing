<?php
require_once '../php/config.php';

$res = $conn->query("SELECT * FROM borrow_listings LIMIT 1");

echo "🔍 Borrow Listings Test\n";
echo $res && $res->num_rows >= 0 ? "Listings fetched successfully\n" : "Listings query failed\n";