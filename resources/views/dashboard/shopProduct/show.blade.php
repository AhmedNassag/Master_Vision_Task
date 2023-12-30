<?php $page="shopProduct";?>

@extends('layouts.master')

@section('css')
    <!-- Print -->
    <style>
        @media print {
            .notPrint {
                display: none;
            }
        }
    </style>
    @section('title')
        {{ trans('main.ShopProduct') }}
    @stop
@endsection



@section('content')
            <!-- Page Wrapper -->
            <div class="page-wrapper">
                <div class="content container-fluid">
                    <!-- Page Header -->
                <div class="page-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="page-title">{{ trans('main.ShopProduct') }}</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ trans('main.Dashboard') }}</a></li>
                                <li class="breadcrumb-item active">{{ trans('main.ShopProduct') }}</li>
                            </ul>
                        </div>
                        <div class="col-auto">
                            <a href="{{ route('shopProduct.index') }}" type="button" class="btn btn-primary me-2" id="filter_search">
                                {{ trans('main.Back') }}
                                <i class="fas fa-arrow-left"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-body">

                                    <!-- validationNotify -->
                                    @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endif

                                    <!-- success Notify -->
                                    @if (session()->has('success'))
                                    <script id="successNotify">
                                        window.onload = function() {
                                            notif({
                                                msg: "تمت العملية بنجاح",
                                                type: "success"
                                            })
                                        }
                                    </script>
                                    @endif

                                    <!-- error Notify -->
                                    @if (session()->has('error'))
                                    <script id="errorNotify">
                                        window.onload = function() {
                                            notif({
                                                msg: "لقد حدث خطأ.. برجاء المحاولة مرة أخرى!",
                                                type: "error"
                                            })
                                        }
                                    </script>
                                    @endif

                                    <!-- canNotDeleted Notify -->
                                    @if (session()->has('canNotDeleted'))
                                    <script id="canNotDeleted">
                                        window.onload = function() {
                                            notif({
                                                msg: "لا يمكن الحذف لوجود بيانات أخرى مرتبطة بها..!",
                                                type: "error"
                                            })
                                        }
                                    </script>
                                    @endif
                                    <div class="table-responsive">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover mb-0">
                                                <tr>
                                                    <th>{{ trans('main.Product') }}</th>	
                                                    <td>{{ $data->product ? $data->product->name : '' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>{{ trans('main.Shop') }}</th>	
                                                    <td>{{ $data->shop ? $data->shop->name : '' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>{{ trans('main.Quantity') }}</th>
                                                    <td>{{ $data->quantity }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>	
                    </div>	
                </div>
            </div>			
        </div>
        <!-- /Page Wrapper -->
	</div>
</div>
<!-- /Main Wrapper -->
	
@endsection



@section('js')
    
@endsection
