<!-- Start Modal -->
<div class="modal fade custom-modal" id="editModal{{ $item->id }}">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">{{ trans('main.Edit') }} {{ trans('main.Product') }}</h4>
                <button type="button" class="close" data-bs-dismiss="modal"><span>&times;</span></button>
            </div>

            <div class="modal-body">
                <form action="{{ route('product.update', 'test') }}" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
                    {{ method_field('patch') }}
                    @csrf
                    <!-- name -->
                    <div class="form-group">
                        <label>{{ trans('main.Name') }}</label>
                        <input class="form-control" type="text" name="name" placeholder="{{ trans('main.Name') }}"  value="{{ $item->name }}" required>
                        <div class="valid-feedback">{{ trans('main.Looks Good') }}</div>
                        <div class="invalid-feedback">{{ trans('main.Error Here')}}</div>
                    </div>

                    <!-- price -->
                    <div class="form-group">
                        <label>{{ trans('main.Price') }}</label>
                        <input type="text" class="form-control" name="price" value="{{ $item->price }}" placeholder="{{ trans('main.Price') }}" required>
                        <div class="valid-feedback">{{ trans('main.Looks Good') }}</div>
                        <div class="invalid-feedback">{{ trans('main.Error Here')}}</div>
                    </div>
                    
                    <!-- category_id -->
                    <div class="form-group">
                        <label for="category_id" class="mr-sm-2">{{ trans('main.Category') }} :</label>
                        <select class="form-control select2" name="category_id">
                            <option value="">{{ trans('main.Without') }}</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $item->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- file -->
                    <div class="form-group">
                    <label>{{ trans('main.Photo') }} :</label>
                    <input class="form-control" type="file" name="file" accept="image/*" data-height="70"/>
                    @if($item->media)
                    <div class="row">
                        <div class="col-12">
                            <img class="img-thumbnail m-1" src="{{ $item->media->file_path }}" alt="{{ $item->media->file_name }}" height="100" width="100">
                        </div>
                    </div>
                    @endif

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
