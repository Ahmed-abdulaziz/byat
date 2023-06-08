@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>
                <small></small>
            </h1>

            <ol class="breadcrumb">
                <li class="active"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</li>
            </ol>
        </section>

        <section class="content">

            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">@lang('site.create')</h3>
                          
                        </div>
                        @include('partials._errors')
                        <form role="form" action="{{route('dashboard.appuser.store')}}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="box-body">

                                <div class="col-md-6 form-group">
                                    <label for="">@lang('site.name')</label>
                                    <input type="text" name="name" class="form-control" id="" value="{{ old('name') ,  '' }}"  placeholder="@lang('site.name')">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="">@lang('site.phone')</label>
                                    <input type="number" name="phone" class="form-control" value="{{ old('phone') , '' }}"  id="" placeholder="@lang('site.phone')">
                                </div>
                                  <div class="col-md-6 form-group">
                                    <label for="">@lang('site.email')</label>
                                    <input type="email" name="email" class="form-control" value="{{ old('email') , '' }}"  id="" placeholder="@lang('site.email')">
                                </div>
                                 <div class="col-md-6 form-group">
                                    <label for="">@lang('site.password')</label>
                                    <input type="password" name="password" class="form-control" id="" placeholder="@lang('site.password')">
                                </div>
                              <div class="col-md-6 form-group">
                                    <label for="">@lang('site.image')</label>
                                    <input type="file" name="img" class="form-control" id="" placeholder="@lang('site.image')">
                                </div>

                                

                            </div>
                            <!-- /.box-body -->

                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary">@lang('site.Save')</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>



        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
