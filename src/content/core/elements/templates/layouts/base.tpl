<!DOCTYPE html>
<html lang="ru">
<head>
	{include 'file:chunks/head.tpl'}
</head>
<body>
{'metrika_body' | config | ignore}
{block 'page'}
	{block 'header'}
		{include 'file:chunks/header.tpl'}
	{/block}

	{block 'content'}{/block}

	{block 'footer'}
		{include 'file:chunks/footer.tpl'}
	{/block}
{/block}
</body>
</html>
