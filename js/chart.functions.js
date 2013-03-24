/**
 * Grid theme for Highcharts JS
 * @author Torstein Hønsi
 */

Highcharts.theme = {
   colors: ['#058DC7', '#E0564A', '#ED561B', '#DDDF00', '#24CBE5', '#64E572', '#FF9655', '#FFF263', '#6AF9C4'],
   chart: {
      backgroundColor: {
         linearGradient: [0, 0, 500, 500],
         stops: [
            [0, 'rgb(255, 255, 255)'],
            [1, 'rgb(240, 240, 255)']
         ]
      }
   },
   title: {
      style: {
         color: '#000',
         font: 'bold 16px "Trebuchet MS", Verdana, sans-serif'
      }
   },
   subtitle: {
      style: {
         color: '#666666',
         font: 'bold 12px "Trebuchet MS", Verdana, sans-serif'
      }
   },
   xAxis: {
      gridLineWidth: 1,
      lineColor: '#000',
      tickColor: '#000',
      labels: {
         style: {
            color: '#000',
            font: '11px Trebuchet MS, Verdana, sans-serif'
         }
      },
      title: {
         style: {
            color: '#333',
            fontWeight: 'bold',
            fontSize: '12px',
            fontFamily: 'Trebuchet MS, Verdana, sans-serif'

         }
      }
   },
   yAxis: {
      minorTickInterval: 'auto',
      lineColor: '#000',
      lineWidth: 1,
      tickWidth: 1,
      tickColor: '#000',
      labels: {
         style: {
            color: '#000',
            font: '11px Trebuchet MS, Verdana, sans-serif'
         }
      },
      title: {
         style: {
            color: '#333',
            fontWeight: 'bold',
            fontSize: '12px',
            fontFamily: 'Trebuchet MS, Verdana, sans-serif'
         }
      }
   },
   legend: {
      itemStyle: {
         font: '9pt Trebuchet MS, Verdana, sans-serif',
         color: 'black'

      },
      itemHoverStyle: {
         color: '#039'
      },
      itemHiddenStyle: {
         color: 'gray'
      }
   },
   labels: {
      style: {
         color: '#99b'
      }
   }
};

// Apply the theme
var highchartsOptions = Highcharts.setOptions(Highcharts.theme);
var categories 		= new Array();
var positive_data 	= new Array();
var negative_data 	= new Array();

function getArray(json, type) {
  var data = new Array();
  
  $.each(json,function(key,value){
	switch (type){
		case "s":
			data.push(value);
			break;
		case "i":
			data.push(parseInt(value));
			break;
	}
  });
  return data;
}

var chart = new function() {
	var parent = this;
	var category_check =false;
	var positive_check =false;
	var negative_check =false;
	
	
	this.getCategories = function (feedback_id) {
		$.post(site_root+"/backend/ajax.get/get_chart_categories.php",{product_id:product_id},function(data){
			
			categories 		= getArray(data,"s");
			category_check =true;
			if (category_check && positive_check && negative_check){createChart();}
		});
	}
	this.getPositiveData = function (feedback_id) {
		$.post(site_root+"/backend/ajax.get/get_chart_rating.php",{product_id:product_id,type:"0"},function(data){
				
				positive_data 	= getArray(data,"i");
				positive_check =true;
				if (category_check && positive_check && negative_check){createChart();}

		});
	}
	this.getNegativeData = function (feedback_id) {
		$.post(site_root+"/backend/ajax.get/get_chart_rating.php",{product_id:product_id,type:"1"},function(data){
			
			negative_data 	= getArray(data,"i");
			negative_check =true;
			if (category_check && positive_check && negative_check){createChart();}
		});
	}
	
	
	
	
		
}


if (typeof product_id !== 'undefined') {
	function refresh_chart(){
		chart.getCategories(product_id);
		chart.getPositiveData(product_id);
		chart.getNegativeData(product_id);
	}
}

var createChart = function(){
    var chart;
    $(document).ready(function() {
		var options = {
            chart: {
                renderTo: 'graph',
                type: 'bar'
            },
            title: {
                text: 'Category status'
            },
            xAxis: {
                categories: categories
            },
            yAxis: {
                min: 0,
                title: {
                    text: ''
                }
            },
            legend: {
                backgroundColor: '#FFFFFF',
                reversed: true
            },
            tooltip: {
                formatter: function() {
                    return ''+
                        this.series.name +': '+ this.y +'';
                }
            },
            plotOptions: {
                bar: {
                    dataLabels: {
                        enabled: true
                    }
                }
            },
                series: [{
                name: 'Positive',
                data: []
            }, {
                name: 'Negative',
                data: []
			}]
        };
		//options.xAxis.categories.push(categories);
		options.series[0].data = (positive_data);
		options.series[1].data = (negative_data);
		//alert(JSON.stringify(options));

        chart = new Highcharts.Chart(options);
    });
    
};











