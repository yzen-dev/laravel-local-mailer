@extends('local-mailer::_template')

@section('content')

    <table class="table mt-4">
        <thead class="table-light">
            <tr>
                <td>Logs</td>
                <td class="text-center">Count</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            @foreach ($files as $file)
                <tr>
                    <td>
                        <a href="{{ route('local-mailer::show-by-date',$file['date']) }}">
                            {{ $file['file'] }}
                        </a>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('local-mailer::show-by-date',$file['date']) }}">
                            {{ $file['count'] }}
                        </a>
                    </td>
                    <td class="text-right">
                        <a class="btn btn-success btn-sm">
                            <svg viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"
                                 class="css-i6dzq1">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                <polyline points="7 10 12 15 17 10"></polyline>
                                <line x1="12" y1="15" x2="12" y2="3"></line>
                            </svg>
                        </a>
                        <a class="btn btn-danger btn-sm">
                            <svg viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                <line x1="10" y1="11" x2="10" y2="17"></line>
                                <line x1="14" y1="11" x2="14" y2="17"></line>
                            </svg>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>


@endsection
