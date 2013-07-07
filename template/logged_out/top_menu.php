<div class="navbar navbar-fixed-top">
  <div class="navbar-inner">
	<div class="container">
	  <a class="brand" href="<?=SITE_ROOT."/"?>index.php">SummarizeIt</a>
	  <div class="navbar-search">
				<div class="input-append">
					<form style="margin:0px;">
					<input type="text" class="span3" id="global-search" autocomplete="off" placeholder="Search products...">
					<button type="submit" class="btn btn-success" onclick="return false;" id="global-search-btn" >Search</button>
					
					<a  href="#advancedSearchModal" data-toggle="modal"><button type="submit" class="btn" onclick="return false;" >Advanced</button></a>
					</form>
				</div>
			</div>
	  <ul class="nav pull-right">
		<li><button href="#signInModal" role="button" class="btn btn-primary" data-toggle="modal" id="addProductBtn">Add Product<i class="icon-plus icon-white"></i></button></li>
		<li>
              <a href="#signInModal" data-toggle="modal" >Sign in</a>
			  </li>
			  <li style="margin-left:5px;">
				<a href="#registerModal" data-toggle="modal">Register</a></button>
			  </li>
	  </ul>
	</div>
  </div>
</div>
