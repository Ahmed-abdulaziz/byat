@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.cartype')</h1>

            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li class="active">@lang('site.cartype')</li>
            </ol>
        </section>





        <section class="content">

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title" style="margin-bottom: 15px">@lang('site.cartype') <small></small></h3>


                    <form action="{{route('dashboard.cartype.index')}}" method="get">

                        <div class="row">

                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" placeholder="@lang('site.search')" value="{{ request()->search }}">
                            </div>

                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> @lang('site.search')</button>
                               @if(auth()->user()->hasPermission('create_users'))
                                <a href="{{route('dashboard.cartype.create')}}" class="btn btn-primary"><i class="fa fa-plus"></i> @lang('site.Add new cartype')</a>
                                @else
                                    <a href="{{route('dashboard.cartype.create')}}" class="btn btn-primary disabled"><i class="fa fa-plus"></i> @lang('site.Add new Category')</a>
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
                                <th>@lang('site.brand name')</th>
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
                                    @if(app()->getLocale()=='ar')
                                 {{-- <td>{{$single->brand->name_ar}}</td> --}}
                                    @else
                                      {{--  <td>{{$single->brand->name_en}}</td>--}}
                                    @endif
                                    <td>
                                        @if (auth()->user()->hasPermission('create_users'))
                                                <a href="{{route('dashboard.cartype.edit',$single->id)}}" class="btn btn-primary"><i class="fa fa-edit"></i>@lang('site.update')</a>
                                        @else
                                            <a  class="btn btn-primary disabled"><i class="fa fa-edit"></i>@lang('site.update')</a>
                                        @endif
                                        <form action="{{ route('dashboard.cartype.destroy', $single->id) }}" method="post" style="display: inline-block">
                                            {{ csrf_field() }}
                                            {{ method_field('delete') }}
                                            @if(auth()->user()->hasPermission('create_users'))
                                                      <button  class="btn btn-danger delete btn-sm hidden"><i class="fa fa-trash"></i> @lang('site.delete')</button>
                                                    <button type="submit" class="btn btn-danger delete btn-sm"><i class="fa fa-trash"></i> @lang('site.delete')</button>
                                                    @else

                                                <button type="submit" class="btn btn-danger delete btn-sm disabled"><i class="fa fa-trash"></i> @lang('site.delete')</button>
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
