<?php
require_once "backend/session.class.php";
$session = new Session();
$data = $session->get();

require_once "template/header.php";
if ($session->check()){
	require_once "template/logged_in/top_menu.php";
}else{
	require_once "template/logged_out/top_menu.php";
	require_once "template/logged_out/sign_in_modal.php";
	require_once "template/logged_out/register_modal.php";
}
	
	
	?>

    <div class="container-fluid">
      <div class="row-fluid">
        <div class="span3">
          <div class="well sidebar-nav">
            <ul class="nav nav-list">
              <li class="nav-header">Sidebar</li>
              <li class="active"><a href="#">Link</a></li>
              <li><a href="#">Link</a></li>
              <li><a href="#">Link</a></li>
              <li><a href="#">Link</a></li>
              <li class="nav-header">Sidebar</li>
              <li><a href="#">Link</a></li>
              <li><a href="#">Link</a></li>
              <li><a href="#">Link</a></li>
              <li><a href="#">Link</a></li>
              <li><a href="#">Link</a></li>
              <li><a href="#">Link</a></li>
              <li class="nav-header">Sidebar</li>
              <li><a href="#">Link</a></li>
              <li><a href="#">Link</a></li>
              <li><a href="#">Link</a></li>
            </ul>
          </div><!--/.well -->
        </div><!--/span-->
        <div class="span9">
          <div class="hero-unit">
            <h1>Hello, world!</h1>
            <p>This is a template for a simple marketing or informational website. It includes a large callout called the hero unit and three supporting pieces of content. Use it as a starting point to create something more unique.</p>
            <p><a class="btn btn-primary btn-large">Learn more &raquo;</a></p>
          </div>
          <div class="row-fluid">
            <div class="span4">
              <h2>Heading</h2>
              <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
              <p><a class="btn" href="#">View details &raquo;</a></p>
            </div><!--/span-->
           
          </div><!--/row-->
		  <div class="accordion" id="accordion2">
		  <div class="accordion-group">
			<div class="accordion-heading">
			  <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
				Speed
			  </a>
			</div>
			<div id="collapseOne" class="accordion-body collapse in">
			  <div class="accordion-inner">
				In kinematics, the speed of an object is the magnitude of its velocity (the rate of change of its position).
			  </div>
			</div>
		  </div>
		  <div class="accordion-group">
			<div class="accordion-heading">
			  <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo">
				Transparency
			  </a>
			</div>
			<div id="collapseTwo" class="accordion-body collapse">
			  <div class="accordion-inner">
				Transparency (optics), the physical property of allowing the transmission of light through a material
			  </div>
			  <div class="accordion-inner">
				Transparency (optics), the physical property of allowing the transmission of light through a material
			  </div>
			  <div class="accordion-inner">
				Transparency (optics), the physical property of allowing the transmission of light through a material
			  </div>
			  <div class="accordion-inner">
				Transparency (optics), the physical property of allowing the transmission of light through a material
			  </div>
			</div>
		  </div>

		  <div class="accordion-group">
			<div class="accordion-heading">
			  <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseThree">
				Transparency
			  </a>
			</div>
			<div id="collapseThree" class="accordion-body collapse">
			  <div class="accordion-inner">
				Transparency (optics), the physical property of allowing the transmission of light through a material
			  </div>
			</div>
		  </div>
		  <div class="accordion-group">
			<div class="accordion-heading">
			  <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseFour">
				Transparency
			  </a>
			</div>
			<div id="collapseFour" class="accordion-body collapse">
			  <div class="accordion-inner">
				Transparency (optics), the physical property of allowing the transmission of light through a material
			  </div>
			</div>
		  </div>
		  
		</div>
		 <div class="alert alert-info">
            <strong>Heads up!</strong>
            Options for individual tooltips can alternatively be specified through the use of data attributes.
          </div>
		  <div class="alert alert-warning">
            <strong>Heads up!</strong>
            Navbar links must have resolvable id targets. For example, a  must correspond to something in the dom like.
          </div>
		  <div class="alert alert-danger">
            <strong>Heads up!</strong>
            Navbar links must have resolvable id targets. For example, a  must correspond to something in the dom like.
          </div>
		  
		  <ul class="thumbnails">
              <li class="span4" style="background:white;">
                <div class="thumbnail" >
                  <img data-src="holder.js/300x200" alt="300x200" style="width: 300px; height: 200px;" src="images/default.png">
                  <div class="caption">
                    <h3>Thumbnail label</h3>
                    <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                    <p><a href="#" class="btn btn-primary">Action</a> <a href="#" class="btn">Action</a></p>
                  </div>
                </div>
              </li>
				<li class="span4" style="background:white;">
                <div class="thumbnail">
                  <img data-src="holder.js/300x200" alt="300x200" style="width: 300px; height: 200px;" src="images/default.png">
                  <div class="caption">
                    <h3>Thumbnail label</h3>
                    <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                    <p><a href="#" class="btn btn-primary">Action</a> <a href="#" class="btn">Action</a></p>
                  </div>
                </div>
              </li>
			  <li class="span4" style="background:white;">
                <div class="thumbnail">
                  <img data-src="holder.js/300x200" alt="300x200" style="width: 300px; height: 200px;" src="images/default.png">
                  <div class="caption">
                    <h3>Thumbnail label</h3>
                    <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                    <p><a href="#" class="btn btn-primary">Action</a> <a href="#" class="btn">Action</a></p>
                  </div>
                </div>
              </li>
             
            </ul>
        </div><!--/span-->
      </div><!--/row-->
    </div><!--/.fluid-container-->
<?php
if ($session->check()){
	require_once "template/logged_in/footer.php";
}else{
	require_once "template/logged_out/footer.php";
}
?>
</body>
</html>
