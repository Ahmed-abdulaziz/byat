@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.auctions')</h1>

            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li class="active">@lang('site.auctions')</li>
            </ol>
        </section>





        <section class="content">

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title" style="margin-bottom: 15px">@lang('site.auctions') <small></small></h3>
                </div> <!-- end of box header -->

                <div class="box-body">
                    @if(count($auctions) > 0)
                         <table class="table table-bordered" id="myTable">
                             <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('site.name')</th>
                                <th style="width: 216px;">@lang('site.description')</th>
                                <th>@lang('site.amount-to-open')</th>
                                <th>@lang('site.maximum-amount')</th>
                                <th>@lang('site.number-of-day')</th>
                                <th>@lang('site.number-of-hours')</th>
                                 <th>@lang('site.user-name')</th>
                                <th>@lang('site.place')</th>
                                <th>@lang('site.winner_name')</th>
                                 <th>@lang('site.status')</th>
                                <th>@lang('site.Options')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($auctions as $index=>$single)
                                <tr>
                                    <td>{{++$index}}</td>
                                    
                                    <td>{{$single->name}}</td>
                                    <td>{{$single->description}}</td>
                                    
                                    <td>{{$single->amount_open}}</td>
                                    <td>{{$single->maximum_amount}}</td>
                                    <td>{{$single->day}}</td>
                                    <td>{{$single->hours}}</td>
                                     <td>{{$single->user}}</td>
                                    <td>{{$single->place}}</td>
                                    <td>{{$single->owner}}</td>
                                     <td>
                                         
                                             @if($single->status == 1 )
                                                  <button class="btn ">@lang('site.isactive')</button>
                                            @elseif($single->status == 11)
                                                 <button class="btn">@lang('site.isban')</button>
                                            @endif
                                            
                                     </td>
                                        <td>
                                              @if (auth()->user()->hasPermission('update_auctions'))
                                                    @if($single->status == 0)
                                                         <a href="{{ route('dashboard.Auction-edit', $single->id ) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> @lang('site.edit')</a>
                                                    @endif
                                              @endif
                                             @if (auth()->user()->hasPermission('active_auctions'))
                                                @if($single->status == 0 ||  $single->status == 11 )
                                                      <a href="{{ route('dashboard.Auctions-change-status', [$single->id , 1]) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> @lang('site.active')</a>
                                                @endif
                                                @if($single->status == 1 )
                                                     <a href="{{ route('dashboard.Auctions-change-status', [$single->id , 11]) }}" class="btn btn-danger btn-sm"><i class="fa fa-edit"></i> @lang('site.ban')</a>
                                                @endif
                                             @endif
                                             @if (auth()->user()->hasPermission('delete_auctions'))
                                                @if( ( \Carbon\Carbon::now() > $single->end_date && $single->owner_id == 0 && $single->status != 0 ) ||  $single->status == 0)
                                                    <a href="{{ route('dashboard.Auctions-change-status', [$single->id , 15]) }}" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> @lang('site.delete')</a>
                                                @endif
                                             @endif
                                      </td>
                                   

                                   
                                </tr>
                            @endforeach
                          <tbody>
                        </table>
                    @else
                        <h2>@lang('site.no_data_found')</h2>
                    @endif

                </div>

            </div>

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
