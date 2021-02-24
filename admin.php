<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    <title>Network Manage</title>
</head>
<body>
<?php
require_once dirname(__FILE__).'/classes/Service.php';

$method = $_SERVER['REQUEST_METHOD'];
$service = new Service(dirname(__FILE__).'/config');
?>

<?php
if (strtoupper($method) == 'POST') {
    $action = isset($_POST['action']) ? $_POST['action'] : null;
    $originKey = isset($_POST['networkOriginKey']) ? $_POST['networkOriginKey'] : null;
    $key = isset($_POST['networkKey']) ? $_POST['networkKey'] : null;
    $pattern = isset($_POST['networkPattern']) ? $_POST['networkPattern'] : null;
    $html = isset($_POST['networkHtml']) ? $_POST['networkHtml'] : null;

    if ($action != 'remove') {
        $service->updateNetwork($originKey, $key, $pattern, $html);
    } else {
        $service->removeNetwork($key);
    }
}

?>

<div class="container-lg">
    <div class="d-flex justify-content-between mt-3 mb-2">
        <h1 class="mt-4">Network Management</h1>
        <a class="btn btn-link" href="index.php" role="button">To Home</a>
    </div>
    <div class="modal fade" id="networkEdit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New Network</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="needs-validation" id="editForm" method="post" novalidate>
                    <input type="hidden" name="networkOriginKey">
                    <input type="hidden" name="action">
                    <div class="modal-body">
                        <div class="form-group has-validation">
                            <label for="networkKey" class="col-form-label">Key:</label>
                            <input type="text" class="form-control" name="networkKey" required placeholder="clickbank">
                            <div class="invalid-feedback">
                                Please input key.
                            </div>
                        </div>
                        <div class="form-group has-validation">
                            <label for="networkPattern" class="col-form-label">Target Pattern:</label>
                            <input type="text" class="form-control" name="networkPattern" required placeholder="http://{code}.reseller.hop.clickbank.net">
                            <div class="invalid-feedback">
                                Please input pattern.
                            </div>
                        </div>
                        <div class="form-group has-validation">
                            <label for="networkHtml" class="col-form-label">Html Code:</label>
                            <textarea class="form-control" name="networkHtml" rows="5" required placeholder="Please use {code} to swap the matched code"></textarea>
                            <div class="invalid-feedback">
                                Please input html code.
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary submit-button">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="float-right mb-2">
        <button type="button" class="btn btn-primary btn-sm add-button">Add
            Network
        </button>
    </div>
    <table class="table table-striped table-hover network-grid">
        <thead>
        <tr>
            <!--            <th scope="col">#</th>-->
            <th scope="col">Key</th>
            <th scope="col">Patten</th>
            <th scope="col">Action</th>
        </tr>
        </thead>
        <tbody>
        <?php /** @var AffiliateNetwork $network */
        foreach ($service->getNetworks() as $idx => $network):?>
            <tr>
                <!--            <th scope="row">--><?php //echo $idx
                ?><!--</th>-->
                <td class="text-truncate"><?php echo $network->getName() ?></td>
                <td class="text-truncate"><?php echo $network->getPattern() ?></td>
                <td class="text-nowrap">
                    <button type="button" class="btn btn-primary btn-sm edit-action" data-network-key="<?php echo $network->getName() ?>">
                        edit
                    </button>
                    <button type="button" class="btn btn-primary btn-sm remove-action" data-network-key="<?php echo $network->getName() ?>">
                        remove
                    </button>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
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
  var networkConfig = JSON.parse('<?php echo $service->getNetworksInJson() ?>');
  $(document).ready(function () {
    $('.add-button').click(function () {
      $('#networkEdit #exampleModalLabel').text('New Network');
      $('#networkEdit input[name="networkOriginKey"]').val('');
      $('#networkEdit input[name="networkKey"]').val('').prop('disabled', false);
      $('#networkEdit input[name="networkPattern"]').val('');
      $('#networkEdit textarea[name="networkHtml"]').val('');
      $('#networkEdit .submit-button').text('Add');
      $('#networkEdit').modal('show');
    });

    $('.network-grid .edit-action').click(function () {
      var data = $(this).data();
      if (data.networkKey) {
        data = networkConfig[data.networkKey];
        $('#networkEdit #exampleModalLabel').text('Edit Network');
        $('#networkEdit input[name="networkOriginKey"]').val(data.name);
        $('#networkEdit input[name="networkKey"]').val(data.name).prop('disabled', true);
        $('#networkEdit input[name="networkPattern"]').val($("<div/>").html(data.pattern).text());
        $('#networkEdit textarea[name="networkHtml"]').val($("<div/>").html(data.html).text());
        $('#networkEdit .submit-button').text('Update');
        $('#networkEdit').modal('show');
      }
    });

    $('.network-grid .remove-action').click(function () {
      var data = $(this).data();
      if (data.networkKey) {
        data = networkConfig[data.networkKey];
        $('#networkEdit input[name="networkKey"]').val(data.name);
        $('#networkEdit input[name="action"]').val('remove');
        $('#editForm').submit();
      }
    })
  })
</script>
</body>
</html>

