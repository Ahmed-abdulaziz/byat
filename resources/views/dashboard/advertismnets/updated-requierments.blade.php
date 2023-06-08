@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.update adv requirment')</h1>

            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li class="active">@lang('site.update adv requirment')</li>
            </ol>
        </section>





        <section class="content">

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title" style="margin-bottom: 15px">@lang('site.update adv requirment') <small></small></h3>


                </div> <!-- end of box header -->

                
                <div class="box-body">
                    @if(count($advertisments) > 0)
                        <table class="table table-bordered" id="myTable">
                             <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('site.name')</th>
                                <th>@lang('site.description')</th>
                                <th>@lang('site.price')</th>
                                <th>@lang('site.phone')</th>
                                <th>@lang('site.user-name')</th>
                                <th>@lang('site.place')</th>
                                 <th>@lang('site.Options')</th>
                            </tr>

                            </thead>
                            <tbody>
                            @foreach($advertisments as $index=>$single)
                                <tr>
                                    <td>{{++$index}}</td>
                                    
                                    <td>{{$single->name}}</td>
                                    <td>{{$single->description}}</td>
                                    <td>{{$single->price}}</td>
                                    <td>{{$single->phone}}</td>
                                     <td>{{$single->user}}</td>
                                    <td>{{$single->place}}</td>
                                    <td>
                                        <a href='{{route("dashboard.adv-requierments-edit",$single->id)}}'><button class="btn btn-info">@lang('site.update')</button></a>
                                        <a href='{{route("dashboard.advertisment-details",[$single->adv_id,1])}}'><button class="btn btn-info">@lang('site.description')</button></a>
                                        <a href='{{url("dashboard/adv-updated-status/$single->id/1")}}'><button class="btn btn-success">@lang('site.approve')</button></a>
                                         <a href='{{url("dashboard/adv-updated-status/$single->id/0")}}'><button class="btn btn-danger">@lang('site.disapprove')</button></a>
                                    </td>
                                   

                                   
                                </tr>
                            @endforeach
                        </tbody>
                        </table>
                    @else
                        <h2>@lang('site.no_data_found')</h2>
                    @endif

                </div>

            </div>

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->
  

@endsection

