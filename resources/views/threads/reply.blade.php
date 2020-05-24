<div class="panel panel-default">
    <div class="panel-heading">
        <a href="">{{ $reply->owner->name }}</a>
        said
        {{ $reply->created_at->diffForHumans() }}...
    </div>
    <div class="panel-body">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <div class="panel-body">
            {{ $reply->body }}
        </div>
    </div>
</div>