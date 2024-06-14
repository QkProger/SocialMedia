<div class="comment" data-comment-id="{{ $comment->id }}">
    <div class="text-muted d-f a-c j-b">
        <div class="gap-5">
            <div class="profile-photo">
                <img src="/storage/{{ $comment->user->avatar }}" class="avaChat">
            </div>
            {{ $comment->user->fio }}
        </div>
        <div class="text-muted">{{ $comment->created_at }}</div>
    </div>
    <div>{{ $comment->content }}</div>
    {{-- <span class="reply-button" data-comment-id="{{ $comment->id }}">Жауап қайтару</span> --}}
    <form id="reply-form-{{ $comment->id }}" class="reply-form" action="{{ route('comment.store') }}" method="post">
        @csrf
        <input type="hidden" name="parent_id" value="{{ $comment->id }}">
        <textarea placeholder="Жауап қайтарыңыз..." name="content" required></textarea>
        @if (Route::currentRouteName() == 'user.bookmarks')
            <input type="hidden" name="post_id" value="{{ $bookmark->post->id }}">
        @else
            <input type="hidden" name="post_id" value="{{ $post->id }}">
        @endif
        <button class="btn btn-primary mb-2" type="submit">Жауап қайтару</button>
    </form>

    <div class="subcomments">
        @foreach ($comment->replies as $reply)
            @include('comments.comment', ['comment' => $reply])
        @endforeach
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const replyButtons = document.querySelectorAll('.reply-button');

        replyButtons.forEach(button => {
            button.addEventListener('click', function() {
                const commentId = this.getAttribute('data-comment-id');
                const replyForm = document.getElementById('reply-form-' + commentId);

                if (replyForm) {
                    replyForm.classList.toggle('show');
                }
            });
        });
    });
</script>
<style>
    .comment {
        border: 1px solid #ccc;
        padding: 10px;
        margin-bottom: 10px;
        border-radius: 5px;
        border-radius: var(--card-border-radius);
        background: #fff;
    }

    .comment p {
        margin-bottom: 5px;
    }

    .comment .reply-button {
        cursor: pointer;
        color: #007bff;
        margin-top: 5px;
    }

    .comment .reply-button:hover {
        text-decoration: underline;
    }

    .reply-form {
        /* display: none; */
        margin-top: 10px;
    }

    .reply-form textarea {
        min-height: 60px;
    }
</style>
