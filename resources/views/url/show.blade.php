@extends('layouts.app')

@section('content')
    <div class="shortener-form">
        <div class="shortener-form__result">
            <div class="shortener-form__result__title">LONG URL</div>
            <div class="shortener-form__result__body">{{ $url->url }}</div>
        </div>
        <div class="shortener-form__result">
            <div class="shortener-form__result__title">SHORT URL</div>
            <div class="shortener-form__result__body">{{ request()->getHttpHost() }}/{{ $url->shorten }}</div>
            <button class="shortener-form__result__button"
                    data-toggle="tooltip"
                    data-placement="top"
                    title="Copy Link to clipboard"
                    data-clipboard-text="{{ url($url->shorten) }}"
            >
                <i class="ion-clipboard"></i>
            </button>
        </div>
    </div>
@endsection