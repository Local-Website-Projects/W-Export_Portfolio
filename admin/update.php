<?php
session_start();
require_once("include/dbController.php");
$db_handle = new DBController();

date_default_timezone_set("Asia/Hong_Kong");

if (!isset($_SESSION["userid"])) {
    echo "<script>
                window.location.href='Login';
                </script>";
}

if (isset($_POST['updateCategory'])) {
    $id = $db_handle->checkValue($_POST['id']);
    $name = $db_handle->checkValue($_POST['c_name']);
    $name_en = $db_handle->checkValue($_POST['c_name_en']);
    $status = $db_handle->checkValue($_POST['status']);
    $image = '';
    $query = '';
    if (!empty($_FILES['cat_image']['name'])) {
        $RandomAccountNumber = mt_rand(1, 99999);
        $file_name = $RandomAccountNumber . "_" . $_FILES['cat_image']['name'];
        $file_size = $_FILES['cat_image']['size'];
        $file_tmp = $_FILES['cat_image']['tmp_name'];

        $file_type = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        if ($file_type != "jpg" && $file_type != "png" && $file_type != "jpeg" && $file_type != "gif") {
            $image = '';
        } else {
            $data = $db_handle->runQuery("select * FROM `category` WHERE id='{$id}'");
            unlink($data[0]['image']);
            move_uploaded_file($file_tmp, "assets/cat_img/" . $file_name);
            $image = "assets/cat_img/" . $file_name;
            $query .= ",`image`='" . $image . "'";
        }
    }

    $data = $db_handle->insertQuery("update category set c_name='$name',`c_name_en` = '$name_en', status='$status'" . $query . " where id={$id}");
    echo "<script>
                document.cookie = 'alert = 3;';
                window.location.href='Category';
                </script>";


}

if (isset($_POST['updateProduct'])) {
    $id = $db_handle->checkValue($_POST['id']);
    $p_name = $db_handle->checkValue($_POST['p_name']);
    $p_name_en = $db_handle->checkValue($_POST['p_name_en']);
    $product_code = $db_handle->checkValue($_POST['p_code']);
    $product_description = $db_handle->checkValue($_POST['product_description']);
    $product_description_en = $db_handle->checkValue($_POST['product_description_en']);
    $product_category = $db_handle->checkValue($_POST['product_category']);
    $status = $db_handle->checkValue($_POST['status']);
    $today_deal = $db_handle->checkValue($_POST['today_deal']);
    $product_price = $db_handle->checkValue($_POST['product_price']);
    $cost = $db_handle->checkValue($_POST['cost']);
    $product_weight = $db_handle->checkValue($_POST['product_weight']);
    $query = '';

    $updated_at = date("Y-m-d H:i:s");

    if (!empty($_FILES['images']['tmp_name'][0])) {
        // At least one image is selected

        $dataFileName = []; // Array to store the file names

        // Loop through each uploaded image file
        foreach ($_FILES['images']['tmp_name'] as $index => $uploadedFile) {
            $originalFileName = $_FILES['images']['name'][$index];
            // Get the original image size and type
            list($originalWidth, $originalHeight, $imageType) = getimagesize($uploadedFile);

            // Create image resource from uploaded file based on image type
            switch ($imageType) {
                case IMAGETYPE_JPEG:
                    $image = imagecreatefromjpeg($uploadedFile);
                    break;
                case IMAGETYPE_PNG:
                    $image = imagecreatefrompng($uploadedFile);
                    break;
                case IMAGETYPE_GIF:
                    $image = imagecreatefromgif($uploadedFile);
                    break;
                default:
                    throw new Exception('Unsupported image type.');
            }

            // Resize the image to 250x250 and save it
            $newImage = imagecreatetruecolor(250, 250);
            imagecopyresampled($newImage, $image, 0, 0, 0, 0, 250, 250, $originalWidth, $originalHeight);
            $RandomAccountNumber = mt_rand(1, 99999);
            imagejpeg($newImage, 'assets/products_image/250/' . $RandomAccountNumber . '_' . $originalFileName . '.jpg');

            // Resize the image to 650x650 and save it
            $newImage = imagecreatetruecolor(650, 650);
            imagecopyresampled($newImage, $image, 0, 0, 0, 0, 650, 650, $originalWidth, $originalHeight);
            $RandomAccountNumber = mt_rand(1, 99999);
            imagejpeg($newImage, 'assets/products_image/650/' . $RandomAccountNumber . '_' . $originalFileName . '.jpg');
            $dataFileName[] = 'assets/products_image/650/' . $RandomAccountNumber . '_' . $originalFileName . '.jpg';

            // Free up memory
            imagedestroy($image);
            imagedestroy($newImage);
        }

        $databaseValue = implode(',', $dataFileName);
        $query .= ",`p_image`='" . $databaseValue . "'";
        $fetch_image = $db_handle->runQuery("select p_image from product WHERE id={$id}");
        $img = explode(',',$fetch_image[0]['p_image']);
        foreach ($img as $i){
            unlink($i);
        }
    }

    $data = $db_handle->insertQuery("UPDATE `product` SET `category_id`='$product_category',`product_code`='$product_code',`p_name`='$p_name',`description`='$product_description',`description_en` = '$product_description_en',
                     `status`='$status',`updated_at`='$updated_at',`product_price`='$product_price',`p_name_en` = '$p_name_en',`cost` = '$cost',`product_weight` = '$product_weight', `deal_today` = '$today_deal'" . $query . " WHERE id={$id}");
    echo "<script>
                document.cookie = 'alert = 3;';
                window.location.href='Product';
                </script>";
}

if (isset($_POST['updateCourse'])) {
    $course_id = $db_handle->checkValue($_POST['id']);
    $course_name = $db_handle->checkValue($_POST['course_name']);
    $course_name_en = $db_handle->checkValue($_POST['course_name_en']);
    $course_type = $db_handle->checkValue($_POST['course_type']);
    $course_duration = $db_handle->checkValue($_POST['course_duration']);
    $course_price = $db_handle->checkValue($_POST['course_price']);
    $course_price_poor = $db_handle->checkValue($_POST['course_price_poor']);
    $course_description = $db_handle->checkValue($_POST['course_description']);
    $course_description_en = $db_handle->checkValue($_POST['course_description_en']);
    $status = $db_handle->checkValue($_POST['status']);
    $updated_at = date("Y-m-d H:i:s");
    $image = '';
    $query = '';
    if (!empty($_FILES['course_image']['name'])) {
        $RandomAccountNumber = mt_rand(1, 99999);
        $file_name = $RandomAccountNumber . "_" . $_FILES['course_image']['name'];
        $file_size = $_FILES['course_image']['size'];
        $file_tmp = $_FILES['course_image']['tmp_name'];

        $file_type = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        if ($file_type != "jpg" && $file_type != "png" && $file_type != "jpeg" && $file_type != "gif") {
            $image = '';
        } else {
            $data = $db_handle->runQuery("select * FROM `course` WHERE course_id='{$course_id}'");
            unlink($data[0]['course_image']);
            move_uploaded_file($file_tmp, "assets/course/" . $file_name);
            $image = "assets/course/" . $file_name;
            $query .= ",`course_image`='" . $image . "'";
        }
    }

    $data = $db_handle->insertQuery("UPDATE `course` SET `course_name`='$course_name',`course_name_en`='$course_name_en',`course_duration`='$course_duration',`course_price`='$course_price',`course_price_poor`='$course_price_poor',`course_description`='$course_description',`course_description_en`='$course_description_en',`status`='$status',`updated_at`='$updated_at',`course_type`='$course_type'" . $query . " WHERE course_id='{$course_id}'");
    echo "<script>
                document.cookie = 'alert = 3;';
                window.location.href='Course';
                </script>";
}


if (isset($_POST['update_promo_code'])) {
    $promo_id = $db_handle->checkValue($_POST['id']);
    $updated_at = date("Y-m-d H:i:s");
    $coupon_name = $db_handle->checkValue($_POST['coupon_name']);
    $coupon_code = $db_handle->checkValue($_POST['coupon_code']);
    $coupon_type = $db_handle->checkValue($_POST['coupon_type']);
    $coupon_amount = $db_handle->checkValue($_POST['coupon_amount']);
    $start_date = $db_handle->checkValue($_POST['start_date']);
    $expirey_date = $db_handle->checkValue($_POST['expirey_date']);
    $description = $db_handle->checkValue($_POST['description']);
    $status = $db_handle->checkValue($_POST['status']);
    $min_order_amount = $db_handle->checkValue($_POST['min_order_amount']);

    $data = $db_handle->insertQuery("UPDATE `promo_code` SET `coupon_name`='$coupon_name',`description`='$description',`code`='$coupon_code',`coupon_type`='$coupon_type',`amount`='$coupon_amount',
                        `start_date`='$start_date',`expirey_date`='$expirey_date',`status`='$status',`updated_at`='$updated_at',`minimum_order` = '$min_order_amount' WHERE id={$promo_id}");
    echo "<script>
                document.cookie = 'alert = 3;';
                window.location.href='Promo-Code';
                </script>";
}

if (isset($_POST['updateAdmin'])) {
    $id = $db_handle->checkValue($_POST['id']);
    $name = $db_handle->checkValue($_POST['name']);
    $email = $db_handle->checkValue($_POST['email']);
    $role = $db_handle->checkValue($_POST['role']);
    $password = $db_handle->checkValue($_POST['password']);
    $status = $db_handle->checkValue($_POST['status']);
    $image = '';
    $query = '';
    if (!empty($_FILES['image']['name'])) {
        $RandomAccountNumber = mt_rand(1, 99999);
        $file_name = $RandomAccountNumber . "_" . $_FILES['image']['name'];
        $file_size = $_FILES['image']['size'];
        $file_tmp = $_FILES['image']['tmp_name'];

        $file_type = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        if ($file_type != "jpg" && $file_type != "png" && $file_type != "jpeg" && $file_type != "gif") {
            $image = '';
        } else {
            $data = $db_handle->runQuery("select * FROM `admin_login` WHERE id='{$id}'");
            unlink($data[0]['image']);
            move_uploaded_file($file_tmp, "assets/admin/" . $file_name);
            $image = "assets/admin/" . $file_name;
            $query .= ",`image`='" . $image . "'";
        }
    }

    $data = $db_handle->insertQuery("UPDATE `admin_login` SET `name`='$name',`email`='$email',`password`='$password',`role`='$role',`status`='$status'" . $query . " WHERE id={$id}");
    echo "<script>
                document.cookie = 'alert = 3;';
                window.location.href='Admin';
                </script>";
}

if (isset($_POST['updateHomeBanner'])) {
    $id = $db_handle->checkValue($_POST['id']);
    $banner_name = $db_handle->checkValue($_POST['banner_name']);
    $heading_one = $db_handle->checkValue($_POST['heading_one']);
    $heading_one_cn = $db_handle->checkValue($_POST['heading_one_cn']);
    $heading_two = $db_handle->checkValue($_POST['heading_two']);
    $heading_two_cn = $db_handle->checkValue($_POST['heading_two_cn']);
    $heading_three = $db_handle->checkValue($_POST['heading_three']);
    $heading_three_cn = $db_handle->checkValue($_POST['heading_three_cn']);
    $details = $db_handle->checkValue($_POST['details']);
    $details_cn = $db_handle->checkValue($_POST['details_cn']);
    $link_one = $db_handle->checkValue($_POST['link_one']);
    $updated_at = date("Y-m-d H:i:s");
    $image = '';
    $query = '';
    if (!empty($_FILES['banner_img']['name'])) {
        $RandomAccountNumber = mt_rand(1, 99999);
        $file_name = $RandomAccountNumber . "_" . $_FILES['banner_img']['name'];
        $file_size = $_FILES['banner_img']['size'];
        $file_tmp = $_FILES['banner_img']['tmp_name'];

        $file_type = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        if ($file_type != "jpg" && $file_type != "png" && $file_type != "jpeg" && $file_type != "gif") {
            $image = '';
        } else {
            $data = $db_handle->runQuery("SELECT * FROM banner WHERE id='{$id}'");
            unlink("../" . $data[0]['banner_img']);
            move_uploaded_file($file_tmp, "../assets/images/banner/" . $file_name);
            $image = "assets/images/banner/" . $file_name;
            $query .= ",`banner_img`='" . $image . "'";
        }
    }

    $data = $db_handle->insertQuery("update banner set `banner_name`='$banner_name',`heading_one`='$heading_one',`heading_two`='$heading_two',`heading_three`='$heading_three',`details`='$details',`link_one`='$link_one',`heading_one_cn` = '$heading_one_cn',`heading_two_cn` = '$heading_two_cn',`heading_three_cn` = '$heading_three_cn',`details_cn` = '$details_cn',`updated_at`='$updated_at'" . $query . " where id={$id}");
    echo "<script>
                document.cookie = 'alert = 3;';
                window.location.href='Banner';
                </script>";


}


if (isset($_POST['updateDeliveryCharges'])) {
    $id = $db_handle->checkValue($_POST['id']);
    $min_charge = $db_handle->checkValue($_POST['min_charge']);
    $weight_upto = $db_handle->checkValue($_POST['weight_upto']);
    $additional_charges = $db_handle->checkValue($_POST['additional_charges']);
    $min_order_amount = $db_handle->checkValue($_POST['min_order_amount']);

    $data = $db_handle->insertQuery("UPDATE `delivery_charges` SET `min_delivery_charge`='$min_charge',`weight_upto`='$weight_upto',`next_per_kg_weight`='$additional_charges',`min_order_free_delivery`='$min_order_amount' WHERE delivery_id = '$id'");
    echo "<script>
                document.cookie = 'alert = 3;';
                window.location.href='Delivery-Charges';
                </script>";
}


if (isset($_POST['delivery'])) {
    $id = $db_handle->checkValue($_POST['billing_id']);
    $email = $db_handle->checkValue($_POST['email']);
    $date = $db_handle->checkValue($_POST['date']);
    $status = $db_handle->checkValue($_POST['status']);

    $data = $db_handle->insertQuery("UPDATE `billing_details` SET `delivery_date`='$date',`approve` = '$status' WHERE id='$id'");

    $fetch_customer = $db_handle->runQuery("select customer_id,total_purchase,updated_at from billing_details where id='$id'");
    $customer = $fetch_customer[0]['customer_id'];
    $points = $fetch_customer[0]['total_purchase'];
    $date = $fetch_customer[0]['updated_at'];

    $insert_point = $db_handle->insertQuery("INSERT INTO `point`( `customer_id`, `points`, `date`) VALUES ('$customer','$points','$date')");

    if ($data) {
        $fetch_product = $db_handle->runQuery("select * from invoice_details where billing_id = '$id'");
        $no_fetch_product = $db_handle->numRows("select * from invoice_details where billing_id = '$id'");
        for ($i = 0; $i < $no_fetch_product; $i++) {
            $quantity = $fetch_product[$i]['product_quantity'];
            $product_id = $fetch_product[$i]['product_id'];
            $fetch_stock = $db_handle->runQuery("select quantity from stock where product_id = '$product_id'");
            $no_fetch_stock = $db_handle->numRows("select quantity from stock where product_id = '$product_id'");
            if ($no_fetch_stock > 0) {
                $s_quantity = $fetch_stock[0]['quantity'];
                $s_quantity = $s_quantity - $quantity;
                $update_stock = $db_handle->insertQuery("UPDATE `stock` SET `quantity`='$s_quantity' WHERE product_id = '$product_id'");
            }
        }
        $email_to = $email;
        $subject = 'Wayshk';


        $headers = "From: Wayshk <" . $db_handle->from_email() . ">\r\n";
        $headers .= "Content-Type: text/html; charset=utf-8\r\n";

        $messege = "
            <html>
                <body style='background-color: #eee; font-size: 16px;'>
                <div style='min-width: 200px; background-color: #ffffff; padding: 20px; margin: auto;'>
                    <h3 style='color:black'>Order Update</h3>
                    <p style='color:black;'>
                    Your order is successfully received. Your approximate delivery date is: $date. Please contact us for more details.
                    </p>
                </div>
                </body>
            </html>";
        if (mail($email_to, $subject, $messege, $headers)) {
            echo "<script>
                document.cookie = 'alert = 3;';
                window.location.href='Pending-Order';
                </script>";
        }
    }

}

if (isset($_POST['approved'])) {
    $id = $db_handle->checkValue($_POST['billing_id']);

    $data = $db_handle->insertQuery("UPDATE `billing_details` SET `approve` = '1' WHERE id='$id'");
    if ($data) {
        echo "<script>
                document.cookie = 'alert = 3;';
                window.location.href='Confirm-Order';
                </script>";
    }

}

if (isset($_POST['updatePassword'])) {
    $o_pass = $db_handle->checkValue($_POST['o_pass']);
    $n_pass = $db_handle->checkValue($_POST['n_pass']);

    $previous_pass = $db_handle->runQuery("select password from admin_login limit 1");
    if ($previous_pass[0]['password'] == $o_pass) {
        $update = $db_handle->insertQuery("update admin_login set password = '$n_pass' where id = 2");
        echo "<script>
                document.cookie = 'alert = 3;';
                window.location.href='Profile';
                </script>";
    } else {
        echo "<script>
                document.cookie = 'alert = 5;';
                window.location.href='Profile';
                </script>";
    }
}


if (isset($_POST['update_files'])) {
    $product_catalouge = '';
    $product_order_form = '';
    $updated_at = date("Y-m-d H:i:s");

    $RandomAccountNumber = mt_rand(1, 99999);
    $file_name = $RandomAccountNumber . "_" . $_FILES['product_catalouge']['name'];
    $file_size = $_FILES['product_catalouge']['size'];
    $file_tmp = $_FILES['product_catalouge']['tmp_name'];

    $RandomAccountNumber1 = mt_rand(1, 99999);
    $file_name1 = $RandomAccountNumber . "_" . $_FILES['product_order_form']['name'];
    $file_size1 = $_FILES['product_order_form']['size'];
    $file_tmp1 = $_FILES['product_order_form']['tmp_name'];

    $file_type = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    if ($file_type != "pdf") {
        $product_catalouge = '';
    } else {
        $data = $db_handle->runQuery("SELECT * FROM files");
        unlink("../assets/document/" . $data[0]['path']);
        move_uploaded_file($file_tmp, "../assets/document/" . $file_name);
        unlink("../assets/document/" . $data[1]['path']);
        move_uploaded_file($file_tmp1, "../assets/document/" . $file_name1);
        $update = $db_handle->insertQuery("UPDATE `files` SET `path`='$file_name',`updated_at`='$updated_at' WHERE id = '1'");
        $update2 = $db_handle->insertQuery("UPDATE `files` SET `path`='$file_name1',`updated_at`='$updated_at' WHERE id = '2'");
        if ($update && $update2) {
            echo "<script>
                document.cookie = 'alert = 3;';
                window.location.href='update_files.php';
                </script>";
        }
    }
}


if (isset($_POST['updateTextbook'])) {
    $id = $db_handle->checkValue($_POST['id']);
    $title = $db_handle->checkValue($_POST['title']);
    $title_en = $db_handle->checkValue($_POST['title_en']);
    $category = $db_handle->checkValue($_POST['category']);
    $category_en = $db_handle->checkValue($_POST['category_en']);
    $points = $db_handle->checkValue($_POST['points']);
    $link = $db_handle->checkValue($_POST['link']);
    $description = $db_handle->checkValue($_POST['description']);
    $description_en = $db_handle->checkValue($_POST['description_en']);
    $image = '';
    $query = '';
    $updated_at = date("Y-m-d H:i:s");
    if (!empty($_FILES['textbook_image']['name'])) {
        $RandomAccountNumber = mt_rand(1, 99999);
        $file_name = $RandomAccountNumber . "_" . $_FILES['textbook_image']['name'];
        $file_size = $_FILES['textbook_image']['size'];
        $file_tmp = $_FILES['textbook_image']['tmp_name'];

        $file_type = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        if ($file_type != "jpg" && $file_type != "png" && $file_type != "jpeg" && $file_type != "gif") {
            $image = '';
        } else {
            $data = $db_handle->runQuery("select * FROM `textbook` WHERE id='{$id}'");
            unlink($data[0]['image']);
            move_uploaded_file($file_tmp, "assets/textbook/" . $file_name);
            $image = "assets/textbook/" . $file_name;
            $query .= ",`image`='" . $image . "'";
        }
    }
    $data = $db_handle->insertQuery("UPDATE `textbook` SET `textbook_title`='$title',`textbook_title_en`='$title_en',`textbook_cat`='$category',`textbook_cat_en`='$category_en',
                      `textbook_point`='$points',`download_link`='$link',`textbook_details`='$description',`textbook_details_en`='$description_en',`updated_at`='$updated_at'" . $query . " where id={$id}");
    echo "<script>
                document.cookie = 'alert = 3;';
                window.location.href='Textbook';
                </script>";

}


if (isset($_POST['updateBook'])) {
    $id = $db_handle->checkValue($_POST['id']);
    $date = $db_handle->checkValue($_POST['date']);
    $store_name = $db_handle->checkValue($_POST['store_name']);
    $type = $db_handle->checkValue($_POST['type']);
    $item_name = $db_handle->checkValue($_POST['item_name']);
    $amount = $db_handle->checkValue($_POST['amount']);
    $payer = $db_handle->checkValue($_POST['payer']);
    $payment_method = $db_handle->checkValue($_POST['payment_method']);

    $query = '';

    $updated_at = date("Y-m-d H:i:s");

    if (!empty($_FILES['images']['tmp_name'][0])) {
        // Unlink previous images
        $fetch_image = $db_handle->runQuery("SELECT image FROM book_keeping WHERE bookkeeping_id={$id}");
        $img = explode(',', $fetch_image[0]['image']);
        foreach ($img as $i) {
            unlink($i);
        }

        // Move and store new images with random numbers
        $dataFileName = [];
        $totalFiles = count($_FILES['images']['tmp_name']);
        for ($i = 0; $i < $totalFiles; $i++) {
            $tempFilePath = $_FILES['images']['tmp_name'][$i];
            if ($tempFilePath != "") {
                $fileExtension = pathinfo($_FILES['images']['name'][$i], PATHINFO_EXTENSION);
                $fileName = uniqid() . '_' . $fileExtension; // Generate unique file name with random number
                $targetFilePath = "assets/book_keeping/" . $fileName; // Specify the target directory for uploaded files
                move_uploaded_file($tempFilePath, $targetFilePath);
                $dataFileName[] = $targetFilePath;
            }
        }

        $databaseValue = implode(',', $dataFileName);
        $query .= ", `image`='" . $databaseValue . "'";
    }

    $data = $db_handle->insertQuery("UPDATE `book_keeping` SET `date`='$date',`store_name`='$store_name',`type`='$type',`item_name`='$item_name',`amount`='$amount',`payer`='$payer',`payment_method`='$payment_method'" . $query . " WHERE bookkeeping_id={$id}");
    if ($data) {
        echo "<script>
                document.cookie = 'alert = 3;';
                window.location.href='Book-Keeping';
                </script>";
    }
}

if(isset($_POST['updateCashFlow'])){
    $id = $db_handle->checkValue($_POST['id']);
    $date = $db_handle->checkValue($_POST['date']);
    $amount = $db_handle->checkValue($_POST['amount']);
    $note = $db_handle->checkValue($_POST['note']);
    $updated_at = date("Y-m-d H:i:s");

    $data = $db_handle->insertQuery("UPDATE `cash_flow` SET `date`='$date',`amount`='$amount',`note`='$note',`updated_at`='$updated_at' WHERE cash_id = '$id'");
    if($data){
        echo "<script>
                document.cookie = 'alert = 3;';
                window.location.href='Cash-Flow';
                </script>";
    }
}

if(isset($_POST['updateBankInterest'])){
    $id = $db_handle->checkValue($_POST['id']);
    $date = $db_handle->checkValue($_POST['date']);
    $amount = $db_handle->checkValue($_POST['amount']);
    $note = $db_handle->checkValue($_POST['note']);
    $updated_at = date("Y-m-d H:i:s");

    $data = $db_handle->insertQuery("UPDATE `bank_interest` SET `date`='$date',`amount`='$amount',`note`='$note',`updated_at`='$updated_at' WHERE bank_id = '$id'");
    if($data){
        echo "<script>
                document.cookie = 'alert = 3;';
                window.location.href='Bank-Interest';
                </script>";
    }
}

