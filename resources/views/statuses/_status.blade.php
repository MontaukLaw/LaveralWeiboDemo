<li class="media mt-4 mb-4">
    <a href="{{ route('users.show', $user->id )}}">
        <img src="{{ $user->gravatar() }}" alt="{{ $user->name }}" class="mr-3 gravatar"/>
    </a>
    <div class="media-body">
        <h5 class="mt-0 mb-1">{{ $user->name }}
            {{--diffForHumans()是用人能看懂的方法输出时间格式--}}
            <small> / {{ $status->created_at->diffForHumans() }}</small>
        </h5>
        {{ $status->content }}
    </div>
    @can('destroy', $status)
        {{--onsubmit用来submit的时候做确认, 是js的方法--}}
        <form action="{{ route('statuses.destroy', $status->id) }}" method="POST"  onsubmit="return confirm('您确定要删除本条微博吗？');">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
            <button type="submit" class="btn btn-sm btn-danger">删除</button>
        </form>
    @endcan
</li>