@extends('dashboard.layouts.app')


@section('content')





    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h3>{{$title}}</h3>
                    </div>

                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <!-- HTML (DOM) sourced data  Starts-->
                <div class="col-sm-12">
                    <div class="card">

                        <div class="bg-secondary-lighten card-header d-flex justify-content-between">
                            <h5 class="mb-3">{{$title}}({{$count}})</h5>
                            <div class="text-end  group-btn-top">
                                <div class="form-group d-flex form-group justify-content-between">

                                    <a href="{{route('dashboard.roles.create')}}" class="btn btn-air-primary btn-pill btn-primary"><i
                                            class="fa fa-plus p-1"></i>
                                        @lang('site.add')</a>
                                </div>
                            </div>


                        </div>


                        <div class="card-body">

                                <div class="dt-ext table-responsive">
                                    <table class="display" id="export-button">

                                        {!! $dataTable->table([], true) !!}


                                    </table>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            // $(".alert").delay(5000).slideUp(300);
            $(".alert").slideDown(300).delay(5000).slideUp(300);
        });
        setTimeout(function () {
            $('.alert-box').remove();
        }, 30000);
    </script>

    {!! $dataTable->scripts() !!}

    <script>
        function confirmDelete($id) {
            console.log("Tapped Delete button")
            var that = document.getElementById("deleteForm" + $id);
            var n = new Noty({
                text: "@lang('site.confirm_delete')",
                type: "error",
                killer: true,
                buttons: [
                    Noty.button("@lang('site.yes')", 'btn btn-success mr-2', function () {
                        that.submit();
                    }),
                    Noty.button("@lang('site.no')", 'btn btn-primary mr-2', function () {
                        n.close();
                    })
                ]
            });
            n.show();
        }

        $(document).ready(function () {

            $("#deleteForm").on('click', "#delete", function (e) {

                console.log("Tapped Delete button")
                var that = $(this)
                e.preventDefault();
                var n = new Noty({
                    text: "@lang('site.confirm_delete')",
                    type: "error",
                    killer: true,
                    buttons: [
                        Noty.button("@lang('site.yes')", 'btn btn-success mr-2', function () {
                            that.closest('form').submit();
                        }),
                        Noty.button("@lang('site.no')", 'btn btn-primary mr-2', function () {
                            n.close();
                        })
                    ]
                });
                n.show();

            });


        });
    </script>


@endsection
