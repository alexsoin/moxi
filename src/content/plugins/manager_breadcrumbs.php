<?php
/*
	https://github.com/tanaevr/BreadCrumbsManager
	ppb_managerBreadCrumbs for modx 2.3.x
	Version: 0.1

	original plugincode written by @argnisto
	frankensteined by info@pepebe.
	Description: The plugin adds a breadcrumb navigation below the pagetitle
	for easier navigation/orientation.

	Note: Most of the code was shamelessly frankensteined from modDevTools by argnist.
	modDevTools can be installed by modx package manager. Try it, its a very useful plugin.
	The complete code for moddevtools is hosted on github: https://github.com/argnist/modDevTools

	If you want to have breadcrumbs, but you don't need the rest of modDevTools,
	this will do the job.

	Usage: Copy code into a new plugin (ppb_managerBreadCrumbs) and set it to OnDocFormPrerender. Done.

	2do:
	Rewrite the whole thing and get rid of stuff we don't need.

*/
$limit = 3;
if($modx->event->name != 'OnDocFormPrerender') return;

$config = array();
function getBreadCrumbs($resource,$modx,$limit) {
		if (($modx === modSystemEvent::MODE_NEW) || !$resource) {
			if (!isset($_GET['parent'])) {return;}
			if (!$resource) {return;}
		}

		$context = $resource->get('context_key');
		if ($context != 'web') {
			$modx->reloadContext($context);
		}

		$resources = $modx->getParentIds($resource->get('id'), $limit, array( 'context' => $context ));

		if ($modx === modSystemEvent::MODE_NEW) {
			array_unshift($resources, $_GET['parent']);
		}
		$crumbs = array();
		$root = $modx->toJSON(array(
			'text' => $context,
			'className' => 'first',
			'root' => true,
			'url' => '?'
		));
		$controllerConfig = $modx->controller->config;
		$action = $controllerConfig['controller'];
		if ($action == 'resource/create') {
			$action = 'resource/update';
		}
		if (isset($controllerConfig['id'])) {
			if ($controllerConfig['controller'] == 'resource/create') {
				$actionObj = $modx->getObject('modAction', array('controller' => 'resource/update'));
				$action = $actionObj->get('id');
			} else {
				$action = $controllerConfig['id'];
			}
		}


		$isAll = false;
		for ($i = count($resources)-1; $i >= 0; $i--) {
			$resId = $resources[$i];
			if ($resId == 0) {
				continue;
			}
			$parent = $modx->getObject('modResource', $resId);
			if (!$parent) {break;}
			if ($parent->get('parent') == 0) {
				$isAll = true;
			}
			$crumbs[] = array(
				'text' => $parent->get('pagetitle'),
				'url' => '?a=' . $action . '&id=' . $parent->get('id')
			);
		}


		if ((count($resources) == $limit) && !$isAll) {
			array_unshift($crumbs, array(
				'text' => '...',
			));
		}
		// Add pagetitle of current page
		if ($modx === modSystemEvent::MODE_NEW) {
			$pagetitle = $modx->lexicon('new_document');
		} else {
			$pagetitle = $resource->get('pagetitle');
		}
		$crumbs[] = array('text' => $pagetitle);
		$crumbs = $modx->toJSON($crumbs);

		$tpl = "
			<script id='managerBreadCrumbs_tpl' type='text' data-plugin='managerBreadCrumbs'>
				<tpl if=\"typeof(trail) != 'undefined'\">
					<div class='crumb_wrapper'>
						<ul class='crumbs'>
							<tpl for=\"trail\">
								<li {[values.className != 'undefined' ? 'class=\"'+values.className+'\"' : '' ]}>
									<tpl if=\"typeof url != 'undefined'\">
										<button type='button' data-url='{url}' class=\"controlBtn {[values.root ? ' root' : '' ]}\">
											{text}
										</button>
									</tpl>
									<tpl if=\"typeof url == 'undefined'\">
										<span class=\"text{[values.root ? ' root' : '' ]}\">
											{text}
										</span>
									</tpl>
								</li>
							</tpl>
						</ul>
					</div>
				</tpl>
			</script>
		";

		$modx->controller->addHtml($tpl);
		$panel = "
			<script type='text/javascript' data-plugin='managerBreadCrumbs'>
			var modDevTools = function(config) {
				config = config || {};
				modDevTools.superclass.constructor.call(this,config);
			};
			Ext.extend(modDevTools,Ext.Component,{
				page:{},window:{},grid:{},tree:{},panel:{},combo:{},config: {},view: {},utils: {}
			});
			Ext.reg('moddevtools',modDevTools);

			modDevTools = new modDevTools();
			if (typeof modDevTools.modx23 == 'undefined') {
				modDevTools.modx23 = typeof MODx.config.connector_url != 'undefined' ? true : false;
			}

			modDevTools.BreadcrumbsPanel = function(config) {
				config = config || {};
				Ext.applyIf(config,
					{
						 bdMarkup: document.getElementById('managerBreadCrumbs_tpl').innerHTML
						,bodyStyle: {background: 'transparent'}
					}
				);
				modDevTools.BreadcrumbsPanel.superclass.constructor.call(this,config);
			}

			Ext.extend(modDevTools.BreadcrumbsPanel,MODx.BreadcrumbsPanel,{
				onClick: function(e) {
					var target = e.getTarget();
					if (typeof target != 'undefined') {
						var url = target.getAttribute('data-url');
						if (url) {
							MODx.loadPage(url);
						}
					}
				}
				,_updatePanel: function(data){
					this.tpl.overwrite(this.body, data);
					var \$this = this;
					setTimeout(function(){
						\$this.ownerCt.doLayout();
					}, 200);
				}
				,getPagetitle: function(){
					var pagetitleCmp = Ext.getCmp('modx-resource-pagetitle');
					var pagetitle;
					if (typeof pagetitleCmp != 'undefined') {
						pagetitle = pagetitleCmp.getValue();
						if (pagetitle.length == 0) {
							pagetitle = _('new_document');
						}
					} else {
						pagetitle = '';
					}
					return pagetitle;
				}

			});
			Ext.reg('moddevtools-breadcrumbs-panel',modDevTools.BreadcrumbsPanel);
			Ext.onReady(function() {
				var header = Ext.getCmp('modx-resource-header').ownerCt;
				header.insert( 1, {
					xtype: 'moddevtools-breadcrumbs-panel'
					,id: 'resource-breadcrumbs'
					,desc: ''
					,root : {$root}
				});
				header.doLayout();
				var crumbCmp = Ext.getCmp('resource-breadcrumbs');
				var bd = { trail : {$crumbs}};
				crumbCmp.updateDetail(bd);
				Ext.getCmp('modx-resource-pagetitle').on('keyup', function(){
					bd.trail[bd.trail.length-1] = {text: crumbCmp.getPagetitle()};
					crumbCmp._updatePanel(bd);
				});
			});
			</script>";

		$modx->controller->addHtml($panel);
	}
getBreadCrumbs($resource,$modx,$limit);
return;
