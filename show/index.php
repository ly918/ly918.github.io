<?php
	$name = $_GET["name"];
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title><?php echo $name;?></title>
  </head>
  <body style="margin:0;padding:0;">
    <div style="margin:0;padding:0;">
      <img
        style="height: auto; width: auto\9; width:100%;"
        src="https://img.paopao.design/<?php echo $name; ?>"
        alt=""
      />
    </div>
  </body>
</html>
