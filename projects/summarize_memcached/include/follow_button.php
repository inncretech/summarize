<?php
if (array_key_exists('uid',$_SESSION)){
$followed=$database->query("Select * from notifications_follow where uid='".$_SESSION['uid']."' and product='$id'");

if (isset($_SESSION['uid']))
if (mysql_num_rows($followed)>=1){
	//$followed=true;
	//unfollow
?> 
	<button onclick="unfollow_product('<?=$id;?>');" class="btn btn-primary start"><i class="icon-star icon-white"></i><span>Unfollow</span></button>
<?	
	} else {
	///$followed=false;
	//follow
?>
	<button onclick="follow_product('<?=$id;?>');" class="btn btn-primary start"><i class="icon-star icon-white"></i><span>Follow Product Reviews</span></button>
<?	
	}}
?>
<script>
function follow_product(id){
	$.get('process.php?action=1&p='+id, function(data) {
			$("#product"+id).html("<button onclick=\"unfollow_product('"+id+"');\" class='btn btn-primary start'><i class='icon-star icon-white'></i><span>Unfollow</span></button>");
	});

};
function unfollow_product(id){
		$.get('process.php?action=0&p='+id, function(data) {
			$("#product"+id).html("<button onclick=\"follow_product('"+id+"');\" class='btn btn-primary start'><i class='icon-star icon-white'></i><span>Follow Product Reviews</span></button>");
	});
};
</script>