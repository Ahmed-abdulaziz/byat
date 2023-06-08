@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.Payment Requests')</h1>

            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li class="active">@lang('site.Payment Requests')</li>
            </ol>
        </section>





        <section class="content">

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title" style="margin-bottom: 15px">@lang('site.Payment Requests') <small></small></h3>


                    <form action="{{route('dashboard.payments.index')}}" method="get">

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
                    @if($paymnets->count() > 0)
                        <table class="table table-bordered">
                            <tr>
                                <th>#</th>
                                <th>@lang('site.User Name')</th>
                                <th>@lang('site.phone')</th>
                                <th>@lang('site.type')</th>
                                <th>@lang('site.copy of the receipt')</th>
                                <th>@lang('site.Payment Method')</th>
                                <th>@lang('site.date')</th>
                                <th>@lang('site.Options')</th>
                            </tr>


                            @foreach($paymnets as $index=>$single)
                                <tr>
                                    <td>{{$index +1}}</td>
                                    <td>{{$single->user->name ?? ''}}</td>
                                    <td>{{$single->user->phone ?? ''}}</td>
                                    @if($single->type==1)
                                        <td>@lang('site.Spicaialzation Request')</td>
                                    @else
                                        <td>@lang('site.Subscription Request')</td>
                                    @endif
                                    <td>
                                       <a href="#" id="pop">
                                           <img id="imageresource" width="50px" height="50px" src="{{asset('uploads/paymnets/'.$single->img)}}" >
                                       </a>

                                       <div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                           <div class="modal-dialog">
                                               <div class="modal-content">
                                                   <div class="modal-header">
                                                       <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                       <h4 class="modal-title" id="myModalLabel">Image preview</h4>
                                                   </div>
                                                   <div class="modal-body">
                                                       <img src="" id="imagepreview" style="width: 400px; height: 264px;" >
                                                   </div>
                                                   <div class="modal-footer">
                                                       <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                   </div>
                                               </div>
                                           </div>
                                       </div>

                                   </td>
                                   @if($single->payment_method==3)
                                        <td>@lang('site.bank transfer')</td>
                                    @elseif($single->payment_method==2)
                                        <td>@lang('site.telcome')</td>
                                    @else
                                        <td>@lang('site.credit_card')</td>
                                    @endif
                                    <td>{{$single->created_at}}</td>
                                    <td>
                                        <a href="{{ route('dashboard.payments.edit', $single->id) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> @lang('site.Accept Payment')</a>

                                        <form action="{{ route('dashboard.payments.destroy', $single->id) }}" method="post" style="display: inline-block">
                                            {{ csrf_field() }}
                                            {{ method_field('delete') }}
                                            @if(auth()->user()->hasPermission('delete_appsetting'))

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
                        {{ $paymnets->appends(request()->query())->links() }}
                    @else
                        <h2>@lang('site.no_data_found')</h2>
                    @endif

                </div>

            </div>

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->
    <script>
        $(document).ready(function () {

            $("#pop").on("click", function() {
                $('#imagepreview').attr('src', $('#imageresource').attr('src')); // here asign the image to the modal when the user click the enlarge link
                $('#imagemodal').modal('show'); // imagemodal is the id attribute assigned to the bootstrap modal, then i use the show function
            });

        });


    </script>
@endsection
