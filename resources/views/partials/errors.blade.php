@if ($errors->any())
    <div class="alert alert-danger">
        <p><strong>Whoops, you have some errors:</strong></p>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
