<div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="#">Summarize</a>
          <div class="nav-collapse collapse">
		  <form class="navbar-form pull-left">
            <ul class="nav">
              <!--<li><a href="#">Add Item</a></li>-->
			  <li><button class="btn" type="button" style="margin:6px 5px 0 0 ;"><a href="add-item.php">Add Item</a></button></li>
              <li>
				<div class="input-append">
				  <input class="input-xxlarge-smaller" id="appendedInputButtons" type="text">
				  <button class="btn" type="button">Search</button>
				  <button class="btn" type="button">Advance</button>
				</div>
				
			  </li>
            </ul>
			</form>
            <form class="navbar-form pull-right">
				<ul class="nav">
				<li><img class="small-profile-image" src="images/blue-user-icon.png"></li>
				<li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?=$data['login'];?><b class="caret"></b></a>
                <ul class="dropdown-menu">
                  <li><a href="#">Account Settings</a></li>
                  <li><a href="#">Recent Activity</a></li>
                  <li><a href="#">Notifications</a></li>
				  <li><a href="#">Points</a></li>
				  <li><a href="#">Messages</a></li>
                  <li class="divider"></li>
                  <!--<li class="nav-header">Nav header</li>-->
                  <li><a href="#" onclick="return false;" id="logout-button">Logout</a></li>
                </ul>
				<li><div class="notification-box">10</div></li>
              </li>
             
            </form>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>