<?php
/* This file is part of Jeedom.
 *
 * Jeedom is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Jeedom is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Jeedom. If not, see <http://www.gnu.org/licenses/>.
 */
/*
require_once dirname(__FILE__) . '/../../../core/php/core.inc.php';
include_file('core', 'authentification', 'php');
if (!isConnect()) {
    include_file('desktop', '404', 'php');
    die();
}*/
?>

<?php
	require_once dirname(__FILE__) . '/../../../core/php/core.inc.php';
	include_file('core', 'authentification', 'php');
	if (!isConnect()) {
		include_file('desktop', '404', 'php');
		die();
	}
?>
<div class="row">
	<div class="col-sm-6">
		<legend>{{Source d'eau}}</legend>
		<form class="form-horizontal">
			<fieldset>
				<div class="form-group">
					<label class="col-lg-5 control-label">{{Temps entre 2 branches arrosages}}</label>
					<div class="col-lg-6">
						<input type="text" class="configKey"  data-l1key="temps" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-5 control-label">{{Débit de l'arrivée d'eau (mm ou L/H)}}</label>
					<div class="col-lg-6">
						<input type="text" class="configKey"  data-l1key="debit" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-5 control-label">{{Pression maximal de l'arrivée d'eau (bar)}}</label>
					<div class="col-lg-6">
						<input type="text" class="configKey"  data-l1key="pression" />
					</div>
				</div>
			</fieldset>
		</form>
	</div>
	<div class="col-sm-6">
		<legend>{{Météo}}</legend>
		<form class="form-horizontal">
			<fieldset>
				<div class="form-group">
					<label class="col-lg-5 control-label">{{Maximum de la probabilité de précipitation (%)}}</label>
					<div class="col-lg-6">
						<div class="input-group">
							<input class="configKey form-control input-sm" data-l1key="cmdPrecipProbability"/>
							<span class="input-group-btn">
								<a class="btn btn-success btn-sm listAction">
									<i class="fa fa-list-alt"></i>
								</a>
							</span>
						</div>
						<input type="text" class="configKey"  data-l1key="precipProbability" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-5 control-label">{{Vitesse du vent maximum (km/h)}}</label>
					<div class="col-lg-6">
						<div class="input-group">
							<input class="configKey form-control input-sm" data-l1key="cmdWindSpeed"/>
							<span class="input-group-btn">
								<a class="btn btn-success btn-sm listAction">
									<i class="fa fa-list-alt"></i>
								</a>
							</span>
						</div>
						<input type="text" class="configKey"  data-l1key="windSpeed" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-5 control-label">{{Humidité maximum (%)}}</label>
					<div class="col-lg-6">
						<div class="input-group">
							<input class="configKey form-control input-sm" data-l1key="cmdHumidity"/>
							<span class="input-group-btn">
								<a class="btn btn-success btn-sm listAction">
									<i class="fa fa-list-alt"></i>
								</a>
							</span>
						</div>
						<input type="text" class="configKey"  data-l1key="humidity" />
					</div>
				</div>				
				<div class="form-group">
					<label class="col-lg-5 control-label">{{Précipitation de la veille}}</label>
					<div class="col-lg-6">
						<div class="input-group">
							<input class="configKey form-control input-sm" data-l1key="cmdPrecipitation"/>
							<span class="input-group-btn">
								<a class="btn btn-success btn-sm listAction">
									<i class="fa fa-list-alt"></i>
								</a>
							</span>
						</div>
					</div>
				</div>
			</fieldset>
		</form>
	</div>
	 <div class="col-sm-6">
		<legend>{{Type de plantation}}
			<a class="btn btn-success btn-xs pull-right cursor" id="bt_AddTypePlantation"><i class="fa fa-check"></i> {{Ajouter}}</a>
		</legend>
		<form class="form-horizontal">
			<fieldset>
				<div class="form-group">
					<table id="table_type_plantation" class="table table-bordered table-condensed tablesorter">
						<thead>
							<tr>
								<th>{{Type de plantation}}</th>
								<th>{{Pluviometerie (mm)}}</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
			</fieldset>
		</form>
	</div>
</div>
<?php include_file('core', 'plugin.template', 'js');?>
