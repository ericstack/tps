<?php
include_once '../inventory.php';

$inventory = new Inventory();
if (isset($_POST['action']) && $_POST['action'] == "load") {
    $sql = "SELECT inv.id, inv.serial_no,  inv.name as productname, inv.description, inv.quantity,ct.name as category FROM inventory inv LEFT JOIN category ct ON inv.category_id = ct.id ";
    if (isset($_POST["search"]["value"])) {
        $sql .= "WHERE inv.serial_no LIKE '%" . $_POST['search']['value'] . "%' ";
        $sql .= "OR inv.name LIKE '%" . $_POST['search']['value'] . "%' ";
        $sql .= "OR inv.description LIKE '%" . $_POST['search']['value'] . "%' ";
    }
    // if (isset($_POST['order']['0']['column'])) {
    //     $sql .= 'ORDER BY ' . $_POST['order']['0']['column'] . ' ' . $_POST['order']['0']['dir'] . ' ';
    // } else {
    //     $sql .= 'ORDER BY inv.id DESC ';
    // }
    // if (isset($_POST['length']) != -1) {
    //     $sql .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
    // }
    $productstmt = $inventory->display_inventory($sql);
    $filtered_rows = $productstmt->rowCount();
    $output = array();
    $data = array();
    foreach ($productstmt->fetchAll() as $products) {
        $sub_array = array();
        $sub_array[] =  $products['serial_no'];
        $sub_array[] = $products['productname'];
        $sub_array[] = $products['description'];
        $sub_array[] = $products['quantity'];
        $sub_array[] = $products['category'];
        $sub_array[] = "<button class='btn btn-success updateProduct' id='" . $products["id"] . "'>Update</button>";
        $data[] = $sub_array;
    }
    $output = array(
        "recordsTotal"  =>  $filtered_rows,
        "recordsFiltered" => $filtered_rows,
        "data"    => $data
    );
    echo json_encode($output);
}


if (isset($_POST['action']) && $_POST['action'] == 'category') {
    $sql = "SELECT inv.id, inv.serial_no,  inv.name as productname, inv.description, inv.quantity,ct.name as category FROM inventory inv LEFT JOIN category ct ON inv.category_id = ct.id ";
    $output = '';
    $inventorystmt = $inventory->display_inventory($sql);
    $result = $inventorystmt->fetchAll();
    $output .= "<option value=''>Please Select </option> ";
    foreach ($result as $row) {
        $output .= "<option value='" . $row['id'] . "'>" . $row['product_name'] . "</option>";
    }
    echo $output;
}

if (isset($_POST['action']) && $_POST['action'] == 'add') {
    $value = array(
        'serial_no'    =>   rand(10, 99) . "-" . rand(100, 999) . "-" . rand(1000, 9999),
        'name'         =>    $_POST['product_name'],
        'description'  =>    $_POST['product_description'],
        'quantity'     =>    $_POST['quantity'],
        'category_id'  =>    $_POST['category']
    );
    $inventorystmt = $inventory->add_to_inventory($value);
    if (isset($inventorystmt)) {
        echo 'Product Added';
    }
}

if (isset($_POST['action']) && $_POST['action'] == 'edit') {
    $output = array();
    $sql = "SELECT inv.id, inv.serial_no,  inv.name as productname, inv.description, inv.quantity,ct.id,ct.name as category FROM inventory inv LEFT JOIN category ct ON inv.category_id = ct.id  WHERE inv.id = '" . $_POST['prod_id'] . "' ";
    $inventorystmt = $inventory->display_single_product($sql);
    foreach ($inventorystmt->fetchAll(PDO::FETCH_ASSOC) as $products) {
        $output['name'] = $products['productname'];
        $output['desc'] = $products['description'];
        $output['qty'] = $products['quantity'];
        $output['cat_id'] = $products['id'];
        $output['cat_name'] = $products['category'];
    }
    echo json_encode($output);
}

if (isset($_POST['action']) && $_POST['action'] == 'update') {
    $value = array(
        'name'         =>    $_POST['product_name'],
        'description'  =>    $_POST['product_description'],
        'quantity'     =>    $_POST['quantity'],
        'category_id'  =>    $_POST['category'],
        'id'           =>    $_POST['id']
    );

    $inventorystmt = $inventory->update_inventory($value);
    if (isset($inventorystmt)) {
        echo 'Product Update';
    }
}
if (isset($_POST['action']) && $_POST['action'] == 'loadlist') {
    $output = '';
    $sql = "SELECT id,name FROM inventory";
    $inventorystmt = $inventory->display_inventory($sql);
    $result = $inventorystmt->fetchAll();
    $output .= "<option value=''>Please Select </option> ";
    foreach ($result as $row) {
        $output .= "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
    }
    echo $output;
}

if (isset($_POST['action']) && $_POST['action'] == 'singleprod') {
    $output = array();
    $sql = "SELECT id,description,quantity FROM inventory inv WHERE inv.id = '" . $_POST['prod_id'] . "' ";
    $inventorystmt = $inventory->display_single_product($sql);
    foreach ($inventorystmt->fetchAll(PDO::FETCH_ASSOC) as $products) {
        $output['name'] = $products['productname'];
        $output['desc'] = $products['description'];
        $output['qty'] = $products['quantity'];
        $output['cat_id'] = $products['id'];
        $output['cat_name'] = $products['category'];
    }
    echo json_encode($output);
}
