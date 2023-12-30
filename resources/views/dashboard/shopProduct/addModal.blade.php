<!-- Start Modal -->
<div class="modal fade custom-modal" id="addModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">{{ trans('main.Add') }} {{ trans('main.Product') }}</h4>
                <button type="button" class="close" data-bs-dismiss="modal"><span>&times;</span></button>
            </div>

            <div class="modal-body">
                <form action="{{ route('shopProduct.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                    @csrf
                    <!-- product_id -->
                    <div class="form-group">
                        <label for="product_id" class="mr-sm-2">{{ trans('main.Product') }} :</label>
                        <select class="form-control select2" name="product_id">
                            <option value="">{{ trans('main.Choose') }}</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- shop_id -->
                    <div class="form-group">
                        <label for="shop_id" class="mr-sm-2">{{ trans('main.Shop') }} :</label>
                        <select class="form-control select2" name="shop_id">
                            <option value="">{{ trans('main.Choose') }}</option>
                            @foreach($shops as $shop)
                                <option value="{{ $shop->id }}">{{ $shop->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- quantity -->
                    <div class="form-group">
                        <label>{{ trans('main.Quantity') }}</label>
                        <input type="integer" class="form-control" name="quantity" value="{{ old('quantity') }}" placeholder="{{ trans('main.Quantity') }}" required>
                        <div class="valid-feedback">{{ trans('main.Looks Good') }}</div>
                        <div class="invalid-feedback">{{ trans('main.Error Here')}}</div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary btn-block">{{ trans('main.Confirm') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Modal -->