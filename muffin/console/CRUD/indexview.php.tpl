<div class="innerContainer">

	<div class="heading1">{ControllerName}</div>
	<br /> 
		<a href="<?php echo $http->getControllerUrl(array("controller"=>"{ControllerName}", "action"=>"add")); ?>">Add</a>
	<br />
	<br />
	<table border="0" cellpadding="5" cellspacing="0">
		<tr>{RowHeaderCode}
		</tr>
		<?php
			foreach(${ControllerNameLc} as ${ModelNameLc})
			{
				?>
				<tr>{RowCode}
				</tr>	
				<?php 
			}
		?>
	</table>
	
</div>