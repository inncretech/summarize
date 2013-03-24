<style>
.diagram-box{
	margin:10px;
	padding:5px;
	min-width:100px;
	max-width:300px;
	border:2px solid rgb(243, 243, 243);
	cursor:pointer;
	color:white;
	font-family: Tahoma, Geneva, sans-serif;
	background-color: white;
	text-align:center;
	margin-left:auto;
	margin-right:auto;
}

.diagram-box span {
    display: none;
	position:relative;
	
}
.diagram-box:hover span {
    border: #c0c0c0 1px dotted;
    padding: 5px 5px 5px 5px;
    display: block;
    z-index: 100;
    margin: 10px;
    position: absolute;
	color:#555;
	background-color:white;
    text-decoration: none
}
</style>
<div id="container">
	
</div>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script>
 var treeDiagram = new function() {
		var parent 	= this;
		this.render = function(data){
			var obj 	= JSON.parse(data);
			var code 	= '<table>';

			$.each(obj, function(key, val) {
				code += '<tr><td><table style="margin-left:auto;margin-right:auto;"><tr>';
				$.each(val, function(index,item) {
					var nextColor;
					if (item.next == "1"){
						nextColor = '#9954bb';
					}else{
						nextColor = '#ff0039';
					}
					code += '<td><div class="diagram-box" style="background-color:'+nextColor+'">'+item.title+" ["+item.percent+"%] ";
					code +='<span><img src="default.png"></span></div></td>';
				});
				code += '</tr></table></td></tr>';
			});
			code += '</table>';
			
			$("#container").html(code);
		}
	}
	
var data = new Array();

data[0]	 = new Array("Piatra","Vishal","Dan","Bogdan","Vivek","Suc");
data[1]	 = new Array("Piatra","Dan","Bogdan","Vishal");
data[2]	 = new Array("Piatra","Dan","Bogdan");
data[3]	 = new Array("Piatra","Bogdan");
data[4]	 = new Array("Piatra");

data = {
    '0' : {
        '0' : {
			'title' : 'Piatra',
			'percent' : '20',
			'next' : '1'
		},
		'1' : {
			'title' : 'Vishal',
			'percent' : '15',
			'next' : '1'
		},
		'2' : {
			'title' : 'Dan',
			'percent' : '13',
			'next' : '1'
		},
		'3' : {
			'title' : 'Bogdan',
			'percent' : '12',
			'next' : '1'
		},
		'4' : {
			'title' : 'Vivek',
			'percent' : '10',
			'next' : '0'
		},
		'5' : {
			'title' : 'Suc',
			'percent' : '10',
			'next' : '0'
		}
    },
	'1' : {
        '0' : {
			'title' : 'Piatra',
			'percent' : '30',
			'next' : '1'
		},
		'1' : {
			'title' : 'Vishal',
			'percent' : '20',
			'next' : '1'
		},
		'2' : {
			'title' : 'Dan',
			'percent' : '15',
			'next' : '1'
		},
		'3' : {
			'title' : 'Bogdan',
			'percent' : '10',
			'next' : '0'
		}
    },
	'2' : {
        '0' : {
			'title' : 'Piatra',
			'percent' : '40',
			'next' : '1'
		},
		'1' : {
			'title' : 'Vishal',
			'percent' : '30',
			'next' : '1'
		},
		'2' : {
			'title' : 'Dan',
			'percent' : '20',
			'next' : '0'
		}
    },
	'3' : {
        '0' : {
			'title' : 'Piatra',
			'percent' : '60',
			'next' : '1'
		},
		'1' : {
			'title' : 'Vishal',
			'percent' : '30',
			'next' : '0'
		}
    },
	'4' : {
        '0' : {
			'title' : 'Piatra',
			'percent' : '80',
			'next' : '1'
			
		}
    }
}

var json = JSON.stringify(data);			
treeDiagram.render(json);
</script>