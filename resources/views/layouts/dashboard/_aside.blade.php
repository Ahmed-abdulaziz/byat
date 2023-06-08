<aside class="main-sidebar">

    <section class="sidebar">

        <div class="user-panel">
            <div class="pull-left image">
                @if(!empty(auth()->user()->image))
                    <img src=" {{asset('uploads/user_images/'.auth()->user()->image)}}" class="img-circle" alt="User Image">
                @else
                    <img src="{{ asset('dashboard/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
                @endif
            </div>
            <div class="pull-left info">
                <p>{{ auth()->user()->first_name }}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <ul class="sidebar-menu" data-widget="tree">
            <li><a href="{{ route('dashboard.statistic') }}"><i class="fa fa-th"></i><span>@lang('site.dashboard')</span></a></li>


            @if (auth()->user()->hasPermission('read_cites'))
                <li><a href="{{ route('dashboard.cites.index') }}"><i class="fa fa-th"></i><span>@lang('site.cites')</span></a></li>
            @endif

            @if (auth()->user()->hasPermission('read_area'))
            
                <li><a href="{{ route('dashboard.area.index') }}"><i class="fa fa-th"></i><span>@lang('site.Add Area')</span></a></li>
            @endif


           @if (auth()->user()->hasPermission('read_categories'))
              <li class="treeview" style="height: auto;">
                    <a href="#">
                        <i class="fa fa-folder"></i> <span>@lang('site.Catgoires')</span>
                        <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                    </a>
                    <ul class="treeview-menu" style="display: none;">
                        <li><a href="{{ route('dashboard.catgoiries.index') }}?type=1"><i class="fa fa-th"></i><span>@lang('site.Advertisements')</span></a></li>
                        <li><a href="{{ route('dashboard.catgoiries.index') }}?type=2"><i class="fa fa-th"></i><span>@lang('site.auctions')</span></a></li>

                    </ul>
                </li>
            @endif
              @if (auth()->user()->hasPermission('read_auctions'))
                    <li class="treeview" style="height: auto;">
                    <a href="#">
                        <i class="fa fa-folder"></i> <span>@lang('site.auctions')</span>
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu" style="display: none;">
                            <li><a href="{{ route('dashboard.Auctions') }}"><i class="fa fa-th"></i><span>@lang('site.auctions')</span></a></li>
                             @if (auth()->user()->hasPermission('freeAuctions'))
                                <li><a href="{{ route('dashboard.free-Auctions') }}"><i class="fa fa-th"></i><span>@lang('site.Free auction Numbers')</span></a></li>
                            @endif
                             @if (auth()->user()->hasPermission('auctions_duration'))
                                <li><a href="{{ route('dashboard.auction_duration') }}"><i class="fa fa-th"></i><span>@lang('site.auction duration')</span></a></li>
                             @endif
                              @if (auth()->user()->hasPermission('auction-winners'))
                                <li><a href="{{ route('dashboard.auction_winner') }}"><i class="fa fa-th"></i><span>@lang('site.auction-winners')</span></a></li>
                             @endif
                             @if (auth()->user()->hasPermission('String-after-auction'))
                                <li><a href="{{ route('dashboard.afauctionstring') }}"><i class="fa fa-th"></i><span>@lang('site.String after auction')</span></a></li>
                             @endif
                              @if (auth()->user()->hasPermission('deposit-amount'))
                                <li><a href="{{ route('dashboard.deposit_amount') }}"><i class="fa fa-th"></i><span>@lang('site.deposit amount')</span></a></li>
                             @endif
                             @if (auth()->user()->hasPermission('The-maximum-duration-of-the-auction'))
                                <li><a href="{{ route('dashboard.maximum_auction_duration') }}"><i class="fa fa-th"></i><span>@lang('site.The maximum duration of the auction')</span></a></li>
                             @endif
                             @if (auth()->user()->hasPermission('report'))
                                <li><a href="{{ route('dashboard.reports.index',['type'=>2]) }}"><i class="fa fa-th"></i><span>@lang('site.report')</span></a></li>
                             @endif
                              @if (auth()->user()->hasPermission('auctions_introduction_video'))
                                <li><a href="{{ route('dashboard.auctions_introduction_video') }}"><i class="fa fa-th"></i><span>@lang('site.Auctions introduction video')</span></a></li>
                             @endif
                             
                             
                    </ul>
                </li>
            @endif
            
                @if (auth()->user()->hasPermission('read_advertiments'))
                    <li class="treeview" style="height: auto;">
                    <a href="#">
                        <i class="fa fa-folder"></i> <span>@lang('site.Advertisements')</span>
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu" style="display: none;">
                        <li><a href="{{ route('dashboard.advertismnets.index') }}"><i class="fa fa-th"></i><span>@lang('site.Advertisements')</span></a></li>
                        @if (auth()->user()->hasPermission('Free-Adv-Numbers'))
                        <li><a href="{{ route('dashboard.dailuadvcount.index') }}"><i class="fa fa-th"></i><span>@lang('site.Free Adv Numbers')</span></a></li>
                        @endif 
                        @if (auth()->user()->hasPermission('ad_duration'))
                        <li><a href="{{ route('dashboard.ad_duration') }}"><i class="fa fa-th"></i><span>@lang('site.Ad duration')</span></a></li>
                        @endif
                        @if (auth()->user()->hasPermission('String-after-ADV'))
                        <li><a href="{{ route('dashboard.afadvstring.index') }}"><i class="fa fa-th"></i><span>@lang('site.String after ADV')</span></a></li>
                        @endif
                        @if (auth()->user()->hasPermission('update_adv_requirment'))
                        <li><a href="{{ route('dashboard.update_adv_requirements') }}"><i class="fa fa-th"></i><span>@lang('site.update adv requirment')</span></a></li>
                         @endif
                        @if (auth()->user()->hasPermission('report'))
                             <li><a href="{{ route('dashboard.reports.index',['type'=>1]) }}"><i class="fa fa-th"></i><span>@lang('site.report')</span></a></li>
                        @endif
                         @if (auth()->user()->hasPermission('read_adv_free'))
                         <li><a href="{{ route('dashboard.FreeAdvertisments.index') }}"><i class="fa fa-th"></i><span>@lang('site.adv_free')</span></a></li>
                         @endif
                    </ul>
                </li>
            @endif
          
       
            @if (auth()->user()->hasPermission('read_banars'))
                <li><a href="{{ route('dashboard.banar.index') }}"><i class="fa fa-th"></i><span>@lang('site.Banars')</span></a></li>
            @endif

            @if (auth()->user()->hasPermission('read_packages'))
                <li><a href="{{ route('dashboard.packages.index') }}"><i class="fa fa-th"></i><span>@lang('site.Packages')</span></a></li>
            @endif 
            <!--@if (auth()->user()->hasPermission('read_appsetting'))-->
            <!--    <li><a href="{{ route('dashboard.subscriptions') }}"><i class="fa fa-th"></i><span>@lang('site.pacakage subscriptions')</span></a></li>-->
            <!--@endif-->
            
            @if (auth()->user()->hasPermission('read_monthly_withdrawals'))
                <li><a href="{{ route('dashboard.MonthlyWithdrawals.index') }}"><i class="fa fa-th"></i><span>@lang('site.monthly_withdrawals')</span></a></li>
            @endif
          

            @if (auth()->user()->hasPermission('read_appusers'))
                <li><a href="{{ route('dashboard.appuser.index') }}"><i class="fa fa-th"></i><span>@lang('site.Application Users')</span></a></li>
            @endif
            @if (auth()->user()->hasPermission('appUsers_reports'))
                <li><a href="{{ route('dashboard.report_users') }}"><i class="fa fa-th"></i><span>@lang('site.Customer reports')</span></a></li>
            @endif
            
             @if (auth()->user()->hasPermission('cash_payment_requests'))
                <li><a href="{{ route('dashboard.cash_payment_requests') }}"><i class="fa fa-th"></i><span>@lang('site.cash_payment_requests')</span></a></li>
            @endif
            
            
            @if (auth()->user()->hasPermission('app-user-requirments'))
                <li><a href="{{ route('dashboard.app-user-requirments') }}"><i class="fa fa-th"></i><span>@lang('site.user requirment')</span></a></li>
            @endif

        
             @if (auth()->user()->hasPermission('Balance_recovery'))
                <li class="treeview" style="height: auto;">
                    <a href="#">
                        <i class="fa fa-folder"></i> <span>@lang('site.Balance_recovery')</span>
                        <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                    </a>
                    <ul class="treeview-menu" style="display: none;">
                        <li><a href="{{ route('dashboard.Balance_recovery',['type'=>0]) }}"><i class="fa fa-th"></i><span>@lang('site.Balance_recovery')</span></a></li>
                        <li><a href="{{ route('dashboard.Balance_recovery',['type'=>1]) }}"><i class="fa fa-th"></i><span>@lang('site.Transferred requests')</span></a></li>
                    </ul>
                </li>
            @endif
             @if (auth()->user()->hasPermission('read_codes'))
                <li><a href="{{ route('dashboard.codes') }}"><i class="fa fa-th"></i><span>@lang('site.codes')</span></a></li>
            @endif
            
            
    

            @if (auth()->user()->hasPermission('read_copons'))
              <li class="treeview" style="height: auto;">
                    <a href="#">
                        <i class="fa fa-folder"></i> <span>@lang('site.copons')</span>
                        <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                    </a>
                    <ul class="treeview-menu" style="display: none;">
                        <li><a href="{{ route('dashboard.copons.index') }}"> <i class="fa fa-th"></i><span> @lang('site.copons')</span></a></li>
                          @if (auth()->user()->hasPermission('Coupon_reports'))
                                <li><a href="{{ route('dashboard.Copon-reports') }}"> <i class="fa fa-th"></i><span> @lang('site.Coupon reports')</span></a></li>
                         @endif

                    </ul>
                </li>
            @endif
            <!--@if (auth()->user()->hasPermission('read_categories'))-->
            <!--    <li><a href="{{ route('dashboard.banks.index') }}"><i class="fa fa-th"></i><span>@lang('site.Banks')</span></a></li>-->
            <!--@endif-->

            @if (auth()->user()->hasPermission('Send_Genral_Notifctions'))
                <li><a href="{{ route('dashboard.getnotifview') }}"><i class="fa fa-th"></i><span>@lang('site.Send Genral Notifctions')</span></a></li>
            @endif

            @if (auth()->user()->hasPermission('Complines'))
                <li><a href="{{ route('dashboard.complines.index') }}"><i class="fa fa-th"></i><span>@lang('site.Complines')</span></a></li>
            @endif
            @if (auth()->user()->hasPermission('Suggestions'))
                <li><a href="{{ route('dashboard.suggestion.index') }}"><i class="fa fa-th"></i><span>@lang('site.Suggestions')</span></a></li>
            @endif
            @if (auth()->user()->hasPermission('read_users'))
                <li><a href="{{ route('dashboard.users.index') }}"><i class="fa fa-th"></i><span>@lang('site.Users')</span></a></li>
            @endif

            
            @if (auth()->user()->hasPermission('app_reports'))
                <li class="treeview" style="height: auto;">
                    <a href="#">
                        <i class="fa fa-folder"></i> <span>@lang('site.Reports')</span>
                        <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                    </a>
                    <ul class="treeview-menu" style="display: none;">
                        <li><a href="{{ url('dashboard/subscription-reports/0') }}"><i class="fa fa-th"></i><span>@lang('site.Reports Add ads packages')</span></a></li>
                        <li><a href="{{ url('dashboard/subscription-reports/1') }}"><i class="fa fa-th"></i><span>@lang('site.Reports Add Auctions Packages')</span></a></li>
                        <li><a href="{{ url('dashboard/subscription-reports/2') }}"><i class="fa fa-th"></i><span>@lang('site.Reports Excellence Packages')</span></a></li>
                        <li><a href="{{ route('dashboard.Balance_list') }}"><i class="fa fa-th"></i><span>@lang('site.customer wallets')</span></a></li>
                        <li><a href="{{ route('dashboard.wallet_reports') }}"><i class="fa fa-th"></i><span>@lang('site.Reports charge wallets')</span></a></li>
                        <!--<li><a href="{{ route('dashboard.userpays.index') }}"><i class="fa fa-th"></i><span>@lang('site.Client Payment Reports')</span></a></li>-->

                        <!--<li><a href="{{ route('dashboard.usersub.index') }}"><i class="fa fa-th"></i><span>@lang('site.Client Subscribe Reports')</span></a></li>-->



                    </ul>
                </li>
            @endif
            
            
            @if (auth()->user()->hasPermission('read_appsetting'))
                <li class="treeview" style="height: auto;">
                    <a href="#">
                        <i class="fa fa-folder"></i> <span>@lang('site.appsetting')</span>
                        <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                    </a>
                    <ul class="treeview-menu" style="display: none;">
                            <li><a href="{{ route('dashboard.aboutapp.index') }}"><i class="fa fa-th"></i><span>@lang('site.About App')</span></a></li>
                            <li><a href="{{ route('dashboard.usingplocy.index') }}"><i class="fa fa-th"></i><span>@lang('site.Using Policy')</span></a></li>
                            <li><a href="{{ route('dashboard.callus.index') }}"><i class="fa fa-th"></i><span>@lang('site.Callus')</span></a></li>

                    </ul>
                </li>
            @endif
            

            @if (auth()->user()->hasPermission('Edit_Profile'))
                <li><a href="{{ route('dashboard.updateprofile.edit',auth()->user()->id) }}"><i class="fa fa-th"></i><span>@lang('site.Edit Profile')</span></a></li>
            @endif

        </ul>

    </section>

</aside>

