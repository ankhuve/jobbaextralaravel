@if (count($errors) > 0)
    <div class="alert validationError">
        <strong>Hoppsan!</strong> Nu blev det visst lite fel.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif