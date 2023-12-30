<!-- Start Modal -->
<div class="modal fade custom-modal" id="showModal{{ $item->id }}">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">{{ trans('main.Show') }} {{ trans('main.Sale') }}</h4>
                <button type="button" class="close" data-bs-dismiss="modal"><span>&times;</span></button>
            </div>

            <div class="modal-body">
                <div class="row">
					<div class="col-12">
						<div class="card">
                            <div class="card-body">
                                <!-- <div class="table-responsive"> -->
                                    <div class="row" style="max-width:100%; border: 1px solid gray;">
                                        <div class="col-1 text-center" style="border: 1px solid gray; padding:10px">#</div>
                                        <div class="col-2 text-center" style="border: 1px solid gray; padding:10px">{{ trans('main.Quantity') }}</div>
                                        <div class="col-3 text-center" style="border: 1px solid gray; padding:10px">{{ trans('main.Product') }}</div>
                                        <div class="col-3 text-center" style="border: 1px solid gray; padding:10px">{{ trans('main.Unit Price') }}</div>
                                        <div class="col-3 text-center" style="border: 1px solid gray; padding:10px">{{ trans('main.Sub Total') }}</div>
                                    </div>
                                    <div class="row" style="max-width:100%;">
                                        @if($item->sale_details->count() > 0)
                                            <?php $i = 0; ?>
                                            @foreach ($item->sale_details as $detail)
                                                <?php $i++; ?>
                                                <div class="col-1 text-center" style="padding:10px;">{{ $i }}</div>
                                                <div class="col-2 text-center" style="padding:10px">{{ $detail->quantity }}</div>
                                                <div class="col-3 text-center" style="padding:10px">{{ $detail->product->name }}</div>
                                                <div class="col-3 text-center" style="padding:10px">{{ $detail->unit_price }}</div>
                                                <div class="col-3 text-center" style="padding:10px">{{ $detail->quantity * $detail->unit_price }}</div>
                                            @endforeach
                                        @else
                                            <div class="card flex-fill">
                                                <div class="card-body text-center">
                                                    <p class="card-text f-12">{{ trans('main.No Data Founded') }}</p>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="row" style="max-width:100%; border: 1px solid gray;">
                                        <div class="col-1 text-center" style="padding:10px">#</div>
                                        <div class="col-2 text-center" style="padding:10px">{{ trans('main.Total') }}</div>
                                        <div class="col-3 text-center" style="padding:10px"></div>
                                        <div class="col-3 text-center" style="padding:10px"></div>
                                        <div class="col-3 text-center" style="padding:10px">{{ $item->grandTotal }}</div>
                                    </div>
                                <!-- </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Modal -->
