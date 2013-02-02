
<!-- Modal -->
<div id="addFeedbackModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&#215;</button>
    <h3 id="myModalLabel">Add Freedback <span id="add-feedback-modal-error"></span></h3>
  </div>
  <div class="modal-body">
    <form class="form-horizontal" id="sign-in-form">
	  <div class="control-group" style='margin-bottom: 10px;'>
		<label class="control-label" for="add-feedback-category">Category</label>
		<div class="controls">
		  <input class="input-xlarge" type="text" id="add-feedback-category" placeholder="The category of your feedback">
		</div>
	  </div>
	  <div class="control-group" style='margin-bottom: 10px;'>
		<label class="control-label" for="add-feedback-comment">Feedback</label>
		<div class="controls">
		  <input class="input-xlarge" type="text" id="add-feedback-comment" placeholder="Your thoughts about the product">
		</div>
	  </div>
	  <div class="control-group" style='margin-bottom: 10px;'>
		<label class="control-label" for="add-feedback-type">Type</label>
		<div class="controls">
			<select id="add-feedback-type" style="width: 284px;">
				<option value='0'>Positive</option>
				<option value='1'>Negative</option>
			</select>
		</div>
	  </div>
	</form>
  </div>
  <div class="modal-footer">
	<button class="btn btn-primary" id="add-feedback-btn">Save</button>
	<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
  </div>
</div>
