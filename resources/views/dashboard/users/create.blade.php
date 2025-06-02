@extends('dashboard.layouts.app')
@section('content')

    <!-- <div class="content-page"> -->
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h3>@lang('site.add')</h3>
                    </div>

                </div>
            </div>
        </div>


        <div class="container-fluid">

            <div class="row">
                <!-- Individual column searching (text inputs) Starts-->
                <div class="col-sm-12">
                    <div class="card mt-30">
                        <form action="{{ route('dashboard.users.store') }}" method="post" enctype="multipart/form-data"
                              id="" class="form-main">

                            {{ csrf_field() }}
                            {{ method_field('post') }}
                            <div class="bg-secondary-lighten card-header d-flex justify-content-between">
                                <h5>@lang('site.add') </h5>
                                <div class="text-end  group-btn-top">
                                    <div class="form-group d-flex form-group justify-content-between">
                                        <button type="button" class="btn btn-pill btn-outline-primary btn-air-primary"
                                                onclick="history.back();">

                                            @lang('site.back')
                                        </button>
                                        <button type="submit" class="btn btn-air-primary btn-pill btn-primary"><i
                                                class="fa fa-plus p-1"></i>
                                            @lang('site.add')</button>
                                    </div>
                                </div>


                            </div>
                            <div class="card-body">
                                @include('partials._errors')

                                <div class="row form-group">


                                </div>

                                <div class="row">



                                    <div class="col-md-6 form-group col-12 p-2 ">
                                        <label>@lang('site.first_name')<span class="text-danger">*</span></label>
                                        <input type="text" name="first_name" class="form-control"
                                               value="{{old('first_name')}}"
                                        >
                                    </div>

                                    <div class="col-md-6 form-group col-12 p-2 ">
                                        <label>@lang('site.last_name')<span class="text-danger">*</span></label>
                                        <input type="text" name="last_name" class="form-control"
                                               value="{{old('last_name')}}"
                                        >
                                    </div>


                                    <div class="col-md-6 form-group col-12 p-2">
                                        <label>@lang('site.phone') <span class="text-danger">*</span></label>
                                        <div id="result">
                                            <input type="text" name="phone" class="form-control" type="tel"
                                                   id="mobilephone"
                                                   maxlength="10" size="10" required>

                                        </div>
                                    </div>


                                    <!--<div class="col-md-6">-->
                                    <div class="col-md-6 form-group col-12 p-2">
                                        <label>@lang('site.address') <span class="text-danger">*</span></label>
                                        <input type="text" name="address" class="form-control"
                                               value="{{ old('address') }}"
                                               required>
                                    </div>


                                    <div class="col-md-6 form-group col-12 p-2">

                                        <label>@lang('site.email')<span class="text-danger">*</span></label>
                                        <input type="email" name="email" class="form-control" value="{{ old('email') }}"
                                               required>
                                    </div>
                                    <div class="col-md-6 form-group col-12 p-2 ">
                                        <label>@lang('site.nationality')<span class="text-danger">*</span></label>
                                        <input type="text" name="nationality" class="form-control" value="{{old('nationality')}}"
                                        >
                                    </div>
                                    <div class="col-md-6 form-group col-12 p-2 ">
                                        <label>@lang('site.gender')<span class="text-danger">*</span></label>
                                   <select class="form-control" name="gender">

                                       <option >Please Select</option>
                                       <option value="male">@lang('site.male')</option>
                                       <option value="female">@lang('site.female')</option>
                                   </select>
                                    </div>
                                    <div class="col-md-6 form-group col-12 p-2 ">
                                        <label>@lang('site.location')<span class="text-danger">*</span></label>
                                        <input type="text" name="location" class="form-control"
                                               value="{{old('location')}}"
                                               required>
                                    </div>
                                    <div class="col-md-6 form-group col-12 p-2">

                                        <label>@lang('site.password')<span class="text-danger">*</span></label>
                                        <input type="password" name="password" class="form-control" required>
                                    </div>
                                    <div class="col-md-6 form-group col-12 p-2">
                                        <label>@lang('site.password_confirmation')</label>
                                        <input type="password" name="password_confirmation" class="form-control">
                                    </div>


                                    <div class="col-md-6 form-group">
                                        <label class="form-label">@lang('site.roles')</label>


                                        <select class="js-example-placeholder-multiple col-sm-12" multiple="multiple"
                                                name="roles[]">
                                            <option disabled selected>@lang('site.select')</option>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->id }}">
                                                    {{ $role->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>




                                </div>


                            </div>


                    </div>
                </div>
            </div>
        </div>

        </form>
        <!--    </div>-->
    </div>
    </div><!--</div>-->

    </div>
    <!-- Container-fluid Ends-->

@endsection

