<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Magox 测试</title>
</head>
<body>

<b>变量测试</b>

<b>$name:</b>

{$name}

<b>if语名测试</b>

{if $show}

{else}

{/if}

<b>foreache语句测试</b>

{foreach $array(key,value)}
	{@key}==>{@value}<br>
{/foreach}


</body>
</html>