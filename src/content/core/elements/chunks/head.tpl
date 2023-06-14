{var $head_title = ($_modx->resource.longtitle ?: $_modx->resource.pagetitle~' | '~$_modx->config.site_name) | replace :' "':' «' | replace :'"':'»' | notags}
{var $head_description = ($_modx->resource.description ?: $_modx->resource.introtext) | replace :' "':' «' | replace :'"':'»' | notags}
{var $head_searchable = $_modx->resource.searchable ? 'index, follow' : 'noindex, nofollow'}
{var $head_page_url = $_modx->resource.id | url : ['scheme' => 'full']}
{var $head_img = $_modx->resource.img ? ($_modx->config.site_url | rtrim : '/')~($_modx->resource.img | phpthumbon : 'w=400&h=280') : ''}

<title>{$head_title}</title>
<base href="{$_modx->config.site_url}">

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="{$head_description}">
<meta name="robots" content="{$head_searchable}">

<meta property="og:site_name" content="{$_modx->config.site_name}"/>
<meta property="og:title" content="{$_modx->resource.pagetitle}"/>
<meta property="og:description" content="{$head_description}"/>
<meta property="og:type" content="website"/>
<meta property="og:url" content="{$head_page_url}"/>
<meta property="og:locale" content="ru_RU">
<meta property="og:image" content="{$head_img}" />

<meta itemprop="name" content="{$head_title}">
<meta itemprop="description" content="{$head_description}">
<meta itemprop="image" content="{$head_img}">

{*
<script type="module" crossorigin src="{'/assets/js/index.js' | version}"></script>
<link rel="stylesheet" href="{'/assets/css/index.css' | version}">
*}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5/dist/css/bootstrap.min.css">

{'metrika_head' | config | ignore}
