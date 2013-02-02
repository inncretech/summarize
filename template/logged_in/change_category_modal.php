
<!-- Modal -->
<div id="changeCategoryModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&#215;</button>
    <h3 id="myModalLabel">Change Category <span id="change-category-modal-error"></span></h3>
  </div>
  <div class="modal-body">
    <form class="form-horizontal" id="sign-in-form">
	  <div class="control-group" style='margin-bottom: 10px;'>
		<label class="control-label" for="new-category-name" id="current-category-name" >Current Category</label>
		<div class="controls">
		  <input class="input-xlarge" type="text" id="new-category-name" placeholder="Enter new name here">
		</div>
	  </div>
	</form>
  </div>
  <div class="modal-footer">
	<button class="btn btn-primary" id="change-category-btn">Save</button>
	<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
  </div>
</div>
