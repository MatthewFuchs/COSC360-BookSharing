<?php
echo "=========================\n";
echo "  BookTrade Test Suite  \n";
echo "=========================\n\n";

$tests = [
    "test_auth.php",
    "test_profile_update.php",
    "test_wishlist.php",
    "test_messages.php",
    "test_contact_form.php",
    "test_borrow_listings.php"
];

foreach ($tests as $file) {
    echo "\nRunning $file...\n";
    include $file;
    echo "\n-------------------------\n";
}
?>