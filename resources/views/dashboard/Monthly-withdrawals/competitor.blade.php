@extends('layouts.dashboard.app')

@section('content')
<style>
   
.loader3 {
    width: 100%;
    height: 100%;
    display: inline-block;
    padding: 0px;
    text-align: left;
    background: #fff;
    z-index: 10000;
    position: absolute;
}
.loader3 span {
    position:absolute;
    display:inline-block;
    width:50px;
    height:50px;
    border-radius:100%;
    background:rgba(135, 211, 124,1);
    -webkit-animation:loader3 1.5s linear infinite;
    animation:loader3 1.5s linear infinite;
    left: 45%;
    top: 30%;
}
.loader3 span:last-child {
   animation-delay:-0.9s;
   -webkit-animation-delay:-0.9s;
}
@keyframes loader3 {
   0% {transform: scale(0, 0);opacity:0.8;}
   100% {transform: scale(1, 1);opacity:0;}
}
@-webkit-keyframes loader3 {
   0% {-webkit-transform: scale(0, 0);opacity:0.8;}
   100% {-webkit-transform: scale(1, 1);opacity:0;}
}


.p-snaper{
    left: 43%;
    font-size: 28px;
    top: 25%;
    position: relative;
}



</style>



<div id="snapper" ><div class="loader3">
    <p class="p-snaper">@lang('site.Please wait')</p>
    <span></span>
    <span></span>

</div>
</div>
    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.competitor in Monthly Withdrawal')</h1>

            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li class="active">@lang('site.competitor in Monthly Withdrawal')</li>
            </ol>
        </section>




        <section class="content">

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title" style="margin-bottom: 15px">@lang('site.competitor in Monthly Withdrawal') <small></small></h3>
                            <div class="row">
                            <div class="col-md-4">
                                 @if(auth()->user()->hasPermission('choose_winner_monthly_withdrawals'))
                                      @if($data->status == 0)
                                            <button type="button" class="btn btn-success random-winner" data-toggle="modal" data-target="#exampleModal">@lang('site.Random winner selection')</button>
                                       @endif
                                 @endif
                            </div>

                        </div>
                </div> <!-- end of box header -->

                <div class="box-body">
                    @if($bills->count() > 0)
                        <table class="table table-bordered" id="myTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>@lang('site.user-name')</th>
                                    <th>@lang('site.phone')</th>
                                </tr>
                            </thead>
                        <tbody>
                                @foreach($bills as $index=>$single)
                                    <tr>
                                        <td>{{$index +1}}</td>
                                        <td>{{$single->user->name}}</td>
                                        <td>{{$single->user->phone}}</td>
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
<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">@lang('site.Search Results')</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
                
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
@endsection
@section('javascript')
<script>
    $("#snapper").hide();
    
    $(".random-winner").click(function(){
        //  $('#exampleModal').modal('show');
        $("#snapper").show();
         interval =  setInterval(function() {
                     $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                    });
                     $.ajax({
                        type: 'post',
                        url: '{{ route("dashboard.random-winner-MonthlyWithdrawals") }}',
                        data: {
                            monthly_withdrawals_id:{{$data->id}},
                        },
                        success: function (response) {
                                clearInterval(interval);
                                console.log(response['name']);
                                if(response != ''){
                                        $(".modal-body").html('<h2>'+ response['name'] +'</h2>');

                                }else{
                                    $(".modal-body").html('<h2> @lang('site.no_data_found')  </h2>');
                                }
                                
                               $("#snapper").hide();
                             
                        }
                    });
                    
            
        }, 5000);
         
    });
</script>
@endsection