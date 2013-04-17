<div class="navbar navbar-fixed-top">
  <div class="navbar-inner">
	<div class="container">
	  <a class="brand" href="<?=SITE_ROOT."/"?>index.php">SummarizeIt</a>
	  <div class="navbar-search">
				<div class="input-append">
					<input type="text" class="span5" id="global-search" autocomplete="off" placeholder="Search products...">
					<button type="submit" class="btn btn-success" onclick="return false;" id="global-search-btn" >Search</button>
					<a  href="#advancedSearchModal" data-toggle="modal"><button type="submit" class="btn" onclick="return false;" >Filter</button></a>
					<a  href="#signInModal" role="button" class="btn btn-primary" data-toggle="modal" id="addProductBtn">Add<i class="icon-plus icon-white"></i>
					</a>
				</div>
			</div>
	  <ul class="nav pull-right">

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
