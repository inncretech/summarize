<div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="brand" href="index.php">SummarizeIt</a>
          <div class="form-search navbar-search">
            <div class="input-append">
              <input type="text" class="span7 search-query" id="global-search" autocomplete="off" placeholder="Search products...">
              <button type="submit" class="btn btn-success" onclick="return false;" id="global-search-btn" >Search</button>
            </div>
          </div>
          <ul class="nav pull-right">

            <li><img class="img-rounded" src="images/upload/member/<?=$member_data['image']['full_image_url'];?>" style="width: 35px; height: 35px; margin-top: 8px"></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?=$member_data['login'];?><b class="caret"></b></a>
              <ul class="dropdown-menu">
                 <li><a href="profile.php?action=settings">Account Settings</a></li>
                  <li><a href="profile.php?action=activity">Recent Activity</a></li>
                  <li><a href="profile.php?action=notifications">Notifications</a></li>
				  <li><a href="profile.php?action=points">Points</a></li>
				  <li><a href="profile.php?action=messages">Messages</a></li>
                  <li class="divider"></li>
				
                  <li><a href="index.php?sign_out=true"  id="logout-button">Logout</a></li>
              </ul>
			  
            </li>
			<li><div class="notification-box">0</div></li>
          </ul>
        </div>
      </div>
    </div>
