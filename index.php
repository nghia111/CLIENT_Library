<?php
    require "inc/init.php";
    $conn = require('inc/db.php');
    $books = Book::getAllBooks($conn);
?>

<? 
    require "./inc/header.php";
?>

<div class="content">
    <div class="row"> 
        <div class="filter col-md-3">
            <div class="filter-title mb-2">
                <h3 >Filter by Category</h3>
            </div>
            
            <div class="list-group">
                <button type="button" class="list-group-item list-group-item-action active" data-category="all">All</button>
                <button type="button" class="list-group-item list-group-item-action" data-category="fiction">Fiction</button>
                <button type="button" class="list-group-item list-group-item-action" data-category="non-fiction">Non-Fiction</button>
                <button type="button" class="list-group-item list-group-item-action" data-category="sci-fi">Sci-Fi</button>
                <button type="button" class="list-group-item list-group-item-action" data-category="fiction">Fiction</button>
                <button type="button" class="list-group-item list-group-item-action" data-category="non-fiction">Non-Fiction</button>
                <button type="button" class="list-group-item list-group-item-action" data-category="sci-fi">Sci-Fi</button>
            </div>
        </div>
        <div class="col-md-9">

            <div class="search row mb-3">
                <div class="col">
                    <div class="input-group">
                        <input type="text" class="form-control" id="search-input" placeholder="Search by title">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button" id="search-button">Search</button>
                        </div>
                    </div>
                </div>
            </div>

            <table class="table table-bordered table-hover">
                <thead align="center">
                    <tr>
                        <th scope="col" width="5%">#</th>
                        <th scope="col" width="15%">Title</th>
                        <th scope="col" width="15%">Category</th>
                        <th scope="col" width="40%">Description</th>
                        <th scope="col" width="15%">Author</th>
                        <th scope="col" width="10%">Image</th>
                    </tr>
                </thead>
                <tbody>
                    <? static $no=1; ?>
                    <? foreach($books as $b): ?>
                        <tr>
                            <td align="center"><? echo $no++ ?></td>
                            <td align="center"><? echo $b->title ?></td>
                            <td align="center"><? echo $b->category ?></td>
                            <td><? echo $b->description ?></td>
                            <td align="center"><? echo $b->author ?></td>
                            <td align="center">
                            <img src="uploads/<? echo $b->imagefile ?>" alt="" width="100" height="100">
                            </td>
                        </tr>
                    <? endforeach; ?>    
                    
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
    require "./inc/footer.php";
?>