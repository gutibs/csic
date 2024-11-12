<html lang="es">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">


<!-- ===============================================-->
<!--    Document Title-->
<!-- ===============================================-->
<title><?php echo SITIO_NOMBRE;?></title>


<meta name="theme-color" content="#ffffff">
<script src="<?php echo BASE_URL;?>/vendors/simplebar/simplebar.min.js"></script>
<script src="<?php echo BASE_URL;?>/assets/js/config.js"></script>


<!-- ===============================================-->
<!--    Stylesheets-->
<!-- ===============================================-->
<link href="<?php echo BASE_URL;?>/vendors/choices/choices.min.css" rel="stylesheet">
<link href="<?php echo BASE_URL;?>/vendors/dhtmlx-gantt/dhtmlxgantt.css" rel="stylesheet">
<link href="<?php echo BASE_URL;?>/vendors/flatpickr/flatpickr.min.css" rel="stylesheet">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
<link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&amp;display=swap" rel="stylesheet">
<link href="<?php echo BASE_URL;?>/vendors/simplebar/simplebar.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
<link href="<?php echo BASE_URL;?>/assets/css/theme-rtl.css" type="text/css" rel="stylesheet" id="style-rtl">
<link href="<?php echo BASE_URL;?>/assets/css/theme.min.css" type="text/css" rel="stylesheet" id="style-default">
<link href="<?php echo BASE_URL;?>/assets/css/user-rtl.min.css" type="text/css" rel="stylesheet" id="user-style-rtl">
<link href="<?php echo BASE_URL;?>/assets/css/user.min.css" type="text/css" rel="stylesheet" id="user-style-default">
<script>
    var phoenixIsRTL = window.config.config.phoenixIsRTL;
    if (phoenixIsRTL) {
        var linkDefault = document.getElementById('style-default');
        var userLinkDefault = document.getElementById('user-style-default');
        linkDefault.setAttribute('disabled', true);
        userLinkDefault.setAttribute('disabled', true);
        document.querySelector('html').setAttribute('dir', 'rtl');
    } else {
        var linkRTL = document.getElementById('style-rtl');
        var userLinkRTL = document.getElementById('user-style-rtl');
        linkRTL.setAttribute('disabled', true);
        userLinkRTL.setAttribute('disabled', true);
    }
</script>


<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<!-- Include SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>