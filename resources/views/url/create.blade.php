@extends('layouts.app')

@section('content')
    <form action="/" method="post" class="form-inline">
        {{ csrf_field() }}
        <div class="shortener-form">
            @if($errors->has('url'))
                <div class="shortener-form__info">
                    <i class="shortener-form__info__icon ion-alert"></i>{{ $errors->first('url') }}
                </div>
            @endif
            <input type="text" name="url" id="url" class="shortener-form__url" value="{{ old('url') }}" placeholder="Paste your long url here">
            <button type="submit" id="shorten-url" class="shortener-form__shorten-button"><i class="shortener-form__shorten-button__icon ion-ios-arrow-right"></i></button>

            <div class="shortener-form__info shortener-form__info--small">
                <div>
                    <strong>Pro Tip:</strong> You can add /info at the end of the short url to see what's behind it
                </div>
            </div>
        </div>
    </form>
@endsection