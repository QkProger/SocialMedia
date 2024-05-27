@extends('layouts.main')
@section('content')
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="message-card chat-app">
                <div id="plist" class="people-list">
                    <div class="search-bar d-f mb-2">
                        <i class="uil uil-search"></i>
                        <input type="search" placeholder="Қолданушыны іздеу..." id="message-search-general">
                    </div>
                    <ul class="list-unstyled chat-list mt-2 mb-0">
                        @php
                            $currentRouteName = Route::currentRouteName();
                            $currentRouteParams = request()->route()->parameters();
                            $currentId = isset($currentRouteParams['user']) ? $currentRouteParams['user'] : null;
                        @endphp
                        @foreach ($friends as $friend)
                            <a href="{{ route('chats.load-chat', $friend->user2->id) }}" class="user-link">
                                <li
                                    class="clearfix {{ $currentRouteName === 'chats.load-chat' && $currentId == $friend->user2->id ? ' chat-active' : '' }}">
                                    <img src="/{{ $friend->user2->avatar }}" class="avaChat">
                                    <div class="about">
                                        <div class="name">
                                            <p>{{ $friend->user2->name }} <br> {{ $friend->user2->surname }}</p>
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
                                        <img src="/{{ $user->avatar }}" class="avaChat">
                                    </a>
                                    <div class="chat-about">
                                        <h6 class="m-b-0">{{ $user->name }} {{ $user->surname }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="chat-history">
                            <ul class="m-b-0">
                                @foreach ($messages as $message)
                                    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
                                    <script>
                                        $(document).ready(function() {
                                            $('.edit-message').on('click', function(e) {
                                                e.preventDefault();
                                                var messageId = $(this).attr('id').split('-')[2];
                                                var editForm = $('#edit-form-' + messageId);

                                                $('.edit-form').not(editForm).hide();
                                                if (editForm.css('display') === 'none') {
                                                    editForm.css('display', 'block');
                                                } else {
                                                    editForm.css('display', 'none');
                                                }
                                            });
                                        });
                                        var elements = document.getElementsByClassName("chat-history");

                                        for (var i = 0; i < elements.length; i++) {
                                            var element = elements[i];
                                            element.scrollTop = element.scrollHeight;
                                        }
                                    </script>
                                    @if ($message->message)
                                        <li class="clearfix">
                                            <div
                                                class="message-data {{ $message->user_id == Auth::id() ? 'text-right' : '' }}">
                                                <span class="message-data-time">
                                                    {{ $message->created_at->format('h:i, F d') }}
                                                </span>
                                            </div>
                                            <div
                                                class="message {{ $message->user_id == Auth::id() ? 'other-message float-right' : 'my-message' }}">
                                                {{ $message->message }}
                                                @if ($message->user_id == Auth::id())
                                                    <span class="message-actions">
                                                        <a href="#" class="edit-message"
                                                            id="edit-message-{{ $message->id }}">
                                                            <i class="uil uil-edit"></i>
                                                        </a>
                                                        <form action="{{ route('chats.chat.delete', $message->id) }}"
                                                            method="post">
                                                            @csrf
                                                            @method('delete')
                                                            <button type="submit" class="mt-2 mb-2"><i
                                                                    class="uil uil-trash"></i></button>
                                                        </form>
                                                    </span>
                                                @elseif ($message->user_id != Auth::id())
                                                    <span class="message-actions">
                                                        <form action="{{ route('chats.chat.delete', $message->id) }}"
                                                            method="post">
                                                            @csrf
                                                            @method('delete')
                                                            <button type="submit" class="mt-2 mb-2"><i
                                                                    class="uil uil-trash"></i></button>
                                                        </form>
                                                    </span>
                                                @endif
                                            </div>
                                        </li>

                                        <!-- Форма редактирования сообщения -->
                                        @if ($message->user_id == Auth::id())
                                            <div class="edit-form" id="edit-form-{{ $message->id }}"
                                                style="display: none;">
                                                <form action="{{ route('chats.chat.update', $message->id) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('put')
                                                    <div class="form-group">
                                                        <label for="editedMessage-{{ $message->id }}">Хабарлама:</label>
                                                        <textarea class="form-control" id="editedMessage-{{ $message->id }}" name="editedMessage" rows="3">{{ $message->message }}</textarea>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary mt-1">Сақтау</button>
                                                </form>
                                            </div>
                                        @endif
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
                                                <a href="{{ route('chats.download', ['id' => $message->id]) }}"
                                                    class="d-f file_input_message">
                                                    {!! $message->svg !!}
                                                    <div class="d-f a-e">
                                                        {{ $message->file_name }}
                                                    </div>
                                                </a>
                                            </div>
                                        </li>
                                    @endif
                                    @if ($message->audio_file_path)
                                        <li class="clearfix">
                                            <div
                                                class="message-data {{ $message->user_id == Auth::id() ? 'text-right' : '' }}">
                                                <span class="message-data-time">
                                                    {{ $message->created_at->format('h:i, F d') }}
                                                </span>
                                            </div>
                                            <div
                                                class="message {{ $message->user_id == Auth::id() ? 'other-message float-right' : 'my-message' }}">
                                                <audio id="audioPlayer" controls>
                                                    <source src="{{ route('getAudioFile', $message->audio_file_path) }}"
                                                        type="audio/webm">
                                                    Сіздің браузеріңіз аудио тегті қолдамайды.
                                                </audio>
                                                <div class="popup-container">
                                                    <i class="uil uil-ellipsis-h post-popup-trigger"
                                                        onclick="togglePopup(this)"></i>
                                                    <div class="post-popup post-action-popup">
                                                        <label for="playbackRate">Скорость воспроизведения:</label>
                                                        <select class="playbackRate" onchange="changePlaybackRate(this)">
                                                            <option value="0.5">0.5x</option>
                                                            <option value="1" selected>1x</option>
                                                            <option value="1.5">1.5x</option>
                                                            <option value="2">2x</option>
                                                        </select>
                                                        <form action="{{ route('chats.chat.delete', $message->id) }}"
                                                            method="post">
                                                            @csrf
                                                            @method('delete')
                                                            <input type="submit" value="Жою"
                                                                class="btn btn-danger mt-2 mb-2">
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <script>
                                                function changePlaybackRate(selectElement) {
                                                    var audioElement = selectElement.closest('.message').querySelector('#audioPlayer');
                                                    audioElement.playbackRate = selectElement.value;
                                                }

                                                function togglePopup(trigger) {
                                                    var popup = trigger.nextElementSibling;
                                                    var allPopups = document.querySelectorAll('.post-action-popup');
                                                    allPopups.forEach(function(p) {
                                                        if (p !== popup) {
                                                            p.style.display = 'none';
                                                        }
                                                    });
                                                    popup.style.display = (popup.style.display === 'none' || popup.style.display === '') ? 'block' : 'none';
                                                }

                                                document.addEventListener('click', function(event) {
                                                    var allPopups = document.querySelectorAll('.post-action-popup');
                                                    allPopups.forEach(function(popup) {
                                                        if (!event.target.matches('.post-popup-trigger') && !popup.contains(event.target)) {
                                                            popup.style.display = 'none';
                                                        }
                                                    });
                                                });
                                            </script>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                        <style>
                            .micro-svg {
                                position: absolute;
                                right: 0;
                                transform: translateX(-45px);
                                width: 25px;
                            }

                            .post-popup {
                                z-index: 1;
                            }
                        </style>
                        <div class="create-container">
                            <div class="clearfix">
                                <div class="input-group mb-0">
                                    <div class="d-f j-b micro_active">
                                        <div id="recording-timer" style="display: none">
                                            00:00</div>
                                        <div class="audio_recording_txt" id="audioActiveTxt">
                                            Аудио хабарлама жазылуда...
                                        </div>
                                    </div>

                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-send"></i></span>
                                    </div>
                                    <div class="message-input">
                                        <form id="messageForm" class="chat-form" enctype="multipart/form-data">
                                            <label for="fileInput" class="file-label">
                                                <i class="uil uil-paperclip"></i>
                                                <input type="file" name="file_name" id="fileInput" class="file-input"
                                                    style="display: none;">
                                            </label>
                                            <input type="text" name="message" id="message" class="chat-input"
                                                placeholder="Хат жіберіңіз...">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" class="micro-svg" id="microphone-icon">
                                                <path
                                                    d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 15h2v2h-2zM12 7a3 3 0 00-3 3v4a3 3 0 006 0v-4a3 3 0 00-3-3z" />
                                            </svg>

                                            <button type="submit" id="submit">
                                                <i class="uil uil-message"></i>
                                            </button>
                                        </form>
                                        <span id="fileNameDisplay"></span>
                                        <br>
                                        <span id="fileSizeDisplay"></span>
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
        document.addEventListener('DOMContentLoaded', function() {
            var audioElements = document.querySelectorAll('audio');

            audioElements.forEach(function(audio) {
                audio.addEventListener('click', function() {
                    if (audio.paused) {
                        audio.play();
                    } else {
                        audio.pause();
                    }
                });
            });
        });
    </script>

    <script>
        const fileNameDisplay = $('#fileNameDisplay');
        const fileSizeDisplay = $('#fileSizeDisplay');
        const fileInput = $('#fileInput');
        const microphoneIcon = $('#microphone-icon');
        const recordingTimer = $('#recording-timer');
        const audioActiveTxt = $('#audioActiveTxt');
        let isRecording = false;
        let audioContext;
        let mediaRecorder;
        let audioChunks = [];
        let recordingInterval;
        let startTime;
        microphoneIcon.on('click', async () => {
            if (!isRecording) {
                try {
                    audioContext = new(window.AudioContext || window.webkitAudioContext)();
                    const stream = await navigator.mediaDevices.getUserMedia({
                        audio: true
                    });

                    mediaRecorder = new MediaRecorder(stream);
                    mediaRecorder.ondataavailable = (event) => {
                        if (event.data.size > 0) {
                            audioChunks.push(event.data);
                        }
                    };

                    mediaRecorder.onstop = () => {
                        const audioBlob = new Blob(audioChunks, {
                            type: 'audio/wav'
                        });
                        const audioUrl = URL.createObjectURL(audioBlob);

                        // Отправьте аудиофайл на сервер
                        const formData = new FormData();
                        formData.append('_token', "{{ csrf_token() }}");
                        formData.append('sendler_user_id', "{{ $user->id }}");
                        formData.append('audio_file', audioBlob);

                        $.ajax({
                            url: "/chats/chat",
                            type: "POST",
                            data: formData,
                            contentType: false,
                            processData: false,
                            success: function(response) {
                                console.log('Успешный ответ сервера:', response);
                                // Ваш код обработки успешного ответа
                            },
                            error: function(xhr, status, error) {
                                console.error('Ошибка при отправке AJAX:', xhr, status, error);
                                // Ваш код обработки ошибки
                            },
                        });

                        audioChunks = [];
                        clearInterval(recordingInterval);
                        recordingTimer.hide();
                        recordingTimer.text("00:00");
                    };

                    mediaRecorder.start();
                    isRecording = true;
                    microphoneIcon.addClass('recording');
                    startRecordingTimer();
                    audioActiveTxt.addClass('audio_recording_txt_active');
                } catch (error) {
                    console.error('Ошибка при получении доступа к микрофону:', error);
                }
            } else {
                if (mediaRecorder && mediaRecorder.state !== 'inactive') {
                    mediaRecorder.stop();
                    isRecording = false;
                    microphoneIcon.removeClass('recording');
                    audioActiveTxt.removeClass('audio_recording_txt_active');
                }
            }
        });

        function startRecordingTimer() {
            startTime = Date.now();
            recordingTimer.show();

            recordingInterval = setInterval(() => {
                const elapsedTime = Date.now() - startTime;
                const minutes = Math.floor(elapsedTime / 60000);
                const seconds = Math.floor((elapsedTime % 60000) / 1000);

                recordingTimer.text(
                    `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`
                );
            }, 1000);
        }
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
        $('#messageForm').on('submit', function(event) {
            event.preventDefault();

            let message = $('#message').val();
            let fileName = $('#fileInput')[0].files[0];

            let formData = new FormData(); // Создаем объект FormData
            formData.append('_token', "{{ csrf_token() }}");
            formData.append('message', message);
            formData.append('sendler_user_id', "{{ $user->id }}");
            formData.append('file_name', fileName);

            $.ajax({
                url: "/chats/chat",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    console.log('Успешный ответ сервера:', response);
                    $('#message').val('');
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
    .file_input_message {
        gap: 5px;
    }

    .micro_active {
        padding-bottom: 5px;
    }

    #recording-timer {
        font-size: 16px;
        color: #1fcf1f;
    }

    .a-e {
        align-items: flex-end;
    }

    .a-c {
        align-items: center;
    }

    .j-b {
        justify-content: space-between;
    }

    .audio_recording_txt {
        text-align: right;
        color: transparent;
    }

    .audio_recording_txt_active {
        color: #1fcf1f;
    }

    .micro-svg {
        transition: fill 0.3s ease;
    }

    .micro-svg.recording {
        fill: #ff7676;
    }

    .uil-trash:before {
        cursor: pointer;
    }
</style>
