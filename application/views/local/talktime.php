
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// $today = date("m/d/Y");
$today = date("Y-m-d");
$frm = array('sd'=>$today, 'ed'=>$today);

?>

<script type="text/javascript">
	// function toggle(source)
	// {
	// 	checkboxes = document.getElementsByClassName('cl_chkbox_extens');
	// 	for(var i=0, n=checkboxes.length; i<n; i++)
	// 		checkboxes[i].checked = source.checked;
	// }



	$(document).ready(function(){
		var startDate = $('#txtStartDate');
		var endDate = $('#txtEndDate');

		startDate.datepicker({
			showAim: 		'drop',
			dateFormat: 	'yy-mm-dd'
		});
		endDate.datepicker({
			showaim: 		'drop',
			dateFormat: 	'yy-mm-dd'
		});


		$('#n_checkall').change(function() {
			$('.cl_chkbox_extens').prop('checked', $(this).prop('checked'));
		});
	});
</script>


<h1 style="color: #7961AA;">Outbound Summary</h1>

<?php
	if(function_exists('validation_errors'))
	{
		// echo '<h4 style="color: red">'.validation_errors().'</h4>';
		echo validation_errors();
	}
?>		

<!-- Form submit -->
<form method="post" action="#">
    <!-- Table chon ngày <table cellpadding=2 boder=0> -->
    <table style="width: 620px;">
        <td><b>Start Date:</b></td> <td><input class="form-control" type="text" id="txtStartDate" name="txtStartDate" value="<?php echo $frm['sd']; ?>" /></td>
        <td style="padding-left: 5px;"><b>Finish Date:</b></td> <td><input class="form-control" type="text" id="txtEndDate" name="txtEndDate" value="<?php echo $frm['ed']; ?>" /></td>
        <td style="padding-left:5px;"><input type="submit" name="submit" value="Submit" class="btn btn-default" /></td>
    </table>
	
	<!--<input type="checkbox" id="n_checkall" onClick="toggle(this)" checked /><label for="n_checkall">Check All</label><br />  -->
	<input type="checkbox" id="n_checkall" onClick="" checked /><label for="n_checkall">Check All</label><br /> 
    
    <!-- Query ten tsr va the hien trong checklist box -->
    <div id="checkboxextens"; style="height: auto; overflow: auto; width: 940px; border-top: solid 2px #ccc; margin-bottom: 5px;">
        <!-- khoi tao ket noi mysql de query ten tsr -->
        <?php 
       
			foreach ( $extensions as $exten )
			{
				echo '<div style="float: left; width: 188px;" ><input type="checkbox" id="exten_'.$exten->name.'" name="chkExtens[]" class="cl_chkbox_extens" value="'.$exten->extension.'" checked /><label for="exten_'.$exten->name.'">'.$exten->name.'</label></div>';
			}
            echo '<div style="clear: both;"></div>';
        ?>    
    </div>
</form>
    

<?php


	if( isset($resultData) )
	{
		if(is_array($resultData))
			cpre($resultData);
		if(is_string($resultData))
			echo $resultData;
	}

	if( isset($talktimeTable) )
	{
		if( $talktimeTable === FALSE )
			echo '<b>Ko có dữ liệu.<b>';
		else
			echo $talktimeTable;
	}


?>












