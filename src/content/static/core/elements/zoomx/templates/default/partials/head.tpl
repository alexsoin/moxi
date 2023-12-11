{$head_title = (('longtitle'|resource) ? ('longtitle'|resource) : ('pagetitle'|resource|cat:' | '|cat:('site_name'|config)))|escape:'html'}
{$head_description = (('description'|resource) ? ('description'|resource) : ('introtext'|resource))|escape:'html'}
{$head_searchable = ('searchable'|resource) ? 'index, follow' : 'noindex, nofollow'}
{$head_page_url = ('id'|resource)|url:['scheme' => 'full']}
{$head_img = ('img'|resource) ? (('site_url'|config|rtrim:'/')|cat:('phpthumbon'|snippet:['input' => 'img'|resource, 'options' => 'w=400&h=280'])) : ''}

<title>{$head_title}</title>
<base href="{'site_url'|config}">

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="{$head_description}">
<meta name="robots" content="{$head_searchable}">

<meta property="og:site_name" content="{'site_name'|config}"/>
<meta property="og:title" content="{'pagetitle'|resource}"/>
<meta property="og:description" content="{$head_description}"/>
<meta property="og:type" content="website"/>
<meta property="og:url" content="{$head_page_url}"/>
<meta property="og:locale" content="ru_RU">
<meta property="og:image" content="{$head_img}" />

<meta itemprop="name" content="{$head_title}">
<meta itemprop="description" content="{$head_description}">
<meta itemprop="image" content="{$head_img}">

{*
<script type="module" crossorigin src="{'/assets/js/index.js'|version}"></script>
<link rel="stylesheet" href="{'/assets/css/index.css'|version}">
*}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5/dist/css/bootstrap.min.css">

{'metrika_head'|config}
