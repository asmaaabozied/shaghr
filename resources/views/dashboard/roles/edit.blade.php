@extends('dashboard.layouts.app')

@section('content')

    <!-- <div class="content-page"> -->
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h3>@lang('site.roles')</h3>
                    </div>

                </div>
            </div>
        </div>

        <div class="container-fluid">

            <div class="row">
                <!-- Individual column searching (text inputs) Starts-->
                <div class="col-sm-12">
                    <div class="card">
                        <form action="{{ route('dashboard.roles.update', $role->id) }}" method="post"
                              enctype="multipart/form-data">

                            {{ csrf_field() }}
                            {{ method_field('put') }}


                            <div class="card-header d-flex justify-content-between">
                                <h5>@lang('site.edit') </h5>
                                <div class="text-end  group-btn-top">
                                    <div class="form-group d-flex form-group justify-content-between">
                                        <button type="button" class="btn btn-pill btn-outline-primary btn-air-primary"
                                                onclick="history.back();">
                                            <!--<i class="fa fa-backward"></i> -->
                                            @lang('site.back')
                                        </button>
                                        <button type="submit" class="btn btn-air-primary btn-pill btn-primary"><i
                                                class="fa fa-plus"></i>
                                            @lang('site.edit')</button>
                                    </div>
                                </div>


                            </div>
                            <div class="card-body">
                                @include('partials._errors')


                                <div class="row">
                                    <div class="col-md-6">

                                            <label>@lang('site.name')</label>
                                            <input type="text" name="name" class="form-control"
                                                   value="{{ $role->name }}">
                                        </div>

                                        <div class="col-md-6">
                                            <label>@lang('site.guard_name')</label>
                                            <input type="text" name="guard_name" class="form-control"
                                                   value="{{ $role->guard_name  }}">
                                        </div>


                                    </div>
                                    <div class="row">
                                    <div class="col-md-12">
                                        <fieldset>
                                            <legend>@lang('site.permissions')</legend>
                                            <div class="form-group">

                                                <ul class="nav ">
                                                    <table class="table table-hover table-bordered">


                                                        @foreach ($models as $index=>$model)
                                                            <tr>
                                                                <td>
                                                                    <li
                                                                        class="form-group {{ $index == 0 ? 'active' : '' }}">
                                                                        @lang('site.' . $model)</li>
                                                                </td>
                                                                <td>

                                                                    <div
                                                                        class="animate-chk d-flex justify-content-around form-group {{ $index == 0 ? 'active' : '' }}"
                                                                        id="{{ $model }}">

                                                                        @foreach ($maps as $map)
                                                                            <label><input class="checkbox_animated"
                                                                                          type="checkbox"
                                                                                          name="permissions[]"
                                                                                          {{ $role->hasPermissionTo($map . '_' . $model) ? 'checked' : '' }}
                                                                                          value="{{ $map . '_' . $model }}">
                                                                                @lang('site.'
                                                                                . $map)
                                                                                <span></span>
                                                                            </label>

                                                                        @endforeach

                                                                    </div>
                                                                </td>

                                                            </tr>
                                                        @endforeach
                                                    </table>
                                                </ul>

                                                <div class="tab-content">


                                                </div><!-- end of tab content -->

                                            </div><!-- end of nav tabs -->

                                    </div>
                                    </div>

                                </div>
                            </div>


                        </form>
                    </div>
                </div>
            </div>
            <!-- Individual column searching (text inputs) Ends-->
        </div>
    </div>

    </div>
    <!-- Container-fluid Ends-->
    </div>

@endsection
