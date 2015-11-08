<!DOCTYPE html>
<html lang="en">

<head>
    <script type="text/JavaScript" src="js/importmaster.js"></script>
    <script type="text/JavaScript" src="js/centreq.js"></script>
    <script type="text/JavaScript" src="js/centreq_sync.js"></script>
    <script type="text/JavaScript" src="js/toArray.js"></script>
    <script type="text/JavaScript" src="js/main.js"></script>
    
    <?php include '_header.php' ?>
</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation" id="nav">
    </nav>
    <div class="container">
      <div class="row">
        <div id="sideline_left" class="col-sm-3 col-md-3"> </div>
        <div class="col-sm-9 col-md-9">
            <div class="panel panel-default">
          <div class="panel-heading">
            <h4><i class="fa fa-fw fa-search"></i> Search for products</h4>
          </div>
          
          
          <form class="form-horizontal" role="form">
            <div class="form-group">
              <input type="email" class="form-control" id="search_input" placeholder="Search...">
              <div class="buttons">
                <button type="button" id="select_cheapest"><a href='#'>Take cheapest product</a></button>
                <button type="button" id="select_search"><a href='#'>Search for product</a></button>
              </div>
            </div>
          </form>
        </div>
    </div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>

</html>
