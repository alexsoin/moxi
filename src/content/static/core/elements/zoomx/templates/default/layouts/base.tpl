<!DOCTYPE html>
<html lang="{'cultureKey'|config}">
<head>
	{include 'partials/head.tpl'}
</head>
<body>
{'metrika_body'|config}
{block 'page'}
	{block 'header'}
		{include 'partials/header.tpl'}
	{/block}

	{block 'content'}{/block}

	{block 'footer'}
		{include 'partials/footer.tpl'}
	{/block}
{/block}
</body>
</html>
