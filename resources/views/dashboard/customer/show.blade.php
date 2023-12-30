<?php $page="customer";?>

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
        {{ trans('main.Customer') }}
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
                                <h3 class="page-title">{{ trans('main.Customer') }}</h3>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ trans('main.Dashboard') }}</a></li>
                                    <li class="breadcrumb-item active">{{ trans('main.Customer') }}</li>
                                </ul>
                            </div>
                            <div class="col-auto">
                                <a href="{{ route('customer.index') }}" type="button" class="btn btn-primary me-2" id="filter_search">
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
                                                    <th class="text-center">{{ trans('main.Name') }}</th>
                                                    <td class="text-center">{{ $data->name }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="text-center">{{ trans('main.Email') }}</th>
                                                    <td class="text-center">{{ $data->email }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="text-center">{{ trans('main.Mobile') }}</th>
                                                    <td class="text-center">{{ $data->mobile }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="text-center">{{ trans('main.Status') }}</th>
                                                    <td class="text-center">
                                                        @if ($data->status == 1)
                                                            <div class="btn ripple btn-purple-gradient" id='swal-success'>
                                                                <span class="label text-success text-center">
                                                                    {{ app()->getLocale() == 'ar' ? 'مفعل' : 'Active' }}
                                                                </span>
                                                            </div>
                                                        @else
                                                            <div class="btn ripple btn-purple-gradient" id='swal-success'>
                                                                <span class="label text-danger text-center">
                                                                    {{ app()->getLocale() == 'ar' ? 'غير مفعل' : 'InActive' }}
                                                                </span>
                                                            </div>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th class="text-center">{{ trans('main.Sales') }}</th>
                                                    <td class="text-center">
                                                        <table class="table table-bordered table-hover mb-0">
                                                            <tr>
                                                                <th class="text-center">{{ trans('main.Date') }}</th>
                                                                <th class="text-center">{{ trans('main.Total') }}</th>
                                                                <th class="text-center">{{ trans('main.Details') }}</th>
                                                            </tr>
                                                            @foreach($data->customer->sales as $sale)
                                                            <tr>
                                                                <td class="text-center">{{ $sale->date }}</td>
                                                                <td class="text-center">{{ $sale->grandTotal }}</td>
                                                                <td class="text-center">
                                                                    <table class="table table-bordered table-hover mb-0">
                                                                        <tr>
                                                                            <th class="text-center">{{ trans('main.Product') }}</th>
                                                                            <th class="text-center">{{ trans('main.Quantity') }}</th>
                                                                            <th class="text-center">{{ trans('main.Unit Price') }}</th>
                                                                            <th class="text-center">{{ trans('main.Sub Total') }}</th>
                                                                        </tr>
                                                                        @foreach($sale->sale_details as $detail)
                                                                        <tr>
                                                                            <td class="text-center">{{ $detail->product->name }}</td>
                                                                            <td class="text-center">{{ $detail->quantity }}</td>
                                                                            <td class="text-center">{{ $detail->unit_price }}</td>
                                                                            <td class="text-center">{{ $detail->quantity * $detail->unit_price }}</td>
                                                                        </tr>
                                                                        @endforeach
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                        </table>
                                                    </td>
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
