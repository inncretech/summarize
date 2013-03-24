<!-- Add Product Modal -->
  <div id="advancedSearchModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="addProductLabel" aria-hidden="true">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&#215;</button>
      <h2 id="addProductLabel">Advanced Search</h2>
    </div>
    <div class="modal-body grey" >
	  <div class="form-horizontal" id="advanced-search-text" style="text-align: center;margin-bottom: 10px;">
		This tool can help you search your desired item by your favorite features.
		</div>
      <div class="form-inline" style="margin: 5px">
        <input type="text" class="input-xlarge" id="advanced-search" style="width: 97.4%;" placeholder="Enter features" autocomplete = "off">
      </div>
		<div id="draggable-container">
	  <div class="form-inline" style="margin: 5px">
		<button class="btn btn-success" id="advance-search-button" style="width:100%;display:none;margin-bottom:5px;" data-dismiss="modal" onclick="render.advancedSearchItems();">Advanced Search your products.</button>
        <div id="dragg-to-area" class="ui-state-highlight" style="border:1px dashed grey;min-height:40px;padding: 5px;text-align: center;" title="Drag your favorite category here.">
			<span id="draggable-text">Enter your search item above to drag your favorite category here.</span>
		</div>
		
      </div>
	  <div id="category-for-search">
	  </div>
		</div>
    </div>
  </div>