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
                        </div>
                        <form >
                            <div class="box-body">

                                <div class="col-md-6 form-group">
                                    <label for="">@lang('site.Name')</label>
                                    <p>{{$auctions->name}}</p>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="">@lang('site.description')</label>
                                    <p>{{$auctions->description}}</p>
                                </div>
                                    <div class="col-md-6 form-group">
                                    <label for="">@lang('site.amount-to-open')</label>
                                    <p>{{$auctions->amount_open}}</p>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="">@lang('site.maximum-amount')</label>
                                    <p>{{$auctions->maximum_amount}}</p>
                                </div>
                                 <div class="col-md-6 form-group">
                                    <label for="">@lang('site.deposit amount')</label>
                                    <p>{{$auctions->deposit_amount}}</p>
                                </div>
                                  <div class="col-md-6 form-group">
                                    <label for="">@lang('site.number-of-day')</label>
                                    <p>{{$auctions->day}}</p>
                                </div>
                                
                                  <div class="col-md-6 form-group">
                                    <label for="">@lang('site.number-of-hours')</label>
                                   <p>{{$auctions->hours}}</p>
                                </div> 
                                     
                               <div class="col-md-3 form-group">
                                        <label>@lang('site.Category-name')</label>
                                         <p>{{$categores->name}}</p>
                                </div>
                              <div class="col-md-3  form-group">
                                        <label>@lang('site.Areas')</label>
                                        <p>{{$areas->name}}</p>
                                </div>
                                 <div class="col-md-12 form-group">
                                        <label>@lang('site.filters')</label>
                                         <div class="row">
                                         @foreach($filters as $filter)
                                         @php
                                            $main = \App\category_items::find($filter->category_item_id);
                                            if($main->type != 3){
                                                $sub = \App\category_item_components::find($filter->category_item_component_id);
                                                if($sub){
                                                    $sub = $sub->name;
                                                }
                                            }else{
                                                $sub = $filter->text;
                                            }
                                         @endphp
                                            <div class="col-md-3 m-2 ">
                                                <button type="button" class="btn btn-info">{{$main->name}}</button>
                                                <button type="button" class="btn btn-primary">{{$sub}}</button>
                                            </div>
                                    @endforeach
                                    </div>
                                </div>
                                
                                @if(!empty($auctions->examination_certificate))
                                  <div class="col-md-12 form-group">
                                    <div class="col-md-6">
                                         <label for="">@lang('site.examination_certificate')</label>
                                        <a href="{{asset('uploads/auctionsexamination_certificate/'.$auctions->examination_certificate)}}" target="_blank">  <img  style="width:100%;height: 300px;object-fit: cover;" src="{{asset('uploads/auctionsexamination_certificate/'.$auctions->examination_certificate)}}" /> </a> 

                                    </div>
                                </div> 
                                 @endif
                                 
                                  <div class="col-md-12 form-group">
                                    <label for="">@lang('site.images')</label>
                                    <div class="row">
                                         @foreach($auctions->images as $image)
                                            <div class="col-md-3 m-2 img-{{$image->id}}">
                                                    <a href="{{asset('uploads/auctions/'.$image->img)}}" target="_blank">  <img style="width: 100%;" src="{{asset('uploads/auctions/'.$image->img)}}" /> </a> 
                                            </div>
                                             @endforeach
                                    </div>
                                </div> 

                            </div>
                        

                        </form>
                    </div>
                </div>
            </div>



        </section><!-- end of content -->

    </div><!-- end of content wrapper -->
@endsection
