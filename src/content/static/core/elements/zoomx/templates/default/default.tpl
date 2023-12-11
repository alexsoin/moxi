{extends 'layouts/base.tpl'}

{block 'content'}
	<div class="container py-6">
		<div class="row">
			<div class="col-12">
				{'content'|resource}
			</div>
		</div>
	</div>
{/block}
