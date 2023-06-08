@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.Customer reports')</h1>

            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li class="active">@lang('site.Customer reports')</li>
            </ol>
        </section>





        <section class="content">

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title" style="margin-bottom: 15px">@lang('site.Customer reports') <small></small></h3>

                </div> <!-- end of box header -->

                <div class="box-body">
                    @if($data->count() > 0)
                        <table class="table table-bordered" id="myTable">
                            <tr>
                                    <th>#</th>
                                    <th>@lang('site.name')</th>
                                    <th>@lang('site.type')</th>
                                    <th>@lang('site.user-name')</th>
                                    <th>@lang('site.phone')</th>
                                    <th>@lang('site.single-report')</th>
                                    <th>@lang('site.Options')</th>
                            </tr>


                            @foreach($data as $index=>$single)
                            
                            @php
                                    if($single->section == 1){
                                         $product =  \App\Advertisments::find($single->product_id);
                                    }elseif($single->section == 2){
                                          $product =  \App\Auctions::find($single->product_id);
                                    }
                                    
                                      $user   =  \App\Models\appUsers::find($single->user_id);
                                      if(empty($single->report_text)){
                                             $report = App\reports::find($single->report_id);
                                             $report_name = $report->name;
                                      }else{
                                            $report_name = $single->report_text;
                                      }
                                     
                            @endphp
                                @if($product)
                                    <tr>
                                        <td>{{$index +1}}</td>
                                        <td>@if($product) {{$product->name}} @endif</td>
                                         <td>@if($single->section == 1) @lang('site.advertiments') @else  @lang('site.auctions') @endif </td>
                                         <td>@if($user) {{$user->name}} @endif</td>
                                          <td>@if($user) {{$user->phone}} @endif</td>
                                         <td>@if($report_name) {{$report_name}} @endif</td>
                                        <td>
                                         @if($single->section == 1) 
                                                  <a href='{{route("dashboard.advertisment-details",[$single->product_id,0])}}'><button class="btn btn-info">@lang('site.description')</button></a>
                                                  @if (auth()->user()->hasPermission('active_advertiments'))
                                                            <a href="{{ route('dashboard.adv-active', [$single->product_id , 2]) }}" class="btn btn-danger btn-sm"><i class="fa fa-edit"></i> @lang('site.ban')</a>
                                                  @endif
                                                   @if (auth()->user()->hasPermission('delete_advertiments'))
                                                            <a href="{{ route('dashboard.adv-active', [$single->product_id , 5]) }}" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> @lang('site.delete')</a>
                                                   @endif
                                         @else 
                                           <a href='{{route("dashboard.auction-details",$single->product_id)}}'><button class="btn btn-info">@lang('site.description')</button></a>
                                          @if (auth()->user()->hasPermission('active_auctions'))
                                                <a href="{{ route('dashboard.Auctions-change-status', [$single->product_id , 11]) }}" class="btn btn-danger btn-sm"><i class="fa fa-edit"></i> @lang('site.ban')</a>
                                             @endif
                                              @if (auth()->user()->hasPermission('delete_auctions'))
                                                     @if( ( \Carbon\Carbon::now() >$product->end_date && $product->owner_id == 0 && $product->status != 0 ) ||  $product->status == 0)
                                                        <a href="{{ route('dashboard.Auctions-change-status', [$single->product_id , 15]) }}" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> @lang('site.delete')</a>
                                                    @endif
                                                @endif 
                                        @endif
                                      
                                        </td>
                                    </tr>
                                 @endif
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
