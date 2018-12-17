<html>
<head>
<title>API Browser</title>
<style>
body {
	font: 12px Arial;
}
.f-left {
	float:left;
}
.f-right {
	float:right;
}
.ml-1em {
	margin-left:1em;
}
.mr-1em {
	margin-right:1em;
}
.p-1em {
	padding:1em;
}
.clear {
	clear:both;
}
.block {
	display:block;
}
</style>
</head>
<body>
	<div id="api_controllers" class="f-left mr-1em">
		<ul>
			<?php foreach ($apiControllers as $apiController):?>
			<li>
			<a href="/service_browser/index/?signature=<?php echo $apiController?>"><?php echo $apiController?></a>
				<?php if (!empty($apiMethods) && !empty($apiMethods[$apiController])):?>
				<ul>
					<?php foreach ($apiMethods[$apiController] as $method):?>
					<li><a href="/service_browser/index/?signature=<?php echo $apiController?>&method=<?php echo $method?>"><?php echo $method?></a></li>
					<?php endforeach;?>
				</ul>
				<?php endif;?>
			</li>
			<?php endforeach;?>
		</ul>
	</div>
	
	<?php if (!empty($selectedClass) && !empty($selectedMethod)):?>
	<div id="api_form"  class="f-left ml-2em">
		<fieldset>
		<legend>API Params</legend>
		<form id="api_request_form" method="<?php echo $submission_method?>" action="/service_browser/index">
		<input type="hidden" name="_method" value="<?php echo $submission_method?>" />
		<input type="hidden" name="signature" value="<?php echo $selectedClass?>" />
		<input type="hidden" name="method" value="<?php echo $selectedMethod?>" />
        <?php foreach ($method_params as $p):?>
			<div class="clear f-left p-1em">
			<label class="f-left mr-1em"><?php echo $p['name']?></label>
			<input class="f-left" type="<?php echo $p['type']?>" name="<?php echo $p['name']?>" />
			<div class="f-left"><?php echo $p['description']?></div>
			</div>
		<?php endforeach;?>
		<input type="submit" name="_submit" value="Submit" class="f-left clear" />
		</form>
		</fieldset>
		<?php if (!empty($result)):?>
		<div id="api_result">
		<?php yo::log($result)?>
		</div>
		<?php endif;?>
	</div>
	<?php endif;?>
</body>
</html>
<?php
