@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.suggestion')</h1>

            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li class="active">@lang('site.suggestion')</li>
            </ol>
        </section>
        <section class="content">

            <div class="box box-primary">

                <div class="box-header with-border">

                    <h3 class="box-title" style="margin-bottom: 15px">@lang('site.suggestion') <small>{{ $complines->total() }}</small></h3>

                    <form action="{{ route('dashboard.suggestion.index') }}" method="get">

                        <div class="row">

                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" placeholder="@lang('site.search')" value="{{ request()->search }}">
                            </div>

                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> @lang('site.search')</button>

                            </div>

                        </div>
                    </form><!-- end of form -->

                </div><!-- end of box header -->

                <div class="box-body">

                    @if ($complines->count() > 0)

                        <table class="table  table-hover">

                            <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('site.Name')</th>
                                <th>@lang('site.email')</th>
                                <th>@lang('site.message')</th>
                                <th>@lang('site.status')</th>
                                <th>@lang('site.action')</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach ($complines as $index=>$user)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td ><p style="max-width:250px;text-overflow:ellipsis; overflow:hidden;white-space:nowrap;" id="message">{{ $user->message }}</p></td>
                                    @if( $user->status==0)
                                    <td>@lang('site.Not answered')</td>
                                    @else
                                        <td>@lang('site.answered')</td>
                                    @endif
                                    <td>

                                            <button type="button" id="pop" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                                @lang('site.View Message')
                                            </button>

                                            <a href="{{ route('dashboard.suggestion.edit', $user->id) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> @lang('site.Answer')</a>


                                    </td>
                                </tr>

                            @endforeach
                            </tbody>

                        </table><!-- end of table -->

                        {{ $complines->appends(request()->query())->links() }}

                    @else

                        <h2>@lang('site.no_data_found')</h2>

                    @endif

                </div><!-- end of box body -->


            </div><!-- end of box -->

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">@lang('site.Message Preview')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="word-wrap: break-word;" >

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {

            $("#pop").on("click", function() {
                var text=document.getElementById('message').innerText;
                console.log(text);
               $('.modal-body').append(text);

            });

        });


    </script>
@endsection
