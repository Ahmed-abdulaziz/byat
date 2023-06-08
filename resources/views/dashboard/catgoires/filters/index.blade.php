@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.filter')</h1>

            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li class="active">@lang('site.filter')</li>
            </ol>
        </section>





        <section class="content">

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title" style="margin-bottom: 15px">@lang('site.filter') <small></small></h3>


                    <form action="{{route('dashboard.catgoiries.index')}}" method="get">

                        <div class="row">


                            <div class="col-md-4">
                               @if(auth()->user()->hasPermission('create_filters'))
                                <a href="{{route('dashboard.add_filters',$cat_id)}}" class="btn btn-primary"><i class="fa fa-plus"></i> @lang('site.create')</a>
                                @endif
                                 @if(auth()->user()->hasPermission('arrange_filters'))
                                   @if($data->count() > 0)
                                        <a href="{{route('dashboard.order_filters',$cat_id)}}" class="btn btn-primary"><i class="fa fa-arrows-v" aria-hidden="true"></i>  @lang('site.arrange filters')</a>
                                   @endif
                                 @endif
                                
                            </div>
                     
                        </div>
                    </form><!-- end of form -->
                </div> <!-- end of box header -->

                <div class="box-body">
                    @if($data->count() > 0)
                        <table class="table table-bordered" id="myTable">
                            <thead>
                                   <tr>
                                        <th>#</th>
                                        <th>@lang('site.name')</th>
                                        <th>@lang('site.Options')</th>
                                    </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $index=>$single)
                                    <tr>
                                        <td>{{$index +1}}</td>
                                       <td>{{$single->name}}</td>
                                     
    
                                        <td>
                                         
                                            @if (auth()->user()->hasPermission('update_filters'))
                                                    <a href="{{route('dashboard.edit_filters',$single->id)}}" class="btn btn-primary"><i class="fa fa-edit"></i>@lang('site.update')</a>
                                            @endif
                                            <form action="{{ route('dashboard.destroy_filters', $single->id) }}" method="post" style="display: inline-block">
                                                {{ csrf_field() }}
                                                @if(auth()->user()->hasPermission('delete_filters'))
                                                        <button type="submit" class="btn btn-danger delete btn-sm"><i class="fa fa-trash"></i> @lang('site.delete')</button>
                                                @endif
                                            </form>
    
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
