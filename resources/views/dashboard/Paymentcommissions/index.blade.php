@extends('layouts.dashboard.app')

@section('content')

<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.Paymentcommissions')</h1>

            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li class="active">@lang('site.Paymentcommissions')</li>
            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">

                <div class="box-header with-border">

                    <h3 class="box-title" style="margin-bottom: 15px">@lang('site.Paymentcommissions') <small></small></h3>


<!------ Include the above in your HEAD tag ---------->


  
    <div class="col-12">
      <div class="card mt-3 tab-card">
        <div class="card-header tab-card-header">
          <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link btn btn-primary" id="one-tab" data-toggle="tab" href="#one" role="tab" aria-controls="One" aria-selected="true">
                
                <h3>
                    تداول/ادفع لي
                    
                </h3>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link btn btn-success" id="two-tab" data-toggle="tab" href="#two" role="tab" aria-controls="Two" aria-selected="false">
                    
                        <h3>
سداد
                </h3>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link btn btn-danger" id="three-tab" data-toggle="tab" href="#three" role="tab" aria-controls="Three" aria-selected="false">
                                        
                        <h3>
معاملات
                </h3>
                </a>
            </li>
          </ul>
        </div>

        <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade show active p-3" id="one" role="tabpanel" aria-labelledby="one-tab">
                        <div class="row">
                            <br>
                            <div class="col-md-4">
                            </div>
                            <div class="col-md-4">
                                   <!--    <a href="{{ url('dashboard/Paymentcommissionscreate/1') }}" class="btn btn-primary"><i class="fa fa-plus"></i> @lang('site.add')</a>
                          -->
                          
                            </div>
                        </div>
                   <div class="box-body">
                    @if ($tadawal->count() > 0)
                        <table class="table table-hover">
                            <thead>
                            <tr>
                             
                                <th>أسم الشركه</th>
                                <th>العموله</th>
                                <th>الحاله</th>
                               
                                <th>@lang('site.action')</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach ($tadawal as $index=>$product)
                                <tr>
                                    
                                    <td>
                                        @if($product->companyname=='تداول')
                                        تداول/ادفع لي
                                        @else
                                        {{ $product->companyname }}
                                        @endif
                                        </td>
                                    <td>{!! $product->commissions !!}</td>
                                    <td>
                                        @if($product->status==0)
                                         {{'مفعل'}}
                                        @else
                                        {{' غير مفعل'}}
                                        @endif
                                        </td>
                                    <td>
                                            <a href="{{ route('dashboard.Paymentcommissions.edit', $product->id) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> @lang('site.edit')</a>
                                            <form action="{{ route('dashboard.Paymentcommissions.destroy', $product->id) }}" method="post" style="display: inline-block">
                                                {{ csrf_field() }}
                                                {{ method_field('delete') }}

  @if($product->status==1)
                                                <button type="submit" class="btn btn-danger delete btn-sm"><i class=""></i>Enabled </button>
                                                @else
                                                <button type="submit" class="btn btn-primary delete btn-sm"><i class=""></i>Disabled </button>

                                                @endif
                                            </form><!-- end of form -->
                                      
                                    </td>
                                </tr>

                            @endforeach
                            </tbody>

                        </table><!-- end of table -->

                        

                    @else

                        <h2>@lang('site.no_data_found')</h2>

                    @endif

                </div><!-- end of box body -->


                    
                    
                    
                    
                       
          </div>
          <div class="tab-pane fade p-3" id="two" role="tabpanel" aria-labelledby="two-tab">
           <div class="row">
                            <br>
                            <div class="col-md-4">
                            </div>
                            <div class="col-md-4">
                                    <!--   <a href="{{ url('dashboard/Paymentcommissionscreate/2') }}" class="btn btn-primary"><i class="fa fa-plus"></i> @lang('site.add')</a>
                         -->
                            </div>
                        </div>
                   <div class="box-body">
                    @if ($sdaad->count() > 0)
                        <table class="table table-hover">
                            <thead>
                            <tr>
                               
                                <th>أسم الشركه</th>
                                <th>العموله</th>
                                <th>الحاله</th>
                               
                                <th>@lang('site.action')</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach ($sdaad as $index=>$product)
                                <tr>
                                    
                                    <td>{{ $product->companyname }}</td>
                                    <td>{!! $product->commissions !!}</td>
                                    <td>
                                        @if($product->status==0)
                                         {{'مفعل'}}
                                        @else
                                        {{' غير مفعل'}}
                                        @endif
                                        </td>
                                    <td>
                                            <a href="{{ route('dashboard.Paymentcommissions.edit', $product->id) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> @lang('site.edit')</a>
                                            <form action="{{ route('dashboard.Paymentcommissions.destroy', $product->id) }}" method="post" style="display: inline-block">
                                                {{ csrf_field() }}
                                                {{ method_field('delete') }}

  @if($product->status==1)
                                                <button type="submit" class="btn btn-danger delete btn-sm"><i class=""></i>Enabled </button>
                                                @else
                                                <button type="submit" class="btn btn-primary delete btn-sm"><i class=""></i>Disabled </button>

                                                @endif
                                            </form><!-- end of form -->
                                      
                                    </td>
                                </tr>

                            @endforeach
                            </tbody>

                        </table><!-- end of table -->

                      

                    @else

                        <h2>@lang('site.no_data_found')</h2>

                    @endif

                </div><!-- end of box body -->

         
         
                       
          </div>
          <div class="tab-pane fade p-3" id="three" role="tabpanel" aria-labelledby="three-tab">
                
                    <div class="row">
                            <br>
                            <div class="col-md-4">
                            </div>
                            <div class="col-md-4">
                                  <!--  <a href="{{ url('dashboard/Paymentcommissionscreate/3') }}" class="btn btn-primary"><i class="fa fa-plus"></i> @lang('site.add')</a>
                          -->
                            </div>
                        </div>
                   <div class="box-body">
                    @if ($moamalt->count() > 0)
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                
                                <th>أسم الشركه</th>
                                <th>العموله</th>
                                <th>الحاله</th>
                               
                                <th>@lang('site.action')</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach ($moamalt as $index=>$product)
                                <tr>
                                    
                                    <td>{{ $product->companyname }}</td>
                                    <td>{!! $product->commissions !!}</td>
                                    <td>
                                        @if($product->status==0)
                                         {{'مفعل'}}
                                        @else
                                        {{' غير مفعل'}}
                                        @endif
                                        </td>
                                    <td>
                                            <a href="{{ route('dashboard.Paymentcommissions.edit', $product->id) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> @lang('site.edit')</a>
                                            <form action="{{ route('dashboard.Paymentcommissions.destroy', $product->id) }}" method="post" style="display: inline-block">
                                                {{ csrf_field() }}
                                                {{ method_field('delete') }}
                                                @if($product->status==1)
                                                <button type="submit" class="btn btn-danger  btn-sm"><i class=""></i>Enabled </button>
                                                @else
                                                <button type="submit" class="btn btn-primary  btn-sm"><i class=""></i>Disabled </button>

                                                @endif
                                            </form><!-- end of form -->
                                      
                                    </td>
                                </tr>

                            @endforeach
                            </tbody>

                        </table><!-- end of table -->

                       

                    @else

                        <h2>@lang('site.no_data_found')</h2>

                    @endif

                </div><!-- end of box body -->
          </div>

        </div>
      </div>
    </div>
  






                  

                </div><!-- end of box header -->

            
            </div><!-- end of box -->

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->


@endsection
