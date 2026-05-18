<?php
function getMedicines($conn){
    $r = mysqli_query($conn, "SELECT m.id, m.name, m.vendor_name, m.price, m.availability, m.description, m.image_path, c.name AS category_name, c.category_type
            FROM medicines m LEFT JOIN categories c ON m.category_id = c.id
            ORDER BY m.name ASC");
    return mysqli_fetch_all($r, MYSQLI_ASSOC);
}

function searchMedicines($conn, $term){
    $like = '%' . $term . '%';
    $stmt = mysqli_prepare($conn,
        "SELECT m.id, m.name, m.vendor_name, m.price, m.availability, m.description, m.image_path, c.name AS category_name, c.category_type
         FROM medicines m LEFT JOIN categories c ON m.category_id = c.id
         WHERE m.name LIKE ? OR m.vendor_name LIKE ? OR c.name LIKE ? ORDER BY m.name ASC");
    mysqli_stmt_bind_param($stmt, 'sss', $like, $like, $like);
    mysqli_stmt_execute($stmt);
    $rows = mysqli_fetch_all(mysqli_stmt_get_result($stmt), MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
    return $rows;
}
?>