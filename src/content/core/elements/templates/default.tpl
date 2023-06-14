{extends 'file:templates/layouts/base.tpl'}

{block 'content'}
	<div class="container py-6">
		<div class="row">
			<div class="col-12">
				{$_modx->resource.content}
			</div>
		</div>
	</div>
{/block}
