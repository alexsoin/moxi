<?php
$eventName = $modx->event->name;
switch ($eventName) {
	case 'OnTempFormPrerender':
		$root_dir = $modx->getOption('base_path');
		$elements_path = $modx->getOption('pdotools_elements_path');
		$elements_url = str_replace($root_dir, '', $elements_path);
		$output = '
			<script>
				Ext.onReady(function() {
					var openModalWindow = function() {
						const templateCode = document.querySelector(`#x-form-el-modx-template-content [name="content"]`).value;
						const regex = /(?:extends|include)\s+\'file:([^\']+)\'/g;
						let m;
						const listLinks = [];
						while ((m = regex.exec(templateCode)) !== null) {
							if (m.index === regex.lastIndex) { regex.lastIndex++; }

							m.forEach((match, groupIndex) => {
								if(groupIndex === 1) {
									listLinks.push(`
									<a class="x-btn x-btn-small" href="?a=system/file/edit&file='.$elements_url.'${match}" target="_blank">
										<span class="icon icon-file-text"></span> ${match}
									</a>
									`)
								}
							});
						}
						var win = new Ext.Window({
							title: "Fenom файлы шаблона",
							width: 600,
							height: 300,
							layout: "fit",
							modal: true,
							items: [
								{
									xtype: "panel",
									html: `<div style="display: flex; flex-direction: column; gap: .5rem;">${listLinks.join("")}</div>`
								}
							]
						});
						win.show();
					};

					var addButton = function() {
						var toolbar = Ext.getCmp("modx-action-buttons");
						if (toolbar) {
							toolbar.insertButton(0, {
								xtype: "button",
								text: `<i class="icon icon-file-text"></i> Файлы шаблона`,
								handler: openModalWindow,
								cls: "red-button",
							});
							toolbar.doLayout();
						}
					};

					addButton();
				});
			</script>
		';
		$modx->controller->addHtml($output);
		break;
}
