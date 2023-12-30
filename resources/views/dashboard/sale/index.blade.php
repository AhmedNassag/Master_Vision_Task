<?php $page="sales";?>

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
        {{ trans('main.Sales') }}
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
                                <h3 class="page-title">{{ trans('main.Sales') }}</h3>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ trans('main.Dashboard') }}</a></li>
                                    <li class="breadcrumb-item active">{{ trans('main.Sales') }}</li>
                                </ul>
                            </div>
                            <div class="col-auto">
                                <a href="{{ route('sale.create') }}" type="button" class="btn add-button me-2">
                                    <i class="fas fa-plus"></i>
                                </a>
                                <button type="button" class="btn filter-btn me-2" id="filter_search">
                                    <i class="fas fa-filter"></i>
                                </button>
                                <button type="button" class="btn" id="btn_delete_selected" title="{{ trans('main.Delete Selected') }}" style="display:none; width: 42px; height: 42px; justify-content: center; align-items: center; color: #fff; background: red; border: 1px solid red; border-radius: 5px;">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- /Page Header -->

                    <!-- Search Filter -->
                    <div class="card filter-card" id="filter_inputs" @if($customer_id || $from_date || $to_date) style="display:block" @endif>
                        <div class="card-body pb-0">
                            <form action="{{ route('sale.index') }}" method="get">
                                <div class="row filter-row">
                                    <div class="col-sm-6 col-md-3">
                                        <div class="form-group">
                                            <label>{{ trans('main.Customer') }}</label>
                                            <select class="form-control select2" name="customer_id">
                                                <option value="">{{ trans('main.Choose') }}</option>
                                                @foreach($customers as $customer)
                                                    <option value="{{ $customer->id }}" {{ $customer->id == $customer_id ? 'selected' : ''}}>{{ $customer->company }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <div class="form-group">
                                            <label>{{ trans('main.From Date') }}</label>
                                            <input class="form-control" type="date" name="from_date" value="{{ $from_date }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <div class="form-group">
                                            <label>{{ trans('main.To Date') }}</label>
                                            <input class="form-control" type="date" name="to_date" value="{{ $to_date }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <div class="form-group">
                                            <button class="btn btn-primary btn-block" type="submit">{{ trans('main.Search') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /Search Filter -->

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
                                            <table id="example1" class="table table-stripped">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">#</th>
                                                        <th class="text-center">{{ trans('main.Customer') }}</th>
                                                        <th class="text-center">{{ trans('main.Grand Total') }}</th>
                                                        <th class="text-center">{{ trans('main.Date') }}</th>
                                                        <th class="text-center">{{ trans('main.Notes') }}</th>
                                                        <th class="text-center">{{ trans('main.Actions') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if($data->count() > 0)
                                                        <?php $i = 0; ?>
                                                        @foreach ($data as $item)
                                                            <?php $i++; ?>
                                                            <tr>
                                                                <td class="text-center">{{ $i }}</td>
                                                                <td class="text-center">{{ $item->customer->user->name }}</td>
                                                                <td class="text-center">{{ $item->grandTotal }}</td>
                                                                <td class="text-center">{{ $item->date }}</td>
                                                                <td class="text-center">{{ $item->notes }}</td>
                                                                <td class="text-center">
                                                                    <button type="button" class="btn btn-sm btn-info mr-1" data-bs-toggle="modal" data-bs-target="#showModal{{$item->id}}"><i class="far fa-eye"></i></button>
                                                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{$item->id}}"><i class="far fa-trash-alt"></i></button>
                                                                </td>
                                                            </tr>
                                                            @include('dashboard.sale.showModal')
                                                            @include('dashboard.sale.deleteModal')
                                                            @endforeach
                                                        @else
                                                            <tr>
                                                                <th class="text-center" colspan="6">
                                                                    <div class="col mb-3 d-flex">
                                                                        <div class="card flex-fill">
                                                                            <div class="card-body p-3 text-center">
                                                                                <p class="card-text f-12">{{ trans('main.No Data Founded') }}</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </th>
                                                            </tr>
                                                        @endif
                                                    </tbody>
                                                </table>
                                                {{ $data->links() }}
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
    <script  src="{{ asset('assets_admin/plugins/select2/js/select2.full.min.js') }}"> </script>
    <script>
    //Initialize Select2 Elements
    $('.select2').select2({
        theme: 'bootstrap4'
    });
    </script>
@endsection
