<!-- Add Product Modal -->
  <div id="addProduct" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="addProductLabel" aria-hidden="true">
  
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&#215;</button>
      <h2 id="addProductLabel">Add a Product</h2>
    </div>
	
    <div class="modal-body grey">
      <form class="form-inline" style="margin: 5px">
        <input type="text" class="input-xlarge" id="link" placeholder="URL of Product">
        <button type="submit" id="crawl-link" href="#addManualProduct"  role="button" class="btn btn-primary" data-dismiss="modal" data-toggle="modal">Auto-fill Info</button><button type="submit" href="#addManualProduct" role="button" class="btn btn-primary" data-dismiss="modal" data-toggle="modal" type="submit" class="btn" id="manual_product_add">Manually Add Info</button>
      </form>
    </div>
	<div class="modal-body">
	<div class="alert alert-danger" id="crawler-error" style="display:none;margin-bottom: 0px;background-color:white;color:#ff0039;">
            <strong>Heads Up!</strong>
            The domanin is not supported. Thank you for letting us know. Please add manually the product.
         </div>
	<div class="alert alert-success" id="crawler-success" style="display:none;margin-bottom: 0px;background-color:white;color:#3fb618;">
            <strong>Heads Up!</strong>
            This domain is supported please click on "Auto-fill Info"
         </div>
		</div>
  </div>
	
	<!-- Confirm Product Modal -->
  <div id="addManualProduct" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="confirmProductLabel" aria-hidden="true" style="1000px;">
	
	
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&#215;</button>
      <h2 id="confirmProductLabel">Add product</h2>
		<div class="alert alert-danger" id="product-error" style="display:none;margin-bottom: 0px;">
            <strong>Sorry, we encountered an error while extracting product details</strong>
            Please add the product manually.
         </div>
    </div>
	 <div id="addProductLoading" style="display:none;width: 300px;height: 200px;margin-left:auto;margin-right:auto;margin-top: -30px;"><img src="images/loading.gif"></div>	
     <div class="modal-body" id="addProductModalBody" >
      <form id="product-main-form" method="post" enctype="multipart/form-data" action='backend/ajax.post/image_uploader.php?product=true' style='margin:0px;'>
			
			  <div id="product-image">
				<label class="image-holder">
					<input type="hidden" id="image_data" value="default.png" w="300" h="200">
					<img id="image-preview" data-src="holder.js/300x200" alt="300x200"   src="images/default.png">
				</label>
				<div id='preview'></div>
				
					<button class="btn" id="upload-btn">
						<input type="file" style="opacity:0;position:relative;z-index:10;cursor:pointer;" name="photo" id="product-photo">
						<input type="hidden" name="product" value="true">
						<span class="upload-btn-text">Upload Image<span>
					</button>
				
				
			  </div>
			  <div class="caption" style="padding-bottom:0px;margin-bottom:5px;text-align:right;">
				<!--<h3>Thumbnail label</h3>-->
				<p><input class="product-title" type="text" placeholder="Title" style="margin:0px;width:55%;"></p>
				<p><textarea class="addProductTagArea">example</textarea></p>
				<textarea placeholder="Short description" class="description-area"  style="width:55%"></textarea>
			  </div>
			  <div >
				<p><input class="product-cost" type="text" placeholder="Cost" style="margin:0px;width:97.4%;"></p>
				<p><input class="product-url" type="text" placeholder="External Link" style="margin:0px;width:97.4%;"></p>
				
			  </div>
			
			
		</form>
		
    </div>
   
      
<!--       <hr style="margin-top: 5px; margin-bottom: 10px"/> -->
<!--       <form class="form-inline">
        <input type="text" class="input input-small" placeholder="Category"></input>
        <input type="text" class="input" placeholder="Your Feedback" style="width: 286px"></input>
        <button type="submit" class="btn btn-primary pull-right">Add Feedback</button>
      </form> -->
   
    <div class="modal-body grey">
      <a class="btn btn-info" data-dismiss="modal"><i class="icon icon-time icon-white"></i> Finish Later</a>
      <a class="btn btn-success pull-right" id="save-form-btn"><i class="icon icon-plus icon-white" ></i> Submit Product</a>
     <a class="btn btn-warning pull-right" id="reset-form-btn" data-dismiss="modal"><i class="icon icon-remove icon-white" ></i> Cancel</a>

    </div>
  </div>