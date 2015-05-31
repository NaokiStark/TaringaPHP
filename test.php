<?php

require 'Taringa.class.php';

$Api=new Taringa('usuario','passw');

$result=false;
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Prueba</title>
	<style>
	@import url(http://fonts.googleapis.com/css?family=Open+Sans:400,300);
		body{
			font-family: "Segoe UI","Open Sans","Arial",sans-serif;
			font-size: 14px;
			text-align: center;
			color: #434343;
		}
		ul{
			list-style: none;
		}
		a{
			  color: #2e96ec;
			  text-decoration: none;
		}
		a:hover{
			color: #2e96ec;
			  text-decoration: underline;	
		}
		a:visited{
			color: #2e96ec;
			text-decoration: none;
		}
		a:active{
			color: #2e96ec;
			text-decoration: underline;
		}
		article {
		  width: 80%;
		  margin: 0 auto;
		}
	</style>
</head>

<body>
<main>
	
<p>
<?php
if(isset($_GET['s'])){
	if($Api->isLogged) $result = $Api->sendShout(urldecode($_GET['s']));
	echo ($result==true)?'Error al enviar el shout':'Shout enviado con éxito. <a href="test.php">Volver</a>';
}
else{
	?>
	<p style="text-align:center;">
	<form action="" method="get">
		<textarea name="s" id="s" cols="30" rows="10"></textarea><br>
		<input type="submit" value="Shoutear">
	</form>
	</p>
	<?php
}
?>
</p>
</main>
</body>
</html>