<!DOCTYPE html>
<html lang="en">
<head>
<?php include("pages/inc/Header.php"); ?>
</head>
<body>
<?php include("pages/inc/bs4_navbar.php"); ?>
<div class="modal" id="sh-Modal-Ajax"></div>
<div class="modal" id="sh-Modal-Waiting"><div class="modal-dialog modal-dialog-centered text-center"><i class="fas fa-cog fa-spin fa-5x mx-auto"></i></div></div>
<!-- Start : Your Page Source -->


<a type="button" class="btn btn-primary btn-lg"  role="button" href="<?php echo $AdminFolder; ?>/Apps/Items/add_item"><i class="fas fa-plus"></i></a>


<?php include("pages/inc/bs4_bottombar.php"); ?>
<!-- End : Your Page Source -->
</body>
</html>