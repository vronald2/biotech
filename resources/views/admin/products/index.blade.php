@extends('layouts.app')

@section('content')
    <div class="container">
        <a class="btn btn-primary float-right" href="{{ action('ProductController@create') }}" role="button">Új termék</a>
        <div>{{ $products->links() }}</div>
        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Termék név</th>
                <th scope="col">Kép</th>
                <th scope="col">Forgalmazás kezdete</th>
                <th scope="col">Forgalmazás vége</th>
                <th scope="col">Létrehozva</th>
                <th scope="col">Utóljára módosítva</th>
                <th scope="col">Címkék</th>
                <th scope="col">Műveletek</th>
            </tr>
            </thead>
            <tbody>
            @foreach($products as $product)
                <tr>
                    <th scope="row">{{ $product->id }}</th>
                    <td>{{ $product->name }}</td>
                    <td><img style="width: 150px" src="{{ url($product->image) }}" alt="Image"/>
                    </td>
                    <td>{{ $product->publish_start }}</td>
                    <td>{{ $product->publish_end }}</td>
                    <td>{{ $product->created_at }}</td>
                    <td>{{ $product->updated_at }}</td>
                    <td>
                        @foreach($product->tags as $tag)
                            <b-badge>{{ $tag->slug }}</b-badge>
                        @endforeach
                    </td>
                    <td>
                        <a class="btn btn-primary btn-sm" href="{{ URL::route('product.edit', $product->id) }}"
                           role="button">Szerkesztés</a>
                        <form class="custom-control-inline" action="{{ URL::route('product.destroy', $product->id) }}" method="POST">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <b-button type="submit" size="sm" variant="danger">Törlés</b-button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div>{{ $products->links() }}</div>
    </>
@endsection
