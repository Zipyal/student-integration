<form method="POST" action="{{ route('register') }}">
    @csrf

    <!-- Общие поля -->
    <div class="form-group">
        <label>Роль</label>
        <select name="role" class="form-control" id="role-selector" required>
            <option value="">Выберите роль</option>
            @foreach($roles as $value => $label)
                <option value="{{ $value }}">{{ $label }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label>ФИО</label>
        <input type="text" name="name" value="{{ old('name') }}" required>
    </div>

    <!-- Поля для студентов -->
    <div id="student-fields" style="{{ old('role') == 'student' ? '' : 'display:none;' }}">
        <div class="form-group">
            <label>Страна</label>
            <input type="text" name="country" value="{{ old('country') }}">
        </div>

        <div class="form-group">
            <label>Университет</label>
            <select name="university_id" class="form-control">
                @foreach($universities as $university)
                    <option value="{{ $university->id }}" 
                        {{ old('university_id') == $university->id ? 'selected' : '' }}>
                        {{ $university->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <button type="submit">Зарегистрироваться</button>
</form>

@push('scripts')
<script>
    document.getElementById('role-selector').addEventListener('change', function() {
        document.getElementById('student-fields').style.display = 
            this.value === 'student' ? 'block' : 'none';
    });
</script>
@endpush