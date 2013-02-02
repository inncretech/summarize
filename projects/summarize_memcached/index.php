<?php 
session_start(); 
include "include/database.php"; 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<?php include "include/header.php"; ?>
<script type="text/javascript">
		var page = 1,
      loading = false;
		$.get('include/get_products_for_index.php?page='+page, function(data) {
			$("#innercontainer").append(data);
			loading=false;
		});
  function nearBottomOfPage() {
    return $(window).scrollTop() > $(document).height() - $(window).height() - 100;
  }

  $(window).scroll(function(){
    if (loading) {
      return;
    }

    if(nearBottomOfPage()) {
      loading=true;
      page++;
		$.get('include/get_products_for_index.php?page='+page, function(data) {
			$("#innercontainer").append(data);
			loading=false;
		});
    }
  });

</script>
	</script>
	<body>
<div id="main">
<?php include "include/searchbox.php"; ?>
		<div id="innercontainer" style='width:1035px;'>

</div>
</div>     
</body>
</html>
