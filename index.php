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
require_once dirname(__FILE__).'/classes/Service.php';

$method = $_SERVER['REQUEST_METHOD'];
$service = new Service(dirname(__FILE__).'/config');
$inputString = 'http://www.ebay.com/itm/dawes/REF=11111111 
amazon.com/dp/B01K1C94E4?tag=222222222222222
http://cccccccccccccccc.reseller.hop.clickbank.net 
http://www.ebay.com/itm/dawes/REF=aaaaaaaaaaaaa';
?>

<?php
if (strtoupper($method) == 'POST') {
    $inputString = isset($_POST['inputString']) ? $_POST['inputString'] : null;
}

?>

<div class="container-lg">
    <div class="d-flex justify-content-between mt-3 mb-2">
        <h1 class="mt-4">Swapping Affiliate Network Referral Link</h1>
        <a class="btn btn-link" href="admin.php" role="button">Network Management</a>
    </div>
    <form class="needs-validation" id="editForm" method="post" novalidate>
        <div class="form-group has-validation">
            <label for="networkKey" class="col-form-label">Key:</label>
            <textarea class="form-control" name="inputString" rows="5" required placeholder="Please input string to convert"><?php echo $inputString ?></textarea>
            <div class="invalid-feedback">
                Please input string.
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Generate</button>
    </form>
    <div class="output-code mt-4">
        <label for="networkHtml" class="col-form-label">Output Code:</label>
        <textarea class="form-control" name="networkHtml" rows="5"></textarea>
    </div>
    <div class="output-html mt-3">
        <div>Output Html:</div>
        <code></code>
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

<script>
  var data = JSON.parse('<?php echo $service->doConvert($inputString) ?>');
  $(document).ready(function () {
    var htmlString = $("<div/>").html(data.html).text();
    $('.output-code textarea').val(htmlString);
    $('.output-html code').html(htmlString);
  })
</script>

</body>
</html>

