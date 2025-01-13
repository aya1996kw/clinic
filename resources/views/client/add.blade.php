<?php
use  App\Models\specialization;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Client</title>

    <!-- Custom fonts for this template-->
    <link href="/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">{{Auth::user()->name}}<sup></sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="home">
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">


              <!-- Nav Item - Tables -->
              <li class="nav-item">
                <a class="nav-link" href="../client/add">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Add date</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>


                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>
                     <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                                    <a class="dropdown-item" href="logout" data-toggle="modal" data-target="#logoutModal">
                                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Logout
                                    </a>
                        </li>
                    </ul>
                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid" style="text-align:center">
                <h1 style="color:blue;"> {{Auth::User()->name}}</h1>
                @if(isset($error))
                <small style="color: red;"> {{$error}}</small>
                @endif
                @if(isset($success))
                <small style="color: green;"> {{$success}}</small>
                @endif

                </div>
                <!-- /.container-fluid -->
<br><hr>
                <div class="container">

                <h5 class="container-fluid text-primary" style="text-align:center">Add date</h5>
                @if($message = Session::get('success'))
                <div class="alert alert-success">
                <p>{{$message}}</p>
                </div>
                @endif
                <h3 class="container-sm  text-primary">doctors</h3>
                <div class="row">
                    <div class="col-sm-6  ">

                    <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>specialization</th>
                                            <th>email</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($doctors as $doctor)
                                    <tr>
                                    <td>{{$doctor->name}}</td>
                                    <td>{{$doctor->Sp[0]->name}}</td>
                                    <td>{{$doctor->email}}</td>
                                    </tr>
                                    @endforeach
                         </tbody>
                        </table>
                    </div>
                </div>
    </div>
    <div class="col-sm-6 ">
                <form action="/pick_date" method="POST">
                @csrf
                <div class="container-fluid " style="text-align:center">
                <h3 class="container-fluid text-primary">Date</h3>
                <input type='datetime-local' name="date" placeholder="please select a date">
                <input type="email" name="email" placeholder="please select doctor email">
                <br><br>
                <button type="submit" class="btn btn-primary mb-3">submit</button>
                </form>
                <br>
                <form action="/rating" method="POST">
                @csrf
                <div class="container-fluid " style="text-align:center">
                <h3 class="container-fluid text-primary">Rating for doctor</h3>
                <div class="rating-css">
        <div class="star-icon">
        <input type="radio" value="1" name="product_rating" checked id="rating1">
        <label for="rating1" class="fa fa-star"></label>
        <input type="radio" value="2" name="product_rating" id="rating2">
        <label for="rating2" class="fa fa-star"></label>
        <input type="radio" value="3" name="product_rating" id="rating3">
        <label for="rating3" class="fa fa-star"></label>
        <input type="radio" value="4" name="product_rating" id="rating4">
        <label for="rating4" class="fa fa-star"></label>
        <input type="radio" value="5" name="product_rating" id="rating5">
        <label for="rating5" class="fa fa-star"></label>
        </div>
        </div>
        <label  for="start" class="text-warning" >Nots:</label>
        <textarea name="description" class="form-control" cols="10" rows="3">
        </textarea><br>
        <input type="email" name="email" placeholder="please select doctor email">
        <br> <br>
        <button type="submit" class="btn btn-primary mb-3">submit</button>
        </form>
        <hr>

<form action="" method="post" target="_top">

<input type="hidden" name="cmd" value="_pay_simple">
<input type="hidden" name="reset" value="1">
<input type="hidden" name="merchant" value="606a89bb575311badf510a4a8b79a45e">
<input type="hidden" name="currency" value="LTC">
<input type="hidden" name="amountf" value="1.00">
<input type="hidden" name="item_name" value="Test Item">
<input type="image" src="https://www.coinpayments.net/images/pub/buynow-grey.png" alt="Buy Now with CoinPayments.net">
</form>
</div>
                </div>
  </div>
  <br>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2022</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="../login">Logout</a>
                </div>
            </div>
        </div>
    </div>



</body>

</html>

    <!-- Bootstrap core JavaScript-->
    <script src="/vendor/jquery/jquery.min.js"></script>

    <script src="/vendor/bootstrap/js//bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="/vendor/jquery-easing/jquery.easing.min.js"></script>


    <!-- Custom scripts for all pages-->
    <script src="/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="/js/demo/chart-area-demo.js"></script>
    <script src="/js/demo/chart-pie-demo.js"></script>
