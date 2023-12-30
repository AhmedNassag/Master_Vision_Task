<?php $page="categories";?>

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
        {{ trans('main.Categories') }}
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
                                <h3 class="page-title">{{ trans('main.Categories') }}</h3>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ trans('main.Dashboard') }}</a></li>
                                    <li class="breadcrumb-item active">{{ trans('main.Categories') }}</li>
                                </ul>
                            </div>
                            <div class="col-auto">
                                <button type="button" class="btn add-button me-2" data-bs-toggle="modal" data-bs-target="#addModal">
                                    <i class="fas fa-plus"></i>
                                </button>
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
                    <div class="card filter-card" id="filter_inputs" @if($name || $parent_id || $from_date || $to_date) style="display:block" @endif>
                        <div class="card-body pb-0">
                            <form action="{{ route('category.index') }}" method="get">
                                <div class="row filter-row">
                                    <!-- name -->
                                    <div class="col-sm-6 col-md-3">
                                        <div class="form-group">
                                            <label>{{ trans('main.Name') }}</label>
                                            <input class="form-control" type="text" name="name" value="{{ $name }}">
                                        </div>
                                    </div>
                                    <!-- parent_id -->
                                    <div class="col-sm-6 col-md-3">
                                        <div class="form-group">
                                            <label>{{ trans('main.Parent Category') }} :</label>
                                            <select class="form-control select2" name="parent_id">
                                                <option value="">{{ trans('main.All') }}</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}" {{ $parent_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
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
                                                        <th class="text-center">
                                                            @if($data->count() > 0)
                                                            <input class="box1 mr-1" name="select_all" id="example-select-all" type="checkbox" onclick="CheckAll('box1', this)"  oninput="showBtnDeleteSelected()">
                                                            @endif
                                                            #
                                                        </th>
                                                        <th class="text-center">{{ trans('main.Name') }}</th>
                                                        <th class="text-center">{{ trans('main.Parent Category') }}</th>	
                                                        <th class="text-center">{{ trans('main.Actions') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if($data->count() > 0)
                                                    <?php $i = 0; ?>
                                                    @foreach ($data as $item)
                                                    <?php $i++; ?>
                                                    <tr>
                                                        <td class="text-center notPrint">
                                                            <input id="delete_selected_input" type="checkbox" value="{{ $item->id }}" class="box1 mr-1" oninput="showBtnDeleteSelected()">
                                                            {{ $i }}
                                                        </td>
                                                        <td class="text-center">{{ $item->name }}</td>
                                                        <td class="text-center">{{ $item->category ? $item->category->name : '' }}</td>
                                                        <td class="text-center">
                                                            <button type="button" class="btn btn-sm btn-secondary mr-1" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id }}" title="{{ trans('main.Edit') }}"><i class="far fa-edit"></i></button>
                                                            <button type="button" class="btn btn-sm btn-danger mr-1" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $item->id }}" title="{{ trans('main.Delete') }}"><i class="far fa-trash-alt"></i></button>
                                                            <a href="{{ route('category.show', $item->id) }}" role="button" class="btn btn-sm btn-info" title="{{ trans('main.Show') }}"><i class="far fa-eye"></i></a>
                                                        </td>
                                                    </tr>
                                                    @include('dashboard.category.editModal')
                                                    @include('dashboard.category.deleteModal')
                                                    @endforeach
                                                    @else
                                                    <tr>
                                                        <th class="text-center" colspan="4">
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
                        @include('dashboard.category.addModal')
                        @include('dashboard.category.deleteSelectedModal')		
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
