@extends('layouts.main')
@section('content')
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="message-card chat-app">
                <div id="plist" class="people-list">
                    <div class="search-bar d-f mb-2">
                        <i class="uil uil-search"></i>
                        <input type="search" placeholder="Гурппаны іздеу..." id="message-search-general">
                    </div>
                    <ul class="list-unstyled chat-list mt-2 mb-0">
                        @php
                            $currentRouteName = Route::currentRouteName();
                            $currentRouteParams = request()->route()->parameters();
                            $currentId = isset($currentRouteParams['group']) ? $currentRouteParams['group'] : null;
                        @endphp
                        @foreach ($groups->groups as $group)
                            <a href="{{ route('groups.load-chat', $group) }}" class="user-link"
                                data-user-id="{{ $group->id }}">
                                <li class="clearfix d-f a-c {{ $currentRouteName === 'groups.load-chat' && $currentId == $group->id ? ' chat-active' : '' }}">
                                    <img src="/{{ $group->image }}" class="avaChat">
                                    <div class="about">
                                        <div class="name">
                                            <p><b>{{ $group->name }}</b></p>
                                        </div>
                                    </div>
                                </li>
                            </a>
                        @endforeach
                    </ul>
                </div>
                <div class="chat" id="user-chat-container">
                    @if (!empty($messages))
                        <div class="chat-header clearfix">
                            <div class="row">
                                <div class="col-lg-6 d-f a-c">
                                    <a href="javascript:void(0);" data-toggle="modal" data-target="#view_info">
                                        <img src="/{{ $groupp->image }}" class="avaChat">
                                    </a>
                                    <div class="chat-about">
                                        <h6 class="m-b-0">{{ $groupp->name }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="chat-history">
                            <ul class="m-b-0">
                                @foreach ($messages as $message)
                                    @if ($message->message)
                                        <li class="clearfix">
                                            <div
                                                class="message-data {{ $message->user_id == Auth::id() ? 'text-right' : '' }}">
                                                <span class="message-data-time">
                                                    {{ $message->created_at->format('h:i, F d') }}
                                                </span>
                                            </div>
                                            <div
                                                class="message-data {{ $message->user_id == Auth::id() ? 'text-right' : '' }}">
                                                <span class="message-data-time">
                                                    {{ $message->user->name }} {{ $message->user->surname }}
                                                </span>
                                            </div>
                                            <div
                                                class="message {{ $message->user_id == Auth::id() ? 'other-message float-right' : 'my-message' }}">
                                                {{ $message->message }}
                                            </div>
                                            <span class="edit edit-msg">
                                                {{-- <i class="uil uil-ellipsis-h" id="post-popup-trigger"></i> --}}
                                                <div class="post-popup" id="post-action-popup">
                                                    <form action="{{ route('chats.chat.delete', $message->id) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('delete')
                                                        <input type="submit" value="Жою"
                                                            class="btn btn-danger mt-2 mb-2">
                                                    </form>
                                                </div>
                                            </span>
                                        </li>
                                    @endif

                                    @if ($message->file_name)
                                        <li class="clearfix">
                                            <div
                                                class="message-data {{ $message->user_id == Auth::id() ? 'text-right' : '' }}">
                                                <span class="message-data-time">
                                                    {{ $message->created_at->format('h:i, F d') }}
                                                </span>
                                            </div>
                                            <div
                                                class="message {{ $message->user_id == Auth::id() ? 'other-message float-right' : 'my-message' }}">
                                                <a href="{{ route('groups.download', ['id' => $message->id]) }}">
                                                    {{ $message->file_name }}
                                                </a>
                                            </div>
                                            <span class="edit edit-msg">
                                                {{-- <i class="uil uil-ellipsis-h" id="post-popup-trigger"></i> --}}
                                                <div class="post-popup" id="post-action-popup">
                                                    <form action="{{ route('chats.chat.delete', $message->id) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('delete')
                                                        <input type="submit" value="Жою"
                                                            class="btn btn-danger mt-2 mb-2">
                                                    </form>
                                                </div>
                                            </span>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                        <div class="create-container">
                            <div class="clearfix">
                                <div class="input-group mb-0">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-send"></i></span>
                                    </div>
                                    <div class="message-input">
                                        @if ($groupp->id === 1 && Auth::user()->admin == 1)
                                            <form id="groupMessageForm" class="chat-form" enctype="multipart/form-data">
                                                <label for="fileInput" class="file-label">
                                                    <i class="uil uil-paperclip"></i>
                                                    <input type="file" name="file_name" id="groupFileInput"
                                                        class="file-input" style="display: none;">
                                                </label>
                                                <input type="text" name="message" id="groupMessage" class="chat-input"
                                                    placeholder="Хат жіберіңіз...">
                                                <button type="submit" id="submit">
                                                    <i class="uil uil-message"></i>
                                                </button>
                                            </form>
                                            <span id="groupFileNameDisplay"></span>
                                            <br>
                                            <span id="groupFileSizeDisplay"></span>
                                        @elseif ($groupp->id !== 1)
                                            <form id="groupMessageForm" class="chat-form" enctype="multipart/form-data">
                                                <label for="fileInput" class="file-label">
                                                    <i class="uil uil-paperclip"></i>
                                                    <input type="file" name="file_name" id="groupFileInput"
                                                        class="file-input" style="display: none;">
                                                </label>
                                                <input type="text" name="message" id="groupMessage" class="chat-input"
                                                    placeholder="Хат жіберіңіз...">
                                                <button type="submit" id="submit">
                                                    <i class="uil uil-message"></i>
                                                </button>
                                            </form>
                                            <span id="groupFileNameDisplay"></span>
                                            <br>
                                            <span id="groupFileSizeDisplay"></span>
                                        @else
                                            <div class="no-message d-f j-c">
                                                Хабарламаны тек eduSocial ғана жібере алады
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script>
        const fileNameDisplay = $('#groupFileNameDisplay');
        const fileSizeDisplay = $('#groupFileSizeDisplay');
        const fileInput = $('#groupFileInput');
        $(document).ready(function() {
            const paperclipIcon = $('.uil-paperclip');

            paperclipIcon.on('click', function(e) {
                e.preventDefault();
                if (!fileInput.is(':focus')) {
                    fileInput.trigger('click');
                }
            });

            fileInput.on('change', function() {
                // Действия, которые нужно выполнить после выбора файла
                console.log('Выбран файл:', fileInput.val());

                const file = fileInput.prop('files')[0];
                const fileName = file.name;
                const fileSize = formatBytes(file.size);
                fileNameDisplay.text(`${fileName}`);
                fileSizeDisplay.text(`${fileSize}`);
            });

            function formatBytes(bytes, decimals = 2) {
                if (bytes === 0) return '0 Bytes';

                const k = 1024;
                const dm = decimals < 0 ? 0 : decimals;
                const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];

                const i = Math.floor(Math.log(bytes) / Math.log(k));

                return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
            }
        });
        $('#groupMessageForm').on('submit', function(event) {
            event.preventDefault();

            let message = $('#groupMessage').val();
            let fileName = $('#groupFileInput')[0].files[0];

            let formData = new FormData(); // Создаем объект FormData
            formData.append('_token', "{{ csrf_token() }}");
            formData.append('message', message);
            formData.append('gruppa_id', "{{ $groupp->id }}");
            formData.append('file_name', fileName);

            $.ajax({
                url: "/groups/chat",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    console.log('Успешный ответ сервера:', response);
                    $('#groupMessage').val('');
                    var messages = response.message.message;
                    var createdAt = response.message.created_at;
                    var file = response.message.file_name;

                    var formattedDate = moment(createdAt).format('h:mm, MMMM D');
                    if (messages && file == '') {
                        $('.chat .chat-history ul').append(
                            ' <li class="clearfix"> <div class="message-data text-right"> <span class="message-data-time">' +
                            formattedDate +
                            '</span> </div><div class="message other-message float-right">' +
                            messages + '</div> </li>');
                    } else if (file && messages == '') {
                        $('.chat .chat-history ul').append(
                            ' <li class="clearfix"> <div class="message-data text-right"> <span class="message-data-time">' +
                            formattedDate +
                            '</span> </div><div class="message other-message float-right">' +
                            file + '</div> </li>');
                    } else {
                        $('.chat .chat-history ul').append(
                            ' <li class="clearfix"> <div class="message-data text-right"> <span class="message-data-time">' +
                            formattedDate +
                            '</span> </div><div class="message other-message float-right">' +
                            messages + '</div> </li>' +
                            '</span> </div><div class="message other-message float-right">' +
                            file + '</div> </li>');
                    }


                    var container = document.getElementById('messagesContainer');
                    container.scrollTop = container.scrollHeight;
                },
                error: function(xhr, status, error) {
                    console.error('Ошибка при отправке AJAX:', xhr, status, error);
                },
            });
            fileNameDisplay.text('');
            fileSizeDisplay.text('');
            fileInput.val('');
        });
    </script>

@endsection
<style>
    .no-message {
        color: var(--color-gray);
    }
</style>
