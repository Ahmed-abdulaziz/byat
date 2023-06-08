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


            </div>
            
            
                 <div class="box box-primary">
                    <div class="box-header with-border">
                             <h3 class="box-title" style="margin-bottom: 15px">@lang('site.auction-detalis') <small></small></h3>

                     </div>
                <!-- end of box header -->
                <div style="padding:40px">
                     <p class="h2" >@lang('site.name'):  <span >{{$data->name}}</span></p>
                    <p class="h2" >@lang('site.description'):  <span >{{$data->description}}</span></p>
                     <p class="h2" >@lang('site.amount-to-open'):  <span >{{$data->amount_open}} KWD</span></p>
                     <p class="h2" >@lang('site.maximum-amount'):  <span >{{$data->maximum_amount}} KWD</span></p>
                      <p class="h2" >@lang('site.number-of-day'):  <span >{{$data->day}}</span></p>
                       <p class="h2" >@lang('site.number-of-hours'):  <span >{{$data->hours}}</span></p>
                </div>
                   
            </div>
            
            
            
                 <div class="box box-primary">
                    <div class="box-header with-border">
                             <h3 class="box-title" style="margin-bottom: 15px">@lang('site.auction-user-details') <small></small></h3>

                     </div>
                <!-- end of box header -->
                <div style="padding:40px">
                    <p class="h2" >@lang('site.name'):  <span >{{$data->owner_name}}</span></p>
                    <p class="h2" >@lang('site.phone'):  <span >{{$data->owner_phone}}</span></p>
                    <p class="h2" >@lang('site.email'):  <span >{{$data->owner_email}}</span></p>

                </div>
                   
            </div>
            
            
                 <div class="box box-primary">
                    <div class="box-header with-border">
                             <h3 class="box-title" style="margin-bottom: 15px">@lang('site.auction-winner-details') <small></small></h3>

                     </div>
                <!-- end of box header -->
                <div style="padding:40px">
                    <p class="h2" >@lang('site.name'):  <span >{{$data->winner_name}}</span></p>
                    <p class="h2" >@lang('site.phone'):  <span >{{$data->winner_phone}}</span></p>
                    <p class="h2" >@lang('site.email'):  <span >{{$data->winner_email}}</span></p>
                    <p class="h2" >@lang('site.auction-money-amount'):  <span >{{$data->money}} KWD</span></p>
                </div>
                   
            </div>
            
            

        </section><!-- end of content -->
        

    </div><!-- end of content wrapper -->
    
@endsection
