@extends('local-mailer::_template')

@section('content')
    <a href="{{ route('local-mailer::dashboard') }}" class="back-link">
        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none"
             stroke-linecap="round" stroke-linejoin="round">
            <line x1="19" y1="12" x2="5" y2="12"></line>
            <polyline points="12 19 5 12 12 5"></polyline>
        </svg>
        Back
    </a>
    <div class="container__full-heigth">
        <div class="mailbox">
            <div class="mailbox-head">
                <h2 class="mailbox-head_title">Mail for {{$date}}</h2>
            </div>
            @if (count($mails) > 0)
                <div class="mailbox-body">
                    <div class="mail-list">
                        @foreach ($mails as $mail)
                            <div class="mail-preview" data-mail-frame="{{$mail->body}}"
                                 data-mail-recipient="{{json_encode($mail->to)}}">
                                <div class="mail-preview_subject">
                                    {{$mail->subject}}
                                </div>
                                <div class="mail-preview_date">
                                    {{date_format(date_create($mail->date), 'H:i:s')}}
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mail-content">
                        <div class="mail-recipient">
                            Recipient
                            <div class="mail-recipient_list" id="mailRecipient">
                            </div>
                        </div>
                        <iframe class="mail-frame" id="mailFrame">
                        </iframe>
                    </div>
                </div>
            @else
                <div class="box-center">
                    <h2>List empty</h2>
                </div>
            @endif
        </div>
    </div>
    <script>

        let mails = document.querySelectorAll('.mail-preview');

        Array.prototype.forEach.call(mails, (mail) => {
            mail.addEventListener('click', async () => {
                //document.getElementById('mailFrame').innerHTML = mail.dataset.mailFrame;
                let recipient = document.getElementById('mailRecipient');
                let iframe = document.getElementById('mailFrame');
                let content;

                if (iframe.contentDocument) {
                    content = iframe.contentDocument;
                } else {
                    content = iframe.contentWindow.document;
                }

                content.body.innerHTML = mail.dataset.mailFrame;
                recipient.innerText = Object.keys(JSON.parse(mail.dataset.mailRecipient));
            });
        });

    </script>
@endsection
