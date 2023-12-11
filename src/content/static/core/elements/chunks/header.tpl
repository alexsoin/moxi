<nav class="navbar navbar-expand-lg border-bottom mb-5">
	<div class="container">
			<a class="navbar-brand" href="/" title="{$_modx->config.site_name}">{$_modx->config.site_name}</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar"
							aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbar">
					<ul class="navbar-nav mr-auto">
							{'!pdoMenu' | snippet: [
								'parents' => '0',
								'resources' => '',
								'displayStart' => 1,
								'level' => 2,
								'limit' => 0,
								'tplOuter' => '@INLINE {$wrapper}',
								'tpl' => '@INLINE <li class="nav-item {$classnames}"><a class="nav-link" href="{$link}" title="{$menutitle}" {$attributes}>{$menutitle}</a></li>',
								'tplParentRow' => '@INLINE <li class="nav-item dropdown {$classnames}"><a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" title="{$menutitle}" {$attributes}>{$menutitle}</a><ul class="dropdown-menu" aria-labelledby="navbarDropdown">{$wrapper}</ul></li>',
								'tplInnerRow' => '@INLINE <a class="dropdown-item" href="{$link}" title="{$menutitle}" {$attributes}>{$menutitle}</a>'
							]}
					</ul>
			</div>
	</div>
</nav>
