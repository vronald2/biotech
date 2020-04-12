@extends('layouts.app')

@section('content')
    <div class="container">

        <product-form-component :product="{{ $product->toJson() }}"></product-form-component>

    </div>
@endsection
