@extends('mentor/template/index')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h3 class="text-center mb-4 text-primary">Group Chat Untuk Produk {{ $nama_product }}</h3>
            <div class="card chat-card shadow-lg">
                <div class="card-body chat-body">
                    <ul class="list-group list-group-flush chat-messages" id="chat-messages">
                        @foreach($messages as $message)
                            <li class="list-group-item {{ $message->id_siswa ? 'message-siswa' : 'message-session' }}">
                                <div class="d-flex justify-content-between align-items-center">
                                    <strong class="message-sender">{{ $message->siswa->nama ?? $message->mentor->nama }}</strong>
                                    <small class="text-muted">{{ $message->created_at->diffForHumans() }}</small>
                                </div>
                                <p class="mb-0">{{ $message->message }}</p>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="card-footer chat-footer">
                    <form action="{{ route('groupchat.sendMessageMentor', $id_produk) }}" method="POST">
                        @csrf
                        <div class="input-group">
                            <textarea name="message" class="form-control" rows="1" placeholder="Type your message..." required></textarea>
                            <button type="submit" class="btn btn-primary">Send</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include Perfect Scrollbar for smooth scrolling -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/perfect-scrollbar/1.5.3/perfect-scrollbar.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/perfect-scrollbar/1.5.3/perfect-scrollbar.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const chatMessages = document.getElementById('chat-messages');
        const ps = new PerfectScrollbar(chatMessages);

        // Scroll to bottom of chat after loading messages
        chatMessages.scrollTop = chatMessages.scrollHeight;
    });
</script>

<style>
    .chat-card {
        border-radius: 15px;
        overflow: hidden;
        background: linear-gradient(145deg, #ffffff, #e6e6e6);
        box-shadow: 8px 8px 16px #cacaca, -8px -8px 16px #ffffff;
    }

    .chat-body {
        max-height: 500px;
        overflow-y: auto;
        background-color: #f8f9fa;
        position: relative;
    }

    .chat-messages {
        padding: 10px;
        list-style-type: none;
        margin: 0;
    }

    .chat-messages .list-group-item {
        border: none;
        border-radius: 10px;
        padding: 10px;
        margin-bottom: 10px;
        background-color: #e9ecef;
        position: relative;
        clear: both;
    }

    .chat-messages .message-siswa {
        background-color: #d4edda;
        float: left;
        text-align: left;
        margin-right: 50px; /* Adjust spacing from the right edge */
    }

    .chat-messages .message-session {
        background-color: #d1ecf1;
        float: right;
        text-align: right;
        margin-left: 50px; /* Adjust spacing from the left edge */
    }

    .message-sender {
        font-weight: bold;
    }

    .chat-footer {
        padding: 15px;
        background-color: #007bff;
        border-top: 1px solid #dee2e6;
        border-radius: 15px;
    }

    .chat-footer .input-group {
        display: flex;
        align-items: center;
    }

    .chat-footer .form-control {
        border-radius: 30px;
        padding: 10px 15px;
        border: 1px solid #007bff;
        resize: none;
    }

    .chat-footer .btn {
        border-radius: 30px;
        padding: 10px 20px;
        margin-left: 10px;
    }
</style>
@endsection
