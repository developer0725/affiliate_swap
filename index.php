<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    <title>Swap Link</title>
</head>
<body>
<?php
include_once dirname(__FILE__).'/buy.php';
?>

<div class="container-lg">
    <div class="d-flex justify-content-between mt-3 mb-2">
        <h1 class="mt-4">Swapping Referral Link</h1>
        <div>
            <a class="btn btn-link" href="test.php" role="button">Swapping Test</a>
            <a class="btn btn-link" href="admin.php" role="button">Network Management</a>
        </div>
    </div>
    <div class="my-3">
        <div class="row">
            <div class="col-2">my email address:</div>
            <div class="col-10"><strong>senior.developer725@gmail.com</strong></div>
        </div>
        <div class="row">
            <div class="col-2">skype:</div>
            <div class="col-10"><strong>apollyon.yi</strong></div>
        </div>
    </div>
    <div class="mt-3">
        <strong>Referer URL:</strong>
        <p class="ml-4"><?= $refererUrl ?></p>
    </div>
    <div class="mt-3">
        <strong>Detected Keys:</strong>
        <p class="ml-4"><?= $matchedNetworks ?></p>
    </div>
    <div class="mt-3">
        <label for="htmlCode"><strong>Generated Code:</strong></label>
        <textarea class="form-control html-code" id="htmlCode" rows="5"><?= $generatedCode ?></textarea>
    </div>
    <div class="border-top py-4 mt-5">
        <strong>Output:</strong>
        <div class="output ml-4 my-5">
            <?php if (!empty($generatedCode)) : ?>
                <?php echo $generatedCode ?>
            <?php else: ?>
                <button type="button" class="btn btn-primary">default</button>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Optional JavaScript; choose one of the two! -->

<!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

<!-- Option 2: Separate Popper and Bootstrap JS -->
<!--
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
-->

</body>
</html>

