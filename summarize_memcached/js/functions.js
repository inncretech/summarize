
 var a1;

 jQuery(function() {
 $.ui.autocomplete.prototype._renderItem = function( ul, item){
  var term = this.term.split(' ').join('|');
  var re = new RegExp("(" + term + ")", "gi") ;
  var t = item.label.replace(re,"<span class='highlighttext'>$1</span>");
  return $( "<li></li>" )
     .data( "item.autocomplete", item )
     .append( "<a>" + t + "</a>" )
     .appendTo( ul );
};
 var options = {
 serviceUrl: 'auto_suggest_tags.php',
 width: 514,
 delimiter: /(,|;)\s*/,
 deferRequestBy: 0, //miliseconds
 params: { country: 'Yes' },
 noCache: false //set to true, to disable caching
 };
  var options2 = {
 source: 'auto_suggest_tags.php',
 width: 514,

 };
 
 //add new options source for message to-for
 
 a1 = $('#query').autocomplete(options2);
 
 $('#navigation a').each(function() {
 $(this).click(function(e) {
 var element = $(this).attr('href');
 $('html').animate({ scrollTop: $(element).offset().top }, 300, null, function() { document.location = element; });
 e.preventDefault();
 });
 });
 });
var menuOn=false;
  var selectedInput = null;
  function menuF(){
  if (!menuOn){$('#user-dropdown').fadeIn();menuOn=true;}else{$('#user-dropdown').fadeOut();menuOn=false;}
  }
$(document).ready(function() {
  $('input').focus(function() {
	selectedInput= this;
	});
$(document).keyup(function(event){
	if (event.keyCode == 13) {
	if (selectedInput.id=="catFeed"){
		addFeedback();
	}
	if (selectedInput.id=="goodFeed"){
		addFeedback();
	}
	if (selectedInput.id=="badFeed"){
		addFeedback();
	}
	if (selectedInput.id=="query"){
	 $(".subbx").click(); 
	}
	if (selectedInput.id=="qc"){
		addNewToCompareByName(selectedInput.value);
	}
	}
	});
	});
   
