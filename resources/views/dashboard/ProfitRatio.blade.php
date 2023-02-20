@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.profit_percent')</h1>

            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li class="active">@lang('site.profit_percent')</li>
            </ol>
        </section>



       <!-- <a href="{{ url('dashboard/checkpdf') }}"><i class="fa fa-dashboard"></i>print</a>-->

        <section class="content">

            <div class="box box-primary">

                <div class="box-header with-border">

                    <h3 class="box-title" style="margin-bottom: 15px">@lang('site.profit_percent') <small></small></h3>

                    <form action="{{ route('dashboard.ProfitRatio.index') }}" method="get">

                        <div class="row">
<div class="col-md-2"></div>
                            <div class="col-md-4"><h4>من تاريخ</h4>
                                <input type="date" name="date1" class="form-control" placeholder="1/1/2020" >
                            </div>
                            
                            <div class="col-md-4"> <h4>الي تاريخ</h4>
                            
                            
                                <input type="date" name="date2" class="form-control" placeholder="1/1/2020" >
                            </div>
<br></br>
                            <div class="col-md-12 text-center mb-5" style="margin-top: 15px">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> @lang('site.search')</button>
                         
                            </div>

                        </div>
                    </form><!-- end of form -->

                </div><!-- end of box header -->

                <div class="box-body">

                    @if (!empty($profit))
                    
                        <section class="content">

            <div class="row">

          


           


                <div class="col-lg-12 col-xs-12 ">
                    <div class="box " style="background-color: #91d6ff;">
                        <div class="center">
                           
                          <center ><h3 style="font-weight: bold;">@lang('site.profit_percent') <span style="color:red">@lang('site.in') {{$date1}} @lang('site.to') {{$date2}}</span> </h3></center>  
                            <center ><h3 style="color:red;font-size: 50px;font-weight: bold;">{{  round($profit,2)}}</h3></center> 
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                    </div>
                </div>

            

                

            </div><!-- end of row -->

       

        </section><!-- end of content -->


                      @endif

                </div><!-- end of box body -->


            </div><!-- end of box -->

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->


@endsection
