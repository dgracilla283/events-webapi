<html>
<head>
<title>Generate Client File</title>
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

	<div id="api_form"  class="f-left ml-2em">
		
		<?php if (!empty($arrClientFileGenerated)):?>
		<div>
			Successfully generated client file:
			<?php yo::log($arrClientFileGenerated)?>
		</div>
		<?php endif;?>
	
		<fieldset>
		<legend>API Controllers - select the controller you want to generate a client file</legend>
		<form id="api_request_form" method="post">
        <ul>
			<?php foreach ($apiControllers as $apiController):?>
			<li>
				<label><input type="checkbox" value="<?php echo $apiController?>" name="selectedApiController[]" /> <?php echo $apiController?></label> 
			</li>
			<?php endforeach;?>
		</ul>
		<input type="submit" name="_submit" value="Submit" class="f-right clear" />
		</form>
		</fieldset>
	</div>
</body>
</html>
<?php
