<!DOCTYPE html>
<html lang="en">

	<?php include '_header.php' ?>

  <!-- Header Carousel -->
  <header id="myCarousel" class="carousel slide">
    <!-- Indicators -->
    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
      <li data-target="#myCarousel" data-slide-to="2"></li>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner">
      <div class="item active">
        <div class="fill" style="background-image:url('images/shopfast1.jpg');"></div>
        <div class="carousel-caption">
          <h2>Shop Fast</h2>
        </div>
      </div>
      <div class="item">
        <div class="fill" style="background-image:url('images/shopcheap.jpg');"></div>
        <div class="carousel-caption">
          <h2>Shop Cheap</h2>
        </div>
      </div>
      <div class="item">
        <div class="fill" style="background-image:url('images/shopsmart.jpg');"></div>
        <div class="carousel-caption">
          <h2>Shop Smart</h2>
        </div>
      </div>
    </div>


    <div class="main-text hidden-xs">
      <div class="col-md-12 text-center">
        <img src='images/logo_small_black.png' />
      </div>
    </div>
    <!-- Controls -->
    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
      <span class="icon-prev"></span>
    </a>
    <a class="right carousel-control" href="#myCarousel" data-slide="next">
      <span class="icon-next"></span>
    </a>
  </header>
  
  <!-- Page Content -->
  <div class="container container_index">

    <!-- Marketing Icons Section -->
    <div class="row">
      <div class="col-lg-12">
        <h1 class="page-header text-center">
          Welcome to GroGo
        </h1>
      </div>
      <div class="col-md-3"></div>
      <div class="col-md-6">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h4><i class="fa fa-fw fa-user"></i> Log in</h4>
          </div>
          <form class="form-horizontal" role="form" action="/main.html?user=#inputEmail3" method="post">
            <div class="form-group">
              <div class="col-sm-2">
                <label for="inputEmail3" class="control-label">Email</label>
              </div>
              <div class="col-sm-10">
                <input type="email" class="form-control" id="inputEmail3" placeholder="Email" required />
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-2">
                <label for="inputPassword3" class="control-label">Password</label>
              </div>
              <div class="col-sm-10">
                <input type="password" class="form-control" id="inputPassword3" placeholder="Password" required />
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-offset-2 col-sm-10">
                <div class="checkbox">
                  <label>
                    <input type="checkbox" />Remember me
                  </label>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-offset-2 col-sm-10">
                <input type="submit" class="btn btn-default"></input> or <a href="/register.php">Register</a>
              </div>
            </div>
          </form>
        </div>
      <div class="col-md-3"></div>
      </div>
    </div>
    <!-- /.row -->
  </div>
  <!-- /.container -->

  <!-- jQuery -->
  <script src="js/jquery.js"></script>

  <!-- Bootstrap Core JavaScript -->
  <script src="js/bootstrap.min.js"></script>

  <!-- Script to Activate the Carousel -->
  <script>
  $('.carousel').carousel({
  interval: 5000 //changes the speed
  })
  </script>

  </body>

  </html>
