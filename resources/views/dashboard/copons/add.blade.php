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
                   
                        @include('partials._errors')
                        <form role="form" action="{{route('dashboard.copons.store')}}" method="post">
                            {{ csrf_field() }}
                            <div class="box-body">

                                <div class="col-md-8 form-group">
                                    <label for="">@lang('site.code')</label>
                                    <input type="text" name="code" class="form-control" id="" value="{{ old('code', '') }}" placeholder="@lang('site.code')" required>
                                    @if($errors->has('code'))
                                            <div class="error">{{ $errors->first('code') }}</div>
                                    @endif
                                </div>
                                <div class="col-md-8 form-group">
                                    <label for="">@lang('site.code amount')</label>
                                    <input type="number" step="any" name="balance" class="form-control" value="{{ old('balance', '') }}" id="" placeholder="@lang('site.code amount')" required>
                                        @if($errors->has('balance'))
                                            <div class="error">{{ $errors->first('code') }}</div>
                                       @endif
                                </div>
                                
                                 <div class="col-md-8 form-group">
                                    <label for="">@lang('site.end_date')</label>
                                    <input type="date" name="end_date" class="form-control" id="" value="{{ old('end_date', '') }}" placeholder="@lang('site.end_date')" required>
                                      @if($errors->has('end_date'))
                                            <div class="error">{{ $errors->first('end_date') }}</div>
                                       @endif
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
