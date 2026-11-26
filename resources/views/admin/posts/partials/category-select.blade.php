<label for="category" class="required">{{ __('Choose a category') }}</label>
<select id="category" name="category" class="select-category" required>
    <option value="">--{{ __('Choose a category') }}--</option>
    @foreach ($categories as $category)
        <option value="{{ $category->id }}" @selected((string) old('category', $selectedCategoryId ?? '') === (string) $category->id)>
            {{ $category->parentId === null ? '' : '— ' }}{{ mb_ucfirst($category->displayName) }}
        </option>
    @endforeach
</select>
