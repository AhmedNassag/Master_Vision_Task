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
    {{ trans('main.Add') }} {{ trans('main.ShopProduct') }}
    @stop
@endsection



@section('content')
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
            

            <!-- Page Wrapper -->
            <div class="page-wrapper">
                <div class="content container-fluid">
                    <!-- Page Header -->
                    <div class="page-header">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="page-title">{{ trans('main.Add') }} {{ trans('main.ShopProduct') }}</h3>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ trans('main.Dashboard') }}</a></li>
                                    <li class="breadcrumb-item active">{{ trans('main.Add') }} {{ trans('main.ShopProduct') }}</li>
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
                        <div class="col-lg-12">
                                <div class="card bg-white">
                                    <div class="card-body pt-0">
                                        <form  action="{{ route('shopProduct.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                                            @csrf

                                            <div class="row">
                                                <!-- shop_id -->
                                                <div class="col-6">
                                                    <label for="shop_id" class="mr-sm-2">{{ trans('main.Shop') }} :</label>
                                                    <select class="form-control select2" name="shop_id">
                                                        <?php $shops = \App\Models\Shop::get(['id', 'name']); ?>
                                                        @foreach($shops as $shop)
                                                            <option value="{{$shop->id}}">{{$shop->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <!--shopProduct_details-->
                                                <div class="col-12 mt-5 mb-3" style="border: 1px solid grey; padding:10px;">
                                                    <div id="purchase_details" name="purchase_details">
                                                        <div class="row mt-3">
                                                            <div class="col-5">
                                                                <h4>{{ trans('main.Details') }}</h4>
                                                            </div>
                                                            <div class="col-5"></div>
                                                            <div class="col-2">
                                                                <button id="storeBtn" type="button" class="btn btn-primary ripple">{{ trans('main.Add New Item') }}</button>
                                                            </div>
                                                        </div>
                                                        <table id="myTable" class="col-12 mt-3">
                                                            <tr>
                                                                <td style="width:25%;">
                                                                    <label for="quantity" class="mr-sm-2">{{ trans('main.Quantity') }}</label>
                                                                    <input id="quantity" type="number" class="form-control quantity" name="quantity" value="1" required oninput="checkQuantity()">
                                                                </td>
                                                                <td style="width:5%;"></td>
                                                                <td style="width:30%;">
                                                                    <label for="product_id" class="mr-sm-2">{{ trans('main.Product') }}</label>
                                                                    <select class="form-control select2 product_id" name="product_id" required>
                                                                        <?php $products = \App\Models\Product::get(['id', 'name']); ?>
                                                                        @foreach($products as $product)
                                                                            <option value="{{$product->id}}">{{ $product->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>

                                                <!--details-->
                                                <div class="col-12 mb-3" style="border: 1px solid grey; padding:10px;">
                                                    <div id="details" name="details">
                                                        <div class="row mt-3">
                                                            <div class="col-12">
                                                                <h4 class="text-center" style="text-decoration:underline">{{ trans('main.Products') }}</h4>
                                                            </div>
                                                        </div>
                                                        <table id="detailsTable" class="col-12 mt-3">
                                                            <thead>
                                                                <tr>
                                                                    <th class="text-center">
                                                                        {{ trans('main.Quantity') }}
                                                                    </th>
                                                                    <th class="text-center">
                                                                        {{ trans('main.Product') }}
                                                                    </th>
                                                                    <th class="text-center">
                                                                        {{ trans('main.Actions') }}
                                                                    </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="detailsBody">

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-4">
                                                <button type="submit" class="btn btn-primary btn-block">{{ trans('main.Confirm') }}</button>
                                            </div>
                                        </form>
								    </div>
                                </div>
                            </div>
                            @include('dashboard.shopProduct.deleteItemModal')	
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
    <script type="text/javascript">
        function addRow()
        {
            $('table[id="myTable"]').append('<tr><td style="width:20%;"><label for="quantity" class="mr-sm-2">{{ trans('main.Quantity') }}</label><input id="quantity" type="number" class="form-control" name="quantity[]" value="" required oninput="checkQuantity()"></td><td style="width:2%;"></td><td style="width:38%;"><label for="product_id" class="mr-sm-2">{{ trans('main.Product') }}</label><select class="form-control select2" name="product_id[]" required><option value="" selected>{{ trans('main.Choose') }}</option>@foreach($products as $product)<option value="{{@$product->id}}">{{@$product->name}}</option>@endforeach</select></td></tr>');
        }
    </script>


    <script type="text/javascript">
        function removeRow()
        {
            var myDiv = document.getElementById("myTable").deleteRow(0);
        }
    </script>


    <script type="text/javascript">
        function checkQuantity()
        {
            var quantity = parseFloat(document.getElementById('quantity').value);
            if(quantity < 0)
            {
                alert('يجب أن تكون الكميةأكبر من 0');
                document.getElementById('quantity').value = null;
            }
            if(quantity == 0)
            {
                alert('يجب أن تكون الكميةأكبر من 0');
                document.getElementById('quantity').value = null;
            }
        }
    </script>


    <script>
        $(document).ready(function () {
            //fetch
            fetchDetails();
            function fetchDetails()
            {
                $.ajax({
                    type: "get",
                    url: "{{ route('shopProducts.fetch') }}",
                    dataType: "json",
                    success:function(response) {
                        $('tbody[id="detailsBody"]').html("");
                        $.each(response.sale_details, function(key, item)
                        {
                            $('tbody[id="detailsBody"]').append('<tr>\
                                <td class="text-center">'+item.quantity+'</td>\
                                <td class="text-center">'+item.product+'</td>\
                                <td class="text-center"><button type="button" value="'+item.id+'" class="delete_item btn btn-danger btn-sm">{{ trans('main.Delete') }}</button></td>\
                            </tr>');
                        });                        
                    },
                    error:function(reject){},
                });
            }


            //store
            $(document).on('click','#storeBtn',function(e){
                e.preventDefault();
                $(this).text('إضافة عنصر جديد');
                var storeData = {
                    'quantity'   : $('.quantity').val(),
                    'product_id' : $('.product_id').val(),
                    'unit_price' : $('.unit_price').val(),
                }
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "post",
                    url: "{{ route('shopProducts.store') }}",
                    data: storeData,
                    dataType: "json",
                    success:function(response) {
                        if(response.status == true) {
                            fetchDetails();
                            notif({
                                msg: "تمت العملية بنجاح",
                                type: "success"
                            })
                        }
                    },
                    error:function(reject){},
                });
            });

            //delete
            $(document).on('click','.delete_item',function(e){
                e.preventDefault();
                var item_id = $(this).val();
                $('#item_id').val(item_id);
                $('#delete_error_list').html("");
                $('#deleteItemModal').modal('show');
            });
            $(document).on('click','.delete_item_btn',function(e){
                e.preventDefault();
                $(this).text('جارى الحذف');
                var item_id = $('#item_id').val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "delete",
                    url: "/admin/shopProducts/destroy/"+item_id,
                    success:function(response) {
                        if(response.status == true) {
                            $('#deleteItemModal').modal('hide');
                            $('.delete_item_btn').text('حذف');
                            fetchDetails();
                            notif({
                                msg: "تمت العملية بنجاح",
                                type: "success"
                            })
                        }
                    },
                    error:function(reject){},
                });
            });
        });
    </script>
@endsection
