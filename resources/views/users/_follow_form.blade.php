{{-- 关注模块 --}}
{{-- 访问的是自己的个人页面,就没有关注表单@can即查看权限, 跟userPolicy绑定的 --}}
@can('follow', $user)
    <div class="text-center mt-2 mb-4">
        {{-- 如果已经关注了 --}}
        @if (Auth::user()->isFollowing($user->id))
            <form action="{{ route('followers.destroy', $user->id) }}" method="post">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <button type="submit" class="btn btn-sm btn-outline-primary">取消关注</button>
            </form>
        @else
            <form action="{{ route('followers.store', $user->id) }}" method="post">
                {{ csrf_field() }}
                <button type="submit" class="btn btn-sm btn-primary">关注</button>
            </form>
        @endif
    </div>
@endcan