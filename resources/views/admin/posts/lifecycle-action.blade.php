<form action="{{ route('admin.posts.' . $action, ['id' => $post['id']]) }}" method="POST">
    @csrf
    @method('PUT')
    <button type="submit">{{ $label }}</button>
</form>
