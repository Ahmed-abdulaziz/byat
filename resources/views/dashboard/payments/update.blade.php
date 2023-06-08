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
                            <h3 class="box-title">@lang('site.Confirm Payment')</h3>
                        </div>
                        @include('partials._errors')
                        @include('partials._errors')
                        <form action="{{ route('dashboard.makespcial', $single->adv_id) }}" method="get" style="display: inline-block">
                            {{ csrf_field() }}
                            {{ method_field('get') }}
                            <div class="box-body">
                                <input type="hidden" value="" name="id">
                                <div class="col-md-8  form-group">
                                    @if($catgory)
                                        <label>@lang('site.Choose package')</label>
                                        <select class="form-control select2" style="width: 500%;height:110%" name="pak_id" required>
                                            @foreach($catgory as $singlex)
                                                @if(app()->getLocale()=='ar')
                                                    <option value="{{$singlex->id}}">{{$singlex->name_ar}}</option>
                                                @else
                                                    <option value="{{$singlex->id}}">{{$singlex->name_en}}</option>
                                                @endif
                                            @endforeach
                                        </select>
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
