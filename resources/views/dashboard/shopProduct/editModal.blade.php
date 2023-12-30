<!-- Start Modal -->
<div class="modal fade custom-modal" id="editModal{{ $item->id }}">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">{{ trans('main.Edit') }} {{ trans('main.ShopProduct') }}</h4>
                <button type="button" class="close" data-bs-dismiss="modal"><span>&times;</span></button>
            </div>

            <div class="modal-body">
                <form action="{{ route('shopProduct.update', 'test') }}" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
                    {{ method_field('patch') }}
                    @csrf
                    <!-- product_id -->
                    <div class="form-group">
                        <label for="product_id" class="mr-sm-2">{{ trans('main.Product') }} :</label>
                        <select class="form-control select2" name="product_id">
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" {{ $item->product_id == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- shop_id -->
                    <div class="form-group">
                        <label for="shop_id" class="mr-sm-2">{{ trans('main.Shop') }} :</label>
                        <select class="form-control select2" name="shop_id">
                            @foreach($shops as $shop)
                                <option value="{{ $shop->id }}" {{ $item->shop_id == $shop->id ? 'selected' : '' }}>{{ $shop->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- quantity -->
                    <div class="form-group">
                        <label>{{ trans('main.Quantity') }}</label>
                        <input class="form-control" type="text" name="quantity" placeholder="{{ trans('main.Quantity') }}"  value="{{ $item->quantity }}" required>
                        <div class="valid-feedback">{{ trans('main.Looks Good') }}</div>
                        <div class="invalid-feedback">{{ trans('main.Error Here')}}</div>
                    </div>

                    <!-- id -->
                    <div class="form-group">
                        <input class="form-control" type="hidden" name="id" value="{{ $item->id }}">
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
