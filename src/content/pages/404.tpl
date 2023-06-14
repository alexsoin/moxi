{extends 'file:templates/layouts/error.tpl'}

{block 'error_content'}
<h1 class="text-5xl">Ошибка 404</h1>
<h2 class="text-2xl">Страница не найдена</h2>
<div class="py-3 text-lg mt-5">Страница, на которую вы перешли, не существует, <br>либо вы зашли по неверному адресу.</div>
<div>
	<a href="/" class="text-blue-700 underline hover:no-underline">Вернуться на главную страницу</a>
</div>
{/block}
