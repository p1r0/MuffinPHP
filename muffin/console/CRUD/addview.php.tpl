<div class="heading1">Add {ModelName}</div>
<br /> 
<?php 
	echo $form->create();
?>

<?php 

if(isset($errors))
{
	?>
	<div class="error">
	<b>The following errores were found:</b><br /><br />
	<?php 
	foreach($errors as $error)
	{
		echo $error."<br />";
	}
	?>
	</div>
	<?php
}

?>
<div>
	{FormCode}
</div>

<?php 
	echo $form->end(true, 'Save');
?>

<script>

</script>