@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.user requirment')</h1>

            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li class="active">@lang('site.user requirment')</li>
            </ol>
        </section>





        <section class="content">

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title" style="margin-bottom: 15px">@lang('site.user requirment') <small></small></h3>

                </div> <!-- end of box header -->

                <div class="box-body">
                    @if($requirments->count() > 0)
                        <table class="table table-bordered">
                            <tr>
                                <th>#</th>
                                <th>@lang('site.requirment')</th>
                                <th>@lang('site.change')</th>
                                <th>@lang('site.Options')</th>
                            </tr>


                            @foreach($requirments as $index=>$single)
                                <tr>
                                    <td>{{$index +1}}</td>
                                    <td>{{$single->requirment}}</td>
                                    <td>{{$single->change}}</td>
                                    
                                    <td>
                                        <a href="{{route('dashboard.user-requirements',[$single->id,1])}}"><button type="submit" class="btn btn-success  btn-sm"> @lang('site.approve')</button> </a>  
                                        <a href="{{route('dashboard.user-requirements',[$single->id,2])}}"><button type="submit" class="btn btn-danger  btn-sm"> @lang('site.disapprove')</button> </a>  
                                    </td>
                       
                                </tr>
                            @endforeach

                        </table>
                    @else
                        <h2>@lang('site.no_data_found')</h2>
                    @endif

                </div>

            </div>

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
