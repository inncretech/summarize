<!doctype html>
 
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>jQuery UI Sortable - Default functionality</title>
  <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
  <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  <script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
  <link rel="stylesheet" href="/resources/demos/style.css" />

  <script type="text/javascript">
    $(function() {  
        $("#sortable").sortable({
            revert: true
        }); 
    });
</script>
  <style type="text/css">
    #draggable1 { width: 150px; height: 300px; padding: 0.5em;margin:5px;cursor:pointer; }
    #draggable2 { width: 150px; height: 300px; padding: 0.5em;margin:5px;cursor:pointer; }
    #draggable3 { width: 150px; height: 300px; padding: 0.5em;margin:5px;cursor:pointer; }
	#sortable>div { float: left; }
    #sortable { width: 1000px; height: 35px; padding: 0.5em; }
</style>
</head>
<body>
 
<div class="demo">
    <div id="sortable" >
        <div id = "draggable1" class="ui-state-default">Column 1</div>
        <div id = "draggable2" class="ui-state-default">Column 2</div>
        <div id = "draggable3" class="ui-state-default">Column 3</div>
		<div id = "draggable3" class="ui-state-default">Column 4</div>
		<div id = "draggable3" class="ui-state-default">Column 5</div>
    </div>
</div>
 
 
</body>
</html>