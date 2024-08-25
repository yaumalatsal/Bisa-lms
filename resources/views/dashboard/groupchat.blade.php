@extends('dashboard_template/index')

@section('content')


<style>
    .chat-card {
        border-radius: 15px;
        overflow: hidden;
        background: #fff;
        box-shadow: 0px 4px 8px rgba(0,0,0,0.1);
    }

    .chat-body {
        max-height: 500px;
        overflow-y: auto;
        background-color: #e5ddd5;
        position: relative;
        padding: 10px;
    }

    .chat-messages {
        list-style-type: none;
        margin: 0;
        padding: 0;
    }

    .chat-messages .list-group-item {
        border: none;
        border-radius: 20px;
        padding: 10px 15px;
        margin-bottom: 10px;
        position: relative;
        background-color: #ffffff;
        max-width: 80%;
        word-wrap: break-word;
    }

    .chat-messages .message-siswa {
        background-color: #dcf8c6;
        margin-left: 0;
        margin-right: auto;
        text-align: left;
        border-radius: 20px 20px 0 20px;
        position: relative;
    }

    .chat-messages .message-mentor {
        background-color: #ffffff;
        margin-left: auto;
        margin-right: 0;
        text-align: right;
        border-radius: 20px 20px 20px 0;
        position: relative;
    }

    .chat-messages .list-group-item::before {
        content: "";
        position: absolute;
        top: 10px;
        width: 0;
        height: 0;
        border: 10px solid transparent;
    }

    .chat-messages .message-siswa::before {
        left: -15px;
        border-right-color: #dcf8c6;
    }

    .chat-messages .message-mentor::before {
        right: -15px;
        border-left-color: #ffffff;
    }

    .message-sender {
        font-weight: bold;
        margin-bottom: 5px;
    }

    .chat-footer {
        padding: 10px;
        background-color: #ffffff;
        border-top: 1px solid #dddddd;
        border-radius: 0 0 15px 15px;
    }

    .chat-footer .input-group {
        display: flex;
        align-items: center;
    }

    .chat-footer .form-control {
        border-radius: 20px;
        padding: 10px 15px;
        border: 1px solid #007bff;
        resize: none;
    }

    .chat-footer .btn {
        border-radius: 20px;
        padding: 10px;
        margin-left: 10px;
        background-color: transparent;
        border: none;
        color: #007bff;
        cursor: pointer;
    }

    .chat-footer .btn i {
        font-size: 20px;
    }
</style>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h3 class="text-center mb-4 ">Group Chat Untuk Produk {{ $nama_product }}</h3>
            <div class="card chat-card shadow-lg">
                <div class="card-body chat-body" id="chat-messages">
                    <ul class="list-group list-group-flush chat-messages" >
                        @foreach($messages as $message)
                            <li class="list-group-item {{ $message->id_siswa ? 'message-siswa' : 'message-mentor' }}">
                                <div class="message-content">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <strong class="message-sender">{{ $message->siswa->nama ?? $message->mentor->nama }}</strong>
                                    </div>
                                    <p class="mb-0">{{ $message->message }}</p>
                                    <small class="text-muted">{{ $message->created_at->diffForHumans() }}</small>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="card-footer chat-footer">
                    <form action="{{ route('groupchat.sendMessage', $id_produk) }}" method="POST">
                        @csrf
                        <div class="input-group">
                            <textarea name="message" class="form-control" rows="1" placeholder="Type your message..." required></textarea>
                            <button type="submit" class="btn">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection


@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        function scrollToBottom() {
            const chatMessages = document.getElementById('chat-messages');
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        // Scroll to bottom on page load
        scrollToBottom();

        // Optionally scroll to bottom on new message if you use AJAX or similar
        document.querySelector('form').addEventListener('submit', function () {
            setTimeout(scrollToBottom, 100); // Delay for new message to be rendered
        });
    });
</script>
@endsection