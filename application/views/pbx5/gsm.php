<script type="text/javascript">
	$(document).ready(function(){
		$('#chkCheckAll').change(function(){
			$('.clProjects').prop('checked', $(this).prop('checked'));
		});
	})



</script>

<?php
	if(function_exists('validation_errors'))
		echo validation_errors();
?>

<div class="row">
	<div class="col-md-6">
		<form action="#" method="POST" role="form">
			<legend>GSM Report</legend>	
			<div class="row">
				<div class="col-sm-3">
					<select class="form-control" name="selGsm">
						<option value="vinaMobi">Vina Mobi</option>
						<option value="viettel">Viettel</option>
					</select>
				</div>
			</div>	

		    <table style="margin-top: 0.5em">
		        <td><b>Start Date:</b></td> <td><input class="form-control" type="text" id="txtStartDate" name="txtStartDate" value="<?php echo date("Y-m-d"); ?>" /></td>
		        <td style="padding-left: 5px;"><b>Finish Date:</b></td> <td><input class="form-control" type="text" id="txtEndDate" name="txtEndDate" value="<?php echo date("Y-m-d"); ?>" /></td>
		        <td style="padding-left:5px;"><input type="submit" name="submit" value="Submit" class="btn btn-default" /></td>
		    </table>			

			<div class="checkbox">
				<label><input type="checkbox" id="chkCheckAll" checked>Check All</label>
			</div>

		
			<div class="checkbox">
				<?php foreach($project_prefix as $key => $value): ?>
				<label class="checkbox-inline">
					<input type="checkbox" name="chkProjects[]" value="<?php echo $value;?>" class="clProjects" checked> <?php echo $key;?>
				</label>
				<?php endforeach;?>
			</div>

		</form>
	</div>
</div>

<div class="row">
	<div class="col-md-6">
		<?php 
		if(isset($gsmReportTable))
		{
			if($gsmReportTable === FALSE)
				echo '<h4 style="color:red;"><b>Ko có dữ liệu.<b></h4>';
			else
				echo $gsmReportTable;
		}
		?>
	</div>
</div>
