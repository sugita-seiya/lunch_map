@extends('layout')

@section('content')
    <h1>{{ $shop->name }}</h1>
    <div>
        <p>{{ $shop->category->name }}</p>
        <p>{{ $shop->address }}</p>
    </div>
    <div>
        <a href={{ route('shop.list') }}>一覧に戻る</a>
        @auth
          @if ($shop->user_id === $login_user_id)
            | <a href={{ route('shop.edit', ['id' =>  $shop->id]) }}>編集</a>
            <p></p>
            {{ Form::open(['method' => 'delete', 'route' => ['shop.destroy', $shop->id]]) }}
                {{ Form::submit('削除') }}
            {{ Form::close() }}
          @endif
        @endauth
    </div>
@endsection