 function addFeedForm(value){
  $("#feed-add-"+value).remove();
  var str = '<div id="feed-add-'+value+'" style="display:none;"><div id="block" style="margin-top: 5px;border-bottom: 3px solid #B1AFAF;margin-bottom:5px;width:99%;margin-left:5px;"></div><input type="hidden" value="'+$("#cat-"+value).text()+'" id="catFeed'+value+'"><input type="text" class="feed-input" style="width:745px;margin-bottom: 2px;height: 20px;"  id="feed'+value+'" placeholder="Feedback..."><input type="checkbox" class="switch" id="typeFeed'+value+'"><button style="margin-bottom:2px;width:108px;height: 30px;margin-right:5px;margin-left:5px;" onclick="addFeedback('+value+');" class="btn btn-primary start"><i class="icon-upload icon-white"></i><span>Post</span></button>';
  $("#"+value).append(str);
  $("span[class=switch]").remove();
  $("input[type=checkbox].switch").each(function() {
    // Insert mark-up for switch
    $(this).before(
      '<span class="switch">' +
      '<span class="mask" /><span class="background" />' +
      '</span>'
    );
    // Hide checkbox
    $(this).hide();
   // Set inital state
 	if (!$(this)[0].checked) {
      $(this).prev().find(".background").css({left: "-56px"});
    }
  }); // End each()
 // Toggle switch when clicked
  $("span.switch").click(function() {
    // If on, slide switch off
    if ($(this).next()[0].checked) {
      $(this).find(".background").animate({left: "-56px"}, 200);
    // Otherwise, slide switch on
    } else {
      $(this).find(".background").animate({left: "0px"}, 200);
    }
    // Toggle state of checkbox
    $(this).next()[0].checked = !$(this).next()[0].checked;
  });
  
  $("#feed-add-"+value).fadeIn();
  }
  
  function clearFeedForm(value){
	$("#feed-add-"+value).remove();
  }
  
  function editCat(value,pName,pid){
	var str = $("#cat-"+value).text();
	$("#cat-"+value).css('display','none');
	$("#input-"+value).remove();
	$("#done-"+value).remove();
	$("#"+value).before('<input id="input-'+value+'" type="text" class="cat-input"  value="'+str+'">');
	$("#"+value).before('<img id="done-'+value+'" class="cat-img"  onclick="saveCat('+value+',\''+pName+'\','+pid+');" src="images/done.png">');
	$("#input-"+value).focus(function(){$("#input-"+value).css('box-shadow','none');});
  }
  
  function saveCat(value,pName,pid){
    if (logged){
	var str = $("#input-"+value).val();	
	$.post("process.php",{saveCat: 'true' , name: str,pid: pid , pname:pName},function(data){$("#input-"+value).remove();$("#done-"+value).remove();$("#cat-"+value).text(str);$("#cat-"+value).css('display','block');});
	}else{window.location.href='login.php';}
  }
  
  function fill(value,name,pid){
  for (i=0;i<value.length;i++){
	  createFill(value[i],name,pid);
	}
  }
  
  function createFill(val,name,pid){
  
  if ($("#"+val).attr("class")=="yes"){
		$("#"+val).html("");
		$("#"+val).attr("class","no");
	  }else{
	  $.post("include/getFeedback.php",{id: val,n: name,pi: pid},function(data){
		  data = $.parseJSON(data);
		  $("#"+val).html("");
		  var str="<table style='width:100%;'>";
			  
			  $.each(data, function (i,v){
			
			  
			  str +="<tr><td onclick='addLike("+v.id+",\""+v.type+"\","+val+");' style='width:2%;'><span  class='thumb-"+v.id+"' id='comment-"+v.type+"' style='cursor:pointer;float:right;font-size: 18px;font-weight: bold;margin-left: 5px;'>"+v.thumb+"</span></td><td><div id='comment-"+v.type+"' style='margin:2px;padding-left:10px;margin-right: 5px;'>"+v.comment+" <span onclick='addLike("+v.id+",\""+v.type+"\","+val+");' style='float:right;'><img src='images/up.png' style='width: 25px;margin-top: -3px;cursor:pointer;'><span></div></td></tr>";});
			  
			  str += '</table>';
			  $("#"+val).append(str);
		  });
		$("#"+val).attr("class","yes");
		}
  }
	function addFeedback(value)
	{
		if (logged)
		{
			var ok=true;
			if ($("#catFeed"+value).val().replace(" ", "")==""){ok=false;}
			if ($("#feed"+value).val().replace(" ", "")==""){ok=false;}
			if ($("#typeFeed"+value).val()=="none"){ok=false;$("#typeFeed"+value).css("background-color","#8CE7FF");}
			if (ok){
				$("#typeFeed"+value).css("background-color","white");
				$.post("process.php",{
					category: $("#catFeed"+value).val() ,
					id: pid,
					name: pname,
					addFeedback: 'true',
					feed: $("#feed"+value).val(),
					type: $("#typeFeed"+value).val()
					},function(data){
						if (data=='redirect'){
							window.location.href='login.php?msg=af&id='+pid;
						}
						else
						{
							addCat(data);
							clearFeedForm(value);
						}
					}
				);
			}
			refNot();
		}else{window.location.href='login.php';}
	}
	
	
	function addCat(data)
	{	
		var ok = true;
		var good;
		var bad;
		var idfeed;
		var category;
		var falseCaseCatId;
		data = $.parseJSON(data);
		$(".cat-name-box").each(function(){
			if ($.trim($(this).text()) == $.trim(data.category)){ok=false;falseCaseCatId = ($(this).attr('id').substring(4, $(this).attr('id').length));}
		});
		if (ok){
			if (data.type == 'good'){good=1;bad=0;}else{good=0;bad=1;};
			idfeed = data.idfeed;
			category = $.trim(data.category);
		}
		if (ok){
			var html="";
			html += '<div id="category-box">';
			html += '<div onclick="fill([\''+idfeed+'\']);" class="cat-h2">';
			html += '<span style="float:left;padding-right:10px;"><font id="good-'+idfeed+'" color="#1AB933" style="border-right:2px solid #C2C2C2;padding-right:5px;margin-right:5px;">'+good+'</font><font id="bad-'+idfeed+'" color="#DB3535">'+bad+'</font></span>';
			html += '<span class="cat-name-box"  id="cat-'+idfeed+'" style="float:left;">'+category+'</span></div>';
			html += '<span style="float:right;padding-right:10px;width:22px;cursor:pointer;" onclick="editCat('+idfeed+');"><img style="margin-top: -2px;" src="images/edit.png"></span>';
			html += '<span style="float:right;padding-right:10px;width:22px;cursor:pointer;" onclick="addFeedForm('+idfeed+');"><img style="margin-top: -2px;" src="images/plus.png"></span>';
			html += '<div class="cat-id-box" id="'+idfeed+'" style="width:100%;padding-top:25px;padding-bottom:3px;"> </div></div>';
			$("#category-container").append(html);
		}else{
			if (data.type == 'good'){$("#good-"+falseCaseCatId).text(parseInt($("#good-"+falseCaseCatId).text())+1);}
			if (data.type == 'bad'){$("#bad-"+falseCaseCatId).text(parseInt($("#bad-"+falseCaseCatId).text())+1);}
			createFill(falseCaseCatId);
		}
	}
	
	
	
	
	function confirm_add_review(fc,good2,bad2,id2)
	{
		$.post("process.php",{category:fc , id: id2,addFeedback: 'true', good: good2 , bad: bad2},function(data)
		{
			if (data=='redirect')
			{
				window.location.href='login.php?msg=af&id='+pid;
			}
			else
			{
				$(".ResultList").html(data);
				refNot();
			}
		});
		return false;
	}
	
	function isNumber(n) 
	{
		return !isNaN(parseFloat(n)) && isFinite(n);
	}
	
	function addLike(value,type,val)
	{
		$.get("process.php", { idfeedback: value, id: pid, addLike: "true"},function(data) 
		{
			
			if (isNumber(data))
			{
				if($(".thumb-"+value).text()!=data)
				{
				$(".thumb-"+value).text(data);
				$("#"+type+"-"+val).text(parseInt($("#"+type+"-"+val).text())+1);
				refNot();
				}
			}
			else
			{
				window.location.href=data;
			}
		});
	}
				
	function refNot()
	{
		if (logged)
		{
			$.get("include/getNotCount.php",function(data){$("#noti-count").text(data);});
		}
	}
	$(document).ready(function() 
	{	
		//select all the a tag with name equal to modal
		$('a[name=modal]').click(function(e) 
		{
			//Cancel the link behavior
			e.preventDefault();
			
			//Get the A tag
			var id = $(this).attr('href');
		
			//Get the screen height and width
			var maskHeight = $(document).height();
			var maskWidth = $(window).width();
		
			//Set heigth and width to mask to fill up the whole screen
			$('#mask').css({'width':maskWidth,'height':maskHeight});
			
			//transition effect		
			$('#mask').fadeIn(1000);	
			$('#mask').fadeTo("slow",0.8);	
		
			//Get the window height and width
			var winH = $(window).height();
			var winW = $(window).width();
				  
			//Set the popup window to center
			$(id).css('top',  winH/2-$(id).height()/2);
			$(id).css('left', winW/2-$(id).width()/2);
		
			//transition effect
			$(id).fadeIn(2000); 
	
		});
	
		//if close button is clicked
		$('.window .close').click(function (e) 
		{
			//Cancel the link behavior
			e.preventDefault();
			
			$('#mask').hide();
			$('.window').hide();
		});		
		
		//if mask is clicked
		$('#mask').click(function () 
		{
			$(this).hide();
			$('.window').hide();
		});			

		$(window).resize(function () 
		{
		 
			var box = $('#boxes .window');
	 
			//Get the screen height and width
			var maskHeight = $(document).height();
			var maskWidth = $(window).width();
		  
			//Set height and width to mask to fill up the whole screen
			$('#mask').css({'width':maskWidth,'height':maskHeight});
				   
			//Get the window height and width
			var winH = $(window).height();
			var winW = $(window).width();

			//Set the popup window to center
			box.css('top',  winH/2 - box.height()/2);
			box.css('left', winW/2 - box.width()/2);
		 
		});

	});
function tweetIt(u,at,ats){
	$.post('include/tweet-it.php' , {url: u , atk: at , atksecret: ats } , function(data){} );
	}	
function fbPost(u,n){
	$.post('include/fb-it.php' , {url: u , name: n} , function(data){alert("Product posted!");});
	}	
function goToFeed(){
	$('.postBlock').ScrollTo();
	}	
function highlight(){
	$(".hilite").each(function(){$(this).parent().html($(this).parent().text());});
		var str = $('#find').val();
		var options = {
			exact:"partial",
			style_name_suffix:false,
			highlight:".highlightable",
			keys:str
		}
		jQuery(document).SearchHighlight(options);
	}
function showGraph(){
$('#graph-summary').fadeIn();
}
function hideGraph(){
$('#graph-summary').fadeOut();
}
function fadeDiv(id,op){
	if (op==1){ 
		$(id).fadeIn();
	} else {
		$(id).fadeOut();
	}
}


var page = 1,
		  loading = false;
			$.get('include/get_products_for_index.php?page='+page+"&likeid=<?=$id;?>", function(data) {
				$("#innercontainer2").append(data);
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
			$.get('include/get_products_for_index.php?page='+page+"&likeid=<?=$id;?>", function(data) {
				$("#innercontainer2").append(data);
				loading=false;
			});
		}
	  });
		getQue();
		function postQue(){if (logged){$.post("include/postQue.php",{que: $('#question').val(), pid: pid},function(data){getQue();});}else{window.location.href='login.php';}}
		function getQue(){$.post("include/getQue.php",{pid: pid},function(data){
		 data = $.parseJSON(data);
		 $('#q-container').html('');
		 $.each(data, function (i,v)
		 {
			$('#q-container').append("<div style='width:700px;text-align:left;padding:0 0 5px 0;'><span style='font-size:15px;cursor:pointer;color: #08C;' onclick='window.location.href=\"user.php?uid="+v.uid+"\"'>"+v.user+" : </span><span class='highlightable' style='font-size:15px;cursor:pointer;color: #999;' onclick='window.location.href=\"answers.php?qid="+v.qid+"\"'> "+v.que+"</span></div>");
		 });
		});}
		  function showCompare(){
		   $("#compare-sum").fadeIn(500);
		  }
		  function hideCompare(){
		  $("#compare-sum").fadeOut(500);
		  }
		   function addCurentToCompare(){
			
				
				$.get("include/compare_list.php?a=-1&n="+name,function(data) {
				$("#compare-list").html(data);
				$.get("include/compare_table.php",function(data2) {
					$("#compare-table").html(data2);
					});
			//	$("#compare-list").append('<a href="javascript:void(0)" onclick="addNewToCompare()"> Add this to compare list </a>');
			//	$("#compare-list").append('<br><a href="compare.php"> Go to compare list </a>');
			});
			}
			addCurentToCompare();
   function addInput()
			{
				$("#prod-img").css('opacity','0');
				var top=$("#prod-img").offset().top;
				var left=$("#prod-img").offset().left;
				
				var width=$("#prod-img").width();
				var height=$("#prod-img").height();
				
				$("body").append("<form name='upimg' style='position:absolute;width:"+width+"px;height:"+height+"px;top:"+top+"px;left:"+left+"px;' method='post' action='process.php' enctype='multipart/form-data'><label style=\"background-image:url('images/add-img.png');background-repeat:no-repeat;width:"+width+"px;height:"+height+"px;top:"+top+"px;left:"+left+"px;\"><input style='width:"+width+"px;height:"+height+"px;opacity:0;' id='input-up' name='file' type='file' ><input name='id' type='hidden' value='"+pid+"'><input name='upload-image' type='hidden' value='true'></label></form>");
				$("#input-up").change(function()
				{
					var ext = $('#input-up').val().split('.').pop().toLowerCase();
					if($.inArray(ext, ['png','jpg']) == -1) {
						alert("Please select jpg or png images!");
					}else{
					document.upimg.submit();
					}
				});
			}
			function saveTag(tag)
			{		
				$.post("process.php", {saveTag: 'true',idproduct: pid,tag: tag },function(data){ if (data=="redirect") {window.location.href="login.php?msg=at&id="+pid;}else{refNot();}});		
			}
			function deleteTag(tag)
			{		
				$.post("process.php", {deleteTag: 'true',idproduct: pid,tag: tag },function(data){if (data=="redirect") {window.location.href="login.php?msg=at&id="+pid;}else{refNot();}});		
			}
  
 
  