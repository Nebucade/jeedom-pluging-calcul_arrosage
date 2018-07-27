<?php
	require_once dirname(__FILE__) . '/../../../core/php/core.inc.php';
	include_file('core', 'authentification', 'php');
	if (!isConnect()) {
		include_file('desktop', '404', 'php');
		die();
	}
?>
<div class="col-sm-12">
    <legend>{{Météo}}</legend>
    <form class="form-horizontal">
			<fieldset>
				<div class="form-group">
					<label class="col-lg-5 control-label">{{Météo actuel}}</label>
					<div class="col-lg-6">
						<div class="input-group">
							<input class="configKey form-control input-sm" data-l1key="cmdConditionActuel"/>
							<span class="input-group-btn">
								<a class="btn btn-success btn-sm listAction">
									<i class="fa fa-list-alt"></i>
								</a>
							</span>
						</div>
						<input type="text" class="configKey"  data-l1key="conditionActuel" />
                    </div>
                    
                </div>
                <div class="form-group">
					<label class="col-lg-5 control-label">{{Temperature actuel}}</label>
					<div class="col-lg-6">
						<div class="input-group">
							<input class="configKey form-control input-sm" data-l1key="cmdTemperatureActuel"/>
							<span class="input-group-btn">
								<a class="btn btn-success btn-sm listAction">
									<i class="fa fa-list-alt"></i>
								</a>
							</span>
						</div>
						<input type="text" class="configKey"  data-l1key="temperatureActuel" />
                    </div>
                    
                </div>
                <div class="form-group">
					<label class="col-lg-5 control-label">{{Météo Demain}}</label>
					<div class="col-lg-6">
						<div class="input-group">
							<input class="configKey form-control input-sm" data-l1key="cmdConditiondemain"/>
							<span class="input-group-btn">
								<a class="btn btn-success btn-sm listAction">
									<i class="fa fa-list-alt"></i>
								</a>
							</span>
						</div>
						<input type="text" class="configKey"  data-l1key="conditiondemain" />
                    </div>
                    
                </div>
            </fieldset>
    </form>
</div>

<script>
	$("body").on('click', ".listAction", function() {
		var el = $(this).closest('.input-group').find('input');
		jeedom.cmd.getSelectModal({}, function (result) {
			el.value(result.human);
		});
	});
</script>