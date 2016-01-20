@extends('master')

@section('html-tag')
    <html id="mainpage">
@endsection

@section('content')
    <div id="wrapper">
        <div id="logo">
            <img src="img/logo.png" class="responsive-img" alt="MyGrades">
        </div>

        <a id="playstore" href="https://play.google.com/store/apps/details?id=de.mygrades"><img class="responsive-img" alt="Get it on Google Play" src="https://play.google.com/intl/en_us/badges/images/generic/de-play-badge.png" /></a>

        <div id="teaser">
            <p>Deine Studiumsnoten aktuell und übersichtlich <br> direkt aus deinem Notensystem.</p>
        </div>

        <div id="device"></div>

        <div id="footer">
            <a href="{{ route('datenschutz') }}">Datenschutz</a>
            <a href="{{ route('impressum') }}">Impressum</a>
            <a href="https://www.facebook.com/mygradesapp/">Facebook</a>
            <a href="https://github.com/MyGrades/mygrades-app">Quellcode</a>
        </div>
    </div>
@endsection