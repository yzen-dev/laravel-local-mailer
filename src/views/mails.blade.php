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
                        @foreach ($mails as $key => $mail)
                            <div
                                class="mail-preview"
                                data-mail-key="{{$key}}"
                            >
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
                        <div id="mailRecipientBlock" class="mail-recipient hide">
                            Recipient
                            <div class="mail-recipient_list" id="recipientList">
                            </div>
                        </div>
                        <div id="attachedFiles" class="mail-attached-files hide">
                            Attached files
                            <div class="files-list" id="filesList">
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
        const mails = {!! json_encode($mails) !!};

        const mailsBlock = document.querySelectorAll('.mail-preview');

        Array.prototype.forEach.call(mailsBlock, (mailElement) => {
            mailElement.addEventListener('click', async () => {
                let iframe = document.getElementById('mailFrame');
                let content;

                if (iframe.contentDocument) {
                    content = iframe.contentDocument;
                } else {
                    content = iframe.contentWindow.document;
                }

                const mail = mails[mailElement.dataset.mailKey-1];

                content.body.innerHTML = mail.body;
                document.getElementById('recipientList').innerText = Object.keys(mail.to);
                document.getElementById('mailRecipientBlock').classList.toggle("hide", !mail.to );
                if (mail.attachment) {
                    files = '';
                    mail.attachment.forEach(file => {
                        let fileBlock = '<div class="file-item">';
                        fileBlock += '<div class="file-name">' + file.name + '</div>';
                        if (file.size){
                            fileBlock += '<div class="file-size">' + file.size + '</div>';
                        }
                        fileBlock += '</div>';
                        files += fileBlock;
                    });
                    document.getElementById('filesList').innerHTML = files;
                }
                document.getElementById('attachedFiles').classList.toggle("hide", mail.attachment.length === 0 );
            });
        });

    </script>
@endsection
