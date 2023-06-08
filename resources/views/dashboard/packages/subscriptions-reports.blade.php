@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.pacakage subscriptions')</h1>

            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li class="active">@lang('site.pacakage subscriptions')</li>
            </ol>
        </section>





        <section class="content">

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title" style="margin-bottom: 15px">@lang('site.pacakage subscriptions') <small></small></h3>

                </div> <!-- end of box header -->

                <div class="box-body">
                    @if(count($subscriptions) > 0)
                        <table class="table table-bordered" id="myTable">
                            <thead>
                                 <tr>
                                <th>#</th>
                                <th>@lang('site.user-name')</th>
                                <th>@lang('site.phone')</th>
                                <th>@lang('site.pacakage name')</th>
                                <th>@lang('site.type')</th>
                                <th>@lang('site.count')</th>
                                <th>@lang('site.price')</th>
                            </tr>
                            </thead>
                           

                            <tbody>
                                         @foreach($subscriptions as $index=>$single)
                                <tr>
                                    <td>{{$index +1}}</td>
                                    <td>{{$single->user_name}}</td>
                                    <td>{{$single->user_phone}}</td>
                                    <td>{{$single->package_name}}</td>
                                    
                                     @if($single->type==0)
                                        <td>@lang('site.User packages')</td>
                                    @elseif($single->type==1)
                                        <td>@lang('site.auctions packages')</td>
                                    @elseif($single->type==2)
                                        <td>@lang('site.Technician packages')</td>
                                    
                                    @endif
                                    
                                    
                                    @if($single->type==0)
                                        <td>{{$single->package_adv_num}} @lang('site.adv') </td>
                                    @elseif($single->type==1)
                                        <td>{{$single->package_adv_num}} @lang('site.auction') </td>
                                    @elseif($single->type==2)
                                        <td>{{$single->period}} @lang('site.day')</td>
                                    
                                    @endif
                                    
                                    <td>{{$single->package_price}}</td>

                                  
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
