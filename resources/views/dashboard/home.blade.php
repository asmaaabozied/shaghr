@extends('dashboard.layouts.app')

@section('content')

        <div class="container-fluid">
            <!-- Page-Title -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-title-box">

                        <h4 class="page-title">@lang('site.home')</h4>
                    </div><!--end page-title-box-->
                </div><!--end col-->
            </div>
            <!-- end page title end breadcrumb -->
            <div class="row">
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="card dash-data-card text-center">
                                <div class="card-body">
                                    <div class="icon-info mb-3">
                                        <i class="fas fa-ticket-alt bg-soft-warning"></i>
                                    </div>
                                    <h3 class="text-dark">184</h3>
                                    <h6 class="font-14 text-dark">New Tickets</h6>
                                </div><!--end card-body-->
                            </div><!--end card-->
                        </div><!-- end col-->
                        <div class="col-lg-3">
                            <div class="card dash-data-card text-center">
                                <div class="card-body">
                                    <div class="icon-info mb-3">
                                        <i class="fab fa-codepen bg-soft-pink"></i>
                                    </div>
                                    <h3 class="text-dark">101</h3>
                                    <h6 class="font-14 text-dark">Open Tickets</h6>
                                </div><!--end card-body-->
                            </div><!--end card-->
                        </div><!-- end col-->
                        <div class="col-lg-3">
                            <div class="card dash-data-card text-center">
                                <div class="card-body">
                                    <div class="icon-info mb-3">
                                        <i class="fas fa-hands bg-soft-success"></i>
                                    </div>
                                    <h3 class="text-dark">18</h3>
                                    <h6 class="font-14 text-dark">On Hold</h6>
                                </div><!--end card-body-->
                            </div><!--end card-->
                        </div><!-- end col-->
                        <div class="col-lg-3">
                            <div class="card dash-data-card text-center">
                                <div class="card-body">
                                    <div class="icon-info mb-3">
                                        <i class="fas fa-lock bg-soft-primary"></i>
                                    </div>
                                    <h3 class="text-danger">92</h3>
                                    <h6 class="font-14 text-dark">Unassigned</h6>
                                </div><!--end card-body-->
                            </div><!--end card-->
                        </div><!-- end col-->
                    </div><!--end row-->
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mt-0">Tickets Status</h4>
                            <div class="">
                                <div id="ana_dash_1" class="apex-charts"></div>
                            </div>
                        </div><!--end card-body-->
                    </div><!--end card-->
                </div><!--end col-->
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mt-0">Customer Satisfaction</h4>
                            <div class="happiness-score">
                                <h2 class="mb-1">94.5%</h2>
                                <p class="mb-0 text-uppercase">Happiness</p>
                            </div>
                            <div id="ana_device" class="apex-charts mt-4"></div>
                            <div class="table-responsive">
                                <table class="table border-dashed mb-0">
                                    <thead class="thead-light">
                                    <tr>
                                        <th class="border-bottom-0">Performance Type</th>
                                        <th class="border-bottom-0 text-right">Score</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <th class="border-top-0 text-dark" scope="row"><i class="far fa-grin-stars text-success font-24 mr-2 align-middle"></i>Excellent</th>
                                        <td class="border-top-0 text-right">65%</td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark" scope="row"><i class="far fa-smile text-primary font-24 mr-2 align-middle"></i>Very Good</th>
                                        <td class="text-right">20%</td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark" scope="row"><i class="far fa-meh text-warning font-24 mr-2 align-middle"></i>Good</th>
                                        <td class="text-right">10%</td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark" scope="row"><i class="far fa-frown text-pink font-24 mr-2 align-middle"></i>Fair</th>
                                        <td class="text-right">5%</td>
                                    </tr>

                                    </tbody>
                                </table><!--end /table-->
                            </div>
                        </div><!--end card-body-->
                    </div><!--end card-->
                </div><!--end col-->
            </div><!--end row-->
            <div class="row">
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-7 align-self-center">
                                    <div class="timer-data">
                                        <div class="icon-info mt-1 mb-4">
                                            <i class="dripicons-phone bg-soft-dark"></i>
                                        </div>
                                        <h3 class="mt-0 text-dark">0m:27s</h3>
                                        <h4 class="mt-0 header-title text-truncate">Avg.Speed of answer</h4>
                                        <p class="text-muted mb-0 text-truncate">It is a long established fact that a reader.</p>

                                    </div>
                                </div><!--end col-->
                                <div class="col-5 align-self-center">
                                    <div class="apexchart-wrapper">
                                        <div id="dash_spark_1" class="chart-gutters"></div>
                                    </div>
                                </div><!--end col-->
                            </div><!--end row-->
                        </div><!--end card-body-->
                    </div><!--end card-->
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-7 align-self-center">
                                    <div class="timer-data">
                                        <div class="icon-info mt-1 mb-4">
                                            <i class="dripicons-clock bg-soft-dark"></i>
                                        </div>
                                        <h3 class="mt-0 text-dark">4m:30s</h3>
                                        <h4 class="mt-0 header-title text-truncate">Time to Resolved Complaint</h4>
                                        <p class="text-muted mb-0 text-truncate">It is a long established fact that a reader.</p>

                                    </div>
                                </div><!--end col-->
                                <div class="col-5 align-self-center">
                                    <div class="apexchart-wrapper">
                                        <div id="dash_spark_2" class="chart-gutters"></div>
                                    </div>
                                </div><!--end col-->
                            </div><!--end row-->
                        </div><!--end card-body-->
                    </div><!--end card-->
                </div><!--end col-->
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <p class="badge badge-soft-pink font-11 p-1 mb-1 float-lg-right float-md-none">Last updated 15 minutes ago</p>
                            <h4 class="header-title mt-0 mb-3">Agent Performance</h4>
                            <div class="table-responsive browser_users">
                                <table class="table mb-0">
                                    <thead class="thead-light">
                                    <tr>
                                        <th class="border-top-0">Agent</th>
                                        <th class="border-top-0">Total Calls</th>
                                        <th class="border-top-0">Calls Answered</th>
                                        <th class="border-top-0">Avg.Speed of answer</th>
                                        <th class="border-top-0">Adherence %</th>
                                        <th class="border-top-0">Action</th>
                                    </tr><!--end tr-->
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>
                                            <div class="media">
                                                <img src="../assets/images/users/user-1.png" alt="" class="thumb-sm rounded-circle mr-2">
                                                <div class="media-body align-self-center text-truncate">
                                                    <h6 class="mt-0 mb-1 text-dark">Donald Gardner</h6>
                                                    <p class="text-muted mb-0">Dummy text of the printing.</p>
                                                </div><!--end media-body-->
                                            </div>
                                        </td>
                                        <td>38</td>
                                        <td>32</td>
                                        <td>3:12s</td>
                                        <td>80%</td>
                                        <td>
                                            <a href="#" class="mr-2"><i class="fas fa-edit text-info font-16"></i></a>
                                            <a href="#"><i class="fas fa-trash-alt text-danger font-16"></i></a>
                                        </td>
                                    </tr><!--end tr-->
                                    <tr>
                                        <td>
                                            <div class="media">
                                                <div class="avatar-box thumb-sm align-self-center mr-2">
                                                    <span class="avatar-title bg-soft-pink rounded-circle">NS</span>
                                                </div>
                                                <div class="media-body align-self-center text-truncate">
                                                    <h6 class="mt-0 mb-1 text-dark">Nicholas Smith</h6>
                                                    <p class="text-muted mb-0">Dummy text of the printing.</p>
                                                </div><!--end media-body-->
                                            </div>
                                        </td>
                                        <td>50</td>
                                        <td>45</td>
                                        <td>2:45s</td>
                                        <td>84%</td>
                                        <td>
                                            <a href="#" class="mr-2"><i class="fas fa-edit text-info font-16"></i></a>
                                            <a href="#"><i class="fas fa-trash-alt text-danger font-16"></i></a>
                                        </td>
                                    </tr><!--end tr-->
                                    <tr>
                                        <td>
                                            <div class="media">
                                                <img src="../assets/images/users/user-4.jpg" alt="" class="thumb-sm rounded-circle mr-2">
                                                <div class="media-body align-self-center text-truncate">
                                                    <h6 class="mt-0 mb-1 text-dark">Paula Anderson</h6>
                                                    <p class="text-muted mb-0">Dummy text of the printing.</p>
                                                </div><!--end media-body-->
                                            </div>
                                        </td>
                                        <td>32</td>
                                        <td>24</td>
                                        <td>4:15s</td>
                                        <td>73%</td>
                                        <td>
                                            <a href="#" class="mr-2"><i class="fas fa-edit text-info font-16"></i></a>
                                            <a href="#"><i class="fas fa-trash-alt text-danger font-16"></i></a>
                                        </td>
                                    </tr><!--end tr-->

                                    <tr>
                                        <td>
                                            <div class="media">
                                                <img src="../assets/images/users/user-3.png" alt="" class="thumb-sm rounded-circle mr-2">
                                                <div class="media-body align-self-center text-truncate">
                                                    <h6 class="mt-0 mb-1 text-dark">Lucy Peterson</h6>
                                                    <p class="text-muted mb-0">Dummy text of the printing.</p>
                                                </div><!--end media-body-->
                                            </div>
                                        </td>
                                        <td>25</td>
                                        <td>21</td>
                                        <td>5:42s</td>
                                        <td>93%</td>
                                        <td>
                                            <a href="#" class="mr-2"><i class="fas fa-edit text-info font-16"></i></a>
                                            <a href="#"><i class="fas fa-trash-alt text-danger font-16"></i></a>
                                        </td>
                                    </tr><!--end tr-->
                                    <tr>
                                        <td>
                                            <div class="media">
                                                <div class="avatar-box thumb-sm align-self-center mr-2">
                                                    <span class="avatar-title bg-soft-primary rounded-circle">JR</span>
                                                </div>
                                                <div class="media-body align-self-center text-truncate">
                                                    <h6 class="mt-0 mb-1 text-dark">Joseph Rust</h6>
                                                    <p class="text-muted mb-0">Dummy text of the printing.</p>
                                                </div><!--end media-body-->
                                            </div>
                                        </td>
                                        <td>50</td>
                                        <td>45</td>
                                        <td>2:45s</td>
                                        <td>84%</td>
                                        <td>
                                            <a href="#" class="mr-2"><i class="fas fa-edit text-info font-16"></i></a>
                                            <a href="#"><i class="fas fa-trash-alt text-danger font-16"></i></a>
                                        </td>
                                    </tr><!--end tr-->
                                    </tbody>
                                </table> <!--end table-->
                            </div><!--end /div-->
                        </div><!--end card-body-->
                    </div><!--end card-->
                </div><!--end col-->
            </div><!--end row-->
            <div class="row">
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mt-0 mb-4">Latest Activity</h4>
                            <div class="slimscroll help-activity-height">
                                <div class="activity">
                                    <div class="activity-info">
                                        <div class="icon-info-activity">
                                            <i class="mdi mdi-checkbox-marked-circle-outline bg-soft-success"></i>
                                        </div>
                                        <div class="activity-info-text">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <p class="text-muted mb-0 font-14 w-75"><span class="text-dark font-14">Donald</span>
                                                    updated the status of <a href="" class="text-dark">Refund #1234</a> to awaiting customer response
                                                </p>
                                                <span class="text-muted">10 Minutes ago</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="activity-info">
                                        <div class="icon-info-activity">
                                            <i class="mdi mdi-timer-off bg-soft-pink"></i>
                                        </div>
                                        <div class="activity-info-text">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <p class="text-muted mb-0 font-14 w-75"><span class="text-dark font-14">Lucy Peterson</span>
                                                    was added to the group, group name is <a href="" class="text-dark">Overtake</a>
                                                </p>
                                                <span class="text-muted">50 Minutes ago</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="activity-info">
                                        <div class="icon-info-activity">
                                            <i class="mdi mdi-alert-decagram bg-soft-purple"></i>
                                        </div>
                                        <div class="activity-info-text">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <p class="text-muted mb-0 font-14 w-75"><span class="text-dark font-14">Joseph Rust</span>
                                                    opened new showcase <a href="" class="text-dark">Mannat #112233</a> with theme market
                                                </p>
                                                <span class="text-muted">10 hours ago</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="activity-info">
                                        <div class="icon-info-activity">
                                            <i class="mdi mdi-clipboard-alert bg-soft-warning"></i>
                                        </div>
                                        <div class="activity-info-text">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <p class="text-muted mb-0 font-14 w-75"><span class="text-dark font-14">Donald</span>
                                                    updated the status of <a href="" class="text-dark">Refund #1234</a> to awaiting customer response
                                                </p>
                                                <span class="text-muted">Yesterday</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="activity-info">
                                        <div class="icon-info-activity">
                                            <i class="mdi mdi-clipboard-alert bg-soft-secondary"></i>
                                        </div>
                                        <div class="activity-info-text">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <p class="text-muted mb-0 font-14 w-75"><span class="text-dark font-14">Lucy Peterson</span>
                                                    was added to the group, group name is <a href="" class="text-dark">Overtake</a>
                                                </p>
                                                <span class="text-muted">14 Nov 2019</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="activity-info">
                                        <div class="icon-info-activity">
                                            <i class="mdi mdi-clipboard-alert bg-soft-info"></i>
                                        </div>
                                        <div class="activity-info-text">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <p class="text-muted mb-0 font-14 w-75"><span class="text-dark font-14">Joseph Rust</span>
                                                    opened new showcase <a href="" class="text-dark">Mannat #112233</a> with theme market
                                                </p>
                                                <span class="text-muted">15 Nov 2019</span>
                                            </div>
                                        </div>
                                    </div>
                                </div><!--end activity-->
                            </div><!--crypot dash activity-->
                        </div><!--end card-body-->
                    </div><!--end card-->
                </div><!--end col-->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="p-4 bg-light text-center align-item-center">
                                <h1 class="font-weight-semibold">4.8</h1>
                                <h4 class="header-title">Overall Rating</h4>
                                <ul class="list-inline mb-0 product-review">
                                    <li class="list-inline-item mr-0"><i class="mdi mdi-star text-warning font-24"></i></li>
                                    <li class="list-inline-item mr-0"><i class="mdi mdi-star text-warning font-24"></i></li>
                                    <li class="list-inline-item mr-0"><i class="mdi mdi-star text-warning font-24"></i></li>
                                    <li class="list-inline-item mr-0"><i class="mdi mdi-star text-warning font-24"></i></li>
                                    <li class="list-inline-item mr-0"><i class="mdi mdi-star-half text-warning font-24"></i></li>
                                    <li class="list-inline-item"><small class="text-muted">Total Review (700)</small></li>
                                </ul>
                            </div>
                            <ul class="list-unstyled mt-3">
                                <li class="mb-2">
                                    <span class="text-dark">5 Star</span>
                                    <small class="float-right text-muted ml-3 font-14">593</small>
                                    <div class="progress mt-2" style="height:5px;">
                                        <div class="progress-bar bg-secondary" role="progressbar" style="width: 80%; border-radius:5px;" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </li>
                                <li class="mb-2">
                                    <span class="text-dark">4 Star</span>
                                    <small class="float-right text-muted ml-3 font-14">99</small>
                                    <div class="progress mt-2" style="height:5px;">
                                        <div class="progress-bar bg-secondary" role="progressbar" style="width: 18%; border-radius:5px;" aria-valuenow="18" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </li>
                                <li class="mb-2">
                                    <span class="text-dark">3 Star</span>
                                    <small class="float-right text-muted ml-3 font-14">6</small>
                                    <div class="progress mt-2" style="height:5px;">
                                        <div class="progress-bar bg-secondary" role="progressbar" style="width: 10%; border-radius:5px;" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </li>
                                <li class="mb-2">
                                    <span class="text-dark">2 Star</span>
                                    <small class="float-right text-muted ml-3 font-14">2</small>
                                    <div class="progress mt-2" style="height:5px;">
                                        <div class="progress-bar bg-secondary" role="progressbar" style="width: 1%; border-radius:5px;" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </li>
                                <li>
                                    <span class="text-dark">1 Star</span>
                                    <small class="float-right text-muted ml-3 font-14">0</small>
                                    <div class="progress mt-2" style="height:5px;">
                                        <div class="progress-bar bg-secondary" role="progressbar" style="width: 0%; border-radius:5px;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </li>
                            </ul>
                            <div class="">
                                <h3 class="d-inline-block mr-2 mb-1 mb-lg-0">98.5%</h3>
                                <h4 class="header-title d-inline-block mr-2 mb-1 mb-lg-0">Satisfied Customer</h4>
                                <span class="text-right ml-auto d-inline-block"><i class="far fa-smile font-24 text-warning"></i></span>
                            </div>
                        </div><!--end card-body-->
                    </div><!--end card-->
                </div><!--end col-->
                <div class="col-lg-4">
                    <div class="card profile-card">
                        <div class="card-body p-0">
                            <div class="media p-3  align-items-center">
                                <img src="../assets/images/users/user-4.jpg" alt="user" class="rounded-circle thumb-xl">
                                <div class="media-body ml-3 align-self-center">
                                    <h5 class="pro-title mt-0">Merri Diamond <span class="badge badge-warning font-10">New Agent</span></h5>
                                    <p class="mb-2 text-muted">@SaraHopkins.com</p>
                                    <ul class="list-inline list-unstyled profile-socials mb-0">
                                        <li class="list-inline-item">
                                            <a href="#" class=""><i class="fab fa-facebook-f avatar-md font-16 bg-soft-primary"></i></a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="#" class=""><i class="fab fa-twitter avatar-md font-16 bg-soft-secondary"></i></a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="#" class=""><i class="fab fa-dribbble avatar-md font-16 bg-soft-pink"></i></a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="action-btn">
                                    <a href="" class=""><i class="fas fa-pen text-info mr-2"></i></a>
                                    <a href="" class=""><i class="fas fa-trash-alt text-danger"></i></a>
                                </div>
                            </div>
                        </div><!--end card-body-->
                    </div><!--end card-->
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mt-0 mb-4">Support Status</h4>
                            <h2 class="font-weight-semibold">1530</h2>
                            <h5>Tickets</h5>
                            <div class="progress mb-4">
                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100">70%</div>
                                <div class="progress-bar bg-pink" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%</div>
                                <div class="progress-bar bg-success" role="progressbar" style="width: 5%" aria-valuenow="5" aria-valuemin="0" aria-valuemax="100">5%</div>
                            </div>
                            <ul class="list-unstyled url-list">
                                <li>
                                    <i class="mdi mdi-circle-medium text-pink"></i>
                                    <span>Open Tickets</span>
                                </li>
                                <li>
                                    <i class="mdi mdi-circle-medium text-primary"></i>
                                    <span>Resolved Tickets</span>
                                </li>
                                <li>
                                    <i class="mdi mdi-circle-medium text-success"></i>
                                    <span>Unresolved Tickets</span>
                                </li>
                            </ul>
                        </div><!--end card-body-->
                    </div><!--end card-->
                </div><!--end col-->
            </div><!--end row-->

        </div><!-- container -->
@endsection
