@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.auction-winners')</h1>

            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li class="active">@lang('site.auction-winners')</li>
            </ol>
        </section>





        <section class="content">

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title" style="margin-bottom: 15px">@lang('site.auction-winners') <small></small></h3>

                </div>
                <!-- end of box header -->

                <div class="box-body">
                    @if(count($auctions) > 0)
                        <table class="table table-bordered" id="myTable2">
                            <thead>
                                  <tr>
                                    <th>#</th>
                                    <th>@lang('site.name')</th>
                                    <th>@lang('site.email')</th>
                                    <th>@lang('site.phone')</th>
                                    <th>@lang('site.auction-name')</th>
                                    <th>@lang('site.Options')</th>
                                </tr>

                            </thead>
                          
                        <tbody>
                            
                      
                            @foreach($auctions as $index=>$single)
                                <tr>
                                    <td>{{$index +1}}</td>
                                    <td>{{$single->user}}</td>
                                    <td>{{$single->email}}</td>
                                    <td>{{$single->phone}}</td>
                                    <td>{{$single->name}}</td>
                                    <td>   
                                    <a href="{{route('dashboard.auction_winner_details',$single->id)}}"><button type="submit" class="btn btn-info  btn-sm ">@lang('site.description')</button> </a> 
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
