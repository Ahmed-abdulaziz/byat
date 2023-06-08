@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.Banars')</h1>

            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li class="active">@lang('site.Banars')</li>
            </ol>
        </section>





        <section class="content">

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title" style="margin-bottom: 15px">@lang('site.Banars') <small></small></h3>


                    <form action="{{route('dashboard.banar.index')}}" method="get">

                        <div class="row">

                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" placeholder="@lang('site.search')" value="{{ request()->search }}">
                            </div>

                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> @lang('site.search')</button>
                             
                                       @if(!empty($cat_id))
                                             @if(auth()->user()->hasPermission('create_banars'))
                                                 <a href="{{route('dashboard.banar.create',['cat_id'=>$cat_id])}}" class="btn btn-primary"><i class="fa fa-plus"></i> @lang('site.add')</a>
                                              @endif
                                              @if(auth()->user()->hasPermission('arrange_banars'))
                                                 <a href="{{route('dashboard.order_banners',['cat_id'=>$cat_id])}}" class="btn btn-primary"><i class="fa fa-arrows-v" aria-hidden="true"></i> @lang('site.arrange banars')</a>
                                              @endif
                                         @else
                                            @if(auth()->user()->hasPermission('create_banars'))
                                                    <a href="{{route('dashboard.banar.create')}}" class="btn btn-primary"><i class="fa fa-plus"></i> @lang('site.add')</a>
                                             @endif
                                             @if(auth()->user()->hasPermission('arrange_banars'))
                                                    <a href="{{route('dashboard.order_banners')}}" class="btn btn-primary"><i class="fa fa-arrows-v" aria-hidden="true"></i> @lang('site.arrange banars')</a>
                                              @endif
                                        @endif
                         
                               
                            </div>

                        </div>
                    </form><!-- end of form -->
                </div> <!-- end of box header -->

                <div class="box-body">
                    @if($banars->count() > 0)
                        <table class="table table-bordered">
                            <tr>
                                <th>#</th>
                                <th>@lang('site.image')</th>
                                <th>@lang('site.link')</th>
                                <th>@lang('site.end_date')</th>
                                <th>@lang('site.Options')</th>
                            </tr>


                            @foreach($banars as $index=>$single)
                                <tr>
                                    <td>{{$index +1}}</td>
                                    <td><img src="{{asset('uploads/banars/'.$single->img)}}" style="width: 100px;" class="img-thumbnail" alt=""></td>
                                    <td>{{$single->link}}</td>
                                    <td>{{$single->end_date}}</td>
                                    <td>
                                         @if(auth()->user()->hasPermission('update_banars'))
                                           @if(!empty($cat_id))
                                            <a href="{{route('dashboard.banar.edit',$single->id)}}?cat_id={{$cat_id}}" class="btn btn-primary"><i class="fa fa-edit"></i>@lang('site.update')</a>
                                             @else
                                                 <a href="{{route('dashboard.banar.edit',$single->id)}}" class="btn btn-primary"><i class="fa fa-edit"></i>@lang('site.update')</a>
                                            @endif
                                         @endif
                                        <form action="{{ route('dashboard.banar.destroy', $single->id) }}" method="post" style="display: inline-block">
                                            {{ csrf_field() }}
                                            {{ method_field('delete') }}
                                                    @if(auth()->user()->hasPermission('delete_banars'))
                                                    <button type="submit" class="btn btn-danger delete btn-sm"><i class="fa fa-trash"></i> @lang('site.delete')</button>
                                                    @endif
                                        </form>

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
