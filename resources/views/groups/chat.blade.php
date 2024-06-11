@extends('layouts.main')
@section('content')
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="message-card chat-app">
                <div id="plist" class="people-list">
                    <div class="search-bar d-f mb-2">
                        <i class="uil uil-search"></i>
                        <input type="search" placeholder="Группаны іздеу..." id="message-search-general">
                    </div>
                    <ul class="list-unstyled chat-list mt-2 mb-0">
                        @php
                            $currentRouteName = Route::currentRouteName();
                            $currentRouteParams = request()->route()->parameters();
                            $currentId = isset($currentRouteParams['group']) ? $currentRouteParams['group'] : null;
                        @endphp
                        @foreach ($groups as $groupItem)
                            <a href="{{ route('groups.load-chat', $groupItem->group) }}" class="user-link"
                                data-user-id="{{ $groupItem->group->id }}">
                                <li
                                    class="clearfix relative d-f a-c {{ $currentRouteName === 'groups.load-chat' && $currentId == $groupItem->group->id ? ' chat-active' : '' }}">
                                    @if ($groupItem->group->image)
                                        <img src="/storage/{{ $groupItem->group->image }}" class="avaChat">
                                    @else
                                        <img src="{{ asset('images/default-avatar.jpg') }}" class="avaChat">
                                    @endif
                                    <div class="about">
                                        <div class="name">
                                            <p><b>{{ $groupItem->group->name }}</b></p>
                                        </div>
                                    </div>
                                    @if ($groupItem->group_msg_cnt > 0 && $currentId != $groupItem->gruppa_id)
                                        <small class="notification-count">{{ $groupItem->group_msg_cnt }}</small>
                                    @endif
                                </li>
                            </a>
                        @endforeach
                    </ul>
                </div>
                <script>
                    function openGroupModal(element) {
                        var isAdmin = element.dataset.isAdmin;
                        var groupp_id = element.dataset.group_id;
                        if ((isAdmin == 1 && groupp_id == 1) || groupp_id != 1) {
                            document.querySelector('.left').style.zIndex = '0';
                            document.querySelector('nav').style.zIndex = '0';

                            document.getElementById('groupModal').style.display = 'block';
                            document.getElementById('overlay').style.display = 'block';
                        }
                    }

                    function closeGroupModal() {
                        document.querySelector('.left').style.zIndex = 'auto';
                        document.querySelector('nav').style.zIndex = 'auto';

                        document.getElementById('groupModal').style.display = 'none';
                        document.getElementById('overlay').style.display = 'none';
                    }

                    function saveGroup() {
                        event.preventDefault();
                        document.getElementById('group').submit();
                    }
                </script>
                <div class="chat" id="user-chat-container">
                    @if (!empty($messages))
                        <div class="chat-header clearfix c-p" data-is-admin="{{ $is_admin }}"
                            data-group_id="{{ $groupp->id }}" onclick="openGroupModal(this)">
                            <div class="row">
                                <div class="col-lg-6 d-f a-c">
                                    <a href="javascript:void(0);" data-toggle="modal" data-target="#view_info">
                                        @if ($groupp->image)
                                            <img src="/storage/{{ $groupp->image }}" class="avaChat">
                                        @else
                                            <img src="{{ asset('images/default-avatar.jpg') }}" class="avaChat">
                                        @endif
                                    </a>
                                    <div class="chat-about">
                                        <h6 class="m-b-0">{{ $groupp->name }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="overlay" onclick="closeGroupModal()"></div>
                        <div class="create-container">
                            <div id="groupModal">
                                <span class="close-btn" onclick="closeGroupModal()">✖</span>
                                <h2>Группаны өңдеу</h2>
                                <form action="{{ route('group.update', $groupp->id) }}" method="post"
                                    enctype="multipart/form-data" id="group">
                                    @csrf
                                    <div class="row">
                                        <div class="col-75">
                                            <input type="text" id="name" name="name" placeholder="Аты.."
                                                value="{{ $groupp->name }}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-75">
                                            <textarea id="description" name="description" placeholder="Сипаттамасы.." style="height:200px">{{ $groupp->description }}</textarea>
                                        </div>
                                    </div>

                                    <div class="middle">
                                        <div class="d-b">
                                            <div class="filter-friend">
                                                <div class="messages modal-messages">
                                                    @if ($users->count() != 0)
                                                        <h3 class="friend-title">Қолданушылар</h3>
                                                    @endif
                                                    <div class="user-list">
                                                        @foreach ($users as $user)
                                                            <div class="user-wrapper d-f">
                                                                <input type="checkbox" name="selectedUsers[]"
                                                                    value="{{ $user->id }}"
                                                                    id="user-{{ $user->id }}" style="display: none">
                                                                <label for="user-{{ $user->id }}"
                                                                    class="user-link w-100">
                                                                    <div class="message">
                                                                        <div class="profile-photo">
                                                                            <img src="/storage/{{ $user->avatar }}"
                                                                                class="avaChat">
                                                                        </div>
                                                                        <div class="message-body">
                                                                            <h5>
                                                                                {{ $user->name }} {{ $user->surname }}
                                                                            </h5>
                                                                        </div>
                                                                    </div>
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                            @if ($is_admin == 1)
                                                <div class="testblock">
                                                    <input type="radio" id="delete-radio" name="block-toggle">
                                                    <label class="selectButton" for="delete-radio">Жою</label>
                                                    <div class="block">
                                                        <div class="filter-friend mt-1 mb-3">
                                                            <div class="messages modal-messages">
                                                                @if ($group_users->count() != 0)
                                                                    <h3 class="friend-title">Группа мүшелерін жою</h3>
                                                                @endif
                                                                <div class="user-list">
                                                                    @foreach ($group_users as $groupUser)
                                                                        @if ($groupUser->is_admin == 0 && $groupUser->user->id != Auth::id())
                                                                            <div class="user-wrapper d-f">
                                                                                <input type="checkbox"
                                                                                    name="toDeleteSelectedGroupUsers[]"
                                                                                    value="{{ $groupUser->user->id }}"
                                                                                    id="userDelete-{{ $groupUser->user->id }}"
                                                                                    style="display: none">
                                                                                <label
                                                                                    for="userDelete-{{ $groupUser->user->id }}"
                                                                                    class="user-link w-100">
                                                                                    <div class="message">
                                                                                        <div class="profile-photo">
                                                                                            <img src="/storage/{{ $groupUser->user->avatar }}"
                                                                                                class="avaChat">
                                                                                        </div>
                                                                                        <div class="message-body">
                                                                                            <h5>
                                                                                                {{ $groupUser->user->name }}
                                                                                                {{ $groupUser->user->surname }}
                                                                                            </h5>
                                                                                        </div>
                                                                                    </div>
                                                                                </label>
                                                                            </div>
                                                                        @endif
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <input type="radio" id="admin-radio" name="block-toggle">
                                                    <label class="selectButton" for="admin-radio">Админ</label>
                                                    <div class="block">
                                                        <div class="filter-friend">
                                                            <div class="messages modal-messages">
                                                                @if ($group_users->count() != 0)
                                                                    <h3 class="friend-title">Админ рөлін беру</h3>
                                                                @endif
                                                                <div class="user-list">
                                                                    @foreach ($group_users as $groupUser)
                                                                        @if ($groupUser->is_admin == 0 && $groupUser->user->id != Auth::id())
                                                                            <div class="user-wrapper d-f">
                                                                                <input type="checkbox"
                                                                                    name="toAdminSelectedGroupUsers[]"
                                                                                    value="{{ $groupUser->user->id }}"
                                                                                    id="useradmin-{{ $groupUser->user->id }}"
                                                                                    style="display: none">
                                                                                <label
                                                                                    for="useradmin-{{ $groupUser->user->id }}"
                                                                                    class="user-link w-100">
                                                                                    <div class="message">
                                                                                        <div class="profile-photo">
                                                                                            <img src="/storage/{{ $groupUser->user->avatar }}"
                                                                                                class="avaChat">
                                                                                        </div>
                                                                                        <div class="message-body">
                                                                                            <h5>
                                                                                                {{ $groupUser->user->name }}
                                                                                                {{ $groupUser->user->surname }}
                                                                                            </h5>
                                                                                        </div>
                                                                                    </div>
                                                                                </label>
                                                                            </div>
                                                                        @endif
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-25">
                                            <label for="image">Суреті</label>
                                            @if ($groupp->image)
                                                <img src="/storage/{{ $groupp->image }}" class="avaChat">
                                            @else
                                                <img src="{{ asset('images/default-avatar.jpg') }}" class="avaChat">
                                            @endif
                                        </div>
                                        <div class="col-75">
                                            <input type="file" id="image" name="image">
                                        </div>
                                    </div>
                                    <div class="d-f a-c j-b">
                                        <div class="d-b">
                                            @if ($is_admin == 1)
                                                <h5 class="admin_message"><b>Админ чат</b></h5>
                                                <input class="switch mb-2" type="checkbox" name="status" value="1"
                                                    {{ $groupp->status ? 'checked' : '' }}>
                                            @else
                                                <input type="hidden" name="status" value="{{ $groupp->status }}">
                                            @endif
                                        </div>
                                        <div class="row">
                                            <input type="submit" value="Сақтау" onclick="saveGroup()">
                                        </div>
                                    </div>
                                </form>
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
                                                    @if ($groupp->id == 1 && Auth::user()->admin != 1)
                                                        @if ($groupp->image)
                                                            <img src="/storage/{{ $groupp->image }}" class="avaChat">
                                                        @else
                                                            <img src="{{ asset('images/default-avatar.jpg') }}"
                                                                class="avaChat">
                                                        @endif
                                                        {{ $groupp->name }}
                                                    @else
                                                        <a href="{{ route('user.profile', $message->user->id) }}">
                                                            @if ($message->user->id != auth()->id())
                                                                @if ($message->user->avatar)
                                                                    <img src="/storage/{{ $message->user->avatar }}"
                                                                        class="avaChat">
                                                                @else
                                                                    <img src="{{ asset('images/profile-1.jpg') }}"
                                                                        class="avaChat">
                                                                @endif
                                                            @endif
                                                            {{ $message->user->name }} {{ $message->user->surname }}
                                                        </a>
                                                    @endif
                                                </span>
                                            </div>
                                            <div
                                                class="message {{ $message->user_id == Auth::id() ? 'other-message float-right' : 'my-message' }}">
                                                {{ $message->message }}
                                            </div>
                                            <span class="edit edit-msg">
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
                                                class="message-data {{ $message->user_id == Auth::id() ? 'text-right' : '' }}">
                                                <span class="message-data-time">
                                                    @if ($groupp->id == 1 && Auth::user()->admin != 1)
                                                        {{ $groupp->name }}
                                                    @else
                                                        <a href="{{ route('user.profile', $message->user->id) }}">
                                                            @if ($message->user->id != auth()->id())
                                                                @if ($message->user->avatar)
                                                                    <img src="/storage/{{ $message->user->avatar }}"
                                                                        class="avaChat">
                                                                @else
                                                                    <img src="{{ asset('images/profile-1.jpg') }}"
                                                                        class="avaChat">
                                                                @endif
                                                            @endif
                                                            {{ $message->user->name }} {{ $message->user->surname }}
                                                        </a>
                                                    @endif
                                                </span>
                                            </div>
                                            <div
                                                class="message {{ $message->user_id == Auth::id() ? 'other-message float-right' : 'my-message' }}">
                                                <a href="{{ route('groups.download', ['id' => $message->id]) }}"
                                                    class="d-f file_input_message">
                                                    @if ($message->extension == 'jpg' || $message->extension == 'png' || $message->extension == 'jpeg')
                                                        <img src="{{ url('group_chat_files/' . $message->file_name) }}"
                                                            style="max-width: 200px">
                                                    @else
                                                        <div class="d-f a-e">
                                                            {!! $message->svg !!}
                                                            {{ $message->file_name }}
                                                        </div>
                                                    @endif
                                                </a>
                                            </div>
                                            <span class="edit edit-msg">
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
                                        @if (
                                            ($groupp->id !== 1 && ($groupp->status == 0 || ($groupp->status == 1 && $is_admin == 1))) ||
                                                ($groupp->id === 1 && Auth::user()->admin == 1))
                                            @include('groups.includes.group_form')
                                        @else
                                            @if ($groupp->id == 1)
                                                <div class="no-message d-f j-c">
                                                    Хабарламаны тек eduSocial ғана жібере алады.
                                                </div>
                                            @else
                                                <div class="no-message d-f j-c">
                                                    Хабарламаны тек админдар ғана жібере алады.
                                                </div>
                                            @endif
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
    .testblock {
        flex-direction: column;
        margin-top: 50px;
    }

    .block {
        display: none;
    }

    .testblock input[type="radio"] {
        display: none;
    }

    .testblock input[type="radio"]:checked+.selectButton+.block {
        display: block;
    }

    .testblock .selectButton {
        cursor: pointer;
        margin: 5px;
        padding: 1px 10px;
        border: 1px solid #007BFF;
        border-radius: 5px;
        background-color: var(--color-primary);
        color: white;
        cursor: pointer;
        transition: 0.3s all ease;
    }

    .testblock .selectButton:hover {
        text-decoration: underline;
    }

    .admin_message {
        padding-top: 12px;
    }

    input.switch {
        -moz-appearance: none;
        -webkit-appearance: none;
        -o-appearance: none;
        appearance: none;
        height: 1em;
        width: 2em;
        border-radius: 1em;
        box-shadow: inset -1em 0px 0px 0px rgba(192, 192, 192, 1);
        background-color: white;
        border: 1px solid rgba(192, 192, 192, 1);
        outline: none;
        -webkit-transition: 0.2s;
        transition: 0.2s;
    }

    input.switch:checked {
        box-shadow: inset 1em 0px 0px 0px rgba(33, 150, 243, 0.5);
        border: 1px solid rgba(33, 150, 243, 1);
    }

    input.switch:focus {
        outline-width: 0;
    }

    .file_input_message {
        gap: 5px;
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

    .c-p {
        cursor: pointer;
    }

    .no-message {
        color: var(--color-gray);
    }
</style>

<style>
    #groupModal {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        padding: 30px;
        background: #fff;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
        z-index: 1000;
        max-height: 500px;
        overflow: scroll;
    }

    #overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 999;
    }

    .group-btn {
        right: 17px;
        position: absolute;
    }

    .col-75 {
        width: 75%;
        margin: 0 auto;
    }

    .col-75 input[type="file"] {
        width: 100%;
        padding: 5px;
        box-sizing: border-box;
        margin-top: 9px;
    }

    .close-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        cursor: pointer;
    }

    .modal-messages {
        max-height: 300px;
        overflow-y: scroll;
    }
</style>
