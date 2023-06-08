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
                            <h3 class="box-title">@lang('site.Update Banks')</h3>
                        </div>
                        @include('partials._errors')
                        <form role="form" action="{{route('dashboard.banks.update',$banks->id)}}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            {{ method_field('put') }}
                            <div class="box-body">

                                <div class="col-md-8 form-group">
                                    <label for="">@lang('site.name')</label>
                                    <input type="text" name="name" class="form-control" id="" value="{{$banks->name}}">
                                </div>
                                <div class="col-md-8 form-group">
                                    <label for="">@lang('site.Iban')</label>
                                    <input type="number" name="iban" class="form-control" id="" value="{{$banks->iban}}">
                                </div>

                                <div class="col-md-8 form-group">
                                    <label for="">@lang('site.account_number')</label>
                                    <input type="number" name="account_number" class="form-control" id="" value="{{$banks->account_number}}">
                                </div>

                                <div class="col-md-8 form-group">
                                    <label for="">@lang('site.about_bank')</label>
                                    <textarea  name="about" class="form-control" id="">{{$banks->about}}</textarea>
                                </div>


                                <div class="col-md-8 form-group">
                                    <label>@lang('site.image')</label>
                                    <input type="file" name="img" class="form-control image">
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
