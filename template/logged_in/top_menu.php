<div class="navbar navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container">
			<a class="brand" href="<?=SITE_ROOT."/"?>index.php">SummarizeIt</a>
			<div class="navbar-search">
				<div class="input-append">
					<form style="margin:0px;">
					<input type="text" class="span3" id="global-search" autocomplete="off" placeholder="Search products...">
					<button type="submit" class="btn btn-success" onclick="return false;" id="global-search-btn" >Search</button>
					
					<a href="#advancedSearchModal" data-toggle="modal"><button type="submit" class="btn" onclick="return false;" >Advanced</button></a>
					</form>
					</a>
				</div>
			</div>
			<ul class="nav pull-right">
				<li><button href="#signInModal" role="button" class="btn btn-primary" data-toggle="modal" id="addProductBtn">Add Product<i class="icon-plus icon-white"></i></button></li>
				<li>
					<img class="img-rounded" src="<?='http://'.(S3_BUCKET).'.s3.amazonaws.com/m_'.$member_data['public_id']."_small.jpg";?>" style="width: 35px; height: 35px; margin-top: 8px;margin-left: 10px;">
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?=(strlen($member_data['login'])<8 ? $member_data['login'] : substr($member_data['login'], 0,7)."...");?><b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li>
							<a href="<?=SITE_ROOT?>/profile.php?action=settings">Account Settings</a>
						</li>
						<li>
							<a href="<?=SITE_ROOT?>/profile.php?action=activity">Recent Activity</a>
						</li>
						<li>
							<a href="<?=SITE_ROOT?>/profile.php?action=notifications">Notifications</a>
						</li>
						<li>
							<a href="<?=SITE_ROOT?>/profile.php?action=follow">Products Followed</a>
						</li>
						
						<!--<li>
							<a href="profile.php?action=messages">Messages</a>
						</li>-->
						<li class="divider"></li>
						<li>
							<a href="<?=SITE_ROOT;?>/index.php?sign_out=true"  id="logout-button">Logout</a>
						</li>
					</ul>
				</li>
				<li><div class="notification-box">0</div></li>
			</ul>
		</div>
	</div>
</div>
