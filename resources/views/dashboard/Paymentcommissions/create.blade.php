@extends('layouts.dashboard.app')

@section('content')
@if($type==1)
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                                    تداول/ادفع لي

                
            </h1>

            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li><a href="{{ route('dashboard.Paymentcommissions.index') }}">                     تداول/ادفع لي

                
                </a></li>
                <li class="active">@lang('site.add')</li>
            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">

                <div class="box-header">
                    <h3 class="box-title">@lang('site.add')</h3>
                </div><!-- end of box header -->
                <div class="box-body">

                    @include('partials._errors')


                    <form action="{{ route('dashboard.Paymentcommissions.store') }}" method="post"  enctype="multipart/form-data">

                        {{ csrf_field() }}
                        {{ method_field('post') }}
<input type="hidden" name="type" value="1">
                            <div class="form-group">
                                <label>@lang('site.amounts')</label>
                                <input type="text" name="commissions" class="form-control" value="{{ old('amount') }}">
                            </div>
                        
                      
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> @lang('site.add')</button>
                        </div>

                    </form><!-- end of form -->

                </div><!-- end of box body -->

            </div><!-- end of box -->

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->
@endif

@if($type==2)
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
سداد
                
            </h1>

            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li><a href="{{ route('dashboard.Paymentcommissions.index') }}">                     تداول/ادفع لي

                
                </a></li>
                <li class="active">@lang('site.add')</li>
            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">

                <div class="box-header">
                    <h3 class="box-title">@lang('site.add')</h3>
                </div><!-- end of box header -->
                <div class="box-body">

                    @include('partials._errors')


                    <form action="{{ route('dashboard.Paymentcommissions.store') }}" method="post"  enctype="multipart/form-data">

                        {{ csrf_field() }}
                        {{ method_field('post') }}
<input type="hidden" name="type" value="2">
                            <div class="form-group">
                                <label>@lang('site.amounts')</label>
                                <input type="text" name="commissions" class="form-control" value="{{ old('amount') }}">
                            </div>
                        
                      
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> @lang('site.add')</button>
                        </div>

                    </form><!-- end of form -->

                </div><!-- end of box body -->

            </div><!-- end of box -->

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->
@endif


@if($type==3)
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
معاملات
                
            </h1>

            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li><a href="{{ route('dashboard.Paymentcommissions.index') }}">                     تداول/ادفع لي

                
                </a></li>
                <li class="active">@lang('site.add')</li>
            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">

                <div class="box-header">
                    <h3 class="box-title">@lang('site.add')</h3>
                </div><!-- end of box header -->
                <div class="box-body">

                    @include('partials._errors')


                    <form action="{{ route('dashboard.Paymentcommissions.store') }}" method="post"  enctype="multipart/form-data">

                        {{ csrf_field() }}
                        {{ method_field('post') }}
<input type="hidden" name="type" value="3">
                            <div class="form-group">
                                <label>@lang('site.amounts')</label>
                                <input type="text" name="commissions" class="form-control" value="{{ old('amount') }}">
                            </div>
                        
                      
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> @lang('site.add')</button>
                        </div>

                    </form><!-- end of form -->

                </div><!-- end of box body -->

            </div><!-- end of box -->

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->
@endif
@endsection
