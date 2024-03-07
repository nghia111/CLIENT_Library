<?
    require "inc/init.php";
    $conn = require("inc/db.php");
?>

<?php
    require "./inc/header.php";
?>



<div class="content">
    <div class="book-detail row mb-5">
        <div class="book-detail_cover col-md-4">
            <div class="book-detail_img row">
                <img src="./uploads/1984.jpg" alt="">
            </div>
            <div class="book-detail_category row">
                <h4>Category: Memoir</h4>
            </div>
        </div>
        <div class="book-detail_info col-md-8">
            <div class="book-detail_title row">
               <h2>To Kill a Mockingbird - Harper Lee</h2>
            </div>
            <hr>
            <div class="book-detail_desc row">
                <h5>Description: A classic novel by Harper Lee that explores themes of racial injustice and moral growth in the American South</h5>
            </div>
            <hr>
            <div class="row">
                <div class="book-detail_btn col">
                    <button>Update</button>
                    <button>Delete</button>
                </div>
            </div>
        </div>
    </div>
    <div class="book-suggest_list row">
        <div class="book-suggest_item col-md-3">
            <img src="./uploads/1984.jpg" alt="">
        </div>
        <div class="book-suggest_item col-md-3">
            <img src="./uploads/1984.jpg" alt="">
        </div>
        <div class="book-suggest_item col-md-3">
            <img src="./uploads/1984.jpg" alt="">
        </div>
        <div class="book-suggest_item col-md-3">
            <img src="./uploads/1984.jpg" alt="">
        </div>
    </div>
</div>

<?php
    require "./inc/footer.php";
?>