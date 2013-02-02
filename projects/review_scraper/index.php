<html>
<body>
<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
<script>
function scrape_wireless_amazon(){
	$.post("request_wireless.amazon.php",{data:$("#scrape_wireless_amazon_data").val()},function(data){alert("Done!");$("#scrape_wireless_amazon_data_view").html("<a href='"+data+"' target='_blank'>View</a>");});
}
</script>
Scraper... enter urls separated by comma....
<br>
<textarea rows="5" style="width:900px" id="scrape_wireless_amazon_data" placeholder="wireless.amazon.com"></textarea>
<br>
<input type="submit" onclick="scrape_wireless_amazon();" value="Scrape">
<br>
<div id="scrape_wireless_amazon_data_view"></div>
<br>
<hr>
<br>
<script>
function scrape_amazon(){
	$.post("request_amazon.php",{data:$("#request_amazon_data").val()},function(data){alert("Done!");$("#request_amazon_data_view").html("<a href='"+data+"' target='_blank'>View</a>");});
}
</script>
Scraper... enter urls separated by comma....
<br>
<textarea rows="5" style="width:900px" id="request_amazon_data" placeholder="www.amazon.com"></textarea>
<br>
<input type="submit" onclick="scrape_amazon();" value="Scrape">
<br>
<div id="request_amazon_data_view"></div>
</body>
</html>