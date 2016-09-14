<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Magox 测试</title>
</head>
<body>

<b>变量测试</b>

<b>$name:</b>

<?php echo $this->date['name']; ?>

<b>if语名测试</b>

<?php if($this->date['show']){?>
	
<?php }else{ ?>
	
<?php } ?>

<b>foreache语句测试</b>

<?php foreach ($this->date['array'] as $key => $value) { ?>
	<?php echo $key ?>==><?php echo $value ?><br>
<?php } ?>


</body>
</html>