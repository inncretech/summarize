<table class="table table-bordered">
<tr><th>Id</th><th>Title</th><th>Created At</th><th>Action</th></tr>
<?php foreach ($member_data['survey'] as $key=>$item){ ?>
	<tr id="survey-row-<?=$key;?>">
		<td><?=$item['survey_id'];?></td><td><a href="<?=SITE_ROOT."/survey.php?id=".$item['survey_id'];?>"><?=$item['title'];?></td><td><?=$item['created_at'];?></td>
		<td><button style="margin-right: 5px;" class="btn btn-success" onclick="window.location.href='<?=SITE_ROOT;?>/survey-result.php?id=<?=$item['survey_id'];?>';return false;">View Result</button><button class="btn btn-danger" onclick="survey.remove('<?=$key;?>','<?=$item['survey_id'];?>');return false;">Remove</button></td>
	</tr>
<?php } ?>
</table>