<?php

include "functions.php";

function gallery_all_img($db)
{
    $query = '';
    $output = array();
    $query_blog = "SELECT * FROM `blog`";

    $stmt = $db->prepare($query_blog);
    $stmt->execute();

    $result = $stmt->fetchAll();

    $data = array();

    foreach ($result as $row) {

        $sub_array = array();
        $img = "php_assets/gallery_function/image/" . $row["name"];
        $sub_array[] = '<div class="col-lg-3 col-md-4 col-xs-6 thumb">
                    <a class="thumbnail" href="#" data-image-id="' . $row["id"] . '" data-toggle="modal" data-title="' . $row["title"] . '" data-image="' . $img . '" class="custom_img" data-target="#image-gallery">
                        <img class="img-thumbnail" src="' . $img . '" class="custom_img" alt="Another alt text">
                    </a>
                </div>';
        $data[] = $sub_array;
    }

    return $data;
}
