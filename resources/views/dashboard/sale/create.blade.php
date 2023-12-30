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
    {{ trans('main.Add') }} {{ trans('main.Sale') }}
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
                                <h3 class="page-title">{{ trans('main.Add') }} {{ trans('main.Sale') }}</h3>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ trans('main.Dashboard') }}</a></li>
                                    <li class="breadcrumb-item active">{{ trans('main.Add') }} {{ trans('main.Sale') }}</li>
                                </ul>
                            </div>
                            <div class="col-auto">
                                <a href="{{ route('sale.index') }}" type="button" class="btn btn-primary me-2" id="filter_search">
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
                                    <form  action="{{ route('sale.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                                        @csrf
                                        <div class="row">
                                            <!-- date -->
                                            <div class="col-6">
                                                <label for="date" class="mr-sm-2">{{ trans('main.Date') }}</label>
                                                <input type="date" class="form-control" name="date" value="{{ date('Y-m-d') }}" required>
                                            </div>
                                            <!-- customer_id -->
                                            <div class="col-6">
                                                <label for="customer_id" class="mr-sm-2">{{ trans('main.Customer') }} :</label>
                                                <select class="form-control select2" name="customer_id" required>
                                                    @foreach($customers as $customer)
                                                        <option value="{{$customer->id}}">{{$customer->user->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <!--sale_details-->
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
                                                            <td style="width:28%;">
                                                                <label for="shop_id" class="mr-sm-2">{{ trans('main.Shop') }}</label>
                                                                <select class="form-control select2 shop_id" name="shop_id" required onchange="shopChange()">
                                                                    <option value="">{{ trans('main.Choose') }}</option>
                                                                    @foreach($shops as $shop)
                                                                        <option value="{{@$shop->id}}">{{@$shop->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td style="width:2%;"></td>
                                                            <td style="width:28%;">
                                                                <label for="product_id" class="mr-sm-2">{{ trans('main.Product') }}</label>
                                                                <select class="form-control select2 product_id" name="product_id" required onchange="productChange()">
                                                                    
                                                                </select>
                                                            </td>
                                                            <td style="width:2%;"></td>
                                                            <td style="width:12%;">
                                                                <label for="quantity" class="mr-sm-2">{{ trans('main.Quantity') }}</label>
                                                                <input id="quantity" type="number" class="form-control quantity" name="quantity" value="1" required oninput="checkQuantity()">
                                                            </td>
                                                            <td style="width:2%;"></td>
                                                            <td style="width:12%;">
                                                                    <label for="unit_price" class="mr-sm-2">{{ trans('main.Unit Price') }}</label>
                                                                    <input id="unit_price" type="text" class="form-control text-center unit_price" name="unit_price" value="{{@$products[0]->price}}" readOnly>
                                                            </td>
                                                            <td style="width:2%;"></td>
                                                            <td style="width:12%;">
                                                                <label for="sub_total" class="mr-sm-2">{{ trans('main.Sub Total') }}</label>
                                                                <input id="sub_total" type="text" class="form-control text-center sub_total" name="sub_total" value="{{@$products[0]->price}}" readOnly>
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
                                                            <h4 class="text-center" style="text-decoration:underline">{{ trans('main.Items') }} {{ trans('main.Sale') }}</h4>
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
                                                                    {{ trans('main.Unit Price') }}
                                                                </th>
                                                                <th class="text-center">
                                                                    {{ trans('main.Sub Total') }}
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

                                            <!-- tax -->
                                            <div class="col-4" style="display: none">
                                                <label for="tax" class="mr-sm-2">{{ trans('main.Tax') }}</label>
                                                <input id="tax" type="text" class="form-control" name="tax" value="0" readOnly>
                                            </div>
                                            <!-- discount -->
                                            <div class="col-4" style="display: none">
                                                <label for="discount" class="mr-sm-2">{{ trans('main.Discount') }}</label>
                                                <input id="discount" type="text" class="form-control" name="discount" value="0" readOnly>
                                            </div>
                                            <div class="col-8"></div>
                                            <!-- grand_total -->
                                            <div class="col-4">
                                                <label for="grand_total" class="mr-sm-2">{{ trans('main.Grand Total') }} :</label>
                                                <input id="grand_total" type="text" class="form-control" name="grand_total" value="{{@$products[0]->price}}" readOnly>
                                            </div>
                                            <!-- notes -->
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label>{{ trans('main.Notes') }}</label>
                                                    <textarea type="text" class="form-control" name="notes" value="{{ old('notes') }}" placeholder="{{ trans('main.Notes') }}"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-4">
                                            <button type="submit" class="btn btn-primary btn-block">{{ trans('main.Confirm') }}</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                            @include('dashboard.sale.deleteItemModal')	
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
            $('table[id="myTable"]').append('<tr><td style="width:20%;"><label for="quantity" class="mr-sm-2">{{ trans('main.Quantity') }}</label><input id="quantity" type="number" class="form-control" name="quantity[]" value="" required oninput="checkQuantity()"></td><td style="width:2%;"></td><td style="width:38%;"><label for="product_id" class="mr-sm-2">{{ trans('main.Product') }}</label><select class="form-control select2" name="product_id[]" required onchange="productChange()"><option value="" selected>{{ trans('main.Choose') }}</option>@foreach($products as $product)<option value="{{@$product->id}}">{{@$product->name}}</option>@endforeach</select></td><td style="width:2%;"></td><td style="width:18%;"><label for="unit_price" class="mr-sm-2">{{ trans('main.Unit Price') }}</label><input id="unit_price" type="text" class="form-control text-center" name="unit_price[]" value="{{@$product->price}}" disabled></td><td style="width:2%;"></td><td style="width:18%;"><label for="sub_total" class="mr-sm-2">{{ trans('main.Sub Total') }}</label><input id="sub_total" type="text" class="form-control text-center" name="sub_total[]" value="" disabled></td></tr>');
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
            var quantity    = parseFloat(document.getElementById('quantity').value);
            var unit_price  = parseFloat(document.getElementById('unit_price').value);
            var sub_total   = parseFloat(document.getElementById('sub_total').value);
            var discount    = parseFloat(document.getElementById('discount').value);
            var tax         = parseFloat(document.getElementById('tax').value);
            // var grand_total = parseFloat(document.getElementById('grand_total').value);
            if(quantity < 0)
            {
                alert('يجب أن تكون الكميةأكبر من 0');
                document.getElementById('quantity').value = null;
            }
            else if(quantity == 0)
            {
                alert('يجب أن تكون الكميةأكبر من 0');
                document.getElementById('quantity').value = null;
            }
            else 
            {
                sub_total   = unit_price * quantity;
                grand_total = (unit_price * quantity) + tax - discount;
                document.getElementById('sub_total').value   = sub_total;
                // document.getElementById('grand_total').value = grand_total;
            }
        }
    </script>



<script type="text/javascript">
    function shopChange() {
        $(document).ready(function(){
            $('select[name="shop_id"]').on('change',function(){
                var shop_id = $(this).val();
                if (shop_id) {
                    $.ajax({
                        url:"{{URL::to('admin/shopProductsQuantity')}}/" + shop_id,
                        type:"GET",
                        dataType:"json",
                        success:function(data){
                            $('select[name="product_id"]').empty();
                            $.each(data,function(key,value) {
                                $('select[name="product_id"]').append('<option class="form-control" value="'+ value["id"] +'">' + value["name"] + '</option>');
                            });
                        }
                    });
                } else {
                    $('select[name="product_id"]').empty();
                    console.log('not work')
                }
            });
        });
    }
</script>



    <script type="text/javascript">
        function productChange() {
            $(document).ready(function(){
                $('select[name="product_id"]').on('change',function(){
                    var product_id =$(this).val();
                    if (product_id) {
                        $.ajax({
                            url:"{{URL::to('admin/productDetails')}}/" + product_id,
                            type:"GET",
                            dataType:"json",
                            success:function(data){
                                $('input[name="productPrice"]').empty();
                                $.each(data,function(key,value) {
                                    price = parseFloat(value["price"]).toFixed(2);
                                    document.getElementById("unit_price").value = price;
                                    // var unit_price = parseFloat(document.getElementById("unit_price").val);
                                    // $('<input class="form-control" type="text" name="productPrice" value="'+ value["price"] +'" readonly>');
                                    
                                    var quantity    = parseFloat(document.getElementById('quantity').value);
                                    var sub_total   = parseFloat(document.getElementById('sub_total').value);
                                    var discount    = parseFloat(document.getElementById('discount').value);
                                    var tax         = parseFloat(document.getElementById('tax').value);
                                    // var grand_total = parseFloat(document.getElementById('grand_total').value);

                                    sub_total   = price * quantity;
                                    grand_total = (price * quantity) + tax - discount;
                                    document.getElementById('sub_total').value   = sub_total;
                                    // document.getElementById('grand_total').value = grand_total;
                                });
                            }
                        });
                    } else {
                        console.log('not work')
                    }
                });
            });
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
                    url: "{{ route('details.fetch') }}",
                    dataType: "json",
                    success:function(response) {
                        $('tbody[id="detailsBody"]').html("");
                        $.each(response.sale_details, function(key, item)
                        {
                            $('tbody[id="detailsBody"]').append('<tr>\
                                <td class="text-center">'+item.quantity+'</td>\
                                <td class="text-center">'+item.product+'</td>\
                                <td class="text-center">'+item.unit_price+'</td>\
                                <td class="text-center">'+item.sub_total+'</td>\
                                <td class="text-center"><button type="button" value="'+item.id+'" class="delete_item btn btn-danger btn-sm">{{ trans('main.Delete') }}</button></td>\
                            </tr>');
                        });
                        
                        document.getElementById('grand_total').value = response.grand_total;
                        
                    },
                    error:function(reject){},
                });
            }

            function fetchLastDetails()
            {
                $.ajax({
                    type: "get",
                    url: "{{ route('details.fetchLast') }}",
                    dataType: "json",
                    success:function(response) {
                        // $.each(response.sale_details, function(key, item)
                        // {
                            $('table[id="detailsTable"]').append('<tbody>\
                                <tr>\
                                    <td class="text-center">'+response.sale_details.quantity+'</td>\
                                    <td class="text-center">'+response.sale_details.product+'</td>\
                                    <td class="text-center">'+response.sale_details.unit_price+'</td>\
                                    <td class="text-center">'+response.sale_details.sub_total+'</td>\
                                    <td class="text-center"><button type="button" value="'+response.sale_details.id+'" class="delete_item btn btn-danger btn-sm">{{ trans('main.Delete') }}</button></td>\
                                </tr>\
                            </tbody>');
                        // });
                        
                        document.getElementById('grand_total').value = response.grand_total;
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
                    'shop_id'    : $('.shop_id').val(),
                    'unit_price' : $('.unit_price').val(),
                }
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "post",
                    url: "{{ route('details.store') }}",
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
                        else {
                            notif({
                                msg: "لقد حدث خطأ ما ربما الكمية المدخلة أكبر من المتاحة حالياً",
                                type: "error"
                            })
                        }
                    },
                    error:function(reject) {},
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
                    url: "/admin/details/destroy/"+item_id,
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
