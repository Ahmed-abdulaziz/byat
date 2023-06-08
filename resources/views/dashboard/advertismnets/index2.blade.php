@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.advertesments')</h1>

            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li class="active">@lang('site.advertesments')</li>
            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">

                <div class="box-header with-border">



                </div><!-- end of box header -->

                <div class="box-body">

                    @if ($iamges->count() > 0)

                        <table class="table table-hover">

                            <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('site.images')</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach ($iamges as $index=>$company)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td><img src="{{asset('uploads/adverisments/'.$company->img)}}" style="width: 100px;" class="img-thumbnail" alt=""></td>
                                </tr>

                            @endforeach
                            </tbody>

                        </table><!-- end of table -->



                    @else

                        <h2>@lang('site.no_data_found')</h2>

                    @endif

                </div><!-- end of box body -->


            </div><!-- end of box -->

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->


@endsection
