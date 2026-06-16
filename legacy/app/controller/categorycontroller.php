<?php
include_once '../category.php';
$category = new Category();
if (isset($_POST['action']) == 'category') {
    $output = '';
    $sql = "SELECT * FROM category";
    $categorystmt = $category->display_category($sql);
    $result = $categorystmt->fetchAll();
    $output .= "<option value=''>Please Select </option> ";
    foreach ($result as $row) {
        $output .= "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
    }
    echo $output;
}
