@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.done_gifts')</h1>

            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li class="active">@lang('site.done_gifts')</li>
            </ol>
        </section>





        <section class="content">

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title" style="margin-bottom: 15px">@lang('site.done_gifts') <small></small></h3>


{{--                    <form action="{{route('dashboard.gifts.index')}}" method="get">--}}

{{--                        <div class="row">--}}

{{--                            <div class="col-md-4">--}}
{{--                                <input type="text" name="search" class="form-control" placeholder="@lang('site.search')" value="{{ request()->search }}">--}}
{{--                            </div>--}}

{{--                            <div class="col-md-4">--}}
{{--                                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> @lang('site.search')</button>--}}
{{--                               @if(auth()->user()->hasPermission('create_categories'))--}}
{{--                                <a href="{{route('dashboard.gifts.create')}}" class="btn btn-primary"><i class="fa fa-plus"></i> @lang('site.Add gifts')</a>--}}
{{--                                @else--}}
{{--                                    <a href="{{route('dashboard.gifts.create')}}" class="btn btn-primary disabled"><i class="fa fa-plus"></i> @lang('site.Add gifts')</a>--}}
{{--                                @endif--}}
{{--                            </div>--}}

{{--                        </div>--}}
{{--                    </form><!-- end of form -->--}}
                </div> <!-- end of box header -->

                <div class="box-body">
                    @if($allCatgories->count() > 0)
                        <table class="table table-bordered">
                            <tr>
                                <th>#</th>
                                <th>@lang('site.image')</th>
                                <th>@lang('site.name')</th>
                                <th>@lang('site.end_date')</th>
                                <th>@lang('site.winner_name')</th>
                                <th>@lang('site.winner_phone')</th>
                                <th>@lang('site.winner_subscribe_number')</th>

                            </tr>


                            @foreach($allCatgories as $index=>$single)
                                <tr>
                                    <td>{{$index +1}}</td>
                                    <td><img src="{{asset('uploads/gifts/'.$single->image)}}" style="width: 100px;" class="img-thumbnail" alt=""></td>
                                    <td>{{$single->name ?? ""}}</td>
                                    <td>{{$single->end_date ?? ""}}</td>
                                    <td>{{$single->winner()->first()->name ?? ""}}</td>
                                    <td>{{$single->winner()->first()->phone ?? ""}}</td>
                                    <td>{{$single->winner()->first()->subscrip_number ?? ""}}</td>

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
