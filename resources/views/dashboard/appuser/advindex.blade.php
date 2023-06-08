@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.advertisements')</h1>

            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li class="active">@lang('site.advertisements')</li>
            </ol>
        </section>





        <section class="content">

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title" style="margin-bottom: 15px">@lang('site.advertisements') <small></small></h3>


                    <form action="{{route('dashboard.advertismnets.index')}}" method="get">

                        <div class="row">

                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" placeholder="@lang('site.search')" value="{{ request()->search }}">
                            </div>

                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> @lang('site.search')</button>
                            </div>

                        </div>
                    </form><!-- end of form -->
                </div> <!-- end of box header -->

                <div class="box-body">
                    @if($Bankacounts->count() > 0)
                        <table class="table table-bordered">
                            <tr>
                                <th>#</th>
                                <th>@lang('site.title')</th>
                                <th>@lang('site.phone')</th>
                                <th>@lang('site.Owner Name')</th>
                                <th>@lang('site.advertisement Type')</th>
                                <th>@lang('site.Options')</th>
                            </tr>


                            @foreach($Bankacounts as $index=>$single)
                                <tr>
                                    <td>{{$index +1}}</td>
                                        <td>{{$single->title}}</td>
                                        <td>{{$single->phone}}</td>
                                         <td>{{$single->owner->name}}</td>
                                    @if($single->cat_id==1)
                                        <td>@lang('site.cars')</td>
                                    @elseif($single->cat_id==2)
                                        <td>@lang('site.plates')</td>
                                    @else
                                        <td>@lang('site.Others')</td>
                                    @endif

                                    <td>
                                        <a href="{{ route('dashboard.advertismnets.edit', $single->id) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> @lang('site.View Images')</a>
{{--                                        @if($single->special==-1)--}}
{{--                                            <a href="{{ route('dashboard.makespcial', $single->id) }}" class="btn btn-github btn-sm"><i class="fa fa-star"></i> @lang('site.make Special')</a>--}}
{{--                                        @else--}}
{{--                                            <a href="{{ route('dashboard.makespcial', $single->id) }}" class="btn btn-warning btn-sm"><i class="fa fa-star"></i> @lang('site.Special')</a>--}}
{{--                                        @endif--}}
                                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#exampleModal">
                                            <i class="fa fa-star"></i> @lang('site.make Special')
                                        </button>
                                        <form action="{{ route('dashboard.makespcial', $single->id) }}" method="get" style="display: inline-block">
                                        {{ csrf_field() }}
                                        {{ method_field('get') }}
                                        <!-- Modal -->
                                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">@lang('site.Choose package')</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="col-md-8  form-group">
                                                            @if(isset($catgory))
                                                                <label>@lang('site.Choose package')</label>
                                                                <select class="form-control select2" style="width: 100%;height:110%" name="pak_id" required>
                                                                    @foreach($catgory as $single)
                                                                        @if(app()->getLocale()=='ar')
                                                                            <option value="{{$single->id}}">{{$single->name_ar}}</option>
                                                                        @else
                                                                            <option value="{{$single->id}}">{{$single->name_en}}</option>
                                                                        @endif
                                                                    @endforeach
                                                                </select>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('site.Close')</button>
                                                        <button type="submit" class="btn btn-primary">@lang('site.Choose package')</button>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        </form>
                                        <form action="{{ route('dashboard.advertismnets.destroy', $single->id) }}" method="post" style="display: inline-block">
                                            {{ csrf_field() }}
                                            {{ method_field('delete') }}
                                            @if(auth()->user()->hasPermission('delete_advertiments'))
                                                    <button type="submit" class="btn btn-danger delete btn-sm"><i class="fa fa-trash"></i> @lang('site.delete')</button>
                                                    @else
                                                <button type="submit" class="btn btn-danger delete btn-sm disabled"><i class="fa fa-trash"></i> @lang('site.delete')</button>
                                            @endif
                                        </form>

                                    </td>
                                </tr>
                            @endforeach

                        </table>
                        {{ $Bankacounts->appends(request()->query())->links() }}
                    @else
                        <h2>@lang('site.no_data_found')</h2>
                    @endif

                </div>

            </div>

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
