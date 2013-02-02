<script src="http://code.highcharts.com/highcharts.js"></script>
<script src="http://code.highcharts.com/modules/exporting.js"></script>

<script type="text/javascript">
$(function () {
var chart;
	$(document).ready(function() 
	{
		chart = new Highcharts.Chart({
			chart: {
				renderTo: 'graph-container',
				type: 'bar'
			},
			title: {
				text: 'Product Rating'
			},
			xAxis: {
				categories: [
							<?php $data = $database->query("SELECT DISTINCT * FROM `feedback` WHERE `idproduct` = '".$id."' GROUP BY `category` ");
							$str=null;
							while ($result = mysql_fetch_array($data)) 
								{	
									$str .= "'".$result['category']."',";		//['asdas', 'asdasd', 'asdasd']
								}
								echo substr_replace($str ,"",-1);
							?> 
							]
			},
			yAxis: {
				min: 0,
				title: {
					text: 'Product Details'
				},
				stackLabels: {
				enabled: true,
				style: {
					fontWeight: 'bold',
					color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
				}
			}

			},
			legend: 
			{
				layout: 'vertical',
				align: 'right',
				verticalAlign: 'top',
				x: 0,
				y: 30,
				floating: true,
				borderWidth: 1,
				backgroundColor: '#FFFFFF',
				shadow: true
			},
			tooltip: {

			  formatter: function() {
				return '<b>'+ this.x +'</b><br/>'+
					this.series.name +': '+ this.y +'<br/>'+
					'Total: '+ this.point.stackTotal;
			}
			},

			plotOptions: {
				
				series: {
					dataLabels: {
					enabled: true,
					color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
				}
				}
			},
				series: [{
				pointWidth: 5,
				name: 'Positive',
				data: [<?php $data = $database->query("SELECT DISTINCT * FROM `feedback` WHERE `idproduct` = '".$id."' GROUP BY `category` ");
						$str=null;
						while ($result = mysql_fetch_array($data)) 
							{
								$feedbackdata = $database->query("SELECT * FROM `feedback` WHERE `category` = '".$result['category']."' AND `type`= 'good' AND `idproduct` = '".$id."'");
									$nr= 0;
									while ($feedbackinfo = mysql_fetch_array($feedbackdata) 	)
												{	 
														$nr += $feedbackinfo['thumb'];
													
												}
									$str .= $nr.",";
								
							}
							
							echo substr_replace($str ,"",-1);
						?> ]
			}, {
				pointWidth: 5,
				name: 'Negative',
				data: [<?php $data = $database->query("SELECT DISTINCT * FROM `feedback` WHERE `idproduct` = '".$id."' GROUP BY `category` ");
						$str=null;
						while ($result = mysql_fetch_array($data)) 
							{	
								$feedbackdata = $database->query("SELECT * FROM `feedback` WHERE `category` = '".$result['category']."' AND `type`= 'bad' AND `idproduct` = '".$id."'");
								
									$nr= 0;
									while ($feedbackinfo = mysql_fetch_array($feedbackdata) 	)
												{	 
														$nr += $feedbackinfo['thumb'];
													
												}
									$str .= $nr.",";
								
							}
							
							echo substr_replace($str ,"",-1);
						?> ]
			}]
		});

	});
});	
</script>
<div id="graph-container" style="width:990px; height: 400px; margin: 0 auto;"></div>


