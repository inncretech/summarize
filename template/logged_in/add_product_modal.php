<!-- Add Product Modal -->
<div id="addProduct" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="addProductLabel" aria-hidden="true">

	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&#215;</button>
		<h2 id="addProductLabel">Add a Product or an Entity</h2>
	</div>

	<div class="modal-body grey">
		<form class="form-inline" style="text-align:center;font-family:'calibri';font-size:18px;">
			<button type="submit" href="#addManualProduct" role="button" class="btn btn-primary" data-dismiss="modal" data-toggle="modal" type="submit" class="btn" id="manual_product_add" style="margin-bottom:5px;">Add Manually</button>
				<p style="text-align:center;">Or, Add automatically From Web URL</p>
			<input type="text" class="span6" id="link" placeholder="http://">
			<button type="submit" id="crawl-link" href="#addManualProduct"  role="button" class="btn btn-primary" data-dismiss="modal" data-toggle="modal">Add</button>
			<p style="text-align:center;margin-top:10px;">We allow adding products from popular sites like amazon.com, walmart.com, bestbuy.com, ... <br> If your favorite site is not here <a id="propose-modal-btn" href="#propose-website" data-dismiss="modal" data-toggle="modal">Please let us now</a>.</p>
			
		</form>
		<div class="alert alert-danger" id="crawler-error" style="display:none;margin-bottom: 0px;background-color:white;color:#ff0039;">
			<strong>Heads Up!</strong>
			The domanin is not supported. Thank you for letting us know. Please add manually the product.
		</div>
		<div class="alert alert-success" id="crawler-success" style="display:none;margin-bottom: 0px;background-color:white;color:#3fb618;">
		<strong>Heads Up!</strong>
		This domain is supported please click on "Add"
		</div>
	</div>

</div>

<!-- Add Product Modal -->
<div id="propose-website" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="addProductLabel" aria-hidden="true">

	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&#215;</button>
		<h2 id="addProductLabel">Propose a website for crawling</h2>
	</div>

	<div class="modal-body grey">
		<form class="form-inline" style="text-align:center;font-family:'calibri';font-size:18px;">
			<input type="text" class="span6" id="propose-url" placeholder="http://">
			<button type="submit" id="propose-btn"  role="button" onclick="return false;" class="btn btn-primary">Add</button>
			
			
		</form>
		<div class="alert alert-success" id="propose-success" style="display:none;margin-bottom: 0px;background-color:white;color:#3fb618;">
		<strong>Heads Up!</strong>
		Thank you for helping us!
		</div>
	</div>

</div>

<!-- Confirm Product Modal -->
<div id="addManualProduct" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="confirmProductLabel" aria-hidden="true" style="">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&#215;</button>
		<h2 id="confirmProductLabel">Add product</h2>
		<div class="alert alert-danger" id="product-error" style="display:none;margin-bottom: 0px;">
		<strong>Sorry, we encountered an error while extracting product details</strong>
		Please add the product manually.
		</div>
	</div>
	<div id="addProductLoading" style="display:none;width: 300px;height: 200px;margin-left:auto;margin-right:auto;margin-top: -30px;">
		<img src="/images/loading.gif">
	</div>	
	<div class="modal-body" id="addProductModalBody" >
	<form id="product-main-form" method="post" enctype="multipart/form-data" action='<?=SITE_ROOT;?>/backend/ajax.post/image_uploader.php?product=true' style='margin:0px;'>

		<div id="product-image">
			<label class="image-holder-product">
				<input type="hidden" id="image_data" value="default.png" w="300" h="200">
				<img id="image-preview" data-src="holder.js/300x200" alt="300x200"   src="/images/default.png">
			</label>
			<div id='preview'></div>

			<span class="btn" id="upload-btn" >
				<input type="file" style="opacity:0;padding: 10px;margin-left: -12px;position:relative;z-index:10;cursor:pointer;width:100%;height:100%;" name="photo" id="product-photo">
				<input type="hidden" name="product" value="true">
				<span class="upload-btn-text">Upload Image<span>
			</span>
		</div>
	</form>
		<div class="caption" id="product-details" style="padding-bottom:0px;margin-bottom:5px;text-align:right;">
			<p><input class="product-title" type="text" placeholder="Title" style="margin:0px;width:55%;"></p>
			<p><textarea class="addProductTagArea">example</textarea></p>
			<textarea placeholder="Short description" class="description-area"  style="width:55%;height:100px;"></textarea>
		</div>
		<div>
			<p><input class="product-cost" type="text" placeholder="Cost" style="margin:0px;width:97.4%;"></p>
			<p><input class="product-url" type="text" placeholder="External Link" style="margin:0px;width:97.4%;"></p>
		</div>
	

	</div>
	<div class="modal-body grey">
		
		<a class="btn btn-success pull-right" id="save-form-btn">
			<i class="icon icon-plus icon-white" ></i> Submit Product
		</a>
		<a class="btn btn-warning pull-right" id="reset-form-btn" data-dismiss="modal">
			<i class="icon icon-remove icon-white" ></i> Cancel
		</a>
	</div>
</div>