<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>板橋高中午餐系統</title>
		<!-- Bootstrap -->
		<link href="../css/bootstrap.min.css" rel="stylesheet">
		<link href="../css/animate.css" rel="stylesheet">
		<link href="../css/theme.css" rel="stylesheet">	
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="../script/modules/jquery-1.10.2.min.js"></script>
		<script src="../script/modules/bootstrap.min.js"></script>
	</head>
    <body>
        <div class="content inner-content animated bounceIn" style="background:#63d6ff"> 
            <div class="login-logo"> </div>
            
            <div style="height:20px;"></div>
            <div id="reverse" class="item" style="display: block;"> 
    			<div class="item-img-container"><img class="item-img" src="../images/arrow.png" align="center"/></div>
    			<div class="item-text-container"><p> 回到上一頁 </p></div>
    		</div>
            
            <script>
                $("#reverse").click(function(){
                    window.parent.location.replace("/dinnersys_beta/frontend/");
                });
            </script>
    </body>
</html>
