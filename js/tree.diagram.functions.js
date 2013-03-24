
var treeDiagram = new function() {
	var parent 	= this;
	this.render = function(tree_data){
		var tree_obj 	= JSON.parse(tree_data);
		var tree_code 	= '<table style="margin-left: auto;margin-right: auto;">';
			
		$.each(tree_obj, function(tree_key, tree_val) {
			tree_code += '<tr><td><table style="margin-left:auto;margin-right:auto;"><tr>';
			$.each(tree_val, function(index,item) {
				var nextColor;
				if (item.next == "1"){
					nextColor = '#9954bb';
				}else{
					nextColor = '#ff0039';
				}
				tree_code += '<td><div class="diagram-box" style="background-color:'+nextColor+'">'+item.title+" ["+item.percent+"%] ";
				tree_code +='<span><img src="/images/default.png"></span></div></td>';
			});
			tree_code += '</tr></table></td></tr>';
		});
		tree_code += '</table>';
		$("#tree-diagram-container").html(tree_code);

	}
}

var tree_data = new Array();

tree_data[0]	 = new Array("Samsung Galaxy S3","iPhone 5","Kindle","Nokia 510","Samsung Motorola","Siemens SK65");
tree_data[1]	 = new Array("Samsung Galaxy S3","Kindle","Nokia 510","iPhone 5");
tree_data[2]	 = new Array("Samsung Galaxy S3","Kindle","Nokia 510");
tree_data[3]	 = new Array("Samsung Galaxy S3","Nokia 510");
tree_data[4]	 = new Array("Samsung Galaxy S3");

tree_data = {
	'0' : {
		'0' : {
			'title' : 'Samsung Galaxy S3',
			'percent' : '20',
			'next' : '1'
		},
		'1' : {
			'title' : 'iPhone 5',
			'percent' : '15',
			'next' : '1'
		},
		'2' : {
			'title' : 'Kindle',
			'percent' : '13',
			'next' : '1'
		},
		'3' : {
			'title' : 'Nokia 510',
			'percent' : '12',
			'next' : '1'
		},
		'4' : {
			'title' : 'Samsung Motorola',
			'percent' : '10',
			'next' : '0'
		},
		'5' : {
			'title' : 'Siemens SK65',
			'percent' : '10',
			'next' : '0'
		}
	},
	'1' : {
		'0' : {
			'title' : 'Samsung Galaxy S3',
			'percent' : '30',
			'next' : '1'
		},
		'1' : {
			'title' : 'iPhone 5',
			'percent' : '20',
			'next' : '1'
		},
		'2' : {
			'title' : 'Kindle',
			'percent' : '15',
			'next' : '1'
		},
		'3' : {
			'title' : 'Nokia 510',
			'percent' : '10',
			'next' : '0'
		}
	},
	'2' : {
		'0' : {
			'title' : 'Samsung Galaxy S3',
			'percent' : '40',
			'next' : '1'
		},
		'1' : {
			'title' : 'iPhone 5',
			'percent' : '30',
			'next' : '1'
		},
		'2' : {
			'title' : 'Kindle',
			'percent' : '20',
			'next' : '0'
		}
	},
	'3' : {
		'0' : {
			'title' : 'Samsung Galaxy S3',
			'percent' : '60',
			'next' : '1'
		},
		'1' : {
			'title' : 'iPhone 5',
			'percent' : '30',
			'next' : '0'
		}
	},
	'4' : {
		'0' : {
			'title' : 'Samsung Galaxy S3',
			'percent' : '80',
			'next' : '1'
			
		}
	}
}

var tree_json = JSON.stringify(tree_data);
		
treeDiagram.render(tree_json);
