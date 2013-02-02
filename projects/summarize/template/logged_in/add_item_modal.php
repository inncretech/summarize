
<!-- Modal -->
<div id="useLink" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&#215;</button>
    <h3 id="myModalLabel">Load Data <span id="sign-in-modal-error"></span></h3>
  </div>
  <div class="modal-body">
    <form class="form-horizontal" id="sign-in-form">
	  <div class="control-group" style='margin-bottom: 10px;'>
		<label class="control-label" for="login">External link of product</label>
		<div class="controls">
		  <input class="input-xlarge" type="text" id="link" placeholder="Enter url">
		</div>
	  </div>
	</form>
  </div>
  <div class="modal-footer">
	<button class="btn btn-primary" id="crawl-link">Use</button>
	<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
  </div>
</div>
