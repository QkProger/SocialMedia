@extends('layouts.main')
@section('content')
    <div class="middle edit-profile-grid adaptive-profile">
        <div class="card adaptive-profile-card" style="max-height: 430px">
            <div class="card-body">
                <div class="d-flex flex-column align-items-center text-center">
                    <img src="/storage/{{ $user->avatar }}" alt="Admin" class="rounded-circle" width="150">
                    <div class="mt-3">
                        <h3>{{ $user->nickname }}</h3>
                        <p class="text-muted mb-1">{{ $user->mamandyq }}</p>
                        <p class="text-muted font-size-sm mb-3">{{ $user->oblys }}, {{ $user->qala }}</p>
                    </div>
                </div>
                <br>
            </div>
        </div>
        <div class="create-container">
            <form action="{{ route('user.update', $user->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-25">
                        <label for="name">
                            <h4>Аты</h4>
                        </label>
                    </div>
                    <div class="col-75">
                        <input type="text" name="name" value="{{ $user->name }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-25">
                        <label for="name">
                            <h4>Әке аты</h4>
                        </label>
                    </div>
                    <div class="col-75">
                        <input type="text" name="lastname" value="{{ $user->lastname }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-25">
                        <label for="name">
                            <h4>Тегі</h4>
                        </label>
                    </div>
                    <div class="col-75">
                        <input type="text" name="surname" value="{{ $user->surname }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-25">
                        <label for="name">
                            <h4>Псевдоним</h4>
                        </label>
                    </div>
                    <div class="col-75">
                        <input type="text" name="nickname" value="{{ $user->nickname }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-25">
                        <label for="name">
                            <h4>ИИН</h4>
                        </label>
                    </div>
                    <div class="col-75">
                        <input type="text" name="iin" value="{{ $user->iin }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-25">
                        <label for="name">
                            <h4>Почта</h4>
                        </label>
                    </div>
                    <div class="col-75">
                        <input type="text" name="email" value="{{ $user->email }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-25">
                        <label for="name">
                            <h4>Құпия сөз</h4>
                        </label>
                    </div>
                    <div class="col-75">
                        <input type="text" name="password" class="form-control" value="{{ $user->real_password }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-25">
                        <label for="name">
                            <h4>Туған күні</h4>
                        </label>
                    </div>
                    <div class="col-75">
                        <input type="date" name="birthday" value="{{ $user->birthday }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-25">
                        <label for="name">
                            <h4>Облыс</h4>
                        </label>
                    </div>
                    <div class="col-75">
                        <input type="text" name="oblys" value="{{ $user->oblys }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-25">
                        <label for="name">
                            <h4>Қала</h4>
                        </label>
                    </div>
                    <div class="col-75">
                        <input type="text" name="qala" value="{{ $user->qala }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-25">
                        <label for="name">
                            <h4>Мамандық</h4>
                        </label>
                    </div>
                    <div class="col-75">
                        <input type="text" name="mamandyq" value="{{ $user->mamandyq }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-25">
                        <label for="name">
                            <h4>Телефон номері</h4>
                        </label>
                    </div>
                    <div class="col-75">
                        <input type="text" name="phone" value="{{ $user->phone }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-25">
                        <label for="name">
                            <h4>Аватар</h4>
                        </label>
                    </div>
                    <div class="col-75">
                        <input type="file" name="avatar" value="{{ $user->avatar }}">
                    </div>
                </div>


                <div class="row">
                    <input type="submit" value="Сақтау">
                </div>
            </form>
        </div>
    </div>
@endsection
<style>
    .col-25 {
        margin-right: 0rem;
    }

    @media screen and (max-width: 867px) {
        .adaptive-profile {
            display: flex !important;
            flex-direction: column !important;
            width: 80% !important;
        }

        img.rounded-circle {
            width: 25% !important;
        }

        .adaptive-profile-card {
            margin-bottom: 15px;
        }

        .adaptive-ava-card {
            width: 100% !important;
        }
    }
</style>
