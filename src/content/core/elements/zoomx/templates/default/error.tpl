<!DOCTYPE html>
<html lang="{'cultureKey'|config}">
	<head>
		{block "title"}
		<title>{$e->title|default:"Error {$e->code}"}</title>
		{/block}
		<base href="{'site_url'|config}" />
		<meta charset="{'modx_charset'|config}" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta
			name="viewport"
			content="width=device-width, initial-scale=1, maximum-scale=1"
		/>
		{block "styles"}
		<style>
			*,:before,:after{ box-sizing:border-box;border-width:0;border-style:solid;border-color:#e5e7eb }:before,:after{ --tw-content: "" }html{ line-height:1.5;-webkit-text-size-adjust:100%;-moz-tab-size:4;-o-tab-size:4;tab-size:4;font-family:ui-sans-serif,system-ui,-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Helvetica Neue,Arial,Noto Sans,sans-serif,"Apple Color Emoji","Segoe UI Emoji",Segoe UI Symbol,"Noto Color Emoji";font-feature-settings:normal;font-variation-settings:normal }body{ margin:0;line-height:inherit }hr{ height:0;color:inherit;border-top-width:1px }abbr:where([title]){ -webkit-text-decoration:underline dotted;text-decoration:underline dotted }h1,h2,h3,h4,h5,h6{ font-size:inherit;font-weight:inherit }a{ color:inherit;text-decoration:inherit }b,strong{ font-weight:bolder }code,kbd,samp,pre{ font-family:ui-monospace,SFMono-Regular,Menlo,Monaco,Consolas,Liberation Mono,Courier New,monospace;font-size:1em }small{ font-size:80% }sub,sup{ font-size:75%;line-height:0;position:relative;vertical-align:baseline }sub{ bottom:-.25em }sup{ top:-.5em }table{ text-indent:0;border-color:inherit;border-collapse:collapse }button,input,optgroup,select,textarea{ font-family:inherit;font-size:100%;font-weight:inherit;line-height:inherit;color:inherit;margin:0;padding:0 }button,select{ text-transform:none }button,[type=button],[type=reset],[type=submit]{ -webkit-appearance:button;background-color:transparent;background-image:none }:-moz-focusring{ outline:auto }:-moz-ui-invalid{ box-shadow:none }progress{ vertical-align:baseline }::-webkit-inner-spin-button,::-webkit-outer-spin-button{ height:auto }[type=search]{ -webkit-appearance:textfield;outline-offset:-2px }::-webkit-search-decoration{ -webkit-appearance:none }::-webkit-file-upload-button{ -webkit-appearance:button;font:inherit }summary{ display:list-item }blockquote,dl,dd,h1,h2,h3,h4,h5,h6,hr,figure,p,pre{ margin:0 }fieldset{ margin:0;padding:0 }legend{ padding:0 }ol,ul,menu{ list-style:none;margin:0;padding:0 }textarea{ resize:vertical }input::-moz-placeholder,textarea::-moz-placeholder{ opacity:1;color:#9ca3af }input::placeholder,textarea::placeholder{ opacity:1;color:#9ca3af }button,[role=button]{ cursor:pointer }:disabled{ cursor:default }img,svg,video,canvas,audio,iframe,embed,object{ display:block;vertical-align:middle }img,video{ max-width:100%;height:auto }[hidden]{ display:none }*,:before,:after{ --tw-border-spacing-x: 0;--tw-border-spacing-y: 0;--tw-translate-x: 0;--tw-translate-y: 0;--tw-rotate: 0;--tw-skew-x: 0;--tw-skew-y: 0;--tw-scale-x: 1;--tw-scale-y: 1;--tw-scroll-snap-strictness: proximity;--tw-ring-offset-width: 0px;--tw-ring-offset-color: #fff;--tw-ring-color: rgb(59 130 246 / .5);--tw-ring-offset-shadow: 0 0 #0000;--tw-ring-shadow: 0 0 #0000;--tw-shadow: 0 0 #0000;--tw-shadow-colored: 0 0 #0000;--tw-backdrop-sepia:  }::backdrop{ --tw-border-spacing-x: 0;--tw-border-spacing-y: 0;--tw-translate-x: 0;--tw-translate-y: 0;--tw-rotate: 0;--tw-skew-x: 0;--tw-skew-y: 0;--tw-scale-x: 1;--tw-scale-y: 1;--tw-scroll-snap-strictness: proximity;--tw-ring-offset-width: 0px;--tw-ring-offset-color: #fff;--tw-ring-color: rgb(59 130 246 / .5);--tw-ring-offset-shadow: 0 0 #0000;--tw-ring-shadow: 0 0 #0000;--tw-shadow: 0 0 #0000;--tw-shadow-colored: 0 0 #0000;--tw-backdrop-sepia:  }.container{ width:100% }@media (min-width: 640px){ .container{ max-width:640px } }@media (min-width: 768px){ .container{ max-width:768px } }@media (min-width: 1024px){ .container{ max-width:1024px } }@media (min-width: 1280px){ .container{ max-width:1280px } }@media (min-width: 1536px){ .container{ max-width:1536px } }.mx-auto{ margin-left:auto;margin-right:auto }.mt-4{ margin-top:1rem }.mt-5{ margin-top:1.25rem }.flex{ display:flex }.table{ display:table }.h-full{ height:100% }.min-h-screen{ min-height:100vh }.w-full{ width:100% }.flex-1{ flex:1 1 0% }.table-auto{ table-layout:auto }.select-none{ -webkit-user-select:none;-moz-user-select:none;user-select:none }.flex-col{ flex-direction:column }.items-center{ align-items:center }.justify-center{ justify-content:center }.gap-10{ gap:2.5rem }.overflow-x-auto{ overflow-x:auto }.whitespace-nowrap{ white-space:nowrap }.border{ border-width:1px }.border-b{ border-bottom-width:1px }.border-l{ border-left-width:1px }.bg-gray-100{ --tw-bg-opacity: 1;background-color:rgb(243 244 246 / var(--tw-bg-opacity)) }.bg-gray-200{ --tw-bg-opacity: 1;background-color:rgb(229 231 235 / var(--tw-bg-opacity)) }.px-10{ padding-left:2.5rem;padding-right:2.5rem }.px-2{ padding-left:.5rem;padding-right:.5rem }.py-2{ padding-top:.5rem;padding-bottom:.5rem }.py-3{ padding-top:.75rem;padding-bottom:.75rem }.py-4{ padding-top:1rem;padding-bottom:1rem }.text-left{ text-align:left }.text-2xl{ font-size:1.5rem;line-height:2rem }.text-5xl{ font-size:3rem;line-height:1 }.text-9xl{ font-size:8rem;line-height:1 }.text-lg{ font-size:1.125rem;line-height:1.75rem }.font-bold{ font-weight:700 }.leading-none{ line-height:1 }.text-blue-700{ --tw-text-opacity: 1;color:rgb(29 78 216 / var(--tw-text-opacity)) }.text-gray-300{ --tw-text-opacity: 1;color:rgb(209 213 219 / var(--tw-text-opacity)) }.text-gray-700{ --tw-text-opacity: 1;color:rgb(55 65 81 / var(--tw-text-opacity)) }.underline{ text-decoration-line:underline }.hover\:no-underline:hover{ text-decoration-line:none }@media (min-width: 1024px){ .lg\:flex-row{ flex-direction:row }.lg\:text-\[250px\]{ font-size:250px } }@media (min-width: 1280px){ .xl\:text-\[400px\]{ font-size:400px } }
		</style>
		{/block}
	</head>
	<body>
		<section class="min-h-screen w-full flex items-center">
			<div class="container mx-auto px-10 py-4">
				{block "content"}
				{$name = explode(':', $e->title)}
				{$isAdmin = $modx->getUser()->isMember('Administrator')}
				<div class="flex flex-col lg:flex-row gap-10">
					<div class="flex-1 text-gray-300">
						<div class="text-9xl lg:text-[250px] xl:text-[400px] font-bold select-none leading-none">{$e->code|default:404}</div>
					</div>
					<div class="flex-1">
						<div class="flex flex-col justify-center h-full text-gray-700">
							<h1 class="text-5xl">{$name[1]|default:$e->title}</h1>
							{if $showErrorDetails && $isAdmin}<h2 class="text-2xl mt-4">{$e->message|escape}</h2>{/if}
						</div>
					</div>
				</div>
				{if $showErrorDetails && $isAdmin}
				<div class="flex flex-col justify-center w-full">
					<code class="py-3 text-lg mt-5">({$e->file}:{$e->line})</code>
					<div class="overflow-x-auto w-full">
						<table class="table-auto border w-full" dir="ltr" cellspacing="0" cellpadding="1" border="1" >
							<thead>
								<tr class="bg-gray-200">
									<th class="px-2 py-2" colspan="3">Call Stack</th>
								</tr>
								<tr class="border-b bg-gray-100">
									<th scope="col" class="text-left px-2 py-2">#</th>
									<th scope="col" class="text-left px-2 py-2 border-l">Function</th>
									<th scope="col" class="text-left px-2 py-2 border-l">Location</th>
								</tr>
							</thead>
							<tbody>
								{foreach $e->trace as $line}
									<tr class="border-b">
										<td class="whitespace-nowrap px-2 py-2">{$line@iteration}</td>
										<td class="whitespace-nowrap px-2 py-2 border-l"><code>{$line['class']}{$line['type']}{$line['function']}()</code></td>
										<td class="whitespace-nowrap px-2 py-2 border-l"><code>{$line['file']}<b>:</b>{$line['line']}</code></td>
									</tr>
								{/foreach}
							</tbody>
						</table>
					</div>
				</div>
				{/if}
				{/block}
			</div>
		</section>
	</body>
</html>
