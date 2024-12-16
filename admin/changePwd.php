<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rent Right Bangalore</title>

    <?php
    include('admin-link.php');
    ?>

</head>

<!--=====================================================================-->




<body class="hold-transition sidebar-mini">
    <!--preloader-->
    <div id="preloader">
        <div id="status"></div>
    </div>
    <!-- Site wrapper -->
    <div class="wrapper">


   
    
    <?php
        include('header.php');
        ?>

        <!-- =============================================== -->
        <!-- Left side column. contains the sidebar -->
        <?php
        include('sidebar.php');
        ?>




        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="header-icon"><i class="fa  fa-unlock-alt"></i></div>
                <div class="header-title">
                    <h1>Setting</h1>
                </div>
            </section>
            <!-- Main content -->
            <section class="content">
                <div class="row">

                    <div class="col-sm-3"></div>

                    <div class="col-sm-6">
                        <div class="panel  panel-bd">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    <h4>Change Password</h4>
                                </div>
                            </div>

                            <div class="panel-body">

                                <div class="  panel-shadow1 ">

                                <form action="change_password.php" method="post">
                                <div class="form-group">
                                <label for="current_password">Current Password</label>
                                <input type="password" class="form-control" id="current_password" name="current_password"  placeholder="Current Password"  required>
                            </div>
                            <div class="form-group">
                                <label for="new_password">New Password</label>
                                <input type="password" class="form-control" id="new_password" name="new_password"  placeholder="New Password"  required>
                            </div>
                            <div class="form-group">
                                <label for="confirm_password">Confirm New Password</label>
                                <input type="password" class="form-control" id="confirm_password"  placeholder="Confirm New Password" name="confirm_password" required>
                            </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-add"><i class="fa fa-check"></i> Update
                                            </button>
                                        </div>
                                    </form>
                                </div>

                            </div>

                        </div>
                    </div>

                    <div class="col-sm-3"></div>

                </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->



                 
         <!-- footer copyright -->
        <?php
include('copy.php');
    ?>
        
    </div>
    <!-- /.wrapper -->



    <!-- Start Core Plugins
         =====================================================================-->
    <!-- jQuery -->
    <script src="assets/plugins/jQuery/jquery-1.12.4.min.js" type="text/javascript"></script>
    <!-- jquery-ui -->
    <script src="assets/plugins/jquery-ui-1.12.1/jquery-ui.min.js" type="text/javascript"></script>
    <!-- Bootstrap -->
    <script src="assets/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- lobipanel -->
    <script src="assets/plugins/lobipanel/lobipanel.min.js" type="text/javascript"></script>
    <!-- Pace js -->
    <script src="assets/plugins/pace/pace.min.js" type="text/javascript"></script>
    <!-- SlimScroll -->
    <script src="assets/plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"> </script>
    <!-- FastClick -->
    <script src="assets/plugins/fastclick/fastclick.min.js" type="text/javascript"></script>
    <!-- CRMadmin frame -->
    <script src="assets/dist/js/custom.js" type="text/javascript"></script>
    <!-- End Core Plugins
         =====================================================================-->
    <!-- Start Page Lavel Plugins
         =====================================================================-->
    <!-- ChartJs JavaScript -->
    <script src="assets/plugins/chartJs/Chart.min.js" type="text/javascript"></script>
    <!-- Counter js -->
    <script src="assets/plugins/counterup/waypoints.js" type="text/javascript"></script>
    <script src="assets/plugins/counterup/jquery.counterup.min.js" type="text/javascript"></script>
    <!-- Monthly js -->
    <script src="assets/plugins/monthly/monthly.js" type="text/javascript"></script>
    <!-- End Page Lavel Plugins
         =====================================================================-->
    <!-- Start Theme label Script
         =====================================================================-->
    <!-- Dashboard js -->
    <script src="assets/dist/js/dashboard.js" type="text/javascript"></script>
    <!-- End Theme label Script
         =====================================================================-->
    <script>
    function dash() {
        // single bar chart
        var ctx = document.getElementById("singelBarChart");
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ["Sun", "Mon", "Tu", "Wed", "Th", "Fri", "Sat"],
                datasets: [{
                    label: "My First dataset",
                    data: [40, 55, 75, 81, 56, 55, 40],
                    borderColor: "rgba(0, 150, 136, 0.8)",
                    width: "1",
                    borderWidth: "0",
                    backgroundColor: "rgba(0, 150, 136, 0.8)"
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
        //monthly calender
        $('#m_calendar').monthly({
            mode: 'event',
            //jsonUrl: 'events.json',
            //dataType: 'json'
            xmlUrl: 'events.xml'
        });

        //bar chart
        var ctx = document.getElementById("barChart");
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ["January", "February", "March", "April", "May", "June", "July", "august", "september",
                    "october", "Nobemver", "December"
                ],
                datasets: [{
                        label: "My First dataset",
                        data: [65, 59, 80, 81, 56, 55, 40, 65, 59, 80, 81, 56],
                        borderColor: "rgba(0, 150, 136, 0.8)",
                        width: "1",
                        borderWidth: "0",
                        backgroundColor: "rgba(0, 150, 136, 0.8)"
                    },
                    {
                        label: "My Second dataset",
                        data: [28, 48, 40, 19, 86, 27, 90, 28, 48, 40, 19, 86],
                        borderColor: "rgba(51, 51, 51, 0.55)",
                        width: "1",
                        borderWidth: "0",
                        backgroundColor: "rgba(51, 51, 51, 0.55)"
                    }
                ]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
        //counter
        $('.count-number').counterUp({
            delay: 10,
            time: 5000
        });
    }
    dash();
    </script>
</body>


</html>
