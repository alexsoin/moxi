{extends 'file:templates/layouts/error.tpl'}

{block 'error_content'}
<h1 class="text-5xl">Ошибка 401</h1>
<h2 class="text-2xl">Доступ запрещен</h2>
<div class="py-3 text-lg mt-5">Данная страница доступна только авторизованным пользователям</div>
<div>
	<a href="/" class="text-blue-700 underline hover:no-underline">Вернуться на главную страницу</a>
</div>
{/block}
