<?php $page="index_admin_admin_admin";?>
@extends('layouts.master')
@section('content')

<!-- Page Wrapper -->
<div class="page-wrapper">
	<div class="content container-fluid">
	
		<!-- Page Header -->
		<div class="page-header">
			<div class="row align-items-center">
				<div class="col">
					<h3 class="page-title">{{ trans('main.Dashboard') }}</h3>
					<ul class="breadcrumb">
						<li class="breadcrumb-item"><a href="{{ route('home') }}">{{ trans('main.Home') }}</a></li>
						<li class="breadcrumb-item active">{{ trans('main.Dashboard') }}</li>
					</ul>
				</div>
			</div>
		</div>
		<!-- /Page Header -->
			<div class="row">
			<div class="col-md-8">
				<!--/Wizard-->
				<div class="row">
					<div class="col-md-4 d-flex">
						<div class="card wizard-card flex-fill">
							<div class="card-body">
								<p class="text-primary mt-0 mb-2">{{ trans('main.Customers') }}</p>
								<h5>{{ App\Models\Customer::count(); }}</h5>
								<p><a href="{{ route('user.index') }}">{{ trans('main.View Details') }}</a></p>
								<span class="dash-widget-icon bg-1">
									<i class="fas fa-users"></i>
								</span>
							</div>
						</div>
					</div>
					<div class="col-md-4 d-flex">
						<div class="card wizard-card flex-fill">
							<div class="card-body">
								<p class="text-primary mt-0 mb-2">{{ trans('main.Products') }}</p>
								<h5>{{ App\Models\Product::count(); }}</h5>
								<p><a href="{{ route('product.index') }}">{{ trans('main.View Details') }}</a></p>
								
								<span class="dash-widget-icon bg-1">
									<i class="fas fa-th-large"></i>
								</span>
							</div>
						</div>
					</div>
					<div class="col-md-4 d-flex">
						<div class="card wizard-card flex-fill">
							<div class="card-body">
								<p class="text-primary mt-0 mb-2">{{ trans('main.Sales') }}</p>
								<h5>{{ App\Models\Sale::count(); }}</h5>
								<p><a href="{{ route('sale.index') }}">{{ trans('main.View Details') }}</a></p>
								
								<span class="dash-widget-icon bg-1">
									<i class="fas fa-bezier-curve"></i>
								</span>
							</div>
						</div>
					</div>
				</div>
			</div>	
			<div class="col-md-4 d-flex">
				<div class="card w-100">
					<div class="card-body pt-0">
						<div class="card-header">
							<div class="row">
								<div class="col-7">
									<p>{{ trans('main.Welcome Back') }}</p>
									<h6 class="text-primary">{{ auth()->user()->name }}</h6>
								</div>
								<div class="col-5 text-end">
									<span class="welcome-dash-icon bg-1">
										<i class="fas fa-user"></i>
									</span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>			
		</div>
		
		<!--/Wizard-->
		<div class="row">
			<div class="col-lg-12 d-flex">
				<div class="card w-100">
					<div class="card-body pt-0 pb-2">
						<div class="card-header">
							<h5 class="card-title">Over view</h5>
						</div>
						<div id="chart" class="mt-4"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
<!-- /Page Wrapper -->

</div>
<!-- /Main Wrapper -->
</div>
@endsection