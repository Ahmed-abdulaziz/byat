@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.Packages')</h1>

            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li class="active">@lang('site.Packages')</li>
            </ol>
        </section>





        <section class="content">

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title" style="margin-bottom: 15px">@lang('site.Packages') <small></small></h3>


                    <form action="{{route('dashboard.packages.index')}}" method="get">

                        <div class="row">

                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" placeholder="@lang('site.search')" value="{{ request()->search }}">
                            </div>

                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> @lang('site.search')</button>
                               @if(auth()->user()->hasPermission('create_packages'))
                                <a href="{{route('dashboard.packages.create')}}" class="btn btn-primary"><i class="fa fa-plus"></i> @lang('site.Add new')</a>
                                @endif
                            </div>

                        </div>
                    </form><!-- end of form -->
                </div> <!-- end of box header -->

                <div class="box-body">
                    @if($allCatgories->count() > 0)
                        <table class="table table-bordered">
                            <tr>
                                <th>#</th>
                                <th>@lang('site.name')</th>
                                <th>@lang('site.type')</th>
                                <th>@lang('site.price')</th>
                                <th>@lang('site.count')</th>
                                <th>@lang('site.Options')</th>
                            </tr>


                            @foreach($allCatgories as $index=>$single)
                                <tr>
                                    <td>{{$index +1}}</td>
                                    @if(app()->getLocale()=='ar')
                                        <td>{{$single->name_ar}}</td>
                                    @else
                                        <td>{{$single->name_en}}</td>
                                    @endif
                                    @if($single->type==0)
                                        <td>@lang('site.User packages')</td>
                                    @elseif($single->type==1)
                                        <td>@lang('site.auctions packages')</td>
                                    @elseif($single->type==2)
                                        <td>@lang('site.Technician packages')</td>
                                    
                                    @endif
                                    <td>{{$single->price}}</td>
                                    
                                     @if($single->type==0)
                                        <td>{{$single->adv_num}} @lang('site.adv') </td>
                                    @elseif($single->type==1)
                                        <td>{{$single->adv_num}} @lang('site.auction') </td>
                                    @elseif($single->type==2)
                                        <td>{{$single->period}} @lang('site.day')</td>
                                    
                                    @endif
                                    <td>
                                        @if (auth()->user()->hasPermission('update_packages'))
                                                <a href="{{route('dashboard.packages.edit',$single->id)}}" class="btn btn-primary"><i class="fa fa-edit"></i>@lang('site.update')</a>
                                        @endif
                                        <form action="{{ route('dashboard.packages.destroy', $single->id) }}" method="post" style="display: inline-block">
                                            {{ csrf_field() }}
                                            {{ method_field('delete') }}
                                            @if(auth()->user()->hasPermission('delete_packages'))

                                                      <button  class="btn btn-danger delete btn-sm hidden"><i class="fa fa-trash"></i> @lang('site.delete')</button>

                                                    <button type="submit" class="btn btn-danger delete btn-sm"><i class="fa fa-trash"></i> @lang('site.delete')</button>

                                            @endif
                                        </form>

                                    </td>
                                </tr>
                            @endforeach

                        </table>
                        {{ $allCatgories->appends(request()->query())->links() }}
                    @else
                        <h2>@lang('site.no_data_found')</h2>
                    @endif

                </div>

            </div>

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
