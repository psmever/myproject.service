<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>myproject LandingPage</title>

    <!-- Bootstrap core CSS -->
    <link href="/resource/land/vender/startbootstrap-grayscale-gh-pages/vendor/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="/resource/land/vender/startbootstrap-grayscale-gh-pages/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/resource/land/vender/startbootstrap-grayscale-gh-pages/css/grayscale.min.css" rel="stylesheet">

</head>

<body id="page-top">

<!-- Navigation -->
<!-- Header -->
<header class="masthead">
    <div class="container d-flex h-100 align-items-center">
        <div class="mx-auto text-center">
            <h1 class="mx-auto my-0 text-uppercase">:: 인증 중입니다 ::</h1>
            <div style="border:0px solid #dedede; width:600px; height:100px; line-height:100px; color:#666;font-size:100px; text-align:center;" id="clock">
            </div>
            <div style="border:0px solid #dedede;height:50px;">
            </div>
            <a href="javascript:;" class="btn btn-primary js-scroll-trigger" id="button_get_started">잠시만 기다려 주세요</a>
        </div>
    </div>
</header>

<!-- Footer -->
<!-- Bootstrap core JavaScript -->
<script src="/resource/land/vender/startbootstrap-grayscale-gh-pages/vendor/jquery/jquery.min.js"></script>
<script src="/resource/land/vender/startbootstrap-grayscale-gh-pages/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Plugin JavaScript -->
<script src="/resource/land/vender/startbootstrap-grayscale-gh-pages/vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for this template -->
<!--<script src="/resource/land/js/grayscale.min.js"></script>-->

</body>

</html>
<?php
$code_check = (isset($code_check) && $code_check) ? $code_check : 'false';
$code_end_check = (isset($code_end_check) &&  $code_end_check) ? $code_end_check : 'false';
$auth_complate = (isset($auth_complate) && $auth_complate) ? $auth_complate : 'false';
?>
<script type="text/javascript">
var js_code_check = <?php echo $code_check;?>;
var js_code_end_check = <?php echo $code_end_check;?>;
var js_auth_complate = <?php echo $auth_complate;?>;

function pageStart() {
    if(js_code_check == false) {
        alert('잘못된 인증 코드 입니다.');
        location.href = "/";
    } else if (js_code_end_check == false) {
        alert('이미 인증이 완료된 인증 코드 입니다.');
        location.href = "/";
    } else if (js_auth_complate == true) {
        alert('인증이 완료 되었습니다.');
        location.href = "/";
    } else {
        alert('잘못된 정보 입니다. 관리자에게 문의 하세요.');
        location.href="/";
    }
}
</script>

<script type="text/javascript">
    $( document ).ready(function() {
        pageStart();
    });
</script>