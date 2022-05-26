@extends('local-mailer::_template')

@section('content')
    <a href="{{ route('local-mailer::dashboard') }}" class="back-link">
        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <line x1="19" y1="12" x2="5" y2="12"></line>
            <polyline points="12 19 5 12 12 5"></polyline>
        </svg>
        Back
    </a>
    <div class="">
        <div class="mailbox">
            <div class="mailbox-head">
                <h2 class="mailbox-head_title">Log {{$date}}</h2>
            </div>
            <div class="box-center">
                <h2>File not found</h2>
            </div>
        </div>
    </div>
@endsection
