@extends('dosPanel.layouts.main')

@section('container')

<style>
    .chat-online {
        color: #34ce57
    }

    .chat-offline {
        color: #e4606d
    }

    .chat-messages {
        display: flex;
        flex-direction: column;
        max-height: 800px;
        overflow-y: scroll;
    }

    .chat-message-left,
    .chat-message-right {
        display: flex;
        flex-shrink: 0
    }

    .chat-message-left {
        margin-right: auto
    }

    .chat-message-right {
        flex-direction: row-reverse;
        margin-left: auto
    }
    .flex-grow-0 {
        flex-grow: 0!important;
    }
    .border-top {
        border-top: 1px solid #dee2e6!important;
    }

    .highlight:hover{
        background-color: #C4C4C4;
    }
</style>
@php
    $pesan = Firebase::database()->getReference('message/received/' . Session::get('email'))->getValue();
    $terkirim = Firebase::database()->getReference('message/sent/' . Session::get('email'))->getValue();
    $receive = collect();
    $sent = collect();
    
    if(Firebase::database()->getReference('message/received/' . Session::get('email'))->getSnapshot()->exists()){
        foreach($pesan as $message){
            $receive->put($message['sender'], $message['message']);
        }
    }

    if(Firebase::database()->getReference('message/sent/' . Session::get('email'))->getSnapshot()->exists()){
        foreach($terkirim as $message){
            $sent->put($message['to'], $message['message']);
        }
    }

@endphp
<script src="https://www.gstatic.com/firebasejs/8.2.1/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.2.1/firebase-database.js"></script>
<script src="/js/index.js"></script>
<div class="card">
    @if(Firebase::database()->getReference('message/received/' . Session::get('email'))->getSnapshot()->exists())
        <div class="row g-0">
            <div class="col-12 col-lg-5 col-xl-3 border border-right">
                <ul class="mt-3 nav nav-tabs flex-column" id="myTab" role="tablist">
                    @foreach(Firebase::database()->getReference('message/received/' . Session::get('email'))->getValue() as $snapshot)
                        <li class="nav-item highlight" role="presentation">
                            <a href="#" id="{{ Str::replace('@', '', $snapshot['sender']) }}-tab" data-bs-toggle="tab" type="button" role="tab" aria-controls="{{ Str::replace('@', '', $snapshot['sender']) }}" aria-selected="true" data-bs-target="#{{ Str::replace('@', '', $snapshot['sender']) }}" class="nav-link mx-4 pb-3 list-group-item list-group-item-action border-0">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 ml-3">
                                        {{ Firebase::database()->getReference('users/' . $snapshot['sender'])->getValue()['name'] }}
                                    </div>
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
                
                <hr class="d-block d-lg-none mt-1 mb-0">
            </div>
            <div class="col-12 col-lg-7 col-xl-9">
                <div class="tab-content">
                    @foreach(Firebase::database()->getReference('message/received/' . Session::get('email'))->getValue() as $snapshot)
                        @php
                            $chat = collect();
                            if(Firebase::database()->getReference('message/sent/' . Session::get('email') . '/' . $snapshot['sender'] . '/')->getSnapshot()->exists()){
                                for($i = 1; $i <= count($receive->all()[$snapshot['sender']]); $i++){
                                    $chat->put('m' . $i, [
                                        'message' => $receive->all()[$snapshot['sender']]['m' . $i]['message'],
                                        'time' => $receive->all()[$snapshot['sender']]['m' . $i]['timestamp'],
                                        'from' => $snapshot['sender']
                                    ],);
                                }
                                for($i = 1; $i <= count($sent->all()[$snapshot['sender']]); $i++){
                                    $chat->put('m' . $i + count($receive->all()[$snapshot['sender']]), [
                                        'message' => $sent->all()[$snapshot['sender']]['m' . $i]['message'],
                                        'time' => $sent->all()[$snapshot['sender']]['m' . $i]['timestamp'],
                                        'from' => 'you'
                                    ]);
                                }
                            } else{
                                for($i = 1; $i <= count($receive->all()[$snapshot['sender']]); $i++){
                                    $chat->put('m' . $i, [
                                        'message' => $receive->all()[$snapshot['sender']]['m' . $i]['message'],
                                        'time' => $receive->all()[$snapshot['sender']]['m' . $i]['timestamp'],
                                        'from' => $snapshot['sender']
                                    ],);
                                }
                            }

                            $sort = $chat->sortBy('time');
                        @endphp
                        <div class="tab-pane" id="{{ Str::replace('@', '', $snapshot['sender']) }}" role="tabpanel" aria-labelledby="{{ Str::replace('@', '', $snapshot['sender']) }}-tab" tabindex="0">
                            <div class="py-2 px-4 border-bottom d-none d-lg-block">
                                <div class="d-flex align-items-center py-1">
                                    <div class="flex-grow-1 pl-3">
                                        <strong>{{ Firebase::database()->getReference('users/' . $snapshot['sender'])->getValue()['name'] }}</strong>
                                    </div>
                                </div>
                            </div>
                
                            <div class="position-relative">
                                <div class="chat-messages p-4" id="div{{ Str::replace('@', '', $snapshot['sender']) }}">
                                    @foreach($sort->all() as $m)
                                        <div class="chat-message-{{ $m['from'] == 'you' ? 'right' : 'left' }} pb-4">
                                            <div>
                                                <div class="text-muted small text-nowrap mt-2 mx-2">{{ date('H:i', strtotime($m['time'])) }}</div>
                                            </div>
                                            <div class="flex-shrink-1 bg-light rounded py-2 px-3 mr-3">
                                                <div class="bold mb-1">{{ $m['from'] == 'you' ? 'You' : Firebase::database()->getReference('users/' . $m['from'])->getValue()['name'] }}</div>
                                                {{ $m['message'] }}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="flex-grow-0 py-3 px-4 border-top">
                                <div class="input-group">
                                    <input onkeydown="if(event.code == 'Enter'){document.getElementById('button{!! Str::replace('@', '', $snapshot['sender']) !!}').click()}" type="text" id="message{{ Str::replace('@', '', $snapshot['sender']) }}" class="form-control" placeholder="Type your message">
                                    <button class="btn btn-primary" id="button{{ Str::replace('@', '', $snapshot['sender']) }}">Send</button>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="{{ Str::replace('@', '', $snapshot['sender']) }}value" value="{{ $snapshot['sender'] }}">
                        <input type="hidden" id="{{ Str::replace('@', '', Session::get('email')) }}" value="{{ Session::get('email') }}">

                        <script>
                            const {!! Str::replace('@', '', $snapshot['sender']) !!} = document.getElementById("{!! Str::replace('@', '', $snapshot['sender']) !!}value");
                            var {!! Str::replace('@', '', Session::get('email')) !!} = document.getElementById("{!! Str::replace('@', '', Session::get('email')) !!}");
                            var message{!! Str::replace('@', '', $snapshot['sender']) !!} = document.getElementById("message{!! Str::replace('@', '', $snapshot['sender']) !!}");
                            const div{!! Str::replace('@', '', $snapshot['sender']) !!} = document.getElementById("div{!! Str::replace('@', '', $snapshot['sender']) !!}");
                            var date = '{!! Carbon\Carbon::now() !!}';
                            var date_baru = '{!! date('H:i', strtotime(Carbon\Carbon::now())) !!}'

                            const button{!! Str::replace('@', '', $snapshot['sender']) !!} = document.getElementById("button{{ Str::replace('@', '', $snapshot['sender']) }}");

                            button{!! Str::replace('@', '', $snapshot['sender']) !!}.addEventListener('click', (e)=>{
                                e.preventDefault();
                                const emailPengirim = {!! Str::replace('@', '', $snapshot['sender']) !!}.value;
                                const emailPenerima = {!! Str::replace('@', '', Session::get('email')) !!}.value;
                                const message = message{!! Str::replace('@', '', $snapshot['sender']) !!}.value;
                                if(message == null || message == ''){
                                    alert('bidang pengisian tidak boleh kosong');
                                } else{
                                    message{!! Str::replace('@', '', $snapshot['sender']) !!}.value = '';
                                    var count = 0;
                                    db.ref("message/received/{!! $snapshot['sender'] !!}/{!! Session::get('email') !!}/message").once('value', (snapshot)=>{
                                        count = snapshot.numChildren();
                                        const ma = 'm' + (count + 1);
                                        if(!snapshot.exists()){
                                            db.ref("message/received/{!! $snapshot['sender'] !!}/{!! Session::get('email') !!}").update({
                                                'sender': "{!!  Session::get('email') !!}"
                                            });
    
                                            db.ref("message/sent/{!! Session::get('email') !!}/{!! $snapshot['sender'] !!}").update({
                                                'to': "{!!  $snapshot['sender'] !!}",
                                            });
                                        }
                                        db.ref("message/received/{!! $snapshot['sender'] !!}/{!! Session::get('email') !!}/message/" + ma).update({
                                            'message': message,
                                            'timestamp': date
                                        });
    
                                        db.ref("message/sent/{!! Session::get('email') !!}/{!! $snapshot['sender'] !!}/message/" + ma).update({
                                            'message': message,
                                            'timestamp': date
                                        });
    
                                        db.ref("message/sent/{!! Session::get('email') !!}/{!! $snapshot['sender'] !!}/message").once('child_added', (snapshot)=>{
                                            const newMessage = snapshot.val();
                                            const messageChild = `
                                                        <div class="chat-message-right pb-4">
                                                            <div>
                                                                <div class="text-muted small text-nowrap mt-2 mx-2">${date_baru}</div>
                                                            </div>
                                                            <div class="flex-shrink-1 bg-light rounded py-2 px-3 mr-3">
                                                                <div class="bold mb-1">You</div>
                                                                ${message}
                                                            </div>
                                                        </div>
                                                    `;
                                            div{!! Str::replace('@', '', $snapshot['sender']) !!}.insertAdjacentHTML('beforeend', messageChild);
                                        });
                                    });
                                }
                            });

                            db.ref("message/received/{!! Session::get('email') !!}/{!! $snapshot['sender'] !!}").once('child_changed', (snapshot)=>{
                                        const newMessage = snapshot.val()[`m${snapshot.numChildren()}`];
                                        const time = new Date(newMessage['timestamp']);
                                        const waktu = (time.getMinutes < 10 ? time.getHours() + ':0' + time.getMinutes() : time.getHours() + ':' + time.getMinutes());
                                        console.log(newMessage);
                                        const messageChild = `
                                                    <div class="chat-message-left pb-4">
                                                        <div>
                                                            <div class="text-muted small text-nowrap mt-2 mx-2">${waktu}</div>
                                                        </div>
                                                        <div class="flex-shrink-1 bg-light rounded py-2 px-3 mr-3">
                                                            <div class="bold mb-1">{{ Firebase::database()->getReference('users/' . $snapshot['sender'])->getValue()['name'] }}</div>
                                                            ${newMessage['message']}
                                                        </div>
                                                    </div>
                                                `;
                                        div{!! Str::replace('@', '', $snapshot['sender']) !!}.insertAdjacentHTML('beforeend', messageChild);
                                    });
                        </script>
                    @endforeach
                </div>
            </div>
        </div>
    @else
        <div class="row g-0">
            Belum ada pesan
        </div>
    @endif
</div>
@endsection