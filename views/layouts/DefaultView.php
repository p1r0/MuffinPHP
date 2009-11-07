<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo "Demo - ".$pageTitle ?></title>
</head>

<body>
	<div><?php echo $html->link(array("controller"=>"Login",
									  "action"=>"logout",
									  "title"=>"Logout...")); ?></div>

	<?php echo $content; ?>
</body>

</html>
