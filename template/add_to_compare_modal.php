<!-- Add Product Modal -->
  <div id="addToCompare" style="width:750px;margin-left:-370px;" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="addProductLabel" aria-hidden="true">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&#215;</button>
      <h2 id="addProductLabel">Add products to compares</h2>
    </div>
    <div class="modal-body grey" style="height:380px;">
      <form class="form-inline" style="margin: 5px">
        <input type="text" class="input-xlarge" id="addCompareValue" style="width: 78%;" placeholder="Enter Product" autocomplete = "off">
        <button type="submit" id="addCompareBtn" onclick="compare.set(document.getElementById('addCompareValue').value);return false;" role="button" class="btn btn-primary" >Add to compare</button>
      </form>
	  <div class="form-horizontal" id="register-text" style="text-align: center;margin-top: 25px;">
		You can add a product to the compare list simply by searching the product in the form above and clicking the <br> "Add to compare" button. You can also click on the "+" button from products below.
		</div>
		<table cellspacing="2">
		<tr>
		<td valign="top" >
		<div class="form-horizontal"   style="text-align: left;padding:10px;float:left;width:330px;">
			<h3 style="text-align: center;"><strong>Product Compare List</strong></h3>
			<ul class="unstyled" id="compare-list">
				<div style="height: 145px;overflow: scroll;overflow-x: hidden;">
				</div>
				<li style="margin-top: 10px">
					<a href="#" class="btn btn-primary compare-button" style="width:93%" data-dismiss="modal">Compare Listed Products</a>
				</li>
				</ul>
		</div>
		</td><td valign="top" >
		<div class="form-horizontal" style="text-align: left;padding:10px;float:right;width:330px;">
			<h3 style="text-align: center;"><strong>Similar Products</strong></h3>
			<div class="similar-products">
			</div>
		</div>
		</td>
		</tr>
		</table>
		
    </div>
  </div>