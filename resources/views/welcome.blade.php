@extends('master')

@section('html-tag')
    <html id="mainpage">
@endsection

@section('content')
    <div id="wrapper">
        <div id="logo">
            <img src="img/logo.png" class="responsive-img" alt="MyGrades">
        </div>

        <div id="teaser">
            <p>Deine Noten und Studienfortschritt <br>aktuell und übersichtlich.</p>
        </div>

        <a id="playstore" href="#"><img class="responsive-img" alt="Get it on Google Play" src="https://play.google.com/intl/en_us/badges/images/generic/de-play-badge.png" /></a>

        <div id="device"></div>

        <div id="footer">
            <a href="{{ route('datenschutz') }}">Datenschutz</a>
            <a href="{{ route('impressum') }}">Impressum</a>
        </div>
    </div>
@endsection